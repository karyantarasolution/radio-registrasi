<?php

namespace App\Providers;

use App\Models\Inventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->isAdmin()) {
                    $view->with([
                        'unreadNotificationsCount' => $user->unreadNotifications()->count(),
                        'latestNotifications' => $user->notifications()->limit(5)->get(),
                    ]);
                }

                if ($user->isKaryawan()) {
                    $tomorrow = now()->addDay()->toDateString();
                    $h1Warnings = Inventaris::where('nrp', $user->nrp)
                        ->where('status_peminjaman', 'Belum Dikembalikan')
                        ->whereNotNull('tanggal_pengembalian')
                        ->where('tanggal_pengembalian', $tomorrow)
                        ->get();

                    $overdueItems = Inventaris::where('nrp', $user->nrp)
                        ->where('status_peminjaman', 'Belum Dikembalikan')
                        ->whereNotNull('tanggal_pengembalian')
                        ->where('tanggal_pengembalian', '<', now()->toDateString())
                        ->get();

                    $view->with([
                        'h1Warnings' => $h1Warnings,
                        'overdueItems' => $overdueItems,
                    ]);
                }
            }
        });
    }
}
