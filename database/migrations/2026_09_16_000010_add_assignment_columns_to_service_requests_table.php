<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            // admin yang memilih/assign pekerja (beda dari worker_id = pekerja yang dipilih)
            $table->foreignId('assigned_by')
                  ->nullable()
                  ->after('worker_id')
                  ->constrained('users')
                  ->nullOnDelete();

            // kapan admin assign pekerja & kapan email notifikasi dikirim
            $table->timestamp('assigned_at')->nullable()->after('assigned_by');
            $table->timestamp('notified_at')->nullable()->after('assigned_at');

            // kapan pekerja meng-ACC tugas (isi -> status pindah ke in_progress)
            $table->timestamp('accepted_at')->nullable()->after('notified_at');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_by');
            $table->dropColumn(['assigned_at', 'notified_at', 'accepted_at']);
        });
    }
};
