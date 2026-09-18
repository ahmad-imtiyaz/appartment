<?php

namespace Database\Seeders;

use App\Models\CoinSetting;
use Illuminate\Database\Seeder;

class CoinSettingSeeder extends Seeder
{
    public function run(): void
    {
        CoinSetting::create([
            'min_amount' => 50000,
            'coin_reward' => 10,
            'is_active' => true,
        ]);

        CoinSetting::create([
            'min_amount' => 100000,
            'coin_reward' => 25,
            'is_active' => true,
        ]);

        CoinSetting::create([
            'min_amount' => 200000,
            'coin_reward' => 50,
            'is_active' => true,
        ]);
    }
}
