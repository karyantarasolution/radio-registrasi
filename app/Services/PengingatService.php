<?php

namespace App\Services;

use App\Models\Inventaris;
use App\Models\User;
use App\Notifications\ReminderPeminjamanNotification;

class PengingatService
{
    public static function kirimPengingat(): int
    {
        $hariArray = config('approval.pengingat_hari', [3, 2, 1]);
        $hariBesar = array_map(fn($h) => now()->startOfDay()->addDays($h)->toDateString(), $hariArray);

        $items = Inventaris::where('status_peminjaman', 'Belum Dikembalikan')
            ->whereNotNull('tanggal_pengembalian')
            ->whereIn('tanggal_pengembalian', $hariBesar)
            ->get();

        $overdueItems = Inventaris::where('status_peminjaman', 'Belum Dikembalikan')
            ->whereNotNull('tanggal_pengembalian')
            ->where('tanggal_pengembalian', '<', now()->toDateString())
            ->get();

        $allItems = $items->merge($overdueItems);
        $notified = 0;

        foreach ($allItems as $item) {
            $karyawan = User::where('nrp', $item->nrp)->first();
            if (!$karyawan) {
                continue;
            }

            $hariSisa = (int) now()->startOfDay()->diffInDays($item->tanggal_pengembalian, false);

            $alreadyNotified = $karyawan->notifications()
                ->where('type', ReminderPeminjamanNotification::class)
                ->whereRaw("JSON_EXTRACT(data, '$.inventaris_id') = ?", [$item->id])
                ->exists();

            if (!$alreadyNotified) {
                $karyawan->notify(new ReminderPeminjamanNotification($item, $hariSisa));
                $notified++;
            }
        }

        return $notified;
    }
}