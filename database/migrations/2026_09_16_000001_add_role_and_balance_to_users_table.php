<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // admin, pekerja, guest
            $table->enum('role', ['admin', 'pekerja', 'guest'])->default('guest')->after('email');
            $table->string('phone')->nullable()->after('role');

            // hanya relevan untuk role guest (penyewa apartemen)
            $table->string('apartment_unit_number')->nullable()->after('phone');

            // saldo user, hanya berubah lewat balance_mutations (bukan diedit manual)
            $table->decimal('balance', 15, 2)->default(0)->after('apartment_unit_number');

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'apartment_unit_number', 'balance']);
            $table->dropSoftDeletes();
        });
    }
};
