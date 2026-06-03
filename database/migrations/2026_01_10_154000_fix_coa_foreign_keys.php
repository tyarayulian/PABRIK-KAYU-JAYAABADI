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
        Schema::table('general_journals', function (Blueprint $table) {
            // Drop existing foreign key pointing to chart_of_accounts
            $table->dropForeign(['account_id']);

            // Re-add pointing to akun_coa
            $table->foreign('account_id')
                ->references('id')
                ->on('akun_coa')
                ->onDelete('cascade');
        });

        Schema::table('general_ledgers', function (Blueprint $table) {
            // Drop existing foreign key pointing to chart_of_accounts
            $table->dropForeign(['account_id']);

            // Re-add pointing to akun_coa
            $table->foreign('account_id')
                ->references('id')
                ->on('akun_coa')
                ->onDelete('cascade');
        });

        // Also fix legacy cash tables if they exist
        if (Schema::hasTable('cash_in')) {
            Schema::table('cash_in', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')
                    ->on('akun_coa')
                    ->onDelete('cascade');
            });
        }

        if (Schema::hasTable('cash_out')) {
            Schema::table('cash_out', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')
                    ->on('akun_coa')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_journals', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->foreign('account_id')
                ->references('id')
                ->on('chart_of_accounts')
                ->onDelete('cascade');
        });

        Schema::table('general_ledgers', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->foreign('account_id')
                ->references('id')
                ->on('chart_of_accounts')
                ->onDelete('cascade');
        });

        if (Schema::hasTable('cash_in')) {
            Schema::table('cash_in', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')
                    ->on('chart_of_accounts')
                    ->onDelete('cascade');
            });
        }

        if (Schema::hasTable('cash_out')) {
            Schema::table('cash_out', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                    ->references('id')
                    ->on('chart_of_accounts')
                    ->onDelete('cascade');
            });
        }
    }
};
