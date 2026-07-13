<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = 'buku_tamu';   // nama tabel
    protected $primaryKey = 'no';     // primary key
    public $incrementing = true;      // jika kolom "no" auto increment
    protected $keyType = 'int';       // tipe data primary key

    protected $fillable = [
        'nama',
        'nrp',
        'no_telp',
        'instansi',
        'keperluan',
        'pic_id',
    ];

    public function pic()
    {
        return $this->belongsTo(Pic::class);
    }

    /**
     * Override supaya route model binding pakai kolom "no"
     */
    public function getRouteKeyName()
    {
        return 'no';
    }
}
