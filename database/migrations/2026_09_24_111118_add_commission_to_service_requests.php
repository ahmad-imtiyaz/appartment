<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('percentage', 5, 2)->default(10);
            $table->timestamps();
        });

        // Nilai awal 10%
        DB::table('commission_settings')->insert([
            'percentage' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('commission_percent', 5, 2)->nullable()->after('cost');
            $table->decimal('commission_amount', 12, 2)->nullable()->after('commission_percent');
            $table->decimal('worker_earning', 12, 2)->nullable()->after('commission_amount');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['commission_percent', 'commission_amount', 'worker_earning']);
        });

        Schema::dropIfExists('commission_settings');
    }
};
