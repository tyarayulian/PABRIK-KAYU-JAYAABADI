<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'initial_stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('initial_stock', 15, 2)->default(0)->after('cost');
            });
        }

        // Copy current stock to initial_stock and then we will update stock to be current_stock
        $products = \DB::table('products')->get();
        foreach ($products as $product) {
            \DB::table('products')->where('id', $product->id)->update([
                'initial_stock' => $product->stock
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('initial_stock');
        });
    }
};
