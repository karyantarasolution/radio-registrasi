<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->foreignId('gudang_barang_id')->nullable()->after('no_asset')
                ->constrained('gudang_barang')->nullOnDelete();
        });

        DB::statement("ALTER TABLE inventaris MODIFY status_peminjaman ENUM('Pending', 'Belum Dikembalikan', 'Dikembalikan') DEFAULT 'Pending'");
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropForeign(['gudang_barang_id']);
            $table->dropColumn('gudang_barang_id');
        });

        DB::statement("ALTER TABLE inventaris MODIFY status_peminjaman ENUM('Belum Dikembalikan', 'Dikembalikan') DEFAULT 'Belum Dikembalikan'");
    }
};
