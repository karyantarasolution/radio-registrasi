<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;

class PimpinanNotificationService
{
    public static function notify(Notification $notification): void
    {
        $pimpinans = User::where('role', 'pimpinan')->get();

        foreach ($pimpinans as $pimpinan) {
            $pimpinan->notify($notification);
        }
    }
}
