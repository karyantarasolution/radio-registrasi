<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses notifikasi.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $notifications = Auth::user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(string $id)
    {
        $this->ensureAdmin();

        $notification = Auth::user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('dashboard');

        return redirect($url);
    }

    public function markAllAsRead()
    {
        $this->ensureAdmin();

        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index')->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
