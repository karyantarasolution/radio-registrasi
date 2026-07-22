<?php

namespace Database\Seeders;

use App\Models\BukuTamu;
use App\Models\Pic;
use Illuminate\Database\Seeder;

class BukuTamuSeeder extends Seeder
{
    public function run(): void
    {
        $pics = Pic::all();
        if ($pics->isEmpty()) return;

        $tamus = [
            ['nama' => 'Andi Pratama', 'no_telp' => '081234567890', 'nrp' => 'V-00123', 'instansi' => 'PT Trakindo Utama', 'keperluan' => 'Servis laptop dan klaim garansi'],
            ['nama' => 'Rina Sari', 'no_telp' => '082345678901', 'nrp' => 'V-00124', 'instansi' => 'PT Pamapersada Nusantara', 'keperluan' => 'Pengajuan penawaran UPS baru'],
            ['nama' => 'Hendra Wijaya', 'no_telp' => '083456789012', 'nrp' => 'V-00125', 'instansi' => 'PT Bukit Makmur Mandiri Utama', 'keperluan' => 'Koordinasi jaringan internet'],
            ['nama' => 'Dewi Lestari', 'no_telp' => '084567890123', 'nrp' => 'V-00126', 'instansi' => 'PT Multi Harapan Utama', 'keperluan' => 'Peminjaman proyektor untuk presentasi'],
            ['nama' => 'Rizky Firmansyah', 'no_telp' => '085678901234', 'nrp' => 'V-00127', 'instansi' => 'PT Harapan Baru Mining', 'keperluan' => 'Instalasi jaringan WiFi'],
            ['nama' => 'Siti Nurhaliza', 'no_telp' => '086789012345', 'nrp' => 'V-00128', 'instansi' => 'PT Adaro Indonesia', 'keperluan' => 'Kunjungan audit IT infrastructure'],
            ['nama' => 'Bambang Sutrisno', 'no_telp' => '087890123456', 'nrp' => 'V-00129', 'instansi' => 'PT Kaltim Prima Coal', 'keperluan' => 'Diskusi integrasi sistem'],
            ['nama' => 'Putri Amelia', 'no_telp' => '088901234567', 'nrp' => 'V-00130', 'instansi' => 'PT Indominco Mandiri', 'keperluan' => 'Training penggunaan radio komunikasi'],
        ];

        foreach ($tamus as $tamu) {
            BukuTamu::create(array_merge($tamu, [
                'pic_id' => $pics->random()->id,
            ]));
        }
    }
}
