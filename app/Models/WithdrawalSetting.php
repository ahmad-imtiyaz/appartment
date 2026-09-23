<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalSetting extends Model
{
    protected $fillable = ['min_amount', 'fee_type', 'fee_value'];

    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:2',
            'fee_value' => 'decimal:2',
        ];
    }

    // Satu baris setting; dibuat otomatis dengan default kalau belum ada
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'min_amount' => 10000,
            'fee_type' => 'flat',
            'fee_value' => 0,
        ]);
    }

    public function calculateFee(float $amount): float
    {
        $fee = $this->fee_type === 'percent'
            ? $amount * ((float) $this->fee_value) / 100
            : (float) $this->fee_value;

        return round(min($fee, $amount), 2);
    }
}
