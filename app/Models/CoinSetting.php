<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinSetting extends Model
{
    protected $fillable = [
        'min_amount',
        'coin_reward',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'min_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
