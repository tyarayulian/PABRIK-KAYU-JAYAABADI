<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('akun_coa', function (Blueprint $table) {
            $table->decimal('opening_balance', 15, 2)->default(0)->after('is_active');
            $table->date('opening_balance_date')->nullable()->after('opening_balance');
        });
    }

    public function down(): void
    {
        Schema::table('akun_coa', function (Blueprint $table) {
            $table->dropColumn(['opening_balance', 'opening_balance_date']);
        });
    }
};
