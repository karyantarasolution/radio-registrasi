<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_maintenance')->unique();
            $table->foreignId('gudang_barang_id')->constrained('gudang_barang')->cascadeOnDelete();
            $table->foreignId('inventaris_id')->nullable()->constrained('inventaris')->nullOnDelete();
            $table->string('jenis_kerusakan');
            $table->text('deskripsi_kerusakan')->nullable();
            $table->text('tindakan_perbaikan')->nullable();
            $table->decimal('biaya', 15, 2)->nullable();
            $table->string('status')->default('Menunggu');
            $table->string('petugas')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};