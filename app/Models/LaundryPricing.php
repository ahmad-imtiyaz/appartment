<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaundryPricing extends Model
{
    protected $fillable = [
        'type',
        'duration',
        'price_per_kg',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTypeAndDuration($query, string $type, string $duration)
    {
        return $query->where('type', $type)
            ->where('duration', $duration)
            ->where('is_active', true);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function label(): string
    {
        return match ($this->type) {
            'cuci' => 'Cuci',
            'cuci_setrika' => 'Cuci + Setrika',
            'setrika' => 'Setrika',
            default => $this->type,
        } . ' — ' . match ($this->duration) {
            'reguler' => 'Reguler (3 Hari)',
            'express' => 'Express (1 Hari)',
            default => $this->duration,
        };
    }

    public function durationLabel(): string
    {
        return match ($this->duration) {
            'reguler' => 'Reguler / 3 Hari',
            'express' => 'Express / 1 Hari',
            default => $this->duration,
        };
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'cuci' => 'Cuci',
            'cuci_setrika' => 'Cuci + Setrika',
            'setrika' => 'Setrika',
            default => $this->type,
        };
    }
}
