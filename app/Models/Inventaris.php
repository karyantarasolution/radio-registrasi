<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    public const VERIFIKASI = ['Pending', 'Disetujui', 'Ditolak'];
    public const PEMINJAMAN = ['Pending', 'Belum Dikembalikan', 'Pending Pengembalian', 'Dikembalikan'];
    public const PERSETUJUAN = ['Pending', 'Disetujui', 'Ditolak'];
    public const KONDISI_PENGEMBALIAN = ['Baik', 'Rusak Ringan', 'Rusak Berat'];

    protected $table = 'inventaris';

    protected $fillable = [
        'user_id',
        'nama',
        'nrp',
        'nama_perangkat',
        'no_asset',
        'gudang_barang_id',
        'status_peminjaman',
        'status_verifikasi',
        'status_persetujuan',
        'approved_by',
        'approved_at',
        'tanggal_peminjaman',
        'lama_pinjam',
        'tanggal_pengembalian',
        'tanggal_actual_kembali',
        'kondisi_pengembalian',
        'catatan_pengembalian',
        'foto_pengembalian',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'tanggal_pengembalian' => 'date',
        'tanggal_actual_kembali' => 'date',
    ];

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function dokumentasi()
    {
        return $this->hasOne(DokumentasiPengembalian::class);
    }

    public function isOverdue()
    {
        return $this->tanggal_pengembalian
            && $this->status_peminjaman === 'Belum Dikembalikan'
            && $this->tanggal_pengembalian->isPast();
    }
}
