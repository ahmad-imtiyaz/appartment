<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_request_feedbacks', function (Blueprint $table) {
            $table->id();

            // 1 service_request cuma bisa dikasih 1 feedback
            $table->foreignId('service_request_id')
                  ->unique()
                  ->constrained('service_requests')
                  ->cascadeOnDelete();

            // disimpan lagi di sini (denormalisasi ringan) biar query
            // "semua feedback pekerja A" ga perlu join balik ke service_requests tiap kali
            $table->foreignId('worker_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // guest pemberi feedback

            $table->unsignedTinyInteger('rating'); // nilai 1-5
            $table->string('comment')->nullable(); // ulasan singkat (varchar)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_request_feedbacks');
    }
};
