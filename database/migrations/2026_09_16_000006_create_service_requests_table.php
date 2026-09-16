<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // guest pemohon
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->foreignId('worker_id')->nullable()->constrained('users')->nullOnDelete(); // pekerja yang ditugaskan

            // pending -> di-acc pekerja -> assigned -> in_progress -> completed
            // (atau rejected kalau pekerja/admin menolak)
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'rejected'])
                  ->default('pending');

            $table->text('notes')->nullable();       // catatan dari guest saat request
            $table->text('worker_notes')->nullable(); // catatan dari pekerja saat proses/selesai

            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            // biaya final (bisa berbeda dari base_price, terutama untuk maintenance)
            $table->decimal('cost', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
