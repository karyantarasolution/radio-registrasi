<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registrasis', function (Blueprint $table) {
            $table->id();
            $table->string('perusahaan');
            $table->string('nomor_lambung');
            $table->string('jenis_kendaraan');
            $table->string('nomor_polisi');
            $table->string('id_ptt')->unique();
            $table->string('merek_radio');
            $table->string('serial_number');
            $table->date('tanggal_permintaan')->useCurrent(); // ✅ otomatis tanggal hari ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};

