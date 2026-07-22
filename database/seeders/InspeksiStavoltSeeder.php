<?php

namespace Database\Seeders;

use App\Models\InspeksiStavolt;
use Illuminate\Database\Seeder;

class InspeksiStavoltSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Server Room', 'Ruang Rapat Utama', 'Lantai 3 - Office', 'Workshop Engineering', 'POS Keamanan'];
        $departments = ['ICT', 'Engineering', 'Logistik', 'HCGA', 'Produksi'];
        $inspektors = ['Ahmad Rizky', 'Eko Prasetyo', 'Dedi Kurniawan'];
        $checkItems = ['Baik', 'Baik', 'Baik', 'Baik', 'Tidak'];
        $checkFields = ['casing', 'kebersihan', 'kabel_adaptor', 'tombol_switch', 'indikator_voltase', 'respon_perubahan_beban'];

        for ($i = 1; $i <= 5; $i++) {
            $checks = [];
            foreach ($checkFields as $field) {
                $checks[$field] = $checkItems[array_rand($checkItems)];
            }

            InspeksiStavolt::create([
                'nomor_aset' => 'ICT-SVT-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'merek' => $i <= 3 ? 'Tritonics' : 'Sollatek',
                'type' => $i <= 3 ? 'T-500VA' : 'S-1000VA',
                'sn' => 'SN-SVT-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'departemen' => $departments[array_rand($departments)],
                'lokasi' => $locations[array_rand($locations)],
                'tanggal_inspeksi' => now()->subDays(rand(1, 25)),
                'keterangan' => $i == 4 ? 'Input voltase tidak stabil' : 'Operasional normal',
                'casing' => $checks['casing'],
                'tindakan_casing' => $checks['casing'] === 'Tidak' ? 'Casing retak, perlu pengeleman' : null,
                'kebersihan' => $checks['kebersihan'],
                'tindakan_kebersihan' => $checks['kebersihan'] === 'Tidak' ? 'Dibersihkan dari debu' : null,
                'kabel_adaptor' => $checks['kabel_adaptor'],
                'tindakan_kabel_adaptor' => $checks['kabel_adaptor'] === 'Tidak' ? 'Kabel input aus, diganti' : null,
                'tombol_switch' => $checks['tombol_switch'],
                'tindakan_tombol_switch' => $checks['tombol_switch'] === 'Tidak' ? 'Switch ON/OFF longgar, diperbaiki' : null,
                'indikator_voltase' => $checks['indikator_voltase'],
                'tindakan_indikator_voltase' => $checks['indikator_voltase'] === 'Tidak' ? 'Voltase output tidak stabil, perlu kalibrasi' : null,
                'respon_perubahan_beban' => $checks['respon_perubahan_beban'],
                'tindakan_respon_perubahan_beban' => $checks['respon_perubahan_beban'] === 'Tidak' ? 'Respon lambat saat beban naik/turun' : null,
                'inspektor' => $inspektors[array_rand($inspektors)],
                'jabatan_inspektor' => 'Technician',
                'diketahui_oleh' => 'T.M. Fathin',
            ]);
        }
    }
}
