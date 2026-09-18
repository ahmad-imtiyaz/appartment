<?php

namespace Database\Seeders;

use App\Models\CoinRedemptionProduct;
use Illuminate\Database\Seeder;

class CoinRedemptionProductSeeder extends Seeder
{
    public function run(): void
    {
        CoinRedemptionProduct::create([
            'name' => 'Voucher Makan Siang',
            'description' => 'Voucher makan siang senilai Rp50.000 di kantin apartemen',
            'coin_cost' => 100,
            'stock' => 50,
            'is_active' => true,
        ]);

        CoinRedemptionProduct::create([
            'name' => 'Voucher Laundry 1kg',
            'description' => 'Voucher laundry 1kg gratis (max Rp30.000)',
            'coin_cost' => 80,
            'stock' => 30,
            'is_active' => true,
        ]);

        CoinRedemptionProduct::create([
            'name' => 'Voucher Cleaning Kamar',
            'description' => 'Voucher jasa cleaning kamar 1x (senilai Rp100.000)',
            'coin_cost' => 200,
            'stock' => 20,
            'is_active' => true,
        ]);

        CoinRedemptionProduct::create([
            'name' => 'Merchandise Tumbler',
            'description' => 'Tumbler eksklusif Bersih.id',
            'coin_cost' => 150,
            'stock' => 15,
            'is_active' => true,
        ]);

        CoinRedemptionProduct::create([
            'name' => 'Voucher Parkir Bulanan',
            'description' => 'Gratis parkir 1 bulan (senilai Rp200.000)',
            'coin_cost' => 400,
            'stock' => 10,
            'is_active' => true,
        ]);
    }
}