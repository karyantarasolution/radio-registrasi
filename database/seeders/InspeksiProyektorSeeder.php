<?php

namespace Database\Seeders;

use App\Models\InspeksiProyektor;
use Illuminate\Database\Seeder;

class InspeksiProyektorSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Ruang Rapat Utama', 'Auditorium', 'Ruang Training', 'Meeting Room 3', 'Lantai 5 - Presentation'];
        $departments = ['ICT', 'Engineering', 'HCGA', 'Logistik', 'Produksi'];
        $inspektors = ['Fajar Nugroho', 'Ahmad Rizky', 'Eko Prasetyo'];
        $checkItems = ['Baik', 'Baik', 'Baik', 'Baik', 'Tidak'];
        $checkFields = ['kondisi_casing', 'kebersihan', 'kabel_adaptor', 'lensa_proyektor', 'indikator_lampu', 'fokus_zoom', 'kecerahan_kontras'];

        for ($i = 1; $i <= 5; $i++) {
            $checks = [];
            foreach ($checkFields as $field) {
                $checks[$field] = $checkItems[array_rand($checkItems)];
            }

            InspeksiProyektor::create([
                'nomor_aset' => 'ICT-PJ-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'merek' => $i <= 3 ? 'Epson' : 'BenQ',
                'type' => $i <= 3 ? 'EB-X06' : 'MS535A',
                'sn' => 'SN-PJ-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'departemen' => $departments[array_rand($departments)],
                'lokasi' => $locations[array_rand($locations)],
                'tanggal_inspeksi' => now()->subDays(rand(1, 15)),
                'keterangan' => $i == 5 ? 'Lampu proyektor redup, perlu penggantian' : 'Proyektor berfungsi normal',
                'kondisi_casing' => $checks['kondisi_casing'],
                'tindakan_kondisi_casing' => $checks['kondisi_casing'] === 'Tidak' ? 'Casing lecet, perlu cat ulang' : null,
                'kebersihan' => $checks['kebersihan'],
                'tindakan_kebersihan' => $checks['kebersihan'] === 'Tidak' ? 'Lensa dan filter debu dibersihkan' : null,
                'kabel_adaptor' => $checks['kabel_adaptor'],
                'tindakan_kabel_adaptor' => $checks['kabel_adaptor'] === 'Tidak' ? 'Kabel HDMI aus, diganti' : null,
                'lensa_proyektor' => $checks['lensa_proyektor'],
                'tindakan_lensa_proyektor' => $checks['lensa_proyektor'] === 'Tidak' ? 'Lensa berdebu, dibersihkan dengan lens cleaner' : null,
                'indikator_lampu' => $checks['indikator_lampu'],
                'tindakan_indikator_lampu' => $checks['indikator_lampu'] === 'Tidak' ? 'Lampu sudah redup (3000+ jam), perlu ganti lampu' : null,
                'fokus_zoom' => $checks['fokus_zoom'],
                'tindakan_fokus_zoom' => $checks['fokus_zoom'] === 'Tidak' ? 'Fokus macet, diolesi pelumas' : null,
                'kecerahan_kontras' => $checks['kecerahan_kontras'],
                'tindakan_kecerahan_kontras' => $checks['kecerahan_kontras'] === 'Tidak' ? 'Kecerahan rendah, ganti lampu' : null,
                'koneksi_input_hdmi' => rand(0, 1) ? 'Baik' : 'Tidak',
                'koneksi_input_vga' => rand(0, 1) ? 'Baik' : 'Tidak',
                'koneksi_input_usb' => 'Baik',
                'inspektor' => $inspektors[array_rand($inspektors)],
                'jabatan_inspektor' => 'Staff IT',
                'diketahui_oleh' => 'T.M. Fathin',
            ]);
        }
    }
}
