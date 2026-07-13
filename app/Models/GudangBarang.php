<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangBarang extends Model
{
    use HasFactory;

    protected $table = 'gudang_barang';

    protected $fillable = [
        'nama_perangkat',
        'merk',
        'kategori',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'tanggal_masuk',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public const KONDISI = ['Baik', 'Perlu Maintenance', 'Rusak'];

    public function mutasi()
    {
        return $this->hasMany(StokMutasi::class);
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('stok_tersedia', '>', 0)
            ->where('kondisi', '!=', 'Rusak');
    }
}
