<?php
// database/migrations/2026_09_22_140505_add_waiting_payment_status_to_service_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $newStatuses = ['pending', 'assigned', 'in_progress', 'waiting_approval', 'waiting_payment', 'completed', 'rejected'];
    private array $oldStatuses = ['pending', 'assigned', 'in_progress', 'waiting_approval', 'completed', 'rejected'];

    public function up(): void
    {
        $this->setStatusEnum($this->newStatuses);

        Schema::table('service_requests', function (Blueprint $table) {
            // kapan guest membayar tagihan laundry (setelah worker input berat, sebelum diantar)
            $table->dateTime('laundry_paid_at')->nullable()->after('total_price');
        });
    }

    public function down(): void
    {
        DB::table('service_requests')->where('status', 'waiting_payment')->update(['status' => 'in_progress']);
        $this->setStatusEnum($this->oldStatuses);

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('laundry_paid_at');
        });
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
