<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Inventaris;
use App\Models\BukuTamu;
use App\Models\Karyawan;
use App\Models\InspeksiUps;
use App\Models\InspeksiStavolt;
use App\Models\InspeksiMonitor;
use App\Models\InspeksiProyektor;
use App\Models\Maintenance;
use App\Models\GudangBarang;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jumlahRegistrasi = Registrasi::count();
        $latestRegistrasi = Registrasi::orderBy('created_at', 'desc')->take(5)->get();

        $jumlahInventaris = Inventaris::count();
        $inventarisDikembalikan = Inventaris::where('status_peminjaman', 'Dikembalikan')->count();
        $inventarisBelum = Inventaris::where('status_peminjaman', 'Belum Dikembalikan')->count();
        $inventarisPending = Inventaris::where('status_peminjaman', 'Pending')->count();

        $chartStats = [
            'dikembalikan' => $inventarisDikembalikan,
            'belum' => $inventarisBelum,
            'pending' => $inventarisPending,
            'total' => $jumlahInventaris,
        ];

        $jumlahBukuTamu = BukuTamu::count();
        $latestBukuTamu = BukuTamu::with('pic')->orderBy('no', 'desc')->take(5)->get();

        $jumlahKaryawan = Karyawan::count();

        $jumlahInspeksiUps = InspeksiUps::count();
        $jumlahInspeksiStavolt = InspeksiStavolt::count();
        $jumlahInspeksiMonitor = InspeksiMonitor::count();
        $jumlahInspeksiProyektor = InspeksiProyektor::count();

        $maintenanceStats = [
            'menunggu' => Maintenance::where('status', 'Menunggu')->count(),
            'diproses' => Maintenance::where('status', 'Diproses')->count(),
            'selesai_bulan_ini' => Maintenance::where('status', 'Selesai')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
        ];

        $stokGudang = GudangBarang::sum('stok_tersedia');

        $sayaDipinjam = collect();
        $sayaTerlambat = collect();
        if ($user->isKaryawan()) {
            $sayaDipinjam = Inventaris::where('nrp', $user->nrp)
                ->where('status_peminjaman', 'Belum Dikembalikan')
                ->with('gudangBarang')
                ->get();

            $sayaTerlambat = $sayaDipinjam->filter(function ($item) {
                return $item->batas_peminjaman && $item->batas_peminjaman->isPast();
            });
        }

        $perluMenungguPersetujuan = 0;
        $perluVerifikasiAdmin = collect();
        if ($user->isAdmin()) {
            $perluMenungguPersetujuan = Inventaris::where('status_peminjaman', 'Pending')
                ->where('verifikasi_admin', true)
                ->where('pimpinan_acc', null)
                ->count();
            $perluVerifikasiAdmin = Inventaris::where('status_peminjaman', 'Pending')
                ->where('verifikasi_admin', false)
                ->with('karyawan')
                ->get();
        }

        $pengajuanMenungguAdmin = collect();
        $pengajuanMenungguPimpinan = collect();
        if ($user->isAdmin()) {
            $pengajuanMenungguAdmin = Pengajuan::where('status', 'Menunggu')
                ->whereNull('verified_by')
                ->get();
        }
        if ($user->isPimpinan()) {
            $pengajuanMenungguPimpinan = Pengajuan::where('status', 'Menunggu')
                ->whereNotNull('verified_by')
                ->get();
        }

        return view('dashboard.index', compact(
            'jumlahRegistrasi',
            'latestRegistrasi',
            'jumlahInventaris',
            'inventarisDikembalikan',
            'inventarisBelum',
            'chartStats',
            'jumlahBukuTamu',
            'latestBukuTamu',
            'jumlahKaryawan',
            'jumlahInspeksiUps',
            'jumlahInspeksiStavolt',
            'jumlahInspeksiMonitor',
            'jumlahInspeksiProyektor',
            'maintenanceStats',
            'stokGudang',
            'sayaDipinjam',
            'sayaTerlambat',
            'perluMenungguPersetujuan',
            'perluVerifikasiAdmin',
            'pengajuanMenungguAdmin',
            'pengajuanMenungguPimpinan',
            'user'
        ));
    }
}
