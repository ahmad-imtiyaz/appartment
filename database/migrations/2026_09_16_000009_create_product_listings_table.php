<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_listings', function (Blueprint $table) {
            $table->id();

            // admin yang input info jual-beli (bukan penjual/pembeli beneran, cuma display)
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable(); // mis. "elektronik", "furniture"
            $table->string('contact_info')->nullable(); // no. WA / unit, ditampilkan statis saja

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_listings');
    }
};
