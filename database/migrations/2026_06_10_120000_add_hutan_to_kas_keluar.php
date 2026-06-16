<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            if (!Schema::hasColumn('kas_keluar', 'hutan')) {
                $table->string('hutan')->nullable()->after('product_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('kas_keluar', 'hutan')) {
                $table->dropColumn('hutan');
            }
        });
    }
};
