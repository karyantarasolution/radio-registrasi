<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('pimpinan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('pimpinan_at')->nullable();
            $table->text('catatan_persetujuan')->nullable();
            $table->boolean('butuh_persetujuan_pimpinan')->default(false);
            $table->boolean('urgent')->default(false);
            $table->foreignId('pengembalian_acc_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('pengembalian_acc_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_verifikasi',
                'pimpinan_id',
                'pimpinan_at',
                'catatan_persetujuan',
                'butuh_persetujuan_pimpinan',
                'urgent',
                'pengembalian_acc_by',
                'pengembalian_acc_at',
            ]);
        });
    }
};