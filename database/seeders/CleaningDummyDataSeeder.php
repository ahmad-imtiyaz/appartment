<?php

namespace Database\Seeders;

use App\Models\CleaningPricing;
use Illuminate\Database\Seeder;

class CleaningPricingSeeder extends Seeder
{
    public function run(): void
    {
        CleaningPricing::firstOrCreate(
            ['is_active' => true],
            ['price_per_hour' => 40000]
        );
    }
}
