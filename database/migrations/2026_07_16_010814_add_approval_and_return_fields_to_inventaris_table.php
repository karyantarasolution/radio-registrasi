<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->enum('status_persetujuan', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending')->after('status_verifikasi');
            $table->unsignedBigInteger('approved_by')->nullable()->after('status_persetujuan');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->date('tanggal_actual_kembali')->nullable()->after('tanggal_pengembalian');
            $table->enum('kondisi_pengembalian', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->nullable()->after('tanggal_actual_kembali');
            $table->text('catatan_pengembalian')->nullable()->after('kondisi_pengembalian');
            $table->string('foto_pengembalian')->nullable()->after('catatan_pengembalian');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn([
                'status_persetujuan', 'approved_by', 'approved_at',
                'tanggal_actual_kembali', 'kondisi_pengembalian',
                'catatan_pengembalian', 'foto_pengembalian'
            ]);
        });
    }
};
