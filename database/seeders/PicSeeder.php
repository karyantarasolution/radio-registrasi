<?php

namespace Database\Seeders;

use App\Models\Pic;
use Illuminate\Database\Seeder;

class PicSeeder extends Seeder
{
    public function run(): void
    {
        $pics = [
            ['nama' => 'Budi Santoso', 'departemen' => 'HCGA'],
            ['nama' => 'Siti Aminah', 'departemen' => 'HCGA'],
            ['nama' => 'Andi Pratama', 'departemen' => 'Produksi'],
            ['nama' => 'Rina Wulandari', 'departemen' => 'Produksi'],
            ['nama' => 'Dedi Kurniawan', 'departemen' => 'Logistik'],
            ['nama' => 'Eko Saputra', 'departemen' => 'Logistik'],
            ['nama' => 'Fajar Nugroho', 'departemen' => 'Engineering'],
            ['nama' => 'Gita Permata', 'departemen' => 'Engineering'],
            ['nama' => 'Hendra Wijaya', 'departemen' => 'COE'],
            ['nama' => 'Indah Lestari', 'departemen' => 'COE'],
        ];

        foreach ($pics as $pic) {
            Pic::firstOrCreate(
                ['nama' => $pic['nama'], 'departemen' => $pic['departemen']],
                $pic
            );
        }
    }
}
