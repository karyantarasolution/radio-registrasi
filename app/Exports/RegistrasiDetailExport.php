<?php

namespace App\Exports;

use App\Models\Registrasi;
use Maatwebsite\Excel\Concerns\FromArray;

class RegistrasiDetailExport implements FromArray
{
    protected $registrasi;

    public function __construct(Registrasi $registrasi)
    {
        $this->registrasi = $registrasi;
    }

    public function array(): array
    {
        return [
            ['LAPORAN REGISTRASI RADIO'],
            ['Tanggal', $this->registrasi->tanggal_permintaan->format('d/m/Y')],
            ['ID PTT', $this->registrasi->id_ptt],
            ['Perusahaan', $this->registrasi->perusahaan],
            ['Nomor Lambung', $this->registrasi->nomor_lambung],
            ['Merek Radio', $this->registrasi->merek_radio],
            ['Serial Number', $this->registrasi->serial_number],
        ];
    }
}
