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
            $table->dropColumn('category_id');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::table('cash_in', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('chart_of_accounts')->onDelete('cascade');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('chart_of_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_in', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\ChartOfAccount::class, 'category_id');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\ChartOfAccount::class, 'category_id');
        });

        Schema::table('cash_in', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        });

        Schema::table('cash_out', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        });
    }
};
