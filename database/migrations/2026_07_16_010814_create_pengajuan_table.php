<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->string('judul');
            $table->string('kategori');
            $table->unsignedBigInteger('gudang_barang_id')->nullable();
            $table->string('nama_barang');
            $table->integer('jumlah_diminta')->default(1);
            $table->string('satuan')->default('unit');
            $table->decimal('estimasi_biaya', 15, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Menunggu');
            $table->text('catatan_pimpinan')->nullable();
            $table->integer('jumlah_disetujui')->nullable();
            $table->unsignedBigInteger('diajukan_oleh');
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
