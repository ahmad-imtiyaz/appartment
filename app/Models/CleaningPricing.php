<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleaningPricing extends Model
{
    protected $fillable = [
        'type',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type)
            ->where('is_active', true);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'cleaning-regular' => 'Regular Cleaning',
            'cleaning-deep'    => 'Deep Cleaning',
            'cleaning-postmove' => 'Post Move-in',
            default => $this->type,
        };
    }

    public function typeKey(): string
    {
        return $this->type;
    }
}