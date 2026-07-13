<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMutasi extends Model
{
    use HasFactory;

    protected $table = 'stok_mutasi';

    protected $fillable = [
        'gudang_barang_id',
        'inventaris_id',
        'jenis',
        'jumlah',
        'keterangan',
    ];

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
