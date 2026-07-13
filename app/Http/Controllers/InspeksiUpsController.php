<?php

namespace App\Http\Controllers;

use App\Models\InspeksiUps;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InspeksiUpsExport;
use App\Models\Karyawan;

class InspeksiUpsController extends Controller
{
    // 📄 Tampilkan semua data inspeksi
    public function index(Request $request)
    {
        $query = InspeksiUps::query();

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

        return view('inspeksiups.index', compact('data'));
    }

    // ➕ Form tambah inspeksi baru


    public function create()
    {
        $karyawans = Karyawan::where('jabatan', 'ICT', 'H.ICT')->get();
        $leaders = Karyawan::where('jabatan', 'Group Leader ICT')->get();

        return view('inspeksiups.create', compact('karyawans', 'leaders'));
    }

    // 💾 Simpan data baru
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
            'keterangan' => 'nullable|string|max:500',

            // Tambahkan semua kolom pemeriksaan
            'casing' => 'nullable|string|max:20',
            'kebersihan' => 'nullable|string|max:20',
            'kabel_adaptor' => 'nullable|string|max:20',
            'tombol_switch' => 'nullable|string|max:20',
            'indikator_status' => 'nullable|string|max:20',
            'fungsi_alarm' => 'nullable|string|max:20',
            'respon_kehilangan_daya' => 'nullable|string|max:20',
            'fuse' => 'nullable|string|max:20',

            // Kolom tindakan
            'tindakan_casing' => 'nullable|string|max:255',
            'tindakan_kebersihan' => 'nullable|string|max:255',
            'tindakan_kabel_adaptor' => 'nullable|string|max:255',
            'tindakan_tombol_switch' => 'nullable|string|max:255',
            'tindakan_indikator_status' => 'nullable|string|max:255',
            'tindakan_fungsi_alarm' => 'nullable|string|max:255',
            'tindakan_respon_kehilangan_daya' => 'nullable|string|max:255',
            'tindakan_fuse' => 'nullable|string|max:255',

            'inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        InspeksiUps::create($validated);

        return redirect()->route('inspeksiups.index')
                        ->with('success', 'Data inspeksi UPS berhasil disimpan.');
    }
    // 👁️ Lihat detail inspeksi
    public function show(InspeksiUps $inspeksiup)
    {
        return view('inspeksiups.show', compact('inspeksiup'));
    }

    // ✏️ Form edit inspeksi
    public function edit($id)
    {
        $inspeksiups = InspeksiUps::findOrFail($id);
        $karyawans = Karyawan::where('jabatan', 'ICT', 'H.ICT')->get();
        $leaders = Karyawan::where('jabatan', 'Group Leader ICT')->get();

        return view('inspeksiups.edit', compact(
            'inspeksiups',
            'karyawans',
            'leaders'
        ));
    }


    // 🔄 Update data inspeksi
    public function update(Request $request, InspeksiUps $inspeksiup)
    {
        $rules = [
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',
            'keterangan' => 'nullable|string|max:500',

            'casing' => 'nullable|string|max:20',
            'kebersihan' => 'nullable|string|max:20',
            'kabel_adaptor' => 'nullable|string|max:20',
            'tombol_switch' => 'nullable|string|max:20',
            'indikator_status' => 'nullable|string|max:20',
            'fungsi_alarm' => 'nullable|string|max:20',
            'respon_kehilangan_daya' => 'nullable|string|max:20',
            'fuse' => 'nullable|string|max:20',

            'tindakan_casing' => 'nullable|string|max:255',
            'tindakan_kebersihan' => 'nullable|string|max:255',
            'tindakan_kabel_adaptor' => 'nullable|string|max:255',
            'tindakan_tombol_switch' => 'nullable|string|max:255',
            'tindakan_indikator_status' => 'nullable|string|max:255',
            'tindakan_fungsi_alarm' => 'nullable|string|max:255',
            'tindakan_respon_kehilangan_daya' => 'nullable|string|max:255',
            'tindakan_fuse' => 'nullable|string|max:255',

            'inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);
        $inspeksiup->update($validated);

        return redirect()->route('inspeksiups.index')
                        ->with('success', 'Data inspeksi UPS berhasil diperbarui.');
    }

    // 🗑️ Hapus data inspeksi
    public function destroy(InspeksiUps $inspeksiup)
    {
        $inspeksiup->delete();
        return redirect()->route('inspeksiups.index')
                         ->with('success', 'Data inspeksi UPS berhasil dihapus.');
    }

    // 📄 Export seluruh data ke PDF (Laporan Semua)
    public function exportPDF()
    {
        $data = InspeksiUps::latest()->get();
        $pdf = Pdf::loadView('inspeksiups.report_all', compact('data'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-inspeksi-ups.pdf');
    }

    // 📋 Export seluruh data ke Excel
    public function exportExcel()
    {
        return Excel::download(new InspeksiUpsExport, 'laporan-inspeksi-ups.xlsx');
    }

    // 📋 Cetak satu laporan (per data) dalam bentuk PDF
    public function report($id)
    {
        $inspeksiup = InspeksiUps::findOrFail($id);

        $pdf = Pdf::loadView('inspeksiups.report', compact('inspeksiup'))
                  ->setPaper('A4', 'portrait');

        // Tambahkan revisi halaman otomatis (opsional)
        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = sprintf('Rev.%02d', $pageNumber);
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $size = 9;
            $x = $canvas->get_width() - 60;
            $y = $canvas->get_height() - 25;
            $canvas->text($x, $y, $text, $font, $size);
        });

        return $pdf->stream('laporan-inspeksi-ups-'.$id.'.pdf');
    }
}
