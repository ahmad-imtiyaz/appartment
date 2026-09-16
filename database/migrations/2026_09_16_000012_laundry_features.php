<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_pricings', function (Blueprint $table) {
            $table->id();

            $table->string('type'); // cuci, cuci_setrika, setrika
            $table->string('duration'); // reguler, express
            $table->decimal('price_per_kg', 15, 2);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        // Add laundry columns to service_requests
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('laundry_type')->nullable()->after('service_id');
            $table->string('laundry_duration')->nullable()->after('laundry_type');
            $table->decimal('snapshot_price_per_kg', 15, 2)->nullable()->after('laundry_duration');
            $table->decimal('billable_weight', 8, 2)->nullable()->after('snapshot_price_per_kg');
            $table->decimal('total_price', 15, 2)->nullable()->after('billable_weight');
            $table->timestamp('collected_at')->nullable()->after('total_price');
            $table->timestamp('weighed_at')->nullable()->after('collected_at');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'laundry_type', 'laundry_duration', 'snapshot_price_per_kg',
                'billable_weight', 'total_price', 'collected_at', 'weighed_at'
            ]);
        });

        Schema::dropIfExists('laundry_pricings');
    }
};
