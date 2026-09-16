<?php

namespace App\Notifications;

use App\Models\Maintenance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MaintenanceStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Maintenance $maintenance,
        public string $tipe = 'baru'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $barang = $this->maintenance->gudangBarang;

        return match ($this->tipe) {
            'baru' => [
                'type' => 'maintenance_baru',
                'title' => 'Maintenance Baru',
                'message' => sprintf(
                    'Maintenance %s untuk barang "%s" telah dibuat (%s).',
                    $this->maintenance->nomor_maintenance,
                    $barang->nama_perangkat ?? '-',
                    $this->maintenance->status
                ),
                'url' => route('maintenance.index'),
            ],
            'diproses' => [
                'type' => 'maintenance_diproses',
                'title' => 'Maintenance Diproses',
                'message' => sprintf(
                    'Maintenance %s untuk "%s" sedang dalam proses pengerjaan.',
                    $this->maintenance->nomor_maintenance,
                    $barang->nama_perangkat ?? '-'
                ),
                'url' => route('maintenance.index'),
            ],
            'selesai' => [
                'type' => 'maintenance_selesai',
                'title' => 'Maintenance Selesai',
                'message' => sprintf(
                    'Maintenance %s untuk "%s" telah selesai.',
                    $this->maintenance->nomor_maintenance,
                    $barang->nama_perangkat ?? '-'
                ),
                'url' => route('maintenance.index'),
            ],
            default => [
                'type' => 'maintenance_info',
                'title' => 'Status Maintenance Diupdate',
                'message' => sprintf(
                    'Maintenance %s diupdate ke status "%s".',
                    $this->maintenance->nomor_maintenance,
                    $this->maintenance->status
                ),
                'url' => route('maintenance.index'),
            ],
        };
    }
}