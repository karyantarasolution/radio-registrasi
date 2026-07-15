<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PimpinanSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['name' => 'Pimpinan'],
            [
                'email' => 'pimpinan@ppa.co.id',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
                'nrp' => null,
            ]
        );

        User::updateOrCreate(
            ['name' => 'ICT'],
            [
                'email' => 'ict@ppa.co.id',
                'password' => Hash::make('password'),
                'role' => 'admin_ict',
                'nrp' => 'ICT',
            ]
        );

        User::updateOrCreate(
            ['name' => 'Muhammad Faisal'],
            [
                'email' => 'faisal@ppa.co.id',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'nrp' => '26200305',
            ]
        );

        User::updateOrCreate(
            ['name' => 'Muhammad Akmal'],
            [
                'email' => 'akmal@ppa.co.id',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'nrp' => '25200412',
            ]
        );
    }
}
