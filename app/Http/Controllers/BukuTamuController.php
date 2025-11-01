<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuTamuExport;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuTamuController extends Controller
{
    public function index()
    {
        $bukutamu = BukuTamu::all();
        return view('bukutamu.index', compact('bukutamu'));
    }

    public function create()
    {
        return view('bukutamu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nrp'       => 'required|string|max:50',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
        ]);

        BukuTamu::create($request->all());
        return redirect()->route('bukutamu.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(BukuTamu $bukutamu)
    {
        return view('bukutamu.show', compact('bukutamu'));
    }

    public function edit(BukuTamu $bukutamu)
    {
        return view('bukutamu.edit', compact('bukutamu'));
    }

    public function update(Request $request, BukuTamu $bukutamu)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nrp'       => 'required|string|max:50',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
        ]);

        $bukutamu->update($request->all());
        return redirect()->route('bukutamu.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(BukuTamu $bukutamu)
    {
        $bukutamu->delete();
        return redirect()->route('bukutamu.index')->with('success', 'Data berhasil dihapus.');
    }

    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new BukuTamuExport, 'bukutamu.xlsx');
    }

    // Export PDF
    public function exportPDF()
    {
        $bukutamu = BukuTamu::all();
        $pdf = Pdf::loadView('bukutamu.report', compact('bukutamu'))
                  ->setPaper('A4', 'portrait'); 

        return $pdf->stream('laporan-bukutamu.pdf');
    }
}
