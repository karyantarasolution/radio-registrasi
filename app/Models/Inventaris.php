<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    public const VERIFIKASI = ['Pending', 'Disetujui', 'Ditolak'];
    public const PEMINJAMAN = ['Pending', 'Belum Dikembalikan', 'Dikembalikan'];

    protected $table = 'inventaris';

    protected $fillable = [
        'nama',
        'nrp',
        'nama_perangkat',
        'no_asset',
        'gudang_barang_id',
        'status_peminjaman',
        'status_verifikasi',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }
}
