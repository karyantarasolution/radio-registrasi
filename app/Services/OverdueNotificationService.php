<?php

namespace App\Services;

use App\Models\Inventaris;
use App\Models\User;
use App\Notifications\InventarisOverdueNotification;

class OverdueNotificationService
{
    public static function checkAndNotify(): int
    {
        $overdueItems = Inventaris::where('status_peminjaman', 'Belum Dikembalikan')
            ->whereNotNull('tanggal_pengembalian')
            ->where('tanggal_pengembalian', '<', now()->toDateString())
            ->get();

        $notifiedCount = 0;

        foreach ($overdueItems as $item) {
            $user = User::where('nrp', $item->nrp)->first();
            if ($user) {
                $alreadyNotified = $user->notifications()
                    ->where('type', InventarisOverdueNotification::class)
                    ->where('data->inventaris_id', $item->id)
                    ->exists();

                if (!$alreadyNotified) {
                    $user->notify(new InventarisOverdueNotification($item));
                    $notifiedCount++;
                }
            }
        }

        return $notifiedCount;
    }
}
