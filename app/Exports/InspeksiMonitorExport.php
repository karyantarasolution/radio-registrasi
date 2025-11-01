<?php

namespace App\Exports;

use App\Models\InspeksiMonitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspeksiMonitorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InspeksiMonitor::select(
            'id','nomor_aset','merek','type','sn','waktu_inspeksi','keterangan',
            'layer_monitor','tindakan_layer_monitor',
            'kabel_power','tindakan_kabel_power',
            'bracket_dudukan','tindakan_bracket_dudukan',
            'kebersihan_monitor','tindakan_kebersihan_monitor',
            'stop_kontak','tindakan_stop_kontak',
            'inspektor','diketahui_oleh','created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID','Nomor Aset Monitor/TV','Merek','Type','S/N','Waktu Inspeksi','Keterangan',
            'Tampilan Layer Monitor','Tindakan Layer Monitor',
            'Kondisi Kabel Power','Tindakan Kabel Power',
            'Kondisi Bracket Dudukan','Tindakan Bracket Dudukan',
            'Kebersihan Monitor','Tindakan Kebersihan Monitor',
            'Kondisi Stop Kontak','Tindakan Stop Kontak',
            'Inspektor','Diketahui Oleh','Dibuat'
        ];
    }
}
