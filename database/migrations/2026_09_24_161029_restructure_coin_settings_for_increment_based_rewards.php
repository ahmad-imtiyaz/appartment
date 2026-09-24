<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sistem baru cuma pakai SATU baris setting aktif (pola sama seperti
        // CommissionSetting/WithdrawalSetting), bukan lagi banyak baris tier.
        // Sisakan baris tertua sebagai baris yang akan dipakai, hapus sisanya
        // karena makna "min_amount tier" sudah tidak relevan di logic baru.
        $keepId = DB::table('coin_settings')->orderBy('id')->value('id');

        if ($keepId) {
            DB::table('coin_settings')->where('id', '!=', $keepId)->delete();
        }

        Schema::table('coin_settings', function (Blueprint $table) {
            $table->decimal('increment_amount', 12, 2)->default(50000)->after('id');
            $table->unsignedInteger('points_per_increment')->default(1)->after('increment_amount');
        });

        Schema::table('coin_settings', function (Blueprint $table) {
            $table->dropColumn(['min_amount', 'coin_reward']);
        });

        // Kalau tabel tadinya kosong (belum ada baris sama sekali), CoinSetting::current()
        // di model yang akan buat baris default saat pertama kali dipanggil.
    }

    public function down(): void
    {
        Schema::table('coin_settings', function (Blueprint $table) {
            $table->decimal('min_amount', 12, 2)->default(0)->after('id');
            $table->unsignedInteger('coin_reward')->default(1)->after('min_amount');
            $table->dropColumn(['increment_amount', 'points_per_increment']);
        });
    }
};
