<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\Pengajuan;
use App\Models\StokMutasi;
use App\Models\User;
use App\Models\BukuTamu;
use App\Models\Registrasi;
use App\Models\InspeksiUps;
use App\Models\InspeksiStavolt;
use App\Models\InspeksiMonitor;
use App\Models\InspeksiProyektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'maintenance' => GudangBarang::where('stok_tersedia', '<', DB::raw('stok_total'))->count(),
            'total_peminjaman' => Inventaris::count(),
            'belum_kembali' => Inventaris::where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_menunggu' => Pengajuan::where('status', 'Menunggu')->count(),
            'total_bukutamu' => BukuTamu::count(),
            'total_radio' => Registrasi::count(),
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

        $items = GudangBarang::where('stok_tersedia', '<', DB::raw('stok_total'))
            ->orderBy('nama_perangkat')
            ->get();

        return view('laporan.maintenance', compact('items'));
    }

    public function bukuTamu()
    {
        $this->ensureAuthorized();

        $bukutamu = BukuTamu::with('pic')->orderBy('no', 'desc')->get();

        return view('laporan.bukutamu', compact('bukutamu'));
    }

    public function radio()
    {
        $this->ensureAuthorized();

        $registrasis = Registrasi::orderBy('created_at', 'desc')->get();

        return view('laporan.radio', compact('registrasis'));
    }

    public function pdfGudang()
    {
        $this->ensureAuthorized();

        $barang = GudangBarang::orderBy('nama_perangkat')->get();
        $mutasi = StokMutasi::with('gudangBarang')->orderBy('created_at', 'desc')->limit(50)->get();

        $pdf = Pdf::loadView('laporan.pdf-gudang', compact('barang', 'mutasi'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Gudang-IT.pdf');
    }

    public function pdfPeminjaman()
    {
        $this->ensureAuthorized();

        $inventaris = Inventaris::with('gudangBarang', 'approver')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf-peminjaman', compact('inventaris'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Peminjaman.pdf');
    }

    public function pdfPengajuan()
    {
        $this->ensureAuthorized();

        $pengajuans = Pengajuan::with('user', 'approver', 'gudangBarang')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf-pengajuan', compact('pengajuans'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Pengajuan.pdf');
    }

    public function pdfMaintenance()
    {
        $this->ensureAuthorized();

        $items = GudangBarang::where('stok_tersedia', '<', DB::raw('stok_total'))
            ->orderBy('nama_perangkat')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf-maintenance', compact('items'))->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan-Barang-Maintenance.pdf');
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
