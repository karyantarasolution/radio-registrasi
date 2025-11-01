<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarisController extends Controller
{
   public function index(Request $request)
   {
        $query = Inventaris::query();

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        $inventaris = $query->get();

        return view('inventaris.index', compact('inventaris'));
    }


    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nrp' => 'required|string',
            'nama_perangkat' => 'required|string',
            'no_asset' => 'required|string',
            'status_peminjaman' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
        ]);

        Inventaris::create($request->all());
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());

        // Otomatis isi tanggal_pengembalian jika dikembalikan
        if ($inventaris->status_peminjaman === 'Dikembalikan' && !$inventaris->tanggal_pengembalian) {
            $inventaris->update(['tanggal_pengembalian' => now()]);
        }

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Inventaris::findOrFail($id)->delete();
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil dihapus.');
    }

    // Export ke PDF
    public function report()
    {
        $inventaris = Inventaris::all();

        $pdf = Pdf::loadView('inventaris.report', compact('inventaris'))
                ->setPaper('a4', 'portrait');

        // Menampilkan di browser tanpa download otomatis
        return $pdf->stream('Laporan-Inventaris.pdf');
    }
}
