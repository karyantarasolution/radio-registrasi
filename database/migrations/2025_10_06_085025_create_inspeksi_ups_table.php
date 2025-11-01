<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeksiUpsTable extends Migration
{
    public function up()
    {
        Schema::create('inspeksi_ups', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_aset')->nullable();
            $table->string('merek')->nullable();
            $table->string('type')->nullable();
            $table->string('sn')->nullable();
            $table->string('departemen')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_inspeksi')->nullable();
            $table->text('keterangan')->nullable();

            // status per item: 'Baik' atau 'Tidak'
            $table->string('casing')->nullable();
            $table->text('tindakan_casing')->nullable();

            $table->string('kebersihan')->nullable();
            $table->text('tindakan_kebersihan')->nullable();

            $table->string('kabel_adaptor')->nullable();
            $table->text('tindakan_kabel_adaptor')->nullable();

            $table->string('tombol_switch')->nullable();
            $table->text('tindakan_tombol_switch')->nullable();

            $table->string('indikator_status')->nullable();
            $table->text('tindakan_indikator_status')->nullable();

            $table->string('fungsi_alarm')->nullable();
            $table->text('tindakan_fungsi_alarm')->nullable();

            $table->string('respon_kehilangan_daya')->nullable();
            $table->text('tindakan_respon_kehilangan_daya')->nullable();

            $table->string('fuse')->nullable();
            $table->text('tindakan_fuse')->nullable();

            // opsional: petugas/inspektor & approval
            $table->string('inspektor')->nullable();
            $table->string('diketahui_oleh')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeksi_ups');
    }
}
