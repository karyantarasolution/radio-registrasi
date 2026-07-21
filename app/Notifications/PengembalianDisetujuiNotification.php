<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengembalianDisetujuiNotification extends Notification
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
            'type' => 'inventaris_dikembalikan',
            'title' => 'Pengembalian Disetujui',
            'message' => sprintf(
                'Pengembalian %s telah disetujui. Barang sudah dikembalikan.',
                $this->inventaris->nama_perangkat
            ),
            'url' => route('inventaris.index', ['status' => 'Dikembalikan']),
        ];
    }
}
