<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@apartemen.test'],
            [
                'name' => 'Admin Apartemen',
                'password' => 'password',
                'role' => 'admin',
                'phone' => '081200000001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pekerja1@apartemen.test'],
            [
                'name' => 'Pekerja Satu',
                'password' => 'password',
                'role' => 'pekerja',
                'phone' => '081200000002',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pekerja2@apartemen.test'],
            [
                'name' => 'Pekerja Dua',
                'password' => 'password',
                'role' => 'pekerja',
                'phone' => '081200000003',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'guest@apartemen.test'],
            [
                'name' => 'Guest Testing',
                'password' => 'password',
                'role' => 'guest',
                'phone' => '081200000004',
                'apartment_unit_number' => 'A-1203',
                'balance' => 500000, // biar langsung bisa test ajuin service tanpa top up dulu
                'email_verified_at' => now(),
            ]
        );
    }
}
