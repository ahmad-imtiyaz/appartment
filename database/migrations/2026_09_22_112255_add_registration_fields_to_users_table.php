<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->nullable()->after('role'); // penyewa | pemilik | agent
            $table->string('daerah')->nullable()->after('status'); // saat ini hanya "Jakarta"
            $table->foreignId('apartment_location_id')->nullable()->after('daerah')
                ->constrained('apartment_locations')->nullOnDelete();
            $table->foreignId('apartment_tower_id')->nullable()->after('apartment_location_id')
                ->constrained('apartment_towers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('apartment_tower_id');
            $table->dropConstrainedForeignId('apartment_location_id');
            $table->dropColumn(['status', 'daerah']);
        });
    }
};
