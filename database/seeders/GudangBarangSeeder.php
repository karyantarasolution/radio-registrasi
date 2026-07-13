<?php

namespace Database\Seeders;

use App\Models\GudangBarang;
use App\Models\StokMutasi;
use Illuminate\Database\Seeder;

class GudangBarangSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama_perangkat' => 'Laptop Dell Latitude 5420', 'merk' => 'Dell', 'kategori' => 'Laptop', 'stok_total' => 5, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Laptop HP ProBook 450', 'merk' => 'HP', 'kategori' => 'Laptop', 'stok_total' => 3, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Monitor LG 24 inch', 'merk' => 'LG', 'kategori' => 'Monitor', 'stok_total' => 8, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Monitor Samsung 27 inch', 'merk' => 'Samsung', 'kategori' => 'Monitor', 'stok_total' => 4, 'kondisi' => 'Perlu Maintenance'],
            ['nama_perangkat' => 'Mouse Logitech M331', 'merk' => 'Logitech', 'kategori' => 'Aksesoris', 'stok_total' => 15, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Keyboard Logitech K120', 'merk' => 'Logitech', 'kategori' => 'Aksesoris', 'stok_total' => 12, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Headset Jabra Evolve', 'merk' => 'Jabra', 'kategori' => 'Aksesoris', 'stok_total' => 6, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Proyektor Epson EB-X06', 'merk' => 'Epson', 'kategori' => 'Proyektor', 'stok_total' => 2, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'Router TP-Link Archer', 'merk' => 'TP-Link', 'kategori' => 'Jaringan', 'stok_total' => 4, 'kondisi' => 'Baik'],
            ['nama_perangkat' => 'UPS APC 650VA', 'merk' => 'APC', 'kategori' => 'UPS', 'stok_total' => 3, 'kondisi' => 'Baik'],
        ];

        foreach ($items as $item) {
            $barang = GudangBarang::firstOrCreate(
                ['nama_perangkat' => $item['nama_perangkat']],
                array_merge($item, [
                    'stok_tersedia' => $item['stok_total'],
                    'tanggal_masuk' => now()->toDateString(),
                    'keterangan' => 'Stok awal gudang IT',
                ])
            );

            if ($barang->wasRecentlyCreated) {
                StokMutasi::create([
                    'gudang_barang_id' => $barang->id,
                    'jenis' => 'Masuk',
                    'jumlah' => $barang->stok_total,
                    'keterangan' => 'Barang baru masuk gudang',
                ]);
            }
        }
    }
}
