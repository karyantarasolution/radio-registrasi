<?php

namespace Database\Seeders;

use App\Models\Registrasi;
use Illuminate\Database\Seeder;

class RegistrasiRadioSeeder extends Seeder
{
    public function run(): void
    {
        $registrasis = [
            [
                'perusahaan' => 'PT Putra Perkasa Abadi',
                'nomor_lambung' => 'PPA-001',
                'jenis_kendaraan' => 'Toyota Hilux',
                'nomor_polisi' => 'DA 1234 AB',
                'id_ptt' => 'PTT-2026-001',
                'merek_radio' => 'Motorola CM300',
                'serial_number' => 'MOT-CM300-001',
                'tanggal_permintaan' => now()->subDays(10),
                'channels' => ['CH1' => '140.250', 'CH2' => '142.100', 'CH3' => '150.500'],
                'range_power' => '25W',
                'range_frekuensi' => ['136-174 MHz'],
                'jenis_radio' => 'Mobile',
            ],
            [
                'perusahaan' => 'PT Putra Perkasa Abadi',
                'nomor_lambung' => 'PPA-002',
                'jenis_kendaraan' => 'Mitsubishi Triton',
                'nomor_polisi' => 'DA 5678 CD',
                'id_ptt' => 'PTT-2026-002',
                'merek_radio' => 'Hytera PD780',
                'serial_number' => 'HYT-PD780-002',
                'tanggal_permintaan' => now()->subDays(8),
                'channels' => ['CH1' => '141.500', 'CH2' => '143.250', 'CH3' => '152.000'],
                'range_power' => '45W',
                'range_frekuensi' => ['136-174 MHz'],
                'jenis_radio' => 'Mobile',
            ],
            [
                'perusahaan' => 'PT San intraction Indonesia',
                'nomor_lambung' => 'SIS-001',
                'jenis_kendaraan' => 'Motor',
                'nomor_polisi' => 'DA 9012 EF',
                'id_ptt' => 'PTT-2026-003',
                'merek_radio' => 'Baofeng UV-82',
                'serial_number' => 'BF-UV82-003',
                'tanggal_permintaan' => now()->subDays(5),
                'channels' => ['CH1' => '145.000', 'CH2' => '148.750'],
                'range_power' => '5W',
                'range_frekuensi' => ['146-174 MHz'],
                'jenis_radio' => 'HT',
            ],
            [
                'perusahaan' => 'PT Prima Coal',
                'nomor_lambung' => 'PC-001',
                'jenis_kendaraan' => 'Bus',
                'nomor_polisi' => 'DA 3456 GH',
                'id_ptt' => 'PTT-2026-004',
                'merek_radio' => 'Icom IC-F5060',
                'serial_number' => 'IC-F5060-004',
                'tanggal_permintaan' => now()->subDays(3),
                'channels' => ['CH1' => '140.500', 'CH2' => '142.750', 'CH3' => '151.000', 'CH4' => '153.250'],
                'range_power' => '25W',
                'range_frekuensi' => ['136-162 MHz'],
                'jenis_radio' => 'Mobile',
            ],
            [
                'perusahaan' => 'PT Bara Anugerah Sejahtera',
                'nomor_lambung' => 'BAS-001',
                'jenis_kendaraan' => 'L300',
                'nomor_polisi' => 'DA 7890 IJ',
                'id_ptt' => 'PTT-2026-005',
                'merek_radio' => 'Motorola GP338',
                'serial_number' => 'MOT-GP338-005',
                'tanggal_permintaan' => now()->subDays(1),
                'channels' => ['CH1' => '141.000', 'CH2' => '144.500'],
                'range_power' => '25W',
                'range_frekuensi' => ['136-174 MHz'],
                'jenis_radio' => 'Mobile',
            ],
        ];

        foreach ($registrasis as $r) {
            Registrasi::create($r);
        }
    }
}
