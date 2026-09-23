<?php

namespace App\Services;

use App\Models\BalanceMutation;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RepairPaymentService
{
    /**
     * Potong saldo guest sebesar harga final (total_price) order berbasis survey/repair,
     * tandai harga sudah disetujui, dan kembalikan status ke in_progress.
     *
     * Return false kalau saldo tidak cukup (tidak ada data yang berubah).
     * Aman dipanggil dua kali: kalau sudah dibayar, tidak dipotong lagi.
     */
    public function charge(ServiceRequest $serviceRequest): bool
    {
        $paid = DB::transaction(function () use ($serviceRequest) {
            $locked = ServiceRequest::whereKey($serviceRequest->getKey())
                ->with('service')
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->price_approved_at) {
                return true;
            }

            if (!$locked->total_price) {
                throw new \LogicException('Harga final belum ditetapkan.');
            }

            $guest = User::whereKey($locked->user_id)->lockForUpdate()->firstOrFail();
            $price = (float) $locked->total_price;
            $before = (float) $guest->balance;

            if ($before < $price) {
                return false;
            }

            $after = $before - $price;
            $guest->update(['balance' => $after]);

            BalanceMutation::create([
                'user_id' => $guest->id,
                'type' => 'debit',
                'amount' => $price,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference_type' => 'ServiceRequest',
                'reference_id' => $locked->id,
                'description' => 'Pembayaran jasa ' . $locked->service->name . ' (harga disetujui)',
            ]);

            $locked->update([
                'price_approved_at' => now(),
                'status' => 'in_progress',
            ]);

            return true;
        });

        if ($paid) {
            $serviceRequest->refresh();
        }

        return $paid;
    }
}
