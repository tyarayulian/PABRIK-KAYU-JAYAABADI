<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->string('hutan')->nullable()->after('product_id');
            $table->boolean('is_processed')->default(false)->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->dropColumn(['hutan', 'is_processed']);
        });
    }
};
