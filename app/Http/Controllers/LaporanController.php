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

    public function gudang(Request $request)
    {
        $this->ensureAuthorized();

        $query = GudangBarang::orderBy('nama_perangkat');
        $filters = $request->only(['kondisi', 'tanggal_awal', 'tanggal_akhir']);

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_akhir);
        }

        $barang = $query->get();
        $mutasi = StokMutasi::with('gudangBarang')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('laporan.gudang', compact('barang', 'mutasi', 'filters'));
    }

    public function peminjaman(Request $request)
    {
        $this->ensureAuthorized();

        $query = Inventaris::with('gudangBarang', 'approver');
        $filters = $request->only(['status', 'tanggal_awal', 'tanggal_akhir', 'q']);

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nrp', 'LIKE', "%{$q}%")
                    ->orWhere('nama', 'LIKE', "%{$q}%")
                    ->orWhere('keperluan', 'LIKE', "%{$q}%")
                    ->orWhere('barang', 'LIKE', "%{$q}%");
            });
        }

        $inventaris = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $inventaris->count(),
            'belum' => $inventaris->where('status_peminjaman', 'Belum Dikembalikan')->count(),
            'dikembalikan' => $inventaris->where('status_peminjaman', 'Dikembalikan')->count(),
            'pending' => $inventaris->where('status_peminjaman', 'Pending')->count(),
        ];

        return view('laporan.peminjaman', compact('inventaris', 'stats', 'filters'));
    }

    public function pengajuan(Request $request)
    {
        $this->ensureAuthorized();

        $query = Pengajuan::with('user', 'approver', 'gudangBarang');
        $filters = $request->only(['status', 'kategori', 'tanggal_awal', 'tanggal_akhir', 'q']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'LIKE', "%{$q}%")
                    ->orWhere('kategori', 'LIKE', "%{$q}%")
                    ->orWhere('keperluan', 'LIKE', "%{$q}%");
            });
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $pengajuans->count(),
            'menunggu' => $pengajuans->where('status', 'Menunggu')->count(),
            'disetujui' => $pengajuans->where('status', 'Disetujui')->count(),
            'ditolak' => $pengajuans->where('status', 'Ditolak')->count(),
            'selesai' => $pengajuans->where('status', 'Selesai')->count(),
        ];

        return view('laporan.pengajuan', compact('pengajuans', 'stats', 'filters'));
    }

    public function maintenance(Request $request)
    {
        $this->ensureAuthorized();

        $query = GudangBarang::where('stok_tersedia', '<', DB::raw('stok_total'));

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_akhir);
        }

        $items = $query->orderBy('nama_perangkat')->get();
        $filters = $request->only(['tanggal_awal', 'tanggal_akhir']);

        return view('laporan.maintenance', compact('items', 'filters'));
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

    public function pdfPeminjaman(Request $request)
    {
        $this->ensureAuthorized();

        $query = Inventaris::with('gudangBarang', 'approver');

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $inventaris = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf-peminjaman', compact('inventaris'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Peminjaman.pdf');
    }

    public function pdfPengajuan(Request $request)
    {
        $this->ensureAuthorized();

        $query = Pengajuan::with('user', 'approver', 'gudangBarang');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->get();

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

    public function pdfBukuTamu()
    {
        $this->ensureAuthorized();

        $bukutamu = BukuTamu::with('pic')->orderBy('no', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf-bukutamu', compact('bukutamu'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Buku-Tamu.pdf');
    }

    public function pdfRadio()
    {
        $this->ensureAuthorized();

        $registrasis = Registrasi::orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf-radio', compact('registrasis'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Registrasi-Radio.pdf');
    }

    public function pdfInspeksiUps()
    {
        $this->ensureAuthorized();

        $data = InspeksiUps::latest()->get();

        $pdf = Pdf::loadView('laporan.pdf-inspeksi-ups', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Inspeksi-UPS.pdf');
    }

    public function pdfInspeksiStavolt()
    {
        $this->ensureAuthorized();

        $data = InspeksiStavolt::latest()->get();

        $pdf = Pdf::loadView('laporan.pdf-inspeksi-stavolt', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Inspeksi-Stavolt.pdf');
    }

    public function pdfInspeksiMonitor()
    {
        $this->ensureAuthorized();

        $data = InspeksiMonitor::latest()->get();

        $pdf = Pdf::loadView('laporan.pdf-inspeksi-monitor', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Inspeksi-Monitor.pdf');
    }

    public function pdfInspeksiProyektor()
    {
        $this->ensureAuthorized();

        $data = InspeksiProyektor::latest()->get();

        $pdf = Pdf::loadView('laporan.pdf-inspeksi-proyektor', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Inspeksi-Proyektor.pdf');
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
