<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\Pengajuan;
use App\Models\StokMutasi;
use App\Models\User;
use App\Models\InspeksiUps;
use App\Models\InspeksiStavolt;
use App\Models\InspeksiMonitor;
use App\Models\InspeksiProyektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InspeksiUpsExport;
use App\Exports\InspeksiStavoltExport;
use App\Exports\InspeksiMonitorExport;
use App\Exports\InspeksiProyektorExport;

class LaporanController extends Controller
{
    private function ensureAuthorized(): void
    {
        if (!Auth::user()->isPimpinan() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAuthorized();

        $stats = [
            'total_barang' => GudangBarang::count(),
            'stok_tersedia' => GudangBarang::sum('stok_tersedia'),
            'maintenance' => GudangBarang::whereIn('kondisi', ['Perlu Maintenance', 'Rusak'])->count(),
            'total_peminjaman' => Inventaris::count(),
            'belum_kembali' => Inventaris::where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_menunggu' => Pengajuan::where('status', 'Menunggu')->count(),
            'total_ups' => InspeksiUps::count(),
            'total_stavolt' => InspeksiStavolt::count(),
            'total_monitor' => InspeksiMonitor::count(),
            'total_proyektor' => InspeksiProyektor::count(),
        ];

        return view('laporan.index', compact('stats'));
    }

    public function gudang()
    {
        $this->ensureAuthorized();

        $barang = GudangBarang::orderBy('nama_perangkat')->get();
        $mutasi = StokMutasi::with('gudangBarang')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('laporan.gudang', compact('barang', 'mutasi'));
    }

    public function peminjaman()
    {
        $this->ensureAuthorized();

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
        $this->ensureAuthorized();

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
        $this->ensureAuthorized();

        $items = GudangBarang::where('kondisi', 'Baik')
            ->whereColumn('stok_tersedia', '<', 'stok_total')
            ->orderBy('nama_perangkat')
            ->get();

        return view('laporan.maintenance', compact('items'));
    }

    public function inspeksiUps()
    {
        $this->ensureAuthorized();

        $data = InspeksiUps::latest()->paginate(15);
        return view('laporan.inspeksi-ups', compact('data'));
    }

    public function inspeksiStavolt()
    {
        $this->ensureAuthorized();

        $data = InspeksiStavolt::latest()->paginate(15);
        return view('laporan.inspeksi-stavolt', compact('data'));
    }

    public function inspeksiMonitor()
    {
        $this->ensureAuthorized();

        $data = InspeksiMonitor::latest()->paginate(15);
        return view('laporan.inspeksi-monitor', compact('data'));
    }

    public function inspeksiProyektor()
    {
        $this->ensureAuthorized();

        $data = InspeksiProyektor::latest()->paginate(15);
        return view('laporan.inspeksi-proyektor', compact('data'));
    }
}
