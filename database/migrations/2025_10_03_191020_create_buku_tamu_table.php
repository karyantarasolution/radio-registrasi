<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->id('no'); // nomor urut otomatis
            $table->string('nama');
            $table->string('nrp')->nullable();
            $table->string('instansi')->nullable();
            $table->text('keperluan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('buku_tamu');
    }
};
