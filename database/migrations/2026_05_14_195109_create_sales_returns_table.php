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
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->foreignId('account_id')->nullable()->constrained('chart_of_accounts'); // Kas/Piutang yang dikreditkan
            $table->foreignId('return_account_id')->nullable()->constrained('chart_of_accounts'); // Akun Retur Penjualan
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_returns');
    }
};
