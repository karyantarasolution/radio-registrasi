<?php

namespace Database\Seeders;

use App\Models\InspeksiUps;
use Illuminate\Database\Seeder;

class InspeksiUpsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Server Room', 'Ruang Rapat Utama', 'Lantai 2 - Open Space', 'Ruang Manager', 'Gudang IT'];
        $departments = ['ICT', 'Engineering', 'Logistik', 'HCGA', 'Produksi'];
        $inspektors = ['Ahmad Rizky', 'Budi Hartono', 'Dedi Kurniawan'];
        $checkItems = ['Baik', 'Baik', 'Baik', 'Baik', 'Tidak'];
        $checkFields = ['casing', 'kebersihan', 'kabel_adaptor', 'tombol_switch', 'indikator_status', 'fungsi_alarm', 'respon_kehilangan_daya', 'fuse'];

        for ($i = 1; $i <= 5; $i++) {
            $checks = [];
            foreach ($checkFields as $field) {
                $checks[$field] = $checkItems[array_rand($checkItems)];
            }

            InspeksiUps::create([
                'nomor_aset' => 'ICT-UPS-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'merek' => $i <= 3 ? 'APC' : 'CyberPower',
                'type' => $i <= 3 ? 'SMT1000I' : 'CP1500EPF',
                'sn' => 'SN-UPS-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'departemen' => $departments[array_rand($departments)],
                'lokasi' => $locations[array_rand($locations)],
                'tanggal_inspeksi' => now()->subDays(rand(1, 30)),
                'keterangan' => $i == 3 ? 'Baterai perlu penggantian, alarm tidak berfungsi' : 'Kondisi normal',
                'casing' => $checks['casing'],
                'tindakan_casing' => $checks['casing'] === 'Tidak' ? 'Bersihkan casing dari debu' : null,
                'kebersihan' => $checks['kebersihan'],
                'tindakan_kebersihan' => $checks['kebersihan'] === 'Tidak' ? 'Dibersihkan dari debu dan kotoran' : null,
                'kabel_adaptor' => $checks['kabel_adaptor'],
                'tindakan_kabel_adaptor' => $checks['kabel_adaptor'] === 'Tidak' ? 'Kabel adaptor diganti baru' : null,
                'tombol_switch' => $checks['tombol_switch'],
                'tindakan_tombol_switch' => $checks['tombol_switch'] === 'Tidak' ? 'Switch diperiksa dan diperbaiki' : null,
                'indikator_status' => $checks['indikator_status'],
                'tindakan_indikator_status' => $checks['indikator_status'] === 'Tidak' ? 'LED indikator diganti' : null,
                'fungsi_alarm' => $checks['fungsi_alarm'],
                'tindakan_fungsi_alarm' => $checks['fungsi_alarm'] === 'Tidak' ? 'Alarm buzzer tidak berfungsi, perlu penggantian' : null,
                'respon_kehilangan_daya' => $checks['respon_kehilangan_daya'],
                'tindakan_respon_kehilangan_daya' => $checks['respon_kehilangan_daya'] === 'Tidak' ? 'Baterai soak, UPS tidak backup saat mati listrik' : null,
                'fuse' => $checks['fuse'],
                'tindakan_fuse' => $checks['fuse'] === 'Tidak' ? 'Fuse putus, diganti baru' : null,
                'inspektor' => $inspektors[array_rand($inspektors)],
                'diketahui_oleh' => 'T.M. Fathin',
            ]);
        }
    }
}
