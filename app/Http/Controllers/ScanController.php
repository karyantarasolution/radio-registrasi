<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\Maintenance;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return redirect()->route('scan.index')->with('error', 'Masukkan minimal 2 karakter kode/nomor aset.');
        }

        $gudang = GudangBarang::where(function ($query) use ($q) {
            $query->where('kode_qr', 'LIKE', "%{$q}%")
                ->orWhere('nama_perangkat', 'LIKE', "%{$q}%")
                ->orWhere('merk', 'LIKE', "%{$q}%")
                ->orWhere('lokasi', 'LIKE', "%{$q}%")
                ->orWhere('kategori', 'LIKE', "%{$q}%");
        })->orderBy('nama_perangkat')->get();

        $radio = Registrasi::where(function ($query) use ($q) {
            $query->where('kode_qr', 'LIKE', "%{$q}%")
                ->orWhere('id_ptt', 'LIKE', "%{$q}%")
                ->orWhere('serial_number', 'LIKE', "%{$q}%")
                ->orWhere('nomor_lambung', 'LIKE', "%{$q}%")
                ->orWhere('perusahaan', 'LIKE', "%{$q}%")
                ->orWhere('merek_radio', 'LIKE', "%{$q}%");
        })->orderBy('created_at', 'desc')->get();

        $statusGudang = [];
        foreach ($gudang as $item) {
            $dipinjam = Inventaris::where('gudang_barang_id', $item->id)
                ->whereIn('status_peminjaman', ['Belum Dikembalikan', 'Pending Pengembalian'])
                ->count();
            $maintenanceAktif = Maintenance::where('gudang_barang_id', $item->id)
                ->whereIn('status', ['Menunggu', 'Diproses'])
                ->count();

            $statusGudang[$item->id] = [
                'dipinjam' => $dipinjam,
                'maintenance' => $maintenanceAktif,
                'tersedia' => max(0, $item->stok_tersedia),
            ];
        }

        $hasQuery = strlen($q) >= 2;

        return view('scan.result', compact('gudang', 'radio', 'statusGudang', 'q', 'hasQuery'));
    }
}