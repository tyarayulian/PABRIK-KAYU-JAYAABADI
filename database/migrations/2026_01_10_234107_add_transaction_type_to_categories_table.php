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
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'transaction_type')) {
                $table->enum('transaction_type', ['penjualan', 'pembelian'])->nullable()->after('type');
            }
        });

        // Initialize based on existing type
        \DB::table('categories')->where('type', 'cash_in')->update(['transaction_type' => 'penjualan']);
        \DB::table('categories')->where('type', 'cash_out')->update(['transaction_type' => 'pembelian']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'transaction_type')) {
                $table->dropColumn('transaction_type');
            }
        });
    }
};
