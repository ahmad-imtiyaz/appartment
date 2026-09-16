<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cleaning_pricings', function (Blueprint $table) {
            $table->id();

            $table->string('type'); // cleaning-regular, cleaning-deep, cleaning-postmove
            $table->decimal('price', 15, 2); // harga per sesi cleaning
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cleaning_pricings');
    }
};