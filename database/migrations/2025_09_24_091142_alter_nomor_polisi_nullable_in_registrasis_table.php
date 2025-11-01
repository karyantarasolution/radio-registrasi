<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->string('nomor_polisi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->string('nomor_polisi')->nullable(false)->change();
        });
    }
};