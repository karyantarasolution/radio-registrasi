<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Karyawan::select('nama', 'nrp', 'jabatan', 'departemen')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'NRP', 'Jabatan', 'Departemen'];
    }
}
