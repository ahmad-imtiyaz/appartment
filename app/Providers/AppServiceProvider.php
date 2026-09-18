<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\BalanceMutation; // GANTI dengan nama model riwayat mutasi saldo kamu

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kirim jumlah notifikasi baru ke partial header guest
        View::composer('guest.partials.header-card', function ($view) {
            $user = auth()->user();
            $count = 0;

            if ($user) {
                $count = BalanceMutation::where('user_id', $user->id)
                    ->when(
                        $user->notif_seen_at,
                        fn ($query) => $query->where('created_at', '>', $user->notif_seen_at)
                    )
                    ->count();
            }

            $view->with('notifCount', $count);
        });
    }
}
