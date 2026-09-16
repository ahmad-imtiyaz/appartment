<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('name');   // Laundry, Cleaning, AC Service, Maintenance & Repair
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();

            // harga dasar, bisa null kalau nanti dihitung manual per kasus (misal maintenance)
            $table->decimal('base_price', 15, 2)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
