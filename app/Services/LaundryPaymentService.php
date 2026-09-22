<?php

namespace App\Services;

use App\Models\BalanceMutation;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;

class LaundryPaymentService
{
    public function charge(ServiceRequest $serviceRequest): bool
    {
        return DB::transaction(function () use ($serviceRequest) {
            $serviceRequest->refresh();

            // idempotent: kalau sudah dibayar, anggap sukses tanpa potong saldo lagi
            if ($serviceRequest->laundry_paid_at !== null) {
                return true;
            }

            $guest = $serviceRequest->user()->lockForUpdate()->first();
            $cost = $serviceRequest->total_price ?? 0;

            if ($guest->balance < $cost) {
                return false;
            }

            $balanceBefore = $guest->balance;
            $balanceAfter = $balanceBefore - $cost;

            $guest->update(['balance' => $balanceAfter]);

            BalanceMutation::create([
                'user_id' => $guest->id,
                'type' => 'debit',
                'amount' => $cost,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reference_type' => 'ServiceRequest',
                'reference_id' => $serviceRequest->id,
                'description' => 'Pembayaran laundry #' . $serviceRequest->id,
            ]);

            $serviceRequest->update(['laundry_paid_at' => now()]);

            return true;
        });
    }
}
