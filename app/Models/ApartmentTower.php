<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApartmentTower extends Model
{
    protected $fillable = ['apartment_location_id', 'name', 'is_active'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(ApartmentLocation::class, 'apartment_location_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'apartment_tower_id');
    }
}
