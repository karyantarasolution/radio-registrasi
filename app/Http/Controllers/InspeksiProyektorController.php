<?php

namespace App\Http\Controllers;

use App\Models\InspeksiProyektor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InspeksiProyektorExport;
use Maatwebsite\Excel\Facades\Excel;

class InspeksiProyektorController extends Controller
{
    public function index()
    {
        $data = InspeksiProyektor::latest()->paginate(15);
        return view('inspeksiproyektor.index', compact('data'));
    }

    public function create()
    {
        return view('inspeksiproyektor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',

            'kondisi_casing' => 'nullable|string|max:20',
            'tindakan_kondisi_casing' => 'nullable|string',
            'kebersihan' => 'nullable|string|max:20',
            'tindakan_kebersihan' => 'nullable|string',
            'kabel_adaptor' => 'nullable|string|max:20',
            'tindakan_kabel_adaptor' => 'nullable|string',
            'lensa_proyektor' => 'nullable|string|max:20',
            'tindakan_lensa_proyektor' => 'nullable|string',
            'indikator_lampu' => 'nullable|string|max:20',
            'tindakan_indikator_lampu' => 'nullable|string',
            'fokus_zoom' => 'nullable|string|max:20',
            'tindakan_fokus_zoom' => 'nullable|string',
            'kecerahan_kontras' => 'nullable|string|max:20',
            'tindakan_kecerahan_kontras' => 'nullable|string',
            'koneksi_input_hdmi' => 'nullable|string|max:10',
            'koneksi_input_vga' => 'nullable|string|max:10',
            'koneksi_input_usb' => 'nullable|string|max:10',

            'keterangan' => 'nullable|string',
            'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ]);

        InspeksiProyektor::create($validated);

        return redirect()->route('inspeksiproyektor.index')->with('success', 'Data inspeksi proyektor berhasil disimpan.');
    }

    public function edit(InspeksiProyektor $inspeksiproyektor)
    {
        return view('inspeksiproyektor.edit', compact('inspeksiproyektor'));
    }

    public function update(Request $request, InspeksiProyektor $inspeksiproyektor)
    {
        $validated = $request->validate([
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',

            'kondisi_casing' => 'nullable|string|max:20',
            'tindakan_kondisi_casing' => 'nullable|string',
            'kebersihan' => 'nullable|string|max:20',
            'tindakan_kebersihan' => 'nullable|string',
            'kabel_adaptor' => 'nullable|string|max:20',
            'tindakan_kabel_adaptor' => 'nullable|string',
            'lensa_proyektor' => 'nullable|string|max:20',
            'tindakan_lensa_proyektor' => 'nullable|string',
            'indikator_lampu' => 'nullable|string|max:20',
            'tindakan_indikator_lampu' => 'nullable|string',
            'fokus_zoom' => 'nullable|string|max:20',
            'tindakan_fokus_zoom' => 'nullable|string',
            'kecerahan_kontras' => 'nullable|string|max:20',
            'tindakan_kecerahan_kontras' => 'nullable|string',
            'koneksi_input_hdmi' => 'nullable|string|max:10',
            'koneksi_input_vga' => 'nullable|string|max:10',
            'koneksi_input_usb' => 'nullable|string|max:10',

            'keterangan' => 'nullable|string',
            'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ]);

        $inspeksiproyektor->update($validated);

        return redirect()->route('inspeksiproyektor.index')->with('success', 'Data inspeksi proyektor berhasil diperbarui.');
    }

    public function destroy(InspeksiProyektor $inspeksiproyektor)
    {
        $inspeksiproyektor->delete();
        return redirect()->route('inspeksiproyektor.index')->with('success', 'Data inspeksi proyektor berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new InspeksiProyektorExport, 'inspeksi_proyektor.xlsx');
    }

    public function report($id)
    {
        $inspeksiproyektor = InspeksiProyektor::findOrFail($id);
        $pdf = Pdf::loadView('inspeksiproyektor.report', compact('inspeksiproyektor'))->setPaper('A4', 'portrait');
        return $pdf->stream('inspeksi-proyektor-' . $inspeksiproyektor->id . '.pdf');
    }
}
