<?php

namespace App\Notifications;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanBaruNotification extends Notification
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
        $user = $this->pengajuan->user;

        return [
            'type' => 'pengajuan_baru',
            'title' => 'Pengajuan Baru Menunggu Persetujuan',
            'message' => sprintf(
                '%s mengajukan %s "%s" (%s %s). Menunggu persetujuan Anda.',
                $user->name ?? 'Karyawan',
                $this->pengajuan->kategori,
                $this->pengajuan->judul,
                $this->pengajuan->jumlah_diminta,
                $this->pengajuan->satuan
            ),
            'url' => route('pengajuan.index', ['status' => 'Menunggu']),
        ];
    }
}
