<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('daerah')
                ->nullable()
                ->after('notes');

            $table->foreignId('apartment_location_id')
                ->nullable()
                ->after('daerah')
                ->constrained('apartment_locations')
                ->nullOnDelete();

            $table->foreignId('apartment_tower_id')
                ->nullable()
                ->after('apartment_location_id')
                ->constrained('apartment_towers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['apartment_tower_id']);
            $table->dropForeign(['apartment_location_id']);

            $table->dropColumn([
                'apartment_tower_id',
                'apartment_location_id',
                'daerah',
            ]);
        });
    }
};
