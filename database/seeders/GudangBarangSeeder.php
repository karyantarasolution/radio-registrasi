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
            [
                'nama_perangkat' => 'Laptop Dell Latitude 5420',
                'merk' => 'Dell',
                'kategori' => 'Laptop',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'Baik',
                'keterangan' => 'Laptop standar kantor untuk karyawan',
            ],
            [
                'nama_perangkat' => 'Laptop HP ProBook 450 G8',
                'merk' => 'HP',
                'kategori' => 'Laptop',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'kondisi' => 'Baik',
                'keterangan' => 'Laptop untuk divisi engineering',
            ],
            [
                'nama_perangkat' => 'Monitor LG 24MP400',
                'merk' => 'LG',
                'kategori' => 'Monitor',
                'stok_total' => 15,
                'stok_tersedia' => 15,
                'kondisi' => 'Baik',
                'keterangan' => 'Monitor 24 inch Full HD',
            ],
            [
                'nama_perangkat' => 'Monitor Samsung S24F350',
                'merk' => 'Samsung',
                'kategori' => 'Monitor',
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'Baik',
                'keterangan' => 'Monitor 24 inch Curved',
            ],
            [
                'nama_perangkat' => 'Monitor Dell P2422H',
                'merk' => 'Dell',
                'kategori' => 'Monitor',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
                'keterangan' => 'Monitor 24 inch IPS',
            ],
            [
                'nama_perangkat' => 'Mouse Logitech M331',
                'merk' => 'Logitech',
                'kategori' => 'Aksesoris',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'kondisi' => 'Baik',
                'keterangan' => 'Mouse wireless silent click',
            ],
            [
                'nama_perangkat' => 'Mouse Logitech G102',
                'merk' => 'Logitech',
                'kategori' => 'Aksesoris',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'Baik',
                'keterangan' => 'Mouse gaming untuk workstation',
            ],
            [
                'nama_perangkat' => 'Keyboard Logitech K120',
                'merk' => 'Logitech',
                'kategori' => 'Aksesoris',
                'stok_total' => 25,
                'stok_tersedia' => 25,
                'kondisi' => 'Baik',
                'keterangan' => 'Keyboard USB standar',
            ],
            [
                'nama_perangkat' => 'Keyboard Mechanical Keychron K2',
                'merk' => 'Keychron',
                'kategori' => 'Aksesoris',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
                'keterangan' => 'Keyboard mechanical wireless',
            ],
            [
                'nama_perangkat' => 'Headset Jabra Evolve2 40',
                'merk' => 'Jabra',
                'kategori' => 'Headset',
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'Baik',
                'keterangan' => 'Headset USB-C noise cancelling',
            ],
            [
                'nama_perangkat' => 'Headset Jabra Evolve 75',
                'merk' => 'Jabra',
                'kategori' => 'Headset',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
                'keterangan' => 'Headset wireless Bluetooth',
            ],
            [
                'nama_perangkat' => 'Proyektor Epson EB-X06',
                'merk' => 'Epson',
                'kategori' => 'Proyektor',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'keterangan' => 'Proyektor 3600 lumens',
            ],
            [
                'nama_perangkat' => 'Proyektor BenQ MS535A',
                'merk' => 'BenQ',
                'kategori' => 'Proyektor',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'keterangan' => 'Proyektor SVGA 3800 lumens',
            ],
            [
                'nama_perangkat' => 'Router TP-Link Archer AX55',
                'merk' => 'TP-Link',
                'kategori' => 'Jaringan',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'kondisi' => 'Baik',
                'keterangan' => 'Router WiFi 6 untuk area kantor',
            ],
            [
                'nama_perangkat' => 'Switch HPE 1820 24G',
                'merk' => 'HPE',
                'kategori' => 'Jaringan',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
                'keterangan' => 'Managed switch 24 port',
            ],
            [
                'nama_perangkat' => 'UPS APC BX1100LI',
                'merk' => 'APC',
                'kategori' => 'UPS',
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'Baik',
                'keterangan' => 'UPS 1100VA line-interactive',
            ],
            [
                'nama_perangkat' => 'UPS APC SMT1000I',
                'merk' => 'APC',
                'kategori' => 'UPS',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
                'keterangan' => 'UPS 1000VA smart online',
            ],
            [
                'nama_perangkat' => 'UPS CyberPower CP1500EPF',
                'merk' => 'CyberPower',
                'kategori' => 'UPS',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'keterangan' => 'UPS 1500VA pure sine wave',
            ],
            [
                'nama_perangkat' => 'Printer Canon PIXMA G3010',
                'merk' => 'Canon',
                'kategori' => 'Printer',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'Baik',
                'keterangan' => 'Printer wireless all-in-one',
            ],
            [
                'nama_perangkat' => 'Printer HP LaserJet Pro M404dn',
                'merk' => 'HP',
                'kategori' => 'Printer',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'keterangan' => 'Printer laser monokrom duplex',
            ],
            [
                'nama_perangkat' => 'Scanner Fujitsu ScanSnap iX1600',
                'merk' => 'Fujitsu',
                'kategori' => 'Scanner',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'keterangan' => 'Scanner document ADF',
            ],
            [
                'nama_perangkat' => 'Access Point Ubiquiti UniFi AP',
                'merk' => 'Ubiquiti',
                'kategori' => 'Jaringan',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'kondisi' => 'Baik',
                'keterangan' => 'Access point WiFi 6',
            ],
            [
                'nama_perangkat' => 'Kabel LAN Cat6 UTP (per roll)',
                'merk' => 'Belden',
                'kategori' => 'Kabel',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'Baik',
                'keterangan' => 'Kabel LAN 305 meter per roll',
            ],
            [
                'nama_perangkat' => 'Webcam Logitech C920',
                'merk' => 'Logitech',
                'kategori' => 'Aksesoris',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'kondisi' => 'Baik',
                'keterangan' => 'Webcam Full HD 1080p',
            ],
            [
                'nama_perangkat' => 'Speaker JBL PartyBox 310',
                'merk' => 'JBL',
                'kategori' => 'Audio',
                'stok_total' => 2,
                'stok_tersedia' => 2,
                'kondisi' => 'Baik',
                'keterangan' => 'Speaker portable untuk event',
            ],
        ];

        foreach ($items as $item) {
            $barang = GudangBarang::create(array_merge($item, [
                'tanggal_masuk' => now()->subDays(rand(1, 90))->toDateString(),
            ]));

            StokMutasi::create([
                'gudang_barang_id' => $barang->id,
                'jenis' => 'Masuk',
                'jumlah' => $barang->stok_total,
                'keterangan' => 'Stok awal gudang IT',
            ]);

            if ($barang->stok_tersedia < $barang->stok_total) {
                StokMutasi::create([
                    'gudang_barang_id' => $barang->id,
                    'jenis' => 'Keluar',
                    'jumlah' => $barang->stok_total - $barang->stok_tersedia,
                    'keterangan' => 'Dipinjam / dikirim ke user',
                ]);
            }
        }
    }
}
