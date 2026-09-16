<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PersetujuanPeminjamanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Inventaris $inventaris,
        public string $tipe = 'baru'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return match ($this->tipe) {
            'disetujui' => [
                'type' => 'inventaris_disetujui_pimpinan',
                'title' => 'Peminjaman Disetujui Pimpinan',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) telah disetujui pimpinan.',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index', ['status' => 'Belum Dikembalikan']),
            ],
            'ditolak' => [
                'type' => 'inventaris_ditolak_pimpinan',
                'title' => 'Peminjaman Ditolak Pimpinan',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) telah ditolak pimpinan.',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index', ['verifikasi' => 'Ditolak']),
            ],
            'urgent' => [
                'type' => 'inventaris_urgent_disetujui',
                'title' => 'Peminjaman Disetujui Admin (Urgent)',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) disetujui langsung oleh admin ICT (urgent).',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index'),
            ],
            default => [
                'type' => 'inventaris_menunggu_persetujuan',
                'title' => 'Peminjaman Menunggu Persetujuan',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) membutuhkan persetujuan pimpinan.',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index'),
            ],
        };
    }
}