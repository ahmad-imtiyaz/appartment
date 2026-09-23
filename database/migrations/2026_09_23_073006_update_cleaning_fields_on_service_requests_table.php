<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['cleaning_type', 'snapshot_cleaning_price']);
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->unsignedTinyInteger('cleaning_duration_hours')->nullable()->after('apartment_tower_id');
            $table->decimal('snapshot_cleaning_price_per_hour', 15, 2)->nullable()->after('cleaning_duration_hours');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['cleaning_duration_hours', 'snapshot_cleaning_price_per_hour']);
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('cleaning_type')->nullable();
            $table->decimal('snapshot_cleaning_price', 12, 2)->nullable();
        });
    }
};
