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

        $tier = CoinSetting::active()
            ->where('min_amount', '<=', $amountSpent)
            ->orderByDesc('min_amount')
            ->first();

        if (!$tier) {
            return null;
        }

        $balanceBefore = $guest->coin_balance;
        $balanceAfter = $balanceBefore + $tier->coin_reward;

        $guest->update([
            'coin_balance' => $balanceAfter,
        ]);

        return CoinMutation::create([
            'user_id' => $guest->id,
            'type' => 'earn',
            'amount' => $tier->coin_reward,
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
