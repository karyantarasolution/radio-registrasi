<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE inventaris MODIFY COLUMN status_peminjaman ENUM('Pending','Belum Dikembalikan','Pending Pengembalian','Dikembalikan') DEFAULT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE inventaris MODIFY COLUMN status_peminjaman ENUM('Pending','Menunggu Persetujuan','Belum Dikembalikan','Dikembalikan') DEFAULT NULL");
    }
};
