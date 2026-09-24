<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinSetting extends Model
{
    protected $fillable = [
        'increment_amount',
        'points_per_increment',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'increment_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Ambil (atau buat) satu-satunya baris setting aktif.
     * Pola sama seperti CommissionSetting::current() / WithdrawalSetting::current().
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['is_active' => true],
            ['increment_amount' => 50000, 'points_per_increment' => 1]
        );
    }
}
