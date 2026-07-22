<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->string('range_power')->nullable();
            $table->string('range_frekuensi')->nullable();
            $table->string('jenis_radio')->nullable();
        });
    }

    public function down()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->dropColumn(['range_power', 'range_frekuensi', 'jenis_radio']);
        });
    }

};
