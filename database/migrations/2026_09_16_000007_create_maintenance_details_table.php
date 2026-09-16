<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_request_id')
                  ->unique() // 1 service_request maintenance = 1 detail
                  ->constrained('service_requests')
                  ->cascadeOnDelete();

            // contoh: cat_luntur, kebocoran_air, listrik, kerusakan_pintu, lainnya
            $table->string('damage_category');

            $table->string('location')->nullable(); // mis. "kamar mandi", "dapur"
            $table->text('description')->nullable();

            // tingkat urgensi, opsional tapi berguna buat prioritas pekerja
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_details');
    }
};
