<?php

namespace Database\Seeders;

use App\Models\AcPricing;
use Illuminate\Database\Seeder;

class AcPricingSeeder extends Seeder
{
    public function run(): void
    {
        $pricings = [
            ['type' => 'ac-cleaning', 'price' => 75000],
            ['type' => 'ac-refill', 'price' => 150000],
            ['type' => 'ac-repair', 'price' => 100000],
        ];

        foreach ($pricings as $pricing) {
            AcPricing::updateOrCreate(
                ['type' => $pricing['type']],
                array_merge($pricing, ['is_active' => true])
            );
        }
    }
}
