<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        User::updateOrCreate(
            ['email' => 'admin@apartemen.test'],
            [
                'name' => 'Admin Apartemen',
                'password' => $defaultPassword,
                'role' => 'admin',
                'phone' => '081200000001',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pekerja1@apartemen.test'],
            [
                'name' => 'Pekerja Satu',
                'password' => $defaultPassword,
                'role' => 'pekerja',
                'phone' => '081200000002',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pekerja2@apartemen.test'],
            [
                'name' => 'Pekerja Dua',
                'password' => $defaultPassword,
                'role' => 'pekerja',
                'phone' => '081200000003',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'guest@apartemen.test'],
            [
                'name' => 'Guest Testing',
                'password' => $defaultPassword,
                'role' => 'guest',
                'phone' => '081200000004',
                'apartment_unit_number' => 'A-1203',
                'balance' => 500000,
                'email_verified_at' => now(),
            ]
        );
    }
}