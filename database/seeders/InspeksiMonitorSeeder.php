<?php

namespace Database\Seeders;

use App\Models\InspeksiMonitor;
use Illuminate\Database\Seeder;

class InspeksiMonitorSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Ruang Rapat Utama', 'Lantai 2 - Open Space', 'Ruang Manager', 'Ruang Meeting 2', 'POS Keamanan'];
        $departments = ['ICT', 'Engineering', 'Logistik', 'HCGA', 'Produksi'];
        $inspektors = ['Budi Hartono', 'Ahmad Rizky', 'Citra Dewi'];
        $checkItems = ['Baik', 'Baik', 'Baik', 'Baik', 'Tidak'];
        $checkFields = ['tampilan_layer', 'kabel_power', 'bracket_dudukan', 'kebersihan', 'stop_kontak'];

        for ($i = 1; $i <= 5; $i++) {
            $checks = [];
            foreach ($checkFields as $field) {
                $checks[$field] = $checkItems[array_rand($checkItems)];
            }

            InspeksiMonitor::create([
                'nomor_aset' => 'ICT-MON-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'merek' => $i <= 2 ? 'LG' : ($i <= 4 ? 'Samsung' : 'Dell'),
                'type' => $i <= 2 ? '24MP400' : ($i <= 4 ? 'S24F350' : 'P2422H'),
                'sn' => 'SN-MON-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'departemen' => $departments[array_rand($departments)],
                'lokasi' => $locations[array_rand($locations)],
                'tanggal_inspeksi' => now()->subDays(rand(1, 20)),
                'keterangan' => $i == 3 ? 'Layar berkedip (flickering) sesekali' : 'Kondisi monitor baik',
                'tampilan_layer' => $checks['tampilan_layer'],
                'tindakan_tampilan_layer' => $checks['tampilan_layer'] === 'Tidak' ? 'Layar flickering, cek kabel LVDS' : null,
                'kabel_power' => $checks['kabel_power'],
                'tindakan_kabel_power' => $checks['kabel_power'] === 'Tidak' ? 'Kabel power aus, diganti baru' : null,
                'bracket_dudukan' => $checks['bracket_dudukan'],
                'tindakan_bracket_dudukan' => $checks['bracket_dudukan'] === 'Tidak' ? 'Bracket longgar, dikencangkan' : null,
                'kebersihan' => $checks['kebersihan'],
                'tindakan_kebersihan' => $checks['kebersihan'] === 'Tidak' ? 'Layar dan casing dibersihkan' : null,
                'stop_kontak' => $checks['stop_kontak'],
                'tindakan_stop_kontak' => $checks['stop_kontak'] === 'Tidak' ? 'Stop kontak tidak berfungsi, diganti' : null,
                'inspektor' => $inspektors[array_rand($inspektors)],
                'jabatan_inspektor' => 'Staff IT',
                'diketahui_oleh' => 'T.M. Fathin',
            ]);
        }
    }
}
