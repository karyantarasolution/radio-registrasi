<?php

namespace App\Notifications;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanDiketahuiNotification extends Notification
{
    use Queueable;

    public function __construct(public Pengajuan $pengajuan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'pengajuan_diketahui_admin',
            'title' => 'Pengajuan Diketahui Admin ICT',
            'message' => sprintf(
                'Pengajuan %s "%s" telah diverifikasi (diketahui) admin ICT dan menunggu persetujuan Anda.',
                $this->pengajuan->kategori,
                $this->pengajuan->judul
            ),
            'url' => route('pengajuan.index', ['status' => 'Menunggu']),
        ];
    }
}