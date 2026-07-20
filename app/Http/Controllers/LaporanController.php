<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\Pengajuan;
use App\Models\StokMutasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403);
        }

        $stats = [
            'total_barang' => GudangBarang::count(),
            'stok_tersedia' => GudangBarang::sum('stok_tersedia'),
            'maintenance' => GudangBarang::whereIn('kondisi', ['Perlu Maintenance', 'Rusak'])->count(),
            'total_peminjaman' => Inventaris::count(),
            'belum_kembali' => Inventaris::where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_menunggu' => Pengajuan::where('status', 'Menunggu')->count(),
        ];

        return view('laporan.index', compact('stats'));
    }

    public function gudang()
    {
        $user = Auth::user();
        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403);
        }

        $barang = GudangBarang::orderBy('nama_perangkat')->get();
        $mutasi = StokMutasi::with('gudangBarang')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('laporan.gudang', compact('barang', 'mutasi'));
    }

    public function peminjaman()
    {
        $user = Auth::user();
        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403);
        }

        $inventaris = Inventaris::with('gudangBarang', 'approver')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $inventaris->count(),
            'belum' => $inventaris->where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'dikembalikan' => $inventaris->where('status_peminjaman', 'Dikembalikan')->count(),
            'pending' => $inventaris->where('status_peminjaman', 'Pending')->count(),
        ];

        return view('laporan.peminjaman', compact('inventaris', 'stats'));
    }

    public function pengajuan()
    {
        $user = Auth::user();
        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403);
        }

        $pengajuans = Pengajuan::with('user', 'approver', 'gudangBarang')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $pengajuans->count(),
            'menunggu' => $pengajuans->where('status', 'Menunggu')->count(),
            'disetujui' => $pengajuans->where('status', 'Disetujui')->count(),
            'ditolak' => $pengajuans->where('status', 'Ditolak')->count(),
        ];

        return view('laporan.pengajuan', compact('pengajuans', 'stats'));
    }

    public function maintenance()
    {
        $user = Auth::user();
        if (!$user->isPimpinan() && !$user->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::whereIn('kondisi', ['Perlu Maintenance', 'Rusak'])
            ->orderBy('nama_perangkat')
            ->get();

        return view('laporan.maintenance', compact('items'));
    }
}
