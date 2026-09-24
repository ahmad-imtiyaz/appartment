<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('service_requests', 'daerah')) {
                $table->string('daerah')
                    ->nullable()
                    ->after('notes');
            }

            if (! Schema::hasColumn('service_requests', 'apartment_location_id')) {
                $table->foreignId('apartment_location_id')
                    ->nullable()
                    ->after('daerah')
                    ->constrained('apartment_locations')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('service_requests', 'apartment_tower_id')) {
                $table->foreignId('apartment_tower_id')
                    ->nullable()
                    ->after('apartment_location_id')
                    ->constrained('apartment_towers')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('service_requests', 'apartment_tower_id')) {
            Schema::table('service_requests', function (Blueprint $table) {
                $table->dropForeign(['apartment_tower_id']);
                $table->dropColumn('apartment_tower_id');
            });
        }

        if (Schema::hasColumn('service_requests', 'apartment_location_id')) {
            Schema::table('service_requests', function (Blueprint $table) {
                $table->dropForeign(['apartment_location_id']);
                $table->dropColumn('apartment_location_id');
            });
        }

        if (Schema::hasColumn('service_requests', 'daerah')) {
            Schema::table('service_requests', function (Blueprint $table) {
                $table->dropColumn('daerah');
            });
        }
    }
};
