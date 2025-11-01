<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiProyektor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_aset', 'departemen', 'merek', 'lokasi', 'type', 'tanggal_inspeksi', 'sn',
        'kondisi_casing', 'tindakan_kondisi_casing',
        'kebersihan', 'tindakan_kebersihan',
        'kabel_adaptor', 'tindakan_kabel_adaptor',
        'lensa_proyektor', 'tindakan_lensa_proyektor',
        'indikator_lampu', 'tindakan_indikator_lampu',
        'fokus_zoom', 'tindakan_fokus_zoom',
        'kecerahan_kontras', 'tindakan_kecerahan_kontras',
        'koneksi_input_hdmi', 'koneksi_input_vga', 'koneksi_input_usb',
        'keterangan',
        'inspektor', 'jabatan_inspektor', 'diketahui_oleh'
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
    ];
}
