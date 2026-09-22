<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApartmentLocation extends Model
{
    protected $fillable = ['name', 'is_active'];

    public function towers(): HasMany
    {
        return $this->hasMany(ApartmentTower::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
