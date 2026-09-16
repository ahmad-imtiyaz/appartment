<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            // dua jenis: 'bank_transfer' atau 'qris'
            $table->enum('type', ['bank_transfer', 'qris']);

            $table->string('display_name'); // contoh: "BCA", "QRIS Apartement"

            // hanya diisi kalau type = bank_transfer
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder_name')->nullable();

            // hanya diisi kalau type = qris
            $table->string('qr_image')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
