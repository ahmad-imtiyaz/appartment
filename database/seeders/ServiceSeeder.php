<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Laundry',
                'slug' => 'laundry',
                'description' => 'Layanan cuci & setrika pakaian penghuni apartemen.',
                'base_price' => 25000,
            ],
            [
                'name' => 'Cleaning',
                'slug' => 'cleaning',
                'description' => 'Layanan bersih-bersih unit apartemen.',
                'base_price' => 50000,
            ],
            [
                'name' => 'AC Service',
                'slug' => 'ac',
                'description' => 'Layanan servis/cuci AC unit apartemen.',
                'base_price' => 75000,
            ],
            [
                'name' => 'Maintenance & Repair',
                'slug' => 'maintenance-repair',
                'description' => 'Layanan perbaikan kerusakan unit (cat luntur, kebocoran, listrik, dll). Biaya ditentukan pekerja setelah pengecekan.',
                'base_price' => null, // harga custom per kasus, diisi pekerja saat selesai
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
