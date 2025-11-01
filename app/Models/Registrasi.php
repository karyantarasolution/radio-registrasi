<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'registrasis';

    // Field yang bisa diisi (harus sama dengan migration)
    protected $fillable = [
        'perusahaan',
        'nomor_lambung',
        'jenis_kendaraan',
        'nomor_polisi',
        'id_ptt',
        'merek_radio',
        'serial_number',
        'tanggal_permintaan',
        'channels',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'channels' => 'array',
    ];

}
