<?php

namespace App\Exports;

use App\Models\Registrasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrasiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Registrasi::select(
            'id_ptt',
            'perusahaan',
            'nomor_lambung',
            'jenis_kendaraan',
            'nomor_polisi',
            'merek_radio',
            'serial_number',
            'tanggal_permintaan'
            
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID PTT',
            'Perusahaan',
            'Nomor Lambung',
            'Jenis Kendaraan',
            'Nomor Polisi',
            'Merek Radio',
            'Serial Number',
            'Tanggal Permintaan',
        ];
    }
}
