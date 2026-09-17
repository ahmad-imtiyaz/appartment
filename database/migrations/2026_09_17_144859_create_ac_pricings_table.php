<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ac_pricings', function (Blueprint $table) {
            $table->id();

            $table->string('type'); // ac-cleaning, ac-refill, ac-repair
            $table->decimal('price', 15, 2);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ac_pricings');
    }
};
