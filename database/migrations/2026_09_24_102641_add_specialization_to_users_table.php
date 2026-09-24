<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Buang kolom versi sebelumnya (multi-pilihan) kalau sudah ada
            if (Schema::hasColumn('users', 'specializations')) {
                $table->dropColumn('specializations');
            }

            // Nama jasa yang ditangani pekerja, null = semua jasa
            $table->string('specialization')->nullable()->after('apartment_unit_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('specialization');
        });
    }
};
