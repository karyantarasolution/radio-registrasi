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
    private function isAdmin(): bool
    {
        return Auth::user()->name == 'ICT';
    }

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
        $query = Inventaris::with('gudangBarang');

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        if ($request->filled('verifikasi')) {
            $query->where('status_verifikasi', $request->verifikasi);
        }

        $inventaris = $query->orderBy('tanggal_peminjaman', 'desc')->get();

        $chartStats = [
            'dikembalikan' => $inventaris->where('status_peminjaman', 'Dikembalikan')->count(),
            'belum' => $inventaris->where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'pending' => $inventaris->where('status_peminjaman', 'Pending')->count(),
            'total' => $inventaris->count(),
        ];

        $pendingCount = Inventaris::where('status_verifikasi', 'Pending')->count();

        return view('inventaris.index', compact('inventaris', 'chartStats', 'pendingCount'));
    }

    public function create()
    {
        $gudangBarang = $this->availableGudangBarang();
        return view('inventaris.form', compact('gudangBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nrp' => 'required|string',
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'tanggal_peminjaman' => 'required|date',
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        if ($barang->stok_tersedia <= 0 || $barang->kondisi === 'Rusak') {
            return back()->withErrors(['gudang_barang_id' => 'Barang tidak tersedia untuk dipinjam.'])->withInput();
        }

        $data = [
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status_verifikasi' => 'Pending',
            'status_peminjaman' => 'Pending',
        ];

        $inventaris = Inventaris::create($data);

        if (!$this->isAdmin()) {
            AdminNotificationService::notify(new PengajuanInventarisNotification($inventaris));
        }

        return redirect()->route('inventaris.index')->with('success', 'Pengajuan peminjaman berhasil. Menunggu verifikasi admin.');
    }

    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $gudangBarang = $this->availableGudangBarang();

        if ($inventaris->gudang_barang_id && !$gudangBarang->contains('id', $inventaris->gudang_barang_id)) {
            $current = GudangBarang::find($inventaris->gudang_barang_id);
            if ($current) {
                $gudangBarang->prepend($current);
            }
        }

        return view('inventaris.form', compact('inventaris', 'gudangBarang'));
    }

    public function update(Request $request, $id)
    {
        $inventaris = Inventaris::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'nrp' => 'required|string',
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'tanggal_peminjaman' => 'required|date',
        ]);

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);
        $wasApproved = $inventaris->status_verifikasi === 'Disetujui';

        $data = [
            'nama' => $request->nama,
            'nrp' => $request->nrp,
            'gudang_barang_id' => $barang->id,
            'nama_perangkat' => $barang->nama_perangkat,
            'no_asset' => $barang->kategori . '-' . str_pad($barang->id, 4, '0', STR_PAD_LEFT),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
        ];

        if (!$this->isAdmin()) {
            $data['status_verifikasi'] = 'Pending';
            if (!$wasApproved) {
                $data['status_peminjaman'] = 'Pending';
            } else {
                $data['status_peminjaman'] = $inventaris->status_peminjaman;
            }
        }

        $inventaris->update($data);

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function updatePeminjaman(Request $request, $id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengubah status peminjaman.');
        }

        $request->validate([
            'status_peminjaman' => 'required|in:Pending,Belum Dikembalikan,Dikembalikan',
        ]);

        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);
        $newStatus = $request->status_peminjaman;

        if (in_array($newStatus, ['Belum Dikembalikan', 'Dikembalikan']) && $inventaris->status_verifikasi !== 'Disetujui') {
            return redirect()->route('inventaris.index', request()->only(['status', 'verifikasi']))
                ->with('error', 'Status peminjaman hanya bisa diubah setelah verifikasi Disetujui.');
        }

        $oldStatus = $inventaris->status_peminjaman;

        DB::transaction(function () use ($inventaris, $newStatus, $oldStatus) {
            if ($newStatus === 'Dikembalikan' && $oldStatus === 'Belum Dikembalikan' && $inventaris->gudangBarang) {
                $inventaris->gudangBarang->increment('stok_tersedia');
                $this->recordMutasi($inventaris->gudangBarang, 'Masuk', 1, $inventaris, 'Pengembalian barang');
                $inventaris->update([
                    'status_peminjaman' => 'Dikembalikan',
                    'tanggal_pengembalian' => $inventaris->tanggal_pengembalian ?? now(),
                ]);
            } elseif ($newStatus === 'Belum Dikembalikan') {
                $inventaris->update([
                    'status_peminjaman' => 'Belum Dikembalikan',
                    'tanggal_pengembalian' => null,
                ]);
            } else {
                $inventaris->update(['status_peminjaman' => $newStatus]);
            }
        });

        return redirect()->route('inventaris.index', request()->only(['status', 'verifikasi']))
            ->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function verifikasi(Request $request, $id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Tidak punya akses verifikasi');
        }

        $request->validate([
            'status_verifikasi' => 'required|in:Pending,Disetujui,Ditolak',
        ]);

        $inventaris = Inventaris::with('gudangBarang')->findOrFail($id);
        $newVerifikasi = $request->status_verifikasi;
        $oldVerifikasi = $inventaris->status_verifikasi;

        try {
            DB::transaction(function () use ($inventaris, $newVerifikasi, $oldVerifikasi) {
                if ($newVerifikasi === 'Disetujui' && $oldVerifikasi !== 'Disetujui') {
                    if ($inventaris->gudangBarang) {
                        if ($inventaris->gudangBarang->stok_tersedia <= 0) {
                            throw new \RuntimeException('Stok barang tidak tersedia.');
                        }
                        $inventaris->gudangBarang->decrement('stok_tersedia');
                        $this->recordMutasi($inventaris->gudangBarang, 'Keluar', 1, $inventaris, 'Peminjaman disetujui');
                    }
                    $inventaris->update([
                        'status_verifikasi' => 'Disetujui',
                        'status_peminjaman' => 'Belum Dikembalikan',
                    ]);
                } elseif ($newVerifikasi === 'Ditolak') {
                    $inventaris->update([
                        'status_verifikasi' => 'Ditolak',
                        'status_peminjaman' => 'Pending',
                    ]);
                } else {
                    $inventaris->update(['status_verifikasi' => $newVerifikasi]);
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('inventaris.index', request()->only(['status', 'verifikasi']))
                ->with('error', $e->getMessage());
        }

        return redirect()->route('inventaris.index', request()->only(['status', 'verifikasi']))
            ->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Inventaris::findOrFail($id)->delete();
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil dihapus.');
    }

    public function report()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Tidak punya akses mencetak laporan');
        }

        $inventaris = Inventaris::with('gudangBarang')->get();

        $pdf = Pdf::loadView('inventaris.report', compact('inventaris'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Inventaris.pdf');
    }
}
