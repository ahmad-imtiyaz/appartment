<?php

namespace Database\Seeders;

use App\Models\CleaningArea;
use App\Models\CleaningAddon;
use App\Models\CleaningPricing;
use Illuminate\Database\Seeder;

class CleaningDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        CleaningPricing::firstOrCreate(
            ['is_active' => true],
            ['price_per_hour' => 40000]
        );

        collect(['Kamar Tidur', 'Ruang Tamu', 'Dapur', 'Kamar Mandi', 'Balkon', 'Ruang Kerja'])
            ->each(fn ($name) => CleaningArea::firstOrCreate(['name' => $name], ['is_active' => true]));

        collect([
            ['name' => 'Cuci Kaca Jendela', 'price' => 25000],
            ['name' => 'Setrika Baju Tambahan', 'price' => 15000],
            ['name' => 'Bersih-bersih Kulkas', 'price' => 20000],
            ['name' => 'Cuci Sofa (per unit)', 'price' => 50000],
            ['name' => 'Bersih Area Dapur Ekstra', 'price' => 30000],
        ])->each(fn ($addon) => CleaningAddon::firstOrCreate(
            ['name' => $addon['name']],
            ['price' => $addon['price'], 'is_active' => true]
        ));
    }
}
