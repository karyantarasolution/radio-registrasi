<?php

namespace App\Http\Controllers;

use App\Models\InspeksiStavolt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InspeksiStavoltExport; // nanti bikin

class InspeksiStavoltController extends Controller
{
    public function index()
    {
        $data = InspeksiStavolt::latest()->paginate(15);
        return view('inspeksistavolt.index', compact('data'));
    }

    public function create()
    {
        return view('inspeksistavolt.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nomor_aset'=>'nullable|string|max:255',
            'merek'=>'nullable|string|max:255',
            'type'=>'nullable|string|max:255',
            'sn'=>'nullable|string|max:255',
            'departemen'=>'nullable|string|max:255',
            'lokasi'=>'nullable|string|max:255',
            'tanggal_inspeksi'=>'nullable|date',
            'keterangan'=>'nullable|string',

            'casing'=>'nullable|string|max:20',
            'tindakan_casing'=>'nullable|string',
            'kebersihan'=>'nullable|string|max:20',
            'tindakan_kebersihan'=>'nullable|string',
            'kabel_adaptor'=>'nullable|string|max:20',
            'tindakan_kabel_adaptor'=>'nullable|string',
            'tombol_switch'=>'nullable|string|max:20',
            'tindakan_tombol_switch'=>'nullable|string',
            'indikator_voltase'=>'nullable|string|max:20',
            'tindakan_indikator_voltase'=>'nullable|string',
            'respon_perubahan_beban'=>'nullable|string|max:20',
            'tindakan_respon_perubahan_beban'=>'nullable|string',

            'inspektor'=>'nullable|string|max:255',
            'jabatan_inspektor'=>'nullable|string|max:255',
            'diketahui_oleh'=>'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        InspeksiStavolt::create($validated);

        return redirect()->route('inspeksistavolt.index')->with('success','Data inspeksi Stavolt disimpan.');
    }

    public function show(InspeksiStavolt $inspeksistavolt)
    {
        return view('inspeksistavolt.show', compact('inspeksistavolt'));
    }

    public function edit(InspeksiStavolt $inspeksistavolt)
    {
        return view('inspeksistavolt.edit', compact('inspeksistavolt'));
    }

    public function update(Request $request, InspeksiStavolt $inspeksistavolt)
    {
        $rules = [
            'nomor_aset'=>'nullable|string|max:255',
            'merek'=>'nullable|string|max:255',
            'type'=>'nullable|string|max:255',
            'sn'=>'nullable|string|max:255',
            'departemen'=>'nullable|string|max:255',
            'lokasi'=>'nullable|string|max:255',
            'tanggal_inspeksi'=>'nullable|date',
            'keterangan'=>'nullable|string',

            'casing'=>'nullable|string|max:20',
            'tindakan_casing'=>'nullable|string',
            'kebersihan'=>'nullable|string|max:20',
            'tindakan_kebersihan'=>'nullable|string',
            'kabel_adaptor'=>'nullable|string|max:20',
            'tindakan_kabel_adaptor'=>'nullable|string',
            'tombol_switch'=>'nullable|string|max:20',
            'tindakan_tombol_switch'=>'nullable|string',
            'indikator_voltase'=>'nullable|string|max:20',
            'tindakan_indikator_voltase'=>'nullable|string',
            'respon_perubahan_beban'=>'nullable|string|max:20',
            'tindakan_respon_perubahan_beban'=>'nullable|string',

            'inspektor'=>'nullable|string|max:255',
            'jabatan_inspektor'=>'nullable|string|max:255',
            'diketahui_oleh'=>'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);

        $inspeksistavolt->update($validated);

        return redirect()->route('inspeksistavolt.index')->with('success','Data diperbarui.');
    }


    public function destroy(InspeksiStavolt $inspeksistavolt)
    {
        $inspeksistavolt->delete();
        return redirect()->route('inspeksistavolt.index')->with('success','Data dihapus.');
    }

    // export Excel seluruh data
    public function exportExcel()
    {
        return Excel::download(new InspeksiStavoltExport, 'inspeksi-stavolt.xlsx');
    }

    // export PDF semua
    public function exportPDF()
    {
        $data = InspeksiStavolt::latest()->get();
        $pdf = Pdf::loadView('inspeksistavolt.report_all', compact('data'))->setPaper('A4','portrait');
        return $pdf->stream('laporan-inspeksi-stavolt.pdf');
    }

    // report per data
    public function report(InspeksiStavolt $inspeksistavolt)
    {
        $pdf = Pdf::loadView('inspeksistavolt.report', compact('inspeksistavolt'))->setPaper('A4','portrait');

        // optional page script numbering
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = sprintf('Rev.%02d', $pageNumber);
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $size = 9;
            $x = $canvas->get_width() - 60;
            $y = $canvas->get_height() - 25;
            $canvas->text($x, $y, $text, $font, $size);
        });

        return $pdf->stream('inspeksi-stavolt-'.$inspeksistavolt->id.'.pdf');
    }
}
