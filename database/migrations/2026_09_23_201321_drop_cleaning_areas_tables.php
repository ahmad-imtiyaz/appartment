<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // pivot dulu (punya FK ke cleaning_areas), baru tabel utamanya
        Schema::dropIfExists('cleaning_area_service_request');
        Schema::dropIfExists('cleaning_areas');
    }

    public function down(): void
    {
        Schema::create('cleaning_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('cleaning_area_service_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cleaning_area_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
