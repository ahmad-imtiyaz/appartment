<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class CoinRedemptionProduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'coin_cost',
        'stock',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'coin_cost' => 'integer',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(CoinRedemption::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function canBeRedeemed(): bool
    {
        return $this->is_active && $this->stock > 0;
    }
}