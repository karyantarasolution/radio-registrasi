<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeksiMonitorsTable extends Migration
{
    public function up()
    {
        Schema::create('inspeksi_monitor', function (Blueprint $table) {
            $table->id();
            // identitas perangkat
            $table->string('nomor_aset')->nullable();
            $table->string('merek')->nullable();
            $table->string('type')->nullable();
            $table->string('sn')->nullable();
            $table->string('departemen')->nullable();
            $table->string('lokasi')->nullable();

            // tanggal inspeksi (sama field seperti UPS untuk konsistensi)
            $table->date('tanggal_inspeksi')->nullable();

            // catatan umum
            $table->text('keterangan')->nullable();

            // kolom pemeriksaan (radio: 'Baik' atau 'Tidak')
            $table->string('tampilan_layer')->nullable();
            $table->string('kabel_power')->nullable();
            $table->string('bracket_dudukan')->nullable();
            $table->string('kebersihan')->nullable();
            $table->string('stop_kontak')->nullable();

            // kolom tindakan masing2
            $table->text('tindakan_tampilan_layer')->nullable();
            $table->text('tindakan_kabel_power')->nullable();
            $table->text('tindakan_bracket_dudukan')->nullable();
            $table->text('tindakan_kebersihan')->nullable();
            $table->text('tindakan_stop_kontak')->nullable();

            // tanda tangan / penanggung jawab
            $table->string('inspektor')->nullable();
            $table->string('jabatan_inspektor')->nullable();
            $table->string('diketahui_oleh')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeksi_monitor');
    }
}
