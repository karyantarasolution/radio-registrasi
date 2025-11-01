<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrasiExport;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RegistrasiController extends Controller
{
    public function index()
    {
        // ambil semua data dari tabel registrasi
        $data = Registrasi::all();
        return view('registrasi.index', compact('data'));
    }

    public function create()
    {
        return view('registrasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan' => 'required|string|max:255',
            'nomor_lambung' => 'required|string|max:50',
            'jenis_kendaraan' => 'required|string|max:100',
            'nomor_polisi' => 'nullable|string|max:50',
            'merek_radio' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:registrasis,serial_number',
            'channels' => 'nullable|array', // ✅ validasi array
        ]);

        $lastPtt = Registrasi::max('id_ptt'); 
        $lastNumber = $lastPtt ? intval($lastPtt) : 0;
        $idPtt = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $registrasi = new Registrasi($request->all());
        $registrasi->id_ptt = $idPtt;
        $registrasi->tanggal_permintaan = now();
        $registrasi->channels = $request->channels ?? []; // ✅ simpan channel dalam bentuk array
        $registrasi->save();

        return redirect()->route('registrasi.index')->with('success', 'Data berhasil disimpan.');
    }

    // ✅ Tambahan: DETAIL (Show)
    public function show($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        return view('registrasi.show', compact('registrasi'));
    }

    // ✅ Tambahan: HAPUS (Destroy)
    public function destroy($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        $registrasi->delete();

        return redirect()->route('registrasi.index')->with('success', 'Data berhasil dihapus.');
    }

    // ========== Export & Report Tetap Sama ==========

    public function report($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        $logoPath = public_path('images/logo_mining.png');
        $channels = $registrasi->channel ?? [];

        $pdf = Pdf::loadView('registrasi.report', compact('registrasi', 'logoPath', 'channels'))
            ->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = sprintf('Rev.%02d', $pageNumber);
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $size = 9;
            $x = $canvas->get_width() - 60;
            $y = $canvas->get_height() - 25;
            $canvas->text($x, $y, $text, $font, $size);
        });

        return $pdf->stream('report.pdf');
    }


    public function exportExcel($id)
    {
        $registrasi = Registrasi::findOrFail($id);

        $data = [
            ['ID', 'Perusahaan', 'No Lambung', 'ID PTT', 'Tanggal'],
            [
                $registrasi->id,
                $registrasi->perusahaan,
                $registrasi->nomor_lambung,
                $registrasi->id_ptt,
                $registrasi->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i:s'),
            ]
        ];

        return Excel::download(new \App\Exports\ArrayExport($data), "registrasi-{$id}.xlsx");
    }

    public function exportCSV($id)
    {
        $registrasi = Registrasi::findOrFail($id);

        $csvData = "ID,Perusahaan,No Lambung,ID PTT,Tanggal\n";
        $csvData .= "{$registrasi->id},{$registrasi->perusahaan},{$registrasi->nomor_lambung},{$registrasi->id_ptt},{$registrasi->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i:s')}";

        $filename = "registrasi-{$id}.csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportAllExcel()
    {
        $registrasis = Registrasi::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN SEMUA REGISTRASI RADIO');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Header tabel
        $sheet->fromArray(['ID', 'Perusahaan', 'No Lambung', 'ID PTT', 'Tanggal', 'Serial Number'], NULL, 'A3');

        // Data
        $row = 4;
        foreach ($registrasis as $r) {
            $sheet->fromArray([
                $r->id,
                $r->perusahaan,
                $r->nomor_lambung,
                $r->id_ptt,
                $r->created_at ? $r->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i:s') : '-',
                $r->serial_number,
            ], NULL, "A{$row}");
            $row++;
        }

        // Download file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'registrasi_all.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }
}
