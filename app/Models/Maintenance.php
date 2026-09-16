<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    public const STATUS = ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'];

    protected $fillable = [
        'nomor_maintenance',
        'gudang_barang_id',
        'inventaris_id',
        'jenis_kerusakan',
        'deskripsi_kerusakan',
        'tindakan_perbaikan',
        'biaya',
        'status',
        'petugas',
        'tanggal_masuk',
        'tanggal_selesai',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function histories()
    {
        return $this->hasMany(MaintenanceHistory::class)->orderBy('created_at', 'asc');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function inProgress()
    {
        return in_array($this->status, ['Menunggu', 'Diproses']);
    }
}