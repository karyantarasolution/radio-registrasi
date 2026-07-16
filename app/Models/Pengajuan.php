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
        'tanggal_pengajuan',
        'tanggal_persetujuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_persetujuan' => 'datetime',
        'jumlah_diminta' => 'integer',
        'jumlah_disetujui' => 'integer',
    ];

    public const KATEGORI = ['Pembelian', 'Maintenance'];
    public const STATUS = ['Menunggu', 'Disetujui', 'Ditolak'];

    public function user()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function gudangBarang()
    {
        return $this->belongsTo(GudangBarang::class);
    }
}
