<?php

namespace Database\Seeders;

use App\Models\CleaningPricing;
use Illuminate\Database\Seeder;

class CleaningPricingSeeder extends Seeder
{
    public function run(): void
    {
        $pricings = [
            ['type' => 'cleaning-regular',  'price' => 100000],
            ['type' => 'cleaning-deep',     'price' => 200000],
            ['type' => 'cleaning-postmove', 'price' => 300000],
        ];

        foreach ($pricings as $p) {
            CleaningPricing::updateOrCreate(
                ['type' => $p['type']],
                ['price' => $p['price'], 'is_active' => true]
            );
        }
    }
}