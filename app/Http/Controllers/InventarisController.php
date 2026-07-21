<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\StokMutasi;
use App\Services\AdminNotificationService;
use App\Services\PimpinanNotificationService;
use App\Notifications\PengajuanInventarisNotification;
use App\Notifications\PengajuanPimpinanNotification;
use App\Notifications\PengembalianInventarisNotification;
use App\Notifications\PengembalianDisetujuiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarisController extends Controller
{
    private function availableGudangBarang()
    {
        return GudangBarang::available()->orderBy('nama_perangkat')->get();
    }

    private function recordMutasi(GudangBarang $barang, string $jenis, int $jumlah, ?Inventaris $inventaris, string $keterangan): void
    {
        StokMutasi::create([
            'gudang_barang_id' => $barang->id,
            'inventaris_id' => $inventaris?->id,
            'jenis' => $jenis,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan,
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Inventaris::with('gudangBarang', 'approver', 'dokumentasi');

        if ($user->isKaryawan()) {
            $query->where('nrp', $user->nrp);
        }

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        if ($request->filled('verifikasi')) {
            $query->where('status_verifikasi', $request->verifikasi);
        }

        $inventaris = $query->orderBy('created_at', 'desc')->get();

        $chartStats = [
            'dikembalikan' => $inventaris->where('status_peminjaman', 'Dikembalikan')->count(),
            'belum' => $inventaris->where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'pending' => $inventaris->where('status_peminjaman', 'Pending')->count(),
            'pending_pengembalian' => $inventaris->where('status_peminjaman', 'Pending Pengembalian')->count(),
            'total' => $inventaris->count(),
        ];

        $pendingCount = Inventaris::where('status_verifikasi', 'Pending')->count();
        $pendingReturnCount = Inventaris::where('status_peminjaman', 'Pending Pengembalian')->count();

        return view('inventaris.index', compact('inventaris', 'chartStats', 'pendingCount', 'pendingReturnCount'));
    }

    public function create()
    {
        $user = Auth::user();
        $gudangBarang = $this->availableGudangBarang();
        return view('inventaris.form', compact('gudangBarang', 'user'));
    }

    public function searchKaryawan(Request $request)
    {
        $q = $request->input('q', '');
        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $karyawan = \App\Models\User::where('role', 'karyawan')
            ->where(function ($query) use ($q) {
                $query->where('nrp', 'LIKE', "%{$q}%")
                      ->orWhere('name', 'LIKE', "%{$q}%");
            })
            ->select('id', 'name', 'nrp', 'jabatan')
            ->limit(10)
            ->get();

        return response()->json($karyawan);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'tanggal_peminjaman' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
            'nama' => 'required|string|max:255',
            'nrp' => 'required|string|max:255',
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        if ($barang->stok_tersedia <= 0 || $barang->kondisi === 'Rusak') {
            return back()->withErrors(['gudang_barang_id' => 'Barang tidak tersedia untuk dipinjam.'])->withInput();
        }

        $tanggalPeminjaman = \Carbon\Carbon::parse($request->tanggal_peminjaman);
        $tanggalPengembalian = $tanggalPeminjaman->copy()->addDays((int) $request->lama_pinjam);

        $data = [
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'lama_pinjam' => $request->lama_pinjam,
            'tanggal_pengembalian' => $tanggalPengembalian->toDateString(),
            'status_verifikasi' => 'Pending',
            'status_peminjaman' => 'Pending',
        ];

        $inventaris = Inventaris::create($data);

        if (!$user->isAdmin()) {
            AdminNotificationService::notify(new PengajuanInventarisNotification($inventaris));
        }

        PimpinanNotificationService::notify(new PengajuanPimpinanNotification($inventaris, 'baru'));

        return redirect()->route('inventaris.index')->with('success', 'Pengajuan peminjaman berhasil. Menunggu verifikasi admin.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $inventaris = Inventaris::findOrFail($id);

        if ($user->isKaryawan() && $inventaris->nrp !== $user->nrp) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if ($inventaris->status_verifikasi !== 'Pending' && !$user->isAdmin()) {
            return back()->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $gudangBarang = $this->availableGudangBarang();
        if ($inventaris->gudang_barang_id && !$gudangBarang->contains('id', $inventaris->gudang_barang_id)) {
            $current = GudangBarang::find($inventaris->gudang_barang_id);
            if ($current) {
                $gudangBarang->prepend($current);
            }
        }

        return view('inventaris.form', compact('inventaris', 'gudangBarang', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $inventaris = Inventaris::findOrFail($id);

        if ($user->isKaryawan() && $inventaris->nrp !== $user->nrp) {
            abort(403);
        }

        $request->validate([
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'tanggal_peminjaman' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        $tanggalPeminjaman = \Carbon\Carbon::parse($request->tanggal_peminjaman);
        $tanggalPengembalian = $tanggalPeminjaman->copy()->addDays((int) $request->lama_pinjam);

        $data = [
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'lama_pinjam' => $request->lama_pinjam,
            'tanggal_pengembalian' => $tanggalPengembalian->toDateString(),
        ];

        if (!$user->isAdmin()) {
            $data['status_verifikasi'] = 'Pending';
            $data['status_peminjaman'] = 'Pending';
        }

        $inventaris->update($data);

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function verifikasi(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat melakukan verifikasi.');
        }

        $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak',
        ]);

        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);
        $newVerifikasi = $request->status_verifikasi;

        try {
            DB::transaction(function () use ($inventaris, $newVerifikasi, $user) {
                if ($newVerifikasi === 'Disetujui') {
                    if ($inventaris->gudangBarang) {
                        if ($inventaris->gudangBarang->stok_tersedia <= 0) {
                            throw new \RuntimeException('Stok barang tidak tersedia.');
                        }
                        $inventaris->gudangBarang->decrement('stok_tersedia');
                        StokMutasi::create([
                            'gudang_barang_id' => $inventaris->gudangBarang->id,
                            'inventaris_id' => $inventaris->id,
                            'jenis' => 'Keluar',
                            'jumlah' => 1,
                            'keterangan' => 'Peminjaman disetujui admin ICT',
                        ]);
                    }
                    $inventaris->update([
                        'status_verifikasi' => 'Disetujui',
                        'status_peminjaman' => 'Belum Dikembalikan',
                        'approved_by' => $user->id,
                        'approved_at' => now(),
                    ]);
                    PimpinanNotificationService::notify(new PengajuanPimpinanNotification($inventaris, 'disetujui'));
                } else {
                    $inventaris->update([
                        'status_verifikasi' => 'Ditolak',
                        'status_peminjaman' => 'Pending',
                    ]);
                    PimpinanNotificationService::notify(new PengajuanPimpinanNotification($inventaris, 'ditolak'));
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('inventaris.index')->with('error', $e->getMessage());
        }

        return redirect()->route('inventaris.index')->with('success', 'Verifikasi berhasil diperbarui.');
    }

    public function pengembalian(Request $request, $id)
    {
        $user = Auth::user();
        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);

        if ($user->isKaryawan() && $inventaris->nrp !== $user->nrp) {
            abort(403);
        }

        if ($inventaris->status_peminjaman !== 'Belum Dikembalikan') {
            return back()->with('error', 'Barang sedang tidak dipinjam.');
        }

        $request->validate([
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string',
            'foto_sebelum' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'foto_sesudah' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoSebelum = null;
        $fotoSesudah = null;

        if ($request->hasFile('foto_sebelum')) {
            $fotoSebelum = $request->file('foto_sebelum')->store('pengembalian', 'public');
        }
        if ($request->hasFile('foto_sesudah')) {
            $fotoSesudah = $request->file('foto_sesudah')->store('pengembalian', 'public');
        }

        DB::transaction(function () use ($inventaris, $request, $user, $fotoSebelum, $fotoSesudah) {
            \App\Models\DokumentasiPengembalian::create([
                'inventaris_id' => $inventaris->id,
                'kondisi_barang' => $request->kondisi_barang,
                'foto_sebelum' => $fotoSebelum,
                'foto_sesudah' => $fotoSesudah,
                'catatan' => $request->catatan,
                'dikembalikan_oleh' => $user->name,
            ]);

            $inventaris->update([
                'status_peminjaman' => 'Pending Pengembalian',
                'kondisi_pengembalian' => $request->kondisi_barang,
                'catatan_pengembalian' => $request->catatan,
            ]);

            AdminNotificationService::notify(new PengembalianInventarisNotification($inventaris));
        });

        return redirect()->route('inventaris.index')->with('success', 'Dokumentasi pengembalian berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function accPengembalian(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat menyetujui pengembalian.');
        }

        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);

        if ($inventaris->status_peminjaman !== 'Pending Pengembalian') {
            return back()->with('error', 'Pengembalian ini tidak dalam status pending.');
        }

        DB::transaction(function () use ($inventaris, $user) {
            if ($inventaris->gudangBarang && $inventaris->kondisi_pengembalian === 'Baik') {
                $inventaris->gudangBarang->increment('stok_tersedia');
                StokMutasi::create([
                    'gudang_barang_id' => $inventaris->gudangBarang->id,
                    'inventaris_id' => $inventaris->id,
                    'jenis' => 'Masuk',
                    'jumlah' => 1,
                    'keterangan' => 'Pengembalian disetujui admin - kondisi baik',
                ]);
            }

            $inventaris->update([
                'status_peminjaman' => 'Dikembalikan',
                'tanggal_actual_kembali' => now()->toDateString(),
                'approved_by' => $user->id,
                'approved_at' => now(),
            ]);

            $karyawan = \App\Models\User::where('nrp', $inventaris->nrp)->first();
            if ($karyawan) {
                $karyawan->notify(new PengembalianDisetujuiNotification($inventaris));
            }
        });

        return redirect()->route('inventaris.index')->with('success', 'Pengembalian berhasil disetujui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat menghapus data.');
        }

        Inventaris::findOrFail($id)->delete();
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil dihapus.');
    }

    public function report()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $inventaris = Inventaris::with('gudangBarang', 'approver')->get();
        $pdf = Pdf::loadView('inventaris.report', compact('inventaris'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Inventaris.pdf');
    }

    public function riwayat()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $riwayat = Inventaris::with('gudangBarang', 'approver')
            ->where('status_peminjaman', '!=', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('nrp');

        return view('inventaris.riwayat', compact('riwayat'));
    }

    public function riwayatPdf()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $riwayat = Inventaris::with('gudangBarang', 'approver')
            ->where('status_peminjaman', '!=', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('nrp');

        $pdf = Pdf::loadView('inventaris.riwayat-pdf', compact('riwayat'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Riwayat-Peminjaman.pdf');
    }

    public function riwayatPdfPerAkun($nrp)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $riwayat = Inventaris::with('gudangBarang', 'approver')
            ->where('status_peminjaman', '!=', 'Pending')
            ->where('nrp', $nrp)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('nrp');

        $akun = \App\Models\User::where('nrp', $nrp)->first();
        $namaAkun = $akun->name ?? $nrp;

        $pdf = Pdf::loadView('inventaris.riwayat-pdf', compact('riwayat'))->setPaper('a4', 'landscape');
        return $pdf->stream("Laporan-Riwayat-Peminjaman-{$namaAkun}.pdf");
    }

    public function daftarAkun()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $akunKaryawan = \App\Models\User::where('role', 'karyawan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inventaris.daftar-akun', compact('akunKaryawan'));
    }

    public function approveAkun($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $akun = \App\Models\User::findOrFail($id);
        $akun->update(['is_approved' => true]);

        return redirect()->route('admin.daftar-akun')->with('success', 'Akun ' . $akun->name . ' berhasil disetujui.');
    }

    public function destroyAkun($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $akun = \App\Models\User::findOrFail($id);
        $akun->delete();

        return redirect()->route('admin.daftar-akun')->with('success', 'Akun berhasil dihapus.');
    }
}
