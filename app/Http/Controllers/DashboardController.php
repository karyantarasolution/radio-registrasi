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

class DashboardController extends Controller
{
    public function index()
    {
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
            'jumlahInspeksiProyektor'
        ));
    }
}
