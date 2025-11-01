<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->json('channels')->nullable()->after('tanggal_permintaan');
        });
    }

    public function down()
    {
        Schema::table('registrasis', function (Blueprint $table) {
            if (Schema::hasColumn('registrasis', 'channels')) {
                $table->dropColumn('channels');
            }
        });
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 

};
