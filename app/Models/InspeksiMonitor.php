<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiMonitor extends Model
{
    protected $table = 'inspeksi_monitor';

    protected $fillable = [
        'nomor_aset','merek','type','sn','departemen','lokasi','tanggal_inspeksi','keterangan',
        'tampilan_layer','tindakan_tampilan_layer',
        'kabel_power','tindakan_kabel_power',
        'bracket_dudukan','tindakan_bracket_dudukan',
        'kebersihan','tindakan_kebersihan',
        'stop_kontak','tindakan_stop_kontak',
        'inspektor','jabatan_inspektor','diketahui_oleh',
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
    ];
}
