<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            ['display_name' => 'BCA - Apartemen'],
            [
                'type' => 'bank_transfer',
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder_name' => 'PT Apartemen Sejahtera',
                'is_active' => true,
            ]
        );

        PaymentMethod::updateOrCreate(
            ['display_name' => 'QRIS Apartemen'],
            [
                'type' => 'qris',
                'qr_image' => null, // upload manual lewat admin nanti, placeholder dulu
                'is_active' => true,
            ]
        );
    }
}
