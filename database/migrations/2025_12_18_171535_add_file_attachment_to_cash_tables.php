<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cash_in', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('description');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_in', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
