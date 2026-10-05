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
        Schema::table('cleaning_addon_service_request', function (Blueprint $table) {
            $table->boolean('is_done')->default(false)->after('snapshot_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cleaning_addon_service_request', function (Blueprint $table) {
            $table->dropColumn('is_done');
        });
    }
};
