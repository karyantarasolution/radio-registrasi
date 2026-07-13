<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    use HasFactory;

    public const DEPARTEMEN = [
        'HCGA',
        'Produksi',
        'Logistik',
        'Engineering',
        'COE',
    ];

    protected $fillable = [
        'nama',
        'departemen',
    ];

    public function bukuTamu()
    {
        return $this->hasMany(BukuTamu::class, 'pic_id');
    }
}
