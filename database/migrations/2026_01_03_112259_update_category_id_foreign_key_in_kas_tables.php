<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Update existing data for the specific case reported by the user
        // Account 16 with 'Limbah kayu' should point to Category ID 12
        DB::table('kas_masuk')->where('id', 37)->where('category_id', 16)->update(['category_id' => 12]);

        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Revert data for ID 37
        DB::table('kas_masuk')->where('id', 37)->where('category_id', 12)->update(['category_id' => 16]);

        Schema::table('kas_masuk', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('akun_coa')->onDelete('cascade');
        });
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('akun_coa')->onDelete('cascade');
        });
    }
};
