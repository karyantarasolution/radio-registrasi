<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InventarisOverdueNotification extends Notification
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
            'inventaris_id' => $this->inventaris->id,
            'title' => '⚠️ Pengembalian Terlambat',
            'message' => "Barang \"{$this->inventaris->nama_perangkat}\" harusnya dikembalikan pada {$this->inventaris->tanggal_pengembalian}. Segera kembalikan barang ke bagian ICT.",
            'type' => 'warning',
        ];
    }
}
