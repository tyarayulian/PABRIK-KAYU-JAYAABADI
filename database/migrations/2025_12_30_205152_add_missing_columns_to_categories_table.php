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
            if (! Schema::hasColumn('categories', 'name')) {
                $table->string('name')->after('id');
            }
            if (! Schema::hasColumn('categories', 'code')) {
                $table->string('code')->unique()->after('name');
            }
            if (! Schema::hasColumn('categories', 'type')) {
                $table->enum('type', ['cash_in', 'cash_out'])->after('code');
            }
            if (! Schema::hasColumn('categories', 'account_id')) {
                $table->unsignedBigInteger('account_id')->nullable()->after('type');
            }
            if (! Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('account_id');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'account_id')) {
                try {
                    $table->foreign('account_id')
                        ->references('id')
                        ->on('akun_coa')
                        ->onDelete('restrict');
                } catch (\Exception $e) {
                    // Foreign key already exists
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('categories', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('categories', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('categories', 'account_id')) {
                $table->dropForeign(['account_id']);
                $table->dropColumn('account_id');
            }
        });
    }
};
