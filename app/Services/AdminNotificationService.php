<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;

class AdminNotificationService
{
    public static function notify(Notification $notification): void
    {
        $admins = User::where('role', 'ict')->orWhere('name', 'ICT')->get();

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }
}
