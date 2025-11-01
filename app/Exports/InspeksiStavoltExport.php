<?php

namespace App\Exports;

use App\Models\InspeksiStavolt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspeksiStavoltExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InspeksiStavolt::select(
            'id',
            'nomor_aset_stavolt',
            'merek',
            'type',
            'serial_number',
            'departemen',
            'lokasi',
            'tanggal_inspeksi',
            'keterangan',
            'kondisi_casing',
            'tindakan_kondisi_casing',
            'kebersihan',
            'tindakan_kebersihan',
            'kabel_adaptor',
            'tindakan_kabel_adaptor',
            'tombol_switch',
            'tindakan_tombol_switch',
            'indikator_voltage',
            'tindakan_indikator_voltage',
            'respon_perubahan_beban',
            'tindakan_respon_perubahan_beban',
            'inspektor',
            'diketahui_oleh',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nomor Aset Stavolt',
            'Merek',
            'Type',
            'Serial Number',
            'Departemen',
            'Lokasi',
            'Tanggal Inspeksi',
            'Keterangan',
            'Kondisi Casing Stavolt',
            'Tindakan Perbaikan Casing',
            'Kebersihan Stavolt',
            'Tindakan Perbaikan Kebersihan',
            'Kondisi Kabel Adaptor',
            'Tindakan Perbaikan Kabel',
            'Kondisi Tombol & Switch',
            'Tindakan Perbaikan Tombol',
            'Indikator Voltage Input/Output (220V)',
            'Tindakan Perbaikan Indikator',
            'Respon Terhadap Perubahan Beban',
            'Tindakan Perbaikan Respon',
            'Inspektor (ICT)',
            'Diketahui Oleh',
            'Dibuat Pada'
        ];
    }
}
