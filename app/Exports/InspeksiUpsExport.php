<?php

namespace App\Exports;

use App\Models\InspeksiUps;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspeksiUpsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InspeksiUps::select(
            'id','nomor_aset','merek','type','sn','departemen','lokasi','tanggal_inspeksi','keterangan',
            'casing','tindakan_casing','kebersihan','tindakan_kebersihan','kabel_adaptor','tindakan_kabel_adaptor',
            'tombol_switch','tindakan_tombol_switch','indikator_status','tindakan_indikator_status','fungsi_alarm','tindakan_fungsi_alarm',
            'respon_kehilangan_daya','tindakan_respon_kehilangan_daya','fuse','tindakan_fuse','inspektor','diketahui_oleh','created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID','Nomor Aset','Merek','Type','S/N','Departemen','Lokasi','Tanggal Inspeksi','Keterangan',
            'Casing','Tindakan Casing','Kebersihan','Tindakan Kebersihan','Kabel Adaptor','Tindakan Kabel Adaptor',
            'Tombol/Switch','Tindakan Tombol/Switch','Indikator Status','Tindakan Indikator','Fungsi Alarm','Tindakan Alarm',
            'Respon Kehilangan Daya','Tindakan Respon','Fuse','Tindakan Fuse','Inspektor','Diketahui Oleh','Dibuat'
        ];
    }
}
