<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeksiStavoltsTable extends Migration
{
    public function up()
    {
        Schema::create('inspeksi_stavolts', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_aset')->nullable();
            $table->string('merek')->nullable();
            $table->string('type')->nullable();
            $table->string('sn')->nullable();
            $table->string('departemen')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_inspeksi')->nullable();
            $table->text('keterangan')->nullable();

            // kolom checklist (Baik/Tidak) dan tindakan -> nama mirip dengan UPS
            $table->string('casing')->nullable();
            $table->text('tindakan_casing')->nullable();

            $table->string('kebersihan')->nullable();
            $table->text('tindakan_kebersihan')->nullable();

            $table->string('kabel_adaptor')->nullable();
            $table->text('tindakan_kabel_adaptor')->nullable();

            $table->string('tombol_switch')->nullable();
            $table->text('tindakan_tombol_switch')->nullable();

            $table->string('indikator_voltase')->nullable(); // indikator voltase input/output
            $table->text('tindakan_indikator_voltase')->nullable();

            $table->string('respon_perubahan_beban')->nullable();
            $table->text('tindakan_respon_perubahan_beban')->nullable();

            // tanda tangan / penanggung jawab
            $table->string('inspektor')->nullable();
            $table->string('jabatan_inspektor')->nullable();
            $table->string('diketahui_oleh')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeksi_stavolts');
    }
}
