<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('ict', 'user', 'admin_ict', 'pimpinan', 'karyawan', 'tamu') DEFAULT 'user'");

        DB::table('users')->where('name', 'ICT')->update(['role' => 'admin_ict', 'nrp' => 'ICT']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'admin_ict')->update(['role' => 'ict', 'nrp' => null]);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('ict', 'user') DEFAULT 'user'");
    }
};
