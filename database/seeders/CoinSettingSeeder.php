<?php

namespace Database\Seeders;

use App\Models\CoinSetting;
use Illuminate\Database\Seeder;

class CoinSettingSeeder extends Seeder
{
    public function run(): void
    {
        CoinSetting::updateOrCreate(
            ['is_active' => true],
            ['increment_amount' => 50000, 'points_per_increment' => 1]
        );
    }
}
