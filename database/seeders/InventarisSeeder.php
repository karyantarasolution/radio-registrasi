<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('role', ['karyawan', 'admin_ict'])->get();
        if ($users->isEmpty()) return;

        $devices = [
            ['nama_perangkat' => 'Laptop Dell Latitude 5420', 'no_asset' => 'ICT-LP-001'],
            ['nama_perangkat' => 'Laptop Dell Latitude 5420', 'no_asset' => 'ICT-LP-002'],
            ['nama_perangkat' => 'Laptop HP ProBook 450 G8', 'no_asset' => 'ICT-LP-003'],
            ['nama_perangkat' => 'Monitor LG 24MP400', 'no_asset' => 'ICT-MN-001'],
            ['nama_perangkat' => 'Monitor LG 24MP400', 'no_asset' => 'ICT-MN-002'],
            ['nama_perangkat' => 'Monitor Samsung S24F350', 'no_asset' => 'ICT-MN-003'],
            ['nama_perangkat' => 'Mouse Logitech M331', 'no_asset' => 'ICT-MS-001'],
            ['nama_perangkat' => 'Mouse Logitech M331', 'no_asset' => 'ICT-MS-002'],
            ['nama_perangkat' => 'Keyboard Logitech K120', 'no_asset' => 'ICT-KB-001'],
            ['nama_perangkat' => 'Headset Jabra Evolve2 40', 'no_asset' => 'ICT-HS-001'],
            ['nama_perangkat' => 'Headset Jabra Evolve2 40', 'no_asset' => 'ICT-HS-002'],
            ['nama_perangkat' => 'Proyektor Epson EB-X06', 'no_asset' => 'ICT-PJ-001'],
            ['nama_perangkat' => 'UPS APC BX1100LI', 'no_asset' => 'ICT-UP-001'],
            ['nama_perangkat' => 'UPS APC BX1100LI', 'no_asset' => 'ICT-UP-002'],
            ['nama_perangkat' => 'Printer Canon PIXMA G3010', 'no_asset' => 'ICT-PR-001'],
            ['nama_perangkat' => 'Router TP-Link Archer AX55', 'no_asset' => 'ICT-RT-001'],
            ['nama_perangkat' => 'Webcam Logitech C920', 'no_asset' => 'ICT-WC-001'],
            ['nama_perangkat' => 'Switch HPE 1820 24G', 'no_asset' => 'ICT-SW-001'],
        ];

        $inventarisData = [
            // Dikembalikan (sudah dikembalikan)
            0 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 7, 'kondisi_pengembalian' => 'Baik'],
            // Belum Dikembalikan (masih dipinjam)
            1 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 14],
            // Pending
            2 => ['status_peminjaman' => 'Pending', 'status_verifikasi' => 'Pending', 'status_persetujuan' => 'Pending', 'lama_pinjam' => 7],
            // Belum Dikembalikan
            3 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 30],
            // Dikembalikan dengan kondisi rusak ringan
            4 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 10, 'kondisi_pengembalian' => 'Rusak Ringan'],
            // Pending Pengembalian
            5 => ['status_peminjaman' => 'Pending Pengembalian', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 5],
            // Dikembalikan
            6 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 3, 'kondisi_pengembalian' => 'Baik'],
            // Belum Dikembalikan
            7 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 14],
            // Dikembalikan
            8 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 7, 'kondisi_pengembalian' => 'Baik'],
            // Belum Dikembalikan
            9 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 21],
            // Pending
            10 => ['status_peminjaman' => 'Pending', 'status_verifikasi' => 'Pending', 'status_persetujuan' => 'Pending', 'lama_pinjam' => 14],
            // Dikembalikan dengan rusak berat
            11 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 5, 'kondisi_pengembalian' => 'Rusak Berat'],
            // Belum Dikembalikan
            12 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 30],
            // Dikembalikan
            13 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 7, 'kondisi_pengembalian' => 'Baik'],
            // Pending Pengembalian
            14 => ['status_peminjaman' => 'Pending Pengembalian', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 10],
            // Belum Dikembalikan
            15 => ['status_peminjaman' => 'Belum Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 14],
            // Dikembalikan
            16 => ['status_peminjaman' => 'Dikembalikan', 'status_verifikasi' => 'Disetujui', 'status_persetujuan' => 'Disetujui', 'lama_pinjam' => 3, 'kondisi_pengembalian' => 'Baik'],
            // Pending
            17 => ['status_peminjaman' => 'Pending', 'status_verifikasi' => 'Pending', 'status_persetujuan' => 'Pending', 'lama_pinjam' => 7],
        ];

        foreach ($inventarisData as $i => $data) {
            $user = $users[$i % $users->count()];
            $device = $devices[$i];
            $tanggalPinjam = now()->subDays(rand(5, 60))->toDateString();
            $tanggalKembali = $data['status_peminjaman'] === 'Dikembalikan'
                ? now()->subDays(rand(1, 5))->toDateString()
                : null;
            $tanggalActualKembali = $tanggalKembali;
            $catatan = null;

            if (isset($data['kondisi_pengembalian'])) {
                $catatan = match($data['kondisi_pengembalian']) {
                    'Baik' => 'Barang dalam kondisi baik setelah dipinjam.',
                    'Rusak Ringan' => 'Ada goresan kecil pada casing, fungsi masih normal.',
                    'Rusak Berat' => 'Lampu proyektor mati, perlu penggantian.',
                    default => null,
                };
            }

            Inventaris::create([
                'nama' => $user->name,
                'nrp' => $user->nrp,
                'nama_perangkat' => $device['nama_perangkat'],
                'no_asset' => $device['no_asset'],
                'status_peminjaman' => $data['status_peminjaman'],
                'status_verifikasi' => $data['status_verifikasi'],
                'status_persetujuan' => $data['status_persetujuan'],
                'lama_pinjam' => $data['lama_pinjam'],
                'tanggal_peminjaman' => $tanggalPinjam,
                'tanggal_pengembalian' => $tanggalKembali ? now()->addDays($data['lama_pinjam'])->toDateString() : null,
                'tanggal_actual_kembali' => $tanggalActualKembali,
                'kondisi_pengembalian' => $data['kondisi_pengembalian'] ?? null,
                'catatan_pengembalian' => $catatan,
            ]);
        }
    }
}
