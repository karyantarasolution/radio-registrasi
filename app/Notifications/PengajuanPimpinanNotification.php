<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanPimpinanNotification extends Notification
{
    use Queueable;

    public function __construct(public Inventaris $inventaris, public string $tipe = 'baru')
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        if ($this->tipe === 'disetujui') {
            return [
                'type' => 'inventaris_disetujui',
                'title' => 'Peminjaman Disetujui Admin',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) telah disetujui admin ICT.',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index', ['status' => 'Belum Dikembalikan']),
            ];
        }

        if ($this->tipe === 'ditolak') {
            return [
                'type' => 'inventaris_ditolak',
                'title' => 'Peminjaman Ditolak Admin',
                'message' => sprintf(
                    'Peminjaman %s oleh %s (%s) telah ditolak admin ICT.',
                    $this->inventaris->nama_perangkat,
                    $this->inventaris->nama,
                    $this->inventaris->nrp
                ),
                'url' => route('inventaris.index', ['verifikasi' => 'Ditolak']),
            ];
        }

        return [
            'type' => 'inventaris_pengajuan_baru',
            'title' => 'Pengajuan Peminjaman Baru',
            'message' => sprintf(
                '%s (%s) mengajukan peminjaman %s',
                $this->inventaris->nama,
                $this->inventaris->nrp,
                $this->inventaris->nama_perangkat
            ),
            'url' => route('inventaris.index'),
        ];
    }
}
