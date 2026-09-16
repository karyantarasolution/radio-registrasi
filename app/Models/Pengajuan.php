<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GudangBarang;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengajuan',
        'judul',
        'kategori',
        'gudang_barang_id',
        'nama_barang',
        'jumlah_diminta',
        'satuan',
        'estimasi_biaya',
        'deskripsi',
        'status',
        'catatan_pimpinan',
        'jumlah_disetujui',
        'diajukan_oleh',
        'disetujui_oleh',
        'verified_by',
        'verified_at',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_persetujuan' => 'datetime',
        'verified_at' => 'datetime',
        'jumlah_diminta' => 'integer',
        'jumlah_disetujui' => 'integer',
    ];

    public const KATEGORI = ['Pembelian', 'Maintenance'];
    public const STATUS = ['Menunggu', 'Disetujui', 'Ditolak', 'Selesai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'model');
    }

    public function riwayat()
    {
        return $this->hasMany(AsetRiwayat::class, 'pengajuan_id');
    }

    public function menungguVerifikasiAdmin(): bool
    {
        return $this->status === 'Menunggu' && is_null($this->verified_by);
    }

    public function menungguPersetujuanPimpinan(): bool
    {
        return $this->status === 'Menunggu' && !is_null($this->verified_by);
    }
}
