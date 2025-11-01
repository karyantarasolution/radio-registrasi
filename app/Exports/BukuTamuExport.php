<?php

namespace App\Exports;

use App\Models\BukuTamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuTamuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BukuTamu::select('no', 'nama', 'nrp', 'instansi', 'keperluan', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NRP',
            'Instansi',
            'Keperluan',
            'Tanggal Registrasi'
        ];
    }
}
