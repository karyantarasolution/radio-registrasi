<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nrp',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function routeNotificationForMail($notification): ?string
    {
        return $this->email ?? config('notifications.admin_email');
    }

    public function isAdmin()
    {
        return $this->role === 'admin_ict';
    }

    public function isPimpinan()
    {
        return $this->role === 'pimpinan';
    }

    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

    public function isTamu()
    {
        return $this->role === 'tamu';
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'nrp', 'nrp');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
