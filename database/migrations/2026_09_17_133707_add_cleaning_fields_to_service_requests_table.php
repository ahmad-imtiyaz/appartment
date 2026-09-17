<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('cleaning_type')->nullable()->after('snapshot_price_per_kg');
            $table->decimal('snapshot_cleaning_price', 12, 2)->nullable()->after('cleaning_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'cleaning_type',
                'snapshot_cleaning_price',
            ]);
        });
    }
};
