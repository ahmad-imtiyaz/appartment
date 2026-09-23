<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cleaning_pricings', function (Blueprint $table) {
            $table->decimal('price_per_hour', 15, 2)->nullable()->after('type');
        });

        // migrasi data lama (kalau ada) ke price_per_hour, ambil row aktif pertama sebagai basis
        $existing = DB::table('cleaning_pricings')->where('is_active', true)->first();
        if ($existing) {
            DB::table('cleaning_pricings')->update(['price_per_hour' => $existing->price]);
        }

        Schema::table('cleaning_pricings', function (Blueprint $table) {
            $table->dropColumn(['type', 'price']);
            $table->decimal('price_per_hour', 15, 2)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('cleaning_pricings', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->decimal('price', 15, 2)->nullable();
        });

        DB::table('cleaning_pricings')->update(['type' => 'cleaning-regular']);

        Schema::table('cleaning_pricings', function (Blueprint $table) {
            $table->dropColumn('price_per_hour');
        });
    }
};
