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
        'status',                // pending | assigned | in_progress | waiting_approval | completed | rejected
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
        'total_price',          // laundry: dari berat | maintenance-repair: harga final
        'collected_at',
        'weighed_at',
        // cleaning
        'cleaning_type',
        'snapshot_cleaning_price',
        // ac
        'ac_type',
        'snapshot_ac_price',
        // maintenance & repair
        'snapshot_repair_price', // estimasi saat order (null = "Lainnya")
        'survey_notes',
        'survey_reported_at',
        'price_change_note',
        'price_approved_at',
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
            'survey_reported_at' => 'datetime',
            'price_approved_at' => 'datetime',
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

    // MnR: harga final sudah dikirim admin, nunggu guest setuju
    public function isWaitingApproval(): bool
    {
        return $this->status === 'waiting_approval';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu diproses',
            'assigned' => 'Menunggu pekerja',
            'in_progress' => 'Sedang dikerjakan',
            'waiting_approval' => 'Menunggu persetujuan harga',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function isAc(): bool
    {
        return $this->service->slug === 'ac';
    }

    public function isLaundry(): bool
    {
        return $this->service->slug === 'laundry';
    }

    public function isCleaning(): bool
    {
        return $this->service->slug === 'cleaning';
    }

    public function isMaintenance(): bool
    {
        return $this->service->slug === 'maintenance-repair';
    }

    // MnR: harga final sudah disetujui guest & saldo sudah dipotong
    public function isPriceApproved(): bool
    {
        return $this->price_approved_at !== null;
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
