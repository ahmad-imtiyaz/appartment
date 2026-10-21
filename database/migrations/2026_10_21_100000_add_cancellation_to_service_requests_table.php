<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $newStatuses = ['pending', 'assigned', 'in_progress', 'waiting_approval', 'waiting_payment', 'completed', 'rejected', 'cancelled'];
    private array $oldStatuses = ['pending', 'assigned', 'in_progress', 'waiting_approval', 'waiting_payment', 'completed', 'rejected'];

    public function up(): void
    {
        $this->setStatusEnum($this->newStatuses);

        Schema::table('service_requests', function (Blueprint $table) {
            // alasan batal (guest) / tolak (admin), disimpan sebagai key — label ada di lang guest.cancel_reasons
            $table->string('cancel_reason', 50)->nullable()->after('status');
            $table->string('cancel_note', 255)->nullable()->after('cancel_reason');
            $table->foreignId('cancelled_by')->nullable()->after('cancel_note')->constrained('users')->nullOnDelete();
            $table->dateTime('cancelled_at')->nullable()->after('cancelled_by');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cancelled_by');
            $table->dropColumn(['cancel_reason', 'cancel_note', 'cancelled_at']);
        });

        DB::table('service_requests')->where('status', 'cancelled')->update(['status' => 'rejected']);
        $this->setStatusEnum($this->oldStatuses);
    }

    private function setStatusEnum(array $values): void
    {
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            $list = "'" . implode("','", $values) . "'";
            DB::statement("ALTER TABLE service_requests MODIFY status ENUM($list) NOT NULL DEFAULT 'pending'");
            return;
        }

        // sqlite / pgsql (Laravel 11+)
        Schema::table('service_requests', function (Blueprint $table) use ($values) {
            $table->enum('status', $values)->default('pending')->change();
        });
    }
};
