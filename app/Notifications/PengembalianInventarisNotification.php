<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengembalianInventarisNotification extends Notification
{
    use Queueable;

    public function __construct(public Inventaris $inventaris)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'inventaris_pengembalian',
            'title' => 'Pengajuan Pengembalian Baru',
            'message' => sprintf(
                '%s (%s) mengajukan pengembalian %s. Menunggu persetujuan admin.',
                $this->inventaris->nama,
                $this->inventaris->nrp,
                $this->inventaris->nama_perangkat
            ),
            'url' => route('inventaris.index', ['status' => 'Pending Pengembalian']),
        ];
    }
}
