<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReminderPeminjamanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Inventaris $inventaris,
        public int $hariSisa
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isOverdue = $this->hariSisa < 0;
        $days = abs($this->hariSisa);

        if ($isOverdue) {
            $title = '⚠️ Pengembalian Terlambat';
            $message = sprintf(
                'Barang "%s" sudah terlambat %d hari dari batas pengembalian (%s). Segera kembalikan.',
                $this->inventaris->nama_perangkat,
                $days,
                $this->inventaris->tanggal_pengembalian->format('d/m/Y')
            );
        } else {
            $title = '🔔 Pengingat Pengembalian';
            $message = sprintf(
                'Barang "%s" harus dikembalikan dalam %d hari lagi (batas: %s).',
                $this->inventaris->nama_perangkat,
                $this->hariSisa,
                $this->inventaris->tanggal_pengembalian->format('d/m/Y')
            );
        }

        return [
            'type' => $isOverdue ? 'reminder_overdue' : 'reminder_hari',
            'inventaris_id' => $this->inventaris->id,
            'title' => $title,
            'message' => $message,
            'hari_sisa' => $this->hariSisa,
            'url' => route('inventaris.index'),
        ];
    }
}