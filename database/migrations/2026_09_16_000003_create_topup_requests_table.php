<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topup_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->restrictOnDelete();

            $table->decimal('amount', 15, 2);
            $table->string('proof_image'); // bukti transfer/screenshot yang diupload guest

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // diisi saat admin acc/reject
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('admin_note')->nullable(); // alasan kalau reject

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topup_requests');
    }
};
