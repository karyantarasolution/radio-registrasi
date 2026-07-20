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

        $items = GudangBarang::whereIn('kondisi', ['Perlu Maintenance', 'Rusak'])
            ->orderBy('nama_perangkat')
            ->get();

        $stats = [
            'total' => $items->count(),
            'maintenance' => $items->where('kondisi', 'Perlu Maintenance')->count(),
            'rusak' => $items->where('kondisi', 'Rusak')->count(),
            'total_stok' => $items->sum('stok_tersedia'),
        ];

        return view('gudang.maintenance', compact('items', 'stats'));
    }
}
