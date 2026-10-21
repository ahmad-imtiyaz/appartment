<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Banner promosi/iklan/info di beranda guest (di bawah Jual & Beli)
        Schema::create('promo_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');                 // nama internal / alt text
            $table->string('image');                 // 1200x400 (3:1)
            $table->string('link_url')->nullable();  // opsional, dibuka saat banner diklik
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_banners');
    }
};
