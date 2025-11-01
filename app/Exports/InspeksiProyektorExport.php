<?php

namespace App\Exports;

use App\Models\InspeksiProyektor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspeksiProyektorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InspeksiProyektor::select(
            'nomor_aset', 'merek', 'type', 'sn', 'departemen', 'lokasi', 'tanggal_inspeksi',
            'kondisi_casing', 'kebersihan', 'kabel_adaptor', 'lensa', 'indikator_lampu',
            'fokus_zoom', 'kecerahan_kontras', 'koneksi_input_hdmi', 'koneksi_input_vga', 'koneksi_input_usb',
            'tindakan_perbaikan', 'keterangan'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Aset', 'Merek', 'Type', 'S/N', 'Departemen', 'Lokasi', 'Tanggal Inspeksi',
            'Kondisi Casing', 'Kebersihan', 'Kabel Adaptor', 'Lensa', 'Indikator Lampu',
            'Fokus & Zoom', 'Kecerahan & Kontras', 'Input HDMI', 'Input VGA', 'Input USB',
            'Tindakan Perbaikan', 'Keterangan'
        ];
    }
}
