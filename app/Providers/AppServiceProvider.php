<?php

namespace App\Providers;

use App\Models\BalanceMutation; // GANTI dengan nama model riwayat mutasi saldo kamu
use App\Models\DeviceToken;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        // Hapus token FCM device saat user logout agar tidak menerima push notifikasi lama
        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                DeviceToken::where('user_id', $event->user->getAuthIdentifier())->delete();
            }
        });
    }
}
