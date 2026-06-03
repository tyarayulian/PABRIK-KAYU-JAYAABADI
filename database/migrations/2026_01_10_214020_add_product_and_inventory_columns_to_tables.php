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
            if (! Schema::hasColumn('categories', 'is_product')) {
                $table->boolean('is_product')->default(false)->after('type');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 15, 2)->default(0)->after('name');
            }
            if (! Schema::hasColumn('products', 'cost')) {
                $table->decimal('cost', 15, 2)->default(0)->after('price');
            }
        });

        Schema::table('kas_masuk', function (Blueprint $table) {
            if (! Schema::hasColumn('kas_masuk', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('category_id')->constrained('products')->onDelete('set null');
            }
            if (! Schema::hasColumn('kas_masuk', 'quantity')) {
                $table->decimal('quantity', 15, 2)->default(0)->after('product_id');
            }
        });

        Schema::table('kas_keluar', function (Blueprint $table) {
            if (! Schema::hasColumn('kas_keluar', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('category_id')->constrained('products')->onDelete('set null');
            }
            if (! Schema::hasColumn('kas_keluar', 'quantity')) {
                $table->decimal('quantity', 15, 2)->default(0)->after('product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity']);
        });

        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'cost']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_product');
        });
    }
};
