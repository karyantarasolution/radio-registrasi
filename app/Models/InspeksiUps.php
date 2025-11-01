<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiUps extends Model
{
    protected $table = 'inspeksi_ups';

    protected $fillable = [
        'nomor_aset','merek','type','sn','departemen','lokasi','tanggal_inspeksi','keterangan',
        'casing','tindakan_casing',
        'kebersihan','tindakan_kebersihan',
        'kabel_adaptor','tindakan_kabel_adaptor',
        'tombol_switch','tindakan_tombol_switch',
        'indikator_status','tindakan_indikator_status',
        'fungsi_alarm','tindakan_fungsi_alarm',
        'respon_kehilangan_daya','tindakan_respon_kehilangan_daya',
        'fuse','tindakan_fuse',
        'inspektor','diketahui_oleh'
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
    ];
}
