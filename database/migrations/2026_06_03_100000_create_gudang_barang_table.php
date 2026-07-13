<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gudang_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perangkat');
            $table->string('merk')->nullable();
            $table->string('kategori');
            $table->unsignedInteger('stok_total')->default(0);
            $table->unsignedInteger('stok_tersedia')->default(0);
            $table->enum('kondisi', ['Baik', 'Perlu Maintenance', 'Rusak'])->default('Baik');
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudang_barang');
    }
};
