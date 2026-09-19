<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('category', 100);           // mis. "Kebocoran Air / Pipa"
            $table->string('severity', 10);            // ringan | sedang | berat
            $table->decimal('price', 12, 2);           // harga patok (estimasi)
            $table->string('description', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['category', 'severity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_pricings');
    }
};
