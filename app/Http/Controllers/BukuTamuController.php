<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuTamuExport;
use Barryvdh\DomPDF\Facade\Pdf;


class BukuTamuController extends Controller
{
    private function picsGrouped()
    {
        return Pic::orderBy('departemen')->orderBy('nama')->get()->groupBy('departemen');
    }

    public function index()
    {
        $bukutamu = BukuTamu::with('pic')->orderBy('no', 'desc')->get();
        return view('bukutamu.index', compact('bukutamu'));
    }

    public function create()
    {
        $picsGrouped = $this->picsGrouped();
        return view('bukutamu.create', compact('picsGrouped'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'no_telp'   => 'nullable|string|max:20',
            'nrp'       => 'required|string|max:50',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'pic_id'    => 'required|exists:pics,id',
        ]);

        $bukutamu = BukuTamu::create($request->only(['nama', 'no_telp', 'nrp', 'instansi', 'keperluan', 'pic_id']));
        $bukutamu->load('pic');

        return redirect()->route('bukutamu.index')->with('success', 'Data berhasil ditambahkan.');
    }


    public function show(BukuTamu $bukutamu)
    {
        return view('bukutamu.show', compact('bukutamu'));
    }

    public function edit(BukuTamu $bukutamu)
    {
        $picsGrouped = $this->picsGrouped();
        return view('bukutamu.form', compact('bukutamu', 'picsGrouped'));
    }

    public function update(Request $request, BukuTamu $bukutamu)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'no_telp'   => 'nullable|string|max:20',
            'nrp'       => 'required|string|max:50',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'pic_id'    => 'required|exists:pics,id',
        ]);

        $bukutamu->update($request->only(['nama', 'no_telp', 'nrp', 'instansi', 'keperluan', 'pic_id']));
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

    public function previewReport()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isPimpinan()) {
            abort(403, 'Tidak punya akses');
        }

        $bukutamu = BukuTamu::with('pic')->orderBy('no', 'desc')->get();

        return view('bukutamu.preview', compact('bukutamu'));
    }

    private function buildReportPdf()
    {
        $bukutamu = BukuTamu::with('pic')->orderBy('no', 'desc')->get();

        return Pdf::loadView('bukutamu.report', compact('bukutamu'))
            ->setPaper('A4', 'portrait');
    }

    public function exportPDF()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isPimpinan()) {
            abort(403, 'Tidak punya akses');
        }

        return $this->buildReportPdf()->stream('laporan-bukutamu.pdf', ['Attachment' => false]);
    }

    public function downloadPDF()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isPimpinan()) {
            abort(403, 'Tidak punya akses');
        }

        return $this->buildReportPdf()->download('laporan-bukutamu.pdf');
    }
}
