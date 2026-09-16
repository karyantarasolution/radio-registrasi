<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gudang_barang', function (Blueprint $table) {
            $table->string('kode_qr')->nullable()->unique()->after('merk');
            $table->string('lokasi')->nullable()->after('kode_qr');
        });
    }

    public function down(): void
    {
        Schema::table('gudang_barang', function (Blueprint $table) {
            $table->dropColumn(['kode_qr', 'lokasi']);
        });
    }
};