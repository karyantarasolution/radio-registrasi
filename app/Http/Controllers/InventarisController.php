<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\StokMutasi;
use App\Services\AdminNotificationService;
use App\Notifications\PengajuanInventarisNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $query = Inventaris::with('gudangBarang', 'approver');

        if ($user->isKaryawan()) {
            $query->where('nrp', $user->nrp);
        }

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        if ($request->filled('verifikasi')) {
            $query->where('status_verifikasi', $request->verifikasi);
        }

        if ($request->filled('persetujuan')) {
            $query->where('status_persetujuan', $request->persetujuan);
        }

        $inventaris = $query->orderBy('created_at', 'desc')->get();

        $chartStats = [
            'dikembalikan' => $inventaris->where('status_peminjaman', 'Dikembalikan')->count(),
            'belum' => $inventaris->where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'pending' => $inventaris->where('status_peminjaman', 'Pending')->count(),
            'total' => $inventaris->count(),
        ];

        $pendingCount = Inventaris::where('status_verifikasi', 'Pending')->count();
        $pendingApprovalCount = Inventaris::where('status_persetujuan', 'Pending')->count();

        return view('inventaris.index', compact('inventaris', 'chartStats', 'pendingCount', 'pendingApprovalCount'));
    }

    public function create()
    {
        $user = Auth::user();
        $gudangBarang = $this->availableGudangBarang();
        return view('inventaris.form', compact('gudangBarang', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'tanggal_peminjaman' => 'required|date',
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        if ($barang->stok_tersedia <= 0 || $barang->kondisi === 'Rusak') {
            return back()->withErrors(['gudang_barang_id' => 'Barang tidak tersedia untuk dipinjam.'])->withInput();
        }

        $data = [
            'nama' => $user->name,
            'nrp' => $user->nrp,
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status_verifikasi' => 'Pending',
            'status_peminjaman' => 'Pending',
            'status_persetujuan' => 'Pending',
        ];

        $inventaris = Inventaris::create($data);

        if (!$user->isAdmin()) {
            AdminNotificationService::notify(new PengajuanInventarisNotification($inventaris));
        }

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
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        $data = [
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
        ];

        if (!$user->isAdmin()) {
            $data['status_verifikasi'] = 'Pending';
            $data['status_persetujuan'] = 'Pending';
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
            DB::transaction(function () use ($inventaris, $newVerifikasi) {
                if ($newVerifikasi === 'Disetujui') {
                    $inventaris->update([
                        'status_verifikasi' => 'Disetujui',
                        'status_peminjaman' => 'Menunggu Persetujuan',
                    ]);
                } else {
                    $inventaris->update([
                        'status_verifikasi' => 'Ditolak',
                        'status_peminjaman' => 'Pending',
                        'status_persetujuan' => 'Pending',
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('inventaris.index')->with('error', $e->getMessage());
        }

        return redirect()->route('inventaris.index')->with('success', 'Verifikasi berhasil diperbarui.');
    }

    public function persetujuan(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isPimpinan()) {
            abort(403, 'Hanya pimpinan yang dapat melakukan persetujuan.');
        }

        $request->validate([
            'status_persetujuan' => 'required|in:Disetujui,Ditolak',
        ]);

        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);
        $newStatus = $request->status_persetujuan;

        try {
            DB::transaction(function () use ($inventaris, $newStatus, $user) {
                if ($newStatus === 'Disetujui') {
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
                            'keterangan' => 'Peminjaman disetujui pimpinan',
                        ]);
                    }
                    $inventaris->update([
                        'status_persetujuan' => 'Disetujui',
                        'status_peminjaman' => 'Belum Dikembalikan',
                        'approved_by' => $user->id,
                        'approved_at' => now(),
                    ]);
                } else {
                    $inventaris->update([
                        'status_persetujuan' => 'Ditolak',
                        'status_peminjaman' => 'Pending',
                        'status_verifikasi' => 'Pending',
                        'approved_by' => $user->id,
                        'approved_at' => now(),
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('inventaris.index')->with('error', $e->getMessage());
        }

        return redirect()->route('inventaris.index')->with('success', 'Persetujuan berhasil diperbarui.');
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
        ]);

        DB::transaction(function () use ($inventaris, $request, $user) {
            if ($inventaris->gudangBarang && $request->kondisi_barang === 'Baik') {
                $inventaris->gudangBarang->increment('stok_tersedia');
                StokMutasi::create([
                    'gudang_barang_id' => $inventaris->gudangBarang->id,
                    'inventaris_id' => $inventaris->id,
                    'jenis' => 'Masuk',
                    'jumlah' => 1,
                    'keterangan' => 'Pengembalian barang - kondisi baik',
                ]);
            }

            \App\Models\DokumentasiPengembalian::create([
                'inventaris_id' => $inventaris->id,
                'kondisi_barang' => $request->kondisi_barang,
                'catatan' => $request->catatan,
                'dikembalikan_oleh' => $user->name,
            ]);

            $inventaris->update([
                'status_peminjaman' => 'Dikembalikan',
                'tanggal_actual_kembali' => now()->toDateString(),
                'kondisi_pengembalian' => $request->kondisi_barang,
                'catatan_pengembalian' => $request->catatan,
            ]);
        });

        return redirect()->route('inventaris.index')->with('success', 'Pengembalian berhasil didokumentasikan.');
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
}
