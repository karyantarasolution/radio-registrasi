<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE users
            INNER JOIN karyawans ON karyawans.nrp = users.nrp
            SET users.jabatan = karyawans.jabatan
            WHERE (users.jabatan IS NULL OR users.jabatan = '')
        ");
    }

    public function down(): void
    {
        //
    }
};
