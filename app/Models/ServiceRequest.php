<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'worker_id',
        'assigned_by',
        'status',
        'notes',
        'worker_notes',
        'scheduled_at',
        'assigned_at',
        'notified_at',
        'accepted_at',
        'completed_at',
        'cost',

        // potongan admin
        'commission_percent',
        'commission_amount',
        'worker_earning',

        'daerah',
        'apartment_location_id',
        'apartment_tower_id',

        // laundry
        'laundry_type',
        'laundry_duration',
        'snapshot_price_per_kg',
        'billable_weight',
        'total_price',
        'collected_at',
        'weighed_at',
        'laundry_paid_at',

        // cleaning
        'cleaning_duration_hours',
        'snapshot_cleaning_price_per_hour',

        // ac
        'ac_type',
        'snapshot_ac_price',

        // maintenance & repair
        'snapshot_repair_price',
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
            'laundry_paid_at' => 'datetime',
            'survey_reported_at' => 'datetime',
            'price_approved_at' => 'datetime',

            'cost' => 'decimal:2',
            'commission_percent' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'worker_earning' => 'decimal:2',
        ];
    }

    // =========================================================
    // RELASI USER
    // =========================================================

    /**
     * Guest yang membuat service request.
     *
     * withTrashed() diperlukan agar service request tetap bisa
     * menampilkan data user meskipun user sudah di-soft-delete.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Pekerja yang mengerjakan service request.
     *
     * withTrashed() diperlukan agar data pekerja tetap bisa
     * ditampilkan meskipun akun pekerja sudah di-soft-delete.
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id')->withTrashed();
    }

    // =========================================================
    // CANDIDATES / PEKERJA YANG DITAWARI
    // =========================================================

    /**
     * Pekerja-pekerja yang ditawari tugas ini.
     * Siapa cepat ACC, dia mendapatkan tugas.
     */
    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'service_request_candidates',
            'service_request_id',
            'worker_id'
        )->withTimestamps();
    }

    // =========================================================
    // ADMIN
    // =========================================================

    /**
     * Admin yang melakukan assignment.
     *
     * withTrashed() agar riwayat tetap tersedia jika admin
     * kemudian di-soft-delete.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by')->withTrashed();
    }

    // =========================================================
    // RELASI APARTEMEN
    // =========================================================

    public function apartmentLocation(): BelongsTo
    {
        return $this->belongsTo(ApartmentLocation::class);
    }

    public function apartmentTower(): BelongsTo
    {
        return $this->belongsTo(ApartmentTower::class);
    }

    // =========================================================
    // CLEANING ADDONS
    // =========================================================

    public function cleaningAddons(): BelongsToMany
    {
        return $this->belongsToMany(
            CleaningAddon::class,
            'cleaning_addon_service_request'
        )
            ->withPivot('snapshot_price')
            ->withTimestamps();
    }

    // =========================================================
    // MAINTENANCE & REPAIR
    // =========================================================

    /**
     * Hanya terisi jika service-nya Maintenance & Repair.
     */
    public function maintenanceDetail(): HasOne
    {
        return $this->hasOne(MaintenanceDetail::class);
    }

    // =========================================================
    // FOTO
    // =========================================================

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

    // =========================================================
    // FEEDBACK
    // =========================================================

    public function feedback(): HasOne
    {
        return $this->hasOne(ServiceRequestFeedback::class);
    }

    // =========================================================
    // POTONGAN ADMIN
    // =========================================================

    /**
     * Hitung potongan admin dari total tugas memakai
     * persentase yang sedang aktif.
     *
     * Hasilnya di-snapshot ke kolom request supaya perubahan
     * setting tidak mengubah tugas lama.
     */
    public static function commissionFor(float $gross): array
    {
        $percent = CommissionSetting::percentage();

        $amount = round(
            $gross * $percent / 100,
            2
        );

        return [
            'commission_percent' => $percent,
            'commission_amount' => $amount,
            'worker_earning' => round(
                $gross - $amount,
                2
            ),
        ];
    }

    public function hasCommission(): bool
    {
        return $this->commission_percent !== null;
    }

    // =========================================================
    // STATUS HELPER
    // =========================================================

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Admin sudah assign, menunggu pekerja ACC.
     */
    public function isWaitingAcceptance(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Masih ditawarkan ke beberapa pekerja,
     * belum ada yang mengambil.
     */
    public function isOpenOffer(): bool
    {
        return $this->status === 'assigned'
            && $this->worker_id === null;
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Worker sudah selesai cuci, menunggu guest bayar
     * atau sudah bayar dan menunggu pengantaran.
     */
    public function isWaitingPayment(): bool
    {
        return $this->status === 'waiting_payment';
    }

    public function isLaundryPaid(): bool
    {
        return $this->laundry_paid_at !== null;
    }

    /**
     * MnR: harga final sudah dikirim admin,
     * menunggu guest menyetujui.
     */
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

            'waiting_payment' => $this->isLaundryPaid()
                ? 'Sudah dibayar, menunggu diantar'
                : 'Menunggu pembayaran',

            'completed' => 'Selesai',

            'rejected' => 'Ditolak',

            default => ucfirst(
                str_replace('_', ' ', $this->status)
            ),
        };
    }

    // =========================================================
    // SERVICE TYPE
    // =========================================================

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

    // =========================================================
    // AC TYPE
    // =========================================================

    public function isAcRepair(): bool
    {
        return $this->ac_type === 'ac-repair';
    }

    public function isAcFullService(): bool
    {
        return $this->ac_type === 'ac-full-service';
    }

    /**
     * Maintenance & Repair serta AC Repair / Full Service
     * menggunakan alur:
     *
     * survey -> set harga -> approve
     */
    public function requiresSurveyPricing(): bool
    {
        return $this->isMaintenance()
            || (
                $this->isAc()
                && in_array(
                    $this->ac_type,
                    [
                        'ac-repair',
                        'ac-full-service',
                    ]
                )
            );
    }

    /**
     * MnR: harga final sudah disetujui guest
     * dan saldo sudah dipotong.
     */
    public function isPriceApproved(): bool
    {
        return $this->price_approved_at !== null;
    }

    // =========================================================
    // TOTAL PRICE
    // =========================================================

    public function calculateTotalPrice(): void
    {
        // =========================
        // LAUNDRY
        // =========================

        if (
            $this->isLaundry()
            && $this->billable_weight
            && $this->snapshot_price_per_kg
        ) {
            $billableWeight = max(
                $this->billable_weight,
                1
            );

            $this->total_price = round(
                $billableWeight
                * $this->snapshot_price_per_kg,
                2
            );

            $this->save();

            return;
        }

        // =========================
        // CLEANING
        // =========================

        if (
            $this->isCleaning()
            && $this->cleaning_duration_hours
            && $this->snapshot_cleaning_price_per_hour
        ) {
            $base =
                $this->cleaning_duration_hours
                * $this->snapshot_cleaning_price_per_hour;

            $addonTotal = $this->cleaningAddons()
                ->sum('snapshot_price');

            $this->total_price = round(
                $base + $addonTotal,
                2
            );

            $this->save();
        }
    }

    // =========================================================
    // LAUNDRY WEIGHT
    // =========================================================

    public function billableWeightLabel(): string
    {
        return (
            $this->billable_weight !== null
            && $this->billable_weight < 1
        )
            ? '1 kg (minimum)'
            : $this->billable_weight . ' kg';
    }
}
