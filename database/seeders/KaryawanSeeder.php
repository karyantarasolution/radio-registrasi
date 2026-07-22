<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawans = [
            ['nama' => 'T.M. Fathin', 'nrp' => '22100001', 'jabatan' => 'Group Leader', 'departemen' => 'ICT'],
            ['nama' => 'Ahmad Rizky', 'nrp' => '22100002', 'jabatan' => 'Staff IT', 'departemen' => 'ICT'],
            ['nama' => 'Budi Hartono', 'nrp' => '22100003', 'jabatan' => 'Staff IT', 'departemen' => 'ICT'],
            ['nama' => 'Citra Dewi', 'nrp' => '22100004', 'jabatan' => 'Staff IT', 'departemen' => 'ICT'],
            ['nama' => 'Dedi Kurniawan', 'nrp' => '22100005', 'jabatan' => 'Technician', 'departemen' => 'ICT'],
            ['nama' => 'Eko Prasetyo', 'nrp' => '22100006', 'jabatan' => 'Technician', 'departemen' => 'ICT'],
            ['nama' => 'Fajar Nugroho', 'nrp' => '22100007', 'jabatan' => 'Staff IT', 'departemen' => 'Engineering'],
            ['nama' => 'Gita Permata', 'nrp' => '22100008', 'jabatan' => 'Staff IT', 'departemen' => 'Engineering'],
        ];

        foreach ($karyawans as $k) {
            Karyawan::firstOrCreate(
                ['nrp' => $k['nrp']],
                $k
            );
        }
    }
}
