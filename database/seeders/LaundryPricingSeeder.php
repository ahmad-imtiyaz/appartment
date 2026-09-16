<?php

namespace Database\Seeders;

use App\Models\LaundryPricing;
use Illuminate\Database\Seeder;

class LaundryPricingSeeder extends Seeder
{
    public function run(): void
    {
        $pricings = [
            ['type' => 'cuci',        'duration' => 'reguler',  'price_per_kg' => 5000],
            ['type' => 'cuci',        'duration' => 'express',  'price_per_kg' => 7000],
            ['type' => 'cuci_setrika', 'duration' => 'reguler',  'price_per_kg' => 8000],
            ['type' => 'cuci_setrika', 'duration' => 'express',  'price_per_kg' => 10000],
            ['type' => 'setrika',     'duration' => 'reguler',  'price_per_kg' => 6000],
            ['type' => 'setrika',     'duration' => 'express',  'price_per_kg' => 8500],
        ];

        foreach ($pricings as $p) {
            LaundryPricing::updateOrCreate(
                ['type' => $p['type'], 'duration' => $p['duration']],
                ['price_per_kg' => $p['price_per_kg'], 'is_active' => true]
            );
        }
    }
}
