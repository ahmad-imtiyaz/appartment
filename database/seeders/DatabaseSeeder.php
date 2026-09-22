<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            UserSeeder::class,
            PaymentMethodSeeder::class,
            LaundryPricingSeeder::class,
            CleaningPricingSeeder::class,
            AcPricingSeeder::class,
            CoinSettingSeeder::class,
            CoinRedemptionProductSeeder::class,
            ApartmentLocationSeeder::class,
        ]);
    }
}
