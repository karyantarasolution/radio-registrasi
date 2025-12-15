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
            'channels' => 'nullable|array',

            // ➕ validasi tambahan
            'range_power' => 'required|string',
            'range_frekuensi' => 'required|array',
            'jenis_radio' => 'required|string',
        ]);

        $lastPtt = Registrasi::max('id_ptt'); 
        $lastNumber = $lastPtt ? intval($lastPtt) : 0;
        $idPtt = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $registrasi = new Registrasi($request->all());
        $registrasi->id_ptt = $idPtt;
        $registrasi->tanggal_permintaan = now();
        $registrasi->channels = $request->channels ?? [];

        // ➕ field baru
        $registrasi->range_power = $request->range_power;
        $registrasi->range_frekuensi = $request->range_frekuensi;
        $registrasi->jenis_radio = $request->jenis_radio;

        $registrasi->save();

        return redirect()->route('registrasi.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'perusahaan'      => 'required|string|max:255',
            'nomor_lambung'   => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'nomor_polisi'    => 'nullable|string|max:255',
            'merek_radio'     => 'nullable|string|max:255',
            'serial_number'   => 'nullable|string|max:255',
            'channels'        => 'nullable|array',

            // ➕ validasi tambahan
            'range_power' => 'required|string',
            'range_frekuensi' => 'required|array',
            'jenis_radio' => 'required|string',
        ]);

        $registrasi = Registrasi::findOrFail($id);
        $registrasi->perusahaan      = $request->perusahaan;
        $registrasi->nomor_lambung   = $request->nomor_lambung;
        $registrasi->jenis_kendaraan = $request->jenis_kendaraan;
        $registrasi->nomor_polisi    = $request->nomor_polisi;
        $registrasi->merek_radio     = $request->merek_radio;
        $registrasi->serial_number   = $request->serial_number;

        // simpan channel JSON
        $registrasi->channels = json_encode($request->channels ?? []);

        // ➕ update field baru
        $registrasi->range_power = $request->range_power;
        $registrasi->range_frekuensi = $request->range_frekuensi;
        $registrasi->jenis_radio = $request->jenis_radio;

        // 🔥 update otomatis tanggal
        $registrasi->tanggal_permintaan = now();

        $registrasi->save();

        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil diperbarui!');
    }

    public function show($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        return view('registrasi.show', compact('registrasi'));
    }

    public function edit($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        return view('registrasi.edit', compact('registrasi'));
    }

    public function destroy($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        $registrasi->delete();

        return redirect()->route('registrasi.index')->with('success', 'Data berhasil dihapus.');
    }

    public function report($id)
    {
        $registrasi = Registrasi::findOrFail($id);

        $selectedChannels = [];

        if (!empty($registrasi->channels)) {
            if (is_string($registrasi->channels)) {
                $selectedChannels = json_decode($registrasi->channels, true);
            } elseif (is_array($registrasi->channels)) {
                $selectedChannels = $registrasi->channels;
            }
        }

        $logoPath = public_path('images/logo_mining.png');

        return Pdf::loadView('registrasi.report', [
            'registrasi' => $registrasi,
            'selectedChannels' => $selectedChannels,
            'logoPath' => $logoPath
        ])->stream();
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

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN SEMUA REGISTRASI RADIO');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->fromArray(['ID', 'Perusahaan', 'No Lambung', 'ID PTT', 'Tanggal', 'Serial Number'], NULL, 'A3');

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

        $writer = new Xlsx($spreadsheet);
        $fileName = 'registrasi_all.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }
}
