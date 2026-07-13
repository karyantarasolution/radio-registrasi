<?php

namespace App\Notifications;

use App\Models\Inventaris;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanInventarisNotification extends Notification
{
    use Queueable;

    public function __construct(public Inventaris $inventaris)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->payload()['url'];

        return (new MailMessage)
            ->subject('Pengajuan Peminjaman Inventaris Baru')
            ->view('emails.admin-notification', [
                'title' => 'Pengajuan Peminjaman Inventaris Baru',
                'lines' => [
                    'Nama: ' . $this->inventaris->nama,
                    'NRP: ' . $this->inventaris->nrp,
                    'Perangkat: ' . $this->inventaris->nama_perangkat,
                    'Tanggal Pinjam: ' . $this->inventaris->tanggal_peminjaman,
                    'Status: Menunggu verifikasi admin',
                ],
                'actionText' => 'Lihat Pengajuan',
                'actionUrl' => $url,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return $this->payload();
    }

    private function payload(): array
    {
        return [
            'type' => 'inventaris_pengajuan',
            'title' => 'Pengajuan Peminjaman Baru',
            'message' => sprintf(
                '%s (%s) mengajukan peminjaman %s',
                $this->inventaris->nama,
                $this->inventaris->nrp,
                $this->inventaris->nama_perangkat
            ),
            'url' => route('inventaris.index', ['verifikasi' => 'Pending']),
            'nama' => $this->inventaris->nama,
            'nrp' => $this->inventaris->nrp,
            'nama_perangkat' => $this->inventaris->nama_perangkat,
            'tanggal_peminjaman' => $this->inventaris->tanggal_peminjaman,
        ];
    }
}
