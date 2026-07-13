<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['Pending', 'Disetujui', 'Ditolak'])
                ->default('Pending')
                ->after('status_peminjaman');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};
