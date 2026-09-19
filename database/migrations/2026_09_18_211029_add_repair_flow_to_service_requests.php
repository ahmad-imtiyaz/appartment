<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $newStatuses = ['pending', 'assigned', 'in_progress', 'waiting_approval', 'completed', 'rejected'];
    private array $oldStatuses = ['pending', 'assigned', 'in_progress', 'completed', 'rejected'];

    public function up(): void
    {
        $this->setStatusEnum($this->newStatuses);

        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('snapshot_repair_price', 15, 2)->nullable();  // estimasi dari repair_pricings (null = kategori "Lainnya")
            $table->text('survey_notes')->nullable();                     // laporan survei dari pekerja
            $table->dateTime('survey_reported_at')->nullable();
            $table->string('price_change_note', 255)->nullable();         // alasan admin mengubah harga
            $table->dateTime('price_approved_at')->nullable();            // harga final disetujui + saldo sudah dipotong
        });

        Schema::table('maintenance_details', function (Blueprint $table) {
            $table->string('severity', 10)->nullable()->after('damage_category'); // ringan | sedang | berat
        });
    }

    public function down(): void
    {
        DB::table('service_requests')->where('status', 'waiting_approval')->update(['status' => 'in_progress']);
        $this->setStatusEnum($this->oldStatuses);

        Schema::table('maintenance_details', function (Blueprint $table) {
            $table->dropColumn('severity');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'snapshot_repair_price', 'survey_notes', 'survey_reported_at',
                'price_change_note', 'price_approved_at',
            ]);
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
