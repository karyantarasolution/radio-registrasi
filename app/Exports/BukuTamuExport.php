<?php

namespace App\Exports;

use App\Models\BukuTamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuTamuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BukuTamu::with('pic')->orderBy('no', 'desc')->get()->map(function ($tamu) {
            return [
                'no' => $tamu->no,
                'nama' => $tamu->nama,
                'nrp' => $tamu->nrp,
                'instansi' => $tamu->instansi,
                'keperluan' => $tamu->keperluan,
                'pic' => $tamu->pic->nama ?? '-',
                'departemen_pic' => $tamu->pic->departemen ?? '-',
                'created_at' => $tamu->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NRP',
            'Instansi',
            'Keperluan',
            'PIC',
            'Departemen PIC',
            'Tanggal Registrasi',
        ];
    }
}
