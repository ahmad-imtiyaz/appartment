<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',                  // penyewa | pemilik | agent
        'daerah',
        'apartment_location_id',
        'apartment_tower_id',
        'phone',
        'apartment_unit_number',
        'balance',
        'coin_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    // ==== Helper role check ====

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPekerja(): bool
    {
        return $this->role === 'pekerja';
    }

    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    // ==== Relasi Apartemen ====

    public function apartmentLocation(): BelongsTo
    {
        return $this->belongsTo(ApartmentLocation::class);
    }

    public function apartmentTower(): BelongsTo
    {
        return $this->belongsTo(ApartmentTower::class);
    }

    // ==== Relasi sebagai GUEST (penyewa apartemen) ====

    // semua service request yang DIA ajukan
    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'user_id');
    }

    public function topupRequests(): HasMany
    {
        return $this->hasMany(TopupRequest::class, 'user_id');
    }

    public function balanceMutations(): HasMany
    {
        return $this->hasMany(BalanceMutation::class, 'user_id');
    }

    // feedback yang DIA berikan ke pekerja
    public function feedbacksGiven(): HasMany
    {
        return $this->hasMany(ServiceRequestFeedback::class, 'user_id');
    }

    // ==== Relasi sebagai PEKERJA ====

    // semua tugas yang DIA kerjakan
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'worker_id');
    }

    // feedback yang DIA terima dari guest
    public function feedbacksReceived(): HasMany
    {
        return $this->hasMany(ServiceRequestFeedback::class, 'worker_id');
    }

    // ==== Relasi sebagai ADMIN ====

    // topup yang DIA approve/reject
    public function approvedTopups(): HasMany
    {
        return $this->hasMany(TopupRequest::class, 'approved_by');
    }

    // service request yang DIA assign ke pekerja
    public function assignedServiceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'assigned_by');
    }

    public function productListings(): HasMany
    {
        return $this->hasMany(ProductListing::class, 'posted_by');
    }

    public function coinRedemptions(): HasMany
    {
        return $this->hasMany(CoinRedemption::class, 'user_id');
    }

    // ==== Relasi Coin ====

    public function coinMutations(): HasMany
    {
        return $this->hasMany(CoinMutation::class, 'user_id');
    }
}
