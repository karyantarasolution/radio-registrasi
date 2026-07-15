<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiPengembalian extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_pengembalian';

    protected $fillable = [
        'inventaris_id',
        'kondisi_barang',
        'foto_sebelum',
        'foto_sesudah',
        'catatan',
        'dikembalikan_oleh',
    ];

    public const KONDISI = ['Baik', 'Rusak Ringan', 'Rusak Berat'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
