<?php

namespace App\Services;

use App\Models\CoinMutation;
use App\Models\CoinSetting;
use App\Models\ServiceRequest;
use App\Models\User;

class CoinRewardService
{
    public function awardForServiceRequest(
        ServiceRequest $serviceRequest,
        User $guest,
        float $amountSpent
    ): ?CoinMutation {
        if ($amountSpent <= 0) {
            return null;
        }

        $setting = CoinSetting::current();

        if ($setting->increment_amount <= 0) {

            return null;
        }

         $multiples = (int) floor($amountSpent / (float) $setting->increment_amount);
        $reward = $multiples * $setting->points_per_increment;

        if ($reward <= 0) {
            return null;
        }

        $balanceBefore = $guest->coin_balance;
        $balanceAfter = $balanceBefore + $reward;
        $guest->update([
            'coin_balance' => $balanceAfter,
        ]);

        return CoinMutation::create([
            'user_id' => $guest->id,
            'type' => 'earn',
            'amount' => $reward,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reference_type' => 'ServiceRequest',
            'reference_id' => $serviceRequest->id,
            'description' => 'Reward dari '
                . $serviceRequest->service->name
                . ' (Rp'
                . number_format($amountSpent, 0, ',', '.')
                . ')',
        ]);
    }
}
