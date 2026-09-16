<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AsetRiwayat extends Model
{
    use HasFactory;

    protected $table = 'aset_riwayat';

    public const JENIS = [
        'Pembelian',
        'Peminjaman',
        'Pengembalian',
        'Maintenance',
        'Perpindahan',
        'Perbaikan',
        'Pengajuan',
        'Lainnya',
    ];

    protected $fillable = [
        'aset_type',
        'aset_id',
        'jenis',
        'deskripsi',
        'inventaris_id',
        'pengajuan_id',
        'maintenance_id',
        'user_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function aset(): MorphTo
    {
        return $this->morphTo();
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}