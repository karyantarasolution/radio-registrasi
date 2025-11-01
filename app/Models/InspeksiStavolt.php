<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiStavolt extends Model
{
    protected $table = 'inspeksi_stavolts';

    protected $fillable = [
        'nomor_aset','merek','type','sn','departemen','lokasi','tanggal_inspeksi','keterangan',
        'casing','tindakan_casing',
        'kebersihan','tindakan_kebersihan',
        'kabel_adaptor','tindakan_kabel_adaptor',
        'tombol_switch','tindakan_tombol_switch',
        'indikator_voltase','tindakan_indikator_voltase',
        'respon_perubahan_beban','tindakan_respon_perubahan_beban',
        'inspektor','jabatan_inspektor','diketahui_oleh'
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
    ];
}
