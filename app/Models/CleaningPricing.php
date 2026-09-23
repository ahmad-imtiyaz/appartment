<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CleaningPricing extends Model
{
    protected $fillable = [
        'price_per_hour',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_hour' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ambil tarif per-jam yang sedang berlaku (cuma 1 row aktif)
    public static function current(): ?self
    {
        return static::active()->latest()->first();
    }
}
