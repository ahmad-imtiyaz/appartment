<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcPricing extends Model
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
        return $query->where('type', $type)->where('is_active', true);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'ac-cleaning' => 'AC Cleaning',
            'ac-refill'   => 'Freon Refill',
            'ac-repair'   => 'AC Repair',
            default => $this->type,
        };
    }

    public function typeKey(): string
    {
        return $this->type;
    }
}
