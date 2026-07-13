<?php

namespace App\Notifications;

use App\Models\BukuTamu;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KunjunganBukuTamuNotification extends Notification
{
    use Queueable;

    public function __construct(public BukuTamu $bukuTamu)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->payload()['url'];
        $pic = $this->bukuTamu->pic->nama ?? '-';

        return (new MailMessage)
            ->subject('Kunjungan Buku Tamu Baru')
            ->view('emails.admin-notification', [
                'title' => 'Kunjungan Buku Tamu Baru',
                'lines' => [
                    'Nama: ' . $this->bukuTamu->nama,
                    'Instansi: ' . $this->bukuTamu->instansi,
                    'Keperluan: ' . $this->bukuTamu->keperluan,
                    'PIC: ' . $pic,
                ],
                'actionText' => 'Lihat Buku Tamu',
                'actionUrl' => $url,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return $this->payload();
    }

    private function payload(): array
    {
        $this->bukuTamu->loadMissing('pic');

        return [
            'type' => 'bukutamu_kunjungan',
            'title' => 'Kunjungan Buku Tamu Baru',
            'message' => sprintf(
                '%s dari %s — %s',
                $this->bukuTamu->nama,
                $this->bukuTamu->instansi,
                $this->bukuTamu->keperluan
            ),
            'url' => route('bukutamu.index'),
            'nama' => $this->bukuTamu->nama,
            'instansi' => $this->bukuTamu->instansi,
            'keperluan' => $this->bukuTamu->keperluan,
            'pic' => $this->bukuTamu->pic->nama ?? '-',
        ];
    }
}
