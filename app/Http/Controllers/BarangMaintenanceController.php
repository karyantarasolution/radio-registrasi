<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMaintenanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::where('kondisi', 'Baik')
            ->whereColumn('stok_tersedia', '<', 'stok_total')
            ->orderBy('nama_perangkat')
            ->get();

        $stats = [
            'total' => $items->count(),
            'total_unit_maintenance' => $items->sum(function ($item) {
                return $item->stok_total - $item->stok_tersedia;
            }),
            'total_stok_tersedia' => $items->sum('stok_tersedia'),
            'total_stok' => $items->sum('stok_total'),
        ];

        return view('gudang.maintenance', compact('items', 'stats'));
    }
}
