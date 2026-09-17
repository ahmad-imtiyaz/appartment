<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id',              // guest pemohon
        'service_id',
        'worker_id',            // pekerja yang dipilih admin
        'assigned_by',          // admin yang assign
        'status',                // pending | assigned | in_progress | completed | rejected
        'notes',
        'worker_notes',
        'scheduled_at',
        'assigned_at',
        'notified_at',
        'accepted_at',
        'completed_at',
        'cost',
        // laundry
        'laundry_type',
        'laundry_duration',
        'snapshot_price_per_kg',
        'billable_weight',
        'total_price',
        'collected_at',
        'weighed_at',
        // cleaning
        'cleaning_type',
        'snapshot_cleaning_price',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'assigned_at' => 'datetime',
            'notified_at' => 'datetime',
            'accepted_at' => 'datetime',
            'completed_at' => 'datetime',
            'collected_at' => 'datetime',
            'weighed_at' => 'datetime',
            'cost' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // hanya terisi kalau service-nya Maintenance & Repair
    public function maintenanceDetail(): HasOne
    {
        return $this->hasOne(MaintenanceDetail::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ServiceRequestPhoto::class);
    }

    public function beforePhotos(): HasMany
    {
        return $this->photos()->where('type', 'before');
    }

    public function afterPhotos(): HasMany
    {
        return $this->photos()->where('type', 'after');
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(ServiceRequestFeedback::class);
    }

    // ==== Status helper ====
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // admin sudah assign, nunggu pekerja ACC
    public function isWaitingAcceptance(): bool
    {
        return $this->status === 'assigned';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    // ==== Laundry helpers ==== //

    public function isLaundry(): bool
    {
        return $this->service->slug === 'laundry';
    }

    public function calculateTotalPrice(): void
    {
        if (!$this->isLaundry() || !$this->billable_weight || !$this->snapshot_price_per_kg) {
            return;
        }

        $billableWeight = max($this->billable_weight, 1);
        $this->total_price = round($billableWeight * $this->snapshot_price_per_kg, 2);
        $this->save();
    }

    public function billableWeightLabel(): string
    {
        return ($this->billable_weight !== null && $this->billable_weight < 1)
            ? '1 kg (minimum)' : $this->billable_weight . ' kg';
    }
}
