<?php

namespace App\Http\Controllers;

use App\Models\InspeksiMonitor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan package dompdf terpasang
use App\Exports\InspeksiMonitorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Karyawan;

class InspeksiMonitorController extends Controller
{
    public function index(Request $request)
    {
        $query = InspeksiMonitor::query();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_inspeksi', $request->tanggal);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_inspeksi', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_inspeksi', $request->tahun);
        }

        $data = $query->latest()->paginate(15)->withQueryString();

        return view('inspeksimonitor.index', compact('data'));
    }

        public function create()
        {
            $karyawans = Karyawan::where('jabatan', 'ICT', 'H.ICT')->get();
            $leaders = Karyawan::where('jabatan', 'Group Leader ICT')->get();

            return view('inspeksimonitor.create', compact('karyawans', 'leaders'));
        }

    public function store(Request $request)
    {
        $rules = [
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',
            'keterangan' => 'nullable|string',

            'tampilan_layer' => 'nullable|string|max:20',
            'kabel_power' => 'nullable|string|max:20',
            'bracket_dudukan' => 'nullable|string|max:20',
            'kebersihan' => 'nullable|string|max:20',
            'stop_kontak' => 'nullable|string|max:20',

            'tindakan_tampilan_layer' => 'nullable|string',
            'tindakan_kabel_power' => 'nullable|string',
            'tindakan_bracket_dudukan' => 'nullable|string',
            'tindakan_kebersihan' => 'nullable|string',
            'tindakan_stop_kontak' => 'nullable|string',

            'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        InspeksiMonitor::create($validated);

        return redirect()->route('inspeksimonitor.index')->with('success', 'Data inspeksi monitor berhasil disimpan.');
    }

    public function show(InspeksiMonitor $inspeksimonitor)
    {
        return view('inspeksimonitor.show', compact('inspeksimonitor'));
    }

   public function edit($id)
    {
        $inspeksimonitor = InspeksiMonitor::findOrFail($id);
        $karyawans = Karyawan::where('jabatan', 'ICT')->get();
        $leaders = Karyawan::where('jabatan', 'Group Leader ICT')->get();

        return view('inspeksimonitor.edit', compact('inspeksimonitor', 'karyawans', 'leaders'));
    }

    public function update(Request $request, InspeksiMonitor $inspeksimonitor)
    {
        $rules = [
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',
            'keterangan' => 'nullable|string',

            'tampilan_layer' => 'nullable|string|max:20',
            'kabel_power' => 'nullable|string|max:20',
            'bracket_dudukan' => 'nullable|string|max:20',
            'kebersihan' => 'nullable|string|max:20',
            'stop_kontak' => 'nullable|string|max:20',

            'tindakan_tampilan_layer' => 'nullable|string',
            'tindakan_kabel_power' => 'nullable|string',
            'tindakan_bracket_dudukan' => 'nullable|string',
            'tindakan_kebersihan' => 'nullable|string',
            'tindakan_stop_kontak' => 'nullable|string',

            'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        $inspeksimonitor->update($validated);

        return redirect()->route('inspeksimonitor.index')->with('success', 'Data inspeksi monitor berhasil diperbarui.');
    }

    public function destroy(InspeksiMonitor $inspeksimonitor)
    {
        $inspeksimonitor->delete();
        return redirect()->route('inspeksimonitor.index')->with('success', 'Data inspeksi monitor berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new InspeksiMonitorExport, 'inspeksi_monitor.xlsx');
    }

    // PDF per-data (report)
    public function report($id)
    {
        $inspeksimonitor = InspeksiMonitor::findOrFail($id);

        $pdf = Pdf::loadView('inspeksimonitor.report', compact('inspeksimonitor'))
                  ->setPaper('A4', 'portrait');

        // optional: page revision on footer
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = sprintf('Rev.%02d', $pageNumber);
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $size = 9;
            $x = $canvas->get_width() - 60;
            $y = $canvas->get_height() - 25;
            $canvas->text($x, $y, $text, $font, $size);
        });

        return $pdf->stream('inspeksi-monitor-' . $inspeksimonitor->id . '.pdf');
    }
}
