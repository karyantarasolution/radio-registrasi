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
        'catatan_verifikasi',
        'pimpinan_id',
        'pimpinan_at',
        'catatan_persetujuan',
        'butuh_persetujuan_pimpinan',
        'urgent',
        'pengembalian_acc_by',
        'pengembalian_acc_at',
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
        'pimpinan_at' => 'datetime',
        'pengembalian_acc_at' => 'datetime',
        'butuh_persetujuan_pimpinan' => 'boolean',
        'urgent' => 'boolean',
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

    public function pimpinan()
    {
        return $this->belongsTo(User::class, 'pimpinan_id');
    }

    public function pengembalianAccBy()
    {
        return $this->belongsTo(User::class, 'pengembalian_acc_by');
    }

    public function dokumentasi()
    {
        return $this->hasOne(DokumentasiPengembalian::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'model');
    }

    public function riwayat()
    {
        return $this->hasMany(AsetRiwayat::class, 'inventaris_id');
    }

    public function isOverdue()
    {
        return $this->tanggal_pengembalian
            && $this->status_peminjaman === 'Belum Dikembalikan'
            && $this->tanggal_pengembalian->isPast();
    }

    public function menungguPersetujuanPimpinan(): bool
    {
        return $this->status_verifikasi === 'Disetujui'
            && $this->status_persetujuan === 'Pending'
            && $this->status_peminjaman === 'Pending';
    }

    public function daysUntilReturn(): ?int
    {
        if (!$this->tanggal_pengembalian || $this->status_peminjaman !== 'Belum Dikembalikan') {
            return null;
        }
        return (int) now()->startOfDay()->diffInDays($this->tanggal_pengembalian, false);
    }
}
