<?php

namespace Database\Seeders;

use App\Models\GudangBarang;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawanUsers = User::where('role', 'karyawan')->get();
        $pimpinan = User::where('role', 'pimpinan')->first();
        if ($karyawanUsers->isEmpty() || !$pimpinan) return;

        $maintenanceItems = GudangBarang::whereIn('kondisi', ['Perlu Maintenance', 'Rusak'])->get();

        $pengajuans = [
            // Pembelian - Disetujui
            [
                'judul' => 'Pengajuan Laptop baru untuk divisi Engineering',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Laptop Dell Latitude 5530',
                'jumlah_diminta' => 3,
                'satuan' => 'unit',
                'estimasi_biaya' => 36000000,
                'deskripsi' => 'Dibutuhkan 3 unit laptop baru untuk engineer yang baru bergabung.',
                'status' => 'Disetujui',
                'catatan_pimpinan' => 'Disetujui, silakan proses pembelian.',
                'jumlah_disetujui' => 3,
                'hari' => 30,
            ],
            // Pembelian - Disetujui
            [
                'judul' => 'Pengajuan Monitor tambahan untuk ruang rapat',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Monitor LG 27UK850',
                'jumlah_diminta' => 2,
                'satuan' => 'unit',
                'estimasi_biaya' => 8000000,
                'deskripsi' => 'Monitor 27 inch 4K untuk ruang rapat utama.',
                'status' => 'Disetujui',
                'catatan_pimpinan' => 'Disetujui.',
                'jumlah_disetujui' => 2,
                'hari' => 25,
            ],
            // Pembelian - Menunggu
            [
                'judul' => 'Pengajuan Headset baru untuk CS',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Headset Jabra Evolve2 65',
                'jumlah_diminta' => 5,
                'satuan' => 'unit',
                'estimasi_biaya' => 12500000,
                'deskripsi' => 'Headset wireless untuk tim customer service.',
                'status' => 'Menunggu',
                'hari' => 20,
            ],
            // Pembelian - Ditolak
            [
                'judul' => 'Pengajuan Printer Laser',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Printer HP LaserJet M428',
                'jumlah_diminta' => 1,
                'satuan' => 'unit',
                'estimasi_biaya' => 7500000,
                'deskripsi' => 'Printer laser untuk kebutuhan cetak dokumen.',
                'status' => 'Ditolak',
                'catatan_pimpinan' => 'Printer yang ada masih mencukupi.',
                'hari' => 15,
            ],
            // Maintenance - Disetujui
            [
                'judul' => 'Maintenance Monitor Dell P2422H flickering',
                'kategori' => 'Maintenance',
                'nama_barang' => 'Monitor Dell P2422H',
                'jumlah_diminta' => 2,
                'satuan' => 'unit',
                'estimasi_biaya' => 1500000,
                'deskripsi' => '2 unit monitor Dell mengalami flickering pada display.',
                'status' => 'Disetujui',
                'catatan_pimpinan' => 'Disetujui, segera proses maintenance.',
                'jumlah_disetujui' => 2,
                'hari' => 10,
            ],
            // Maintenance - Menunggu
            [
                'judul' => 'Maintenance Headset Jabra Evolve 75',
                'kategori' => 'Maintenance',
                'nama_barang' => 'Headset Jabra Evolve 75',
                'jumlah_diminta' => 2,
                'satuan' => 'unit',
                'estimasi_biaya' => 800000,
                'deskripsi' => '1 unit baterai drop, 1 unit microphone error.',
                'status' => 'Menunggu',
                'hari' => 7,
            ],
            // Maintenance - Menunggu
            [
                'judul' => 'Maintenance UPS APC SMT1000I baterai soak',
                'kategori' => 'Maintenance',
                'nama_barang' => 'UPS APC SMT1000I',
                'jumlah_diminta' => 2,
                'satuan' => 'unit',
                'estimasi_biaya' => 3000000,
                'deskripsi' => '2 unit UPS baterai soak, perlu penggantian baterai.',
                'status' => 'Menunggu',
                'hari' => 5,
            ],
            // Maintenance - Ditolak
            [
                'judul' => 'Maintenance Proyektor BenQ MS535A',
                'kategori' => 'Maintenance',
                'nama_barang' => 'Proyektor BenQ MS535A',
                'jumlah_diminta' => 1,
                'satuan' => 'unit',
                'estimasi_biaya' => 2000000,
                'deskripsi' => 'Lampu proyektor redup, perlu penggantian lampu.',
                'status' => 'Ditolak',
                'catatan_pimpinan' => 'Tunda dulu, belum mendesak.',
                'hari' => 12,
            ],
            // Pembelian - Disetujui
            [
                'judul' => 'Pengajuan Access Point baru',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Access Point Ubiquiti UniFi 6 Pro',
                'jumlah_diminta' => 4,
                'satuan' => 'unit',
                'estimasi_biaya' => 10000000,
                'deskripsi' => 'AP baru untuk area gedung baru.',
                'status' => 'Disetujui',
                'catatan_pimpinan' => 'Disetujui.',
                'jumlah_disetujui' => 4,
                'hari' => 18,
            ],
            // Pembelian - Menunggu
            [
                'judul' => 'Pengajuan Kabel LAN Cat6',
                'kategori' => 'Pembelian',
                'nama_barang' => 'Kabel LAN Cat6 UTP (roll)',
                'jumlah_diminta' => 5,
                'satuan' => 'roll',
                'estimasi_biaya' => 2500000,
                'deskripsi' => 'Kabel LAN untuk instalasi jaringan gedung baru.',
                'status' => 'Menunggu',
                'hari' => 14,
            ],
        ];

        foreach ($pengajuans as $i => $data) {
            $user = $karyawanUsers[$i % $karyawanUsers->count()];
            $hari = $data['hari'];
            unset($data['hari']);

            $gudangBarangId = null;
            if ($data['kategori'] === 'Maintenance') {
                $matchItem = $maintenanceItems->first(fn($m) => str_contains($m->nama_perangkat, $data['nama_barang']));
                if ($matchItem) {
                    $gudangBarangId = $matchItem->id;
                }
            }

            $disetujuiOleh = null;
            $tanggalPersetujuan = null;
            if (in_array($data['status'], ['Disetujui', 'Ditolak'])) {
                $disetujuiOleh = $pimpinan->id;
                $tanggalPersetujuan = now()->subDays(rand(1, 5));
            }

            Pengajuan::create(array_merge($data, [
                'nomor_pengajuan' => 'PJ-' . now()->subDays($hari)->format('Ymd') . '-' . strtoupper(dechex(rand(1000, 4095))),
                'gudang_barang_id' => $gudangBarangId,
                'diajukan_oleh' => $user->id,
                'disetujui_oleh' => $disetujuiOleh,
                'tanggal_pengajuan' => now()->subDays($hari)->toDateString(),
                'tanggal_persetujuan' => $tanggalPersetujuan,
            ]));
        }
    }
}
