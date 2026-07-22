<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PicSeeder::class,
            PimpinanSeeder::class,
            KaryawanSeeder::class,
            GudangBarangSeeder::class,
            InventarisSeeder::class,
            PengajuanSeeder::class,
            RegistrasiRadioSeeder::class,
            BukuTamuSeeder::class,
            InspeksiUpsSeeder::class,
            InspeksiStavoltSeeder::class,
            InspeksiMonitorSeeder::class,
            InspeksiProyektorSeeder::class,
        ]);
    }
}
