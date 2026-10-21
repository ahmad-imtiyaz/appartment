<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rekening pekerja untuk pencairan pendapatan (diisi di profil)
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('specialization');
            $table->string('bank_account_number', 50)->nullable()->after('bank_name');
            $table->string('bank_account_holder')->nullable()->after('bank_account_number');
        });

        // Satu pengajuan pencairan per tugas selesai
        Schema::create('worker_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 15, 2); // = worker_earning tugas

            // snapshot rekening saat diajukan
            $table->string('bank_name');
            $table->string('account_number', 50);
            $table->string('account_holder_name');

            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('proof_path')->nullable(); // foto bukti transfer dari admin
            $table->string('admin_note')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_payouts');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account_number', 'bank_account_holder']);
        });
    }
};
