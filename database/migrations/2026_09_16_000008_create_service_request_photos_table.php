<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_request_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_request_id')
                  ->constrained('service_requests')
                  ->cascadeOnDelete();

            // 'before' = foto kerusakan/kondisi awal dari guest (dipakai terutama untuk maintenance)
            // 'after'  = foto bukti hasil pengerjaan dari pekerja
            $table->enum('type', ['before', 'after']);

            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_request_photos');
    }
};
