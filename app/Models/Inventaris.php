<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = [
        'nama',
        'nrp',
        'nama_perangkat',
        'no_asset',
        'status_peminjaman',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];
}
