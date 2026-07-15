<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained()->cascadeOnDelete();
            $table->enum('kondisi_barang', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->text('catatan')->nullable();
            $table->string('dikembalikan_oleh');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_pengembalian');
    }
};
