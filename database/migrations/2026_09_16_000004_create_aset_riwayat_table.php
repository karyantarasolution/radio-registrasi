<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_riwayat', function (Blueprint $table) {
            $table->id();
            $table->morphs('aset');
            $table->string('jenis');
            $table->text('deskripsi');
            $table->foreignId('inventaris_id')->nullable()->constrained('inventaris')->nullOnDelete();
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuans')->nullOnDelete();
            $table->foreignId('maintenance_id')->nullable()->constrained('maintenances')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_riwayat');
    }
};