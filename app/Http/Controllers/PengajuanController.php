<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Pengajuan;
use App\Models\StokMutasi;
use App\Services\PimpinanNotificationService;
use App\Notifications\PengajuanBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pengajuan::with('user', 'approver', 'gudangBarang');

        if ($user->isKaryawan()) {
            $query->where('diajukan_oleh', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->get();
        $pendingCount = Pengajuan::where('status', 'Menunggu')->count();

        return view('pengajuan.index', compact('pengajuans', 'pendingCount'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isPimpinan()) {
            abort(403, 'Pimpinan tidak dapat membuat pengajuan.');
        }

        $barangMaintenance = GudangBarang::orderBy('nama_perangkat')
            ->get();

        return view('pengajuan.form', compact('barangMaintenance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Pembelian,Maintenance',
            'nama_barang' => 'required|string|max:255',
            'jumlah_diminta' => 'required|integer|min:1',
            'satuan' => 'required|string|max:255',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'judul' => 'required|string|max:255',
            'gudang_barang_id' => 'required_if:kategori,Maintenance|nullable|exists:gudang_barang,id',
        ]);

        $nomor = 'PJ-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $pengajuan = Pengajuan::create([
            'nomor_pengajuan' => $nomor,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'gudang_barang_id' => $request->gudang_barang_id,
            'nama_barang' => $request->nama_barang,
            'jumlah_diminta' => $request->jumlah_diminta,
            'satuan' => $request->satuan,
            'estimasi_biaya' => $request->estimasi_biaya,
            'deskripsi' => $request->deskripsi,
            'status' => 'Menunggu',
            'diajukan_oleh' => Auth::id(),
            'tanggal_pengajuan' => now()->toDateString(),
        ]);

        PimpinanNotificationService::notify(new PengajuanBaruNotification($pengajuan));

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dikirim. Menunggu persetujuan pimpinan.');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isPimpinan()) {
            abort(403, 'Hanya pimpinan yang dapat menyetujui pengajuan.');
        }

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_pimpinan' => 'nullable|string',
            'jumlah_disetujui' => 'nullable|integer|min:0',
        ]);

        $pengajuan = Pengajuan::with('gudangBarang')->findOrFail($id);

        DB::transaction(function () use ($pengajuan, $request, $user) {
            $pengajuan->update([
                'status' => $request->status,
                'disetujui_oleh' => $user->id,
                'tanggal_persetujuan' => now(),
                'catatan_pimpinan' => $request->catatan_pimpinan,
                'jumlah_disetujui' => $request->jumlah_disetujui,
            ]);

            if ($request->status === 'Disetujui') {
                $qty = $request->jumlah_disetujui ?? $pengajuan->jumlah_diminta;

                if ($pengajuan->kategori === 'Pembelian') {
                    $barang = GudangBarang::create([
                        'nama_perangkat' => $pengajuan->nama_barang,
                        'kategori' => 'Pembelian',
                        'stok_total' => $qty,
                        'stok_tersedia' => $qty,
                        'kondisi' => 'Baik',
                        'tanggal_masuk' => now()->toDateString(),
                        'keterangan' => "Hasil pengajuan pembelian {$pengajuan->nomor_pengajuan}",
                    ]);

                    StokMutasi::create([
                        'gudang_barang_id' => $barang->id,
                        'jenis' => 'Masuk',
                        'jumlah' => $qty,
                        'keterangan' => "Barang baru dari pengajuan {$pengajuan->nomor_pengajuan}",
                    ]);

                    $pengajuan->update(['gudang_barang_id' => $barang->id]);

                } elseif ($pengajuan->kategori === 'Maintenance' && $pengajuan->gudangBarang) {
                    $barang = $pengajuan->gudangBarang;

                    $barang->update([
                        'stok_tersedia' => max(0, $barang->stok_tersedia - $qty),
                    ]);

                    StokMutasi::create([
                        'gudang_barang_id' => $barang->id,
                        'jenis' => 'Keluar',
                        'jumlah' => $qty,
                        'keterangan' => "Dikirim ke maintenance - Pengajuan {$pengajuan->nomor_pengajuan}",
                    ]);
                }
            }
        });

        $statusText = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';
        return redirect()->route('pengajuan.index')->with('success', "Pengajuan berhasil {$statusText}.");
    }

    public function selesaiMaintenance(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Hanya admin yang dapat menyelesaikan maintenance.');
        }

        $pengajuan = Pengajuan::with('gudangBarang')->findOrFail($id);

        if ($pengajuan->kategori !== 'Maintenance' || $pengajuan->status !== 'Disetujui') {
            return back()->with('error', 'Hanya pengajuan maintenance yang disetujui yang dapat diselesaikan.');
        }

        DB::transaction(function () use ($pengajuan, $request) {
            $qty = $pengajuan->jumlah_disetujui ?? $pengajuan->jumlah_diminta;

            if ($pengajuan->gudangBarang) {
                $pengajuan->gudangBarang->increment('stok_tersedia', $qty);

                StokMutasi::create([
                    'gudang_barang_id' => $pengajuan->gudangBarang->id,
                    'jenis' => 'Masuk',
                    'jumlah' => $qty,
                    'keterangan' => "Maintenance selesai - Pengajuan {$pengajuan->nomor_pengajuan}",
                ]);
            }

            $pengajuan->update([
                'status' => 'Selesai',
            ]);
        });

        return redirect()->route('pengajuan.index')->with('success', 'Maintenance selesai. Stok barang telah dikembalikan ke gudang IT.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isPimpinan()) {
            abort(403);
        }

        Pengajuan::findOrFail($id)->delete();
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function report()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $pengajuans = Pengajuan::with('user', 'approver', 'gudangBarang')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('pengajuan.report', compact('pengajuans'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Pengajuan.pdf');
    }
}
