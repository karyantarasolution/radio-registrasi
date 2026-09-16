<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('gudang_barang')
            ->orderBy('id')
            ->select(['id', 'kode_qr'])
            ->get()
            ->each(function ($item) {
                if (empty($item->kode_qr)) {
                    DB::table('gudang_barang')
                        ->where('id', $item->id)
                        ->update(['kode_qr' => 'GB-' . str_pad($item->id, 5, '0', STR_PAD_LEFT)]);
                }
            });

        DB::table('registrasis')
            ->orderBy('id')
            ->select(['id', 'id_ptt', 'kode_qr'])
            ->get()
            ->each(function ($item) {
                if (empty($item->kode_qr)) {
                    DB::table('registrasis')
                        ->where('id', $item->id)
                        ->update(['kode_qr' => 'RD-' . ($item->id_ptt ?? str_pad($item->id, 4, '0', STR_PAD_LEFT))]);
                }
            });
    }

    public function down(): void
    {
        DB::table('gudang_barang')->update(['kode_qr' => null]);
        DB::table('registrasis')->update(['kode_qr' => null]);
    }
};