<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_account_id')->nullable()->after('account_id');
        });

        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_account_id')->nullable()->after('account_id');
        });
    }

    public function down(): void
    {
        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->dropColumn('payment_account_id');
        });

        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->dropColumn('payment_account_id');
        });
    }
};
