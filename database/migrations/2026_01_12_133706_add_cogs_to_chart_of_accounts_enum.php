<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE akun_coa MODIFY type ENUM('asset', 'liability', 'equity', 'revenue', 'expense', 'cogs')");
        DB::statement("UPDATE akun_coa SET type = 'cogs' WHERE code = '5100' AND name = 'HPP'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE akun_coa MODIFY type ENUM('asset', 'liability', 'equity', 'revenue', 'expense')");
        DB::statement("UPDATE akun_coa SET type = 'expense' WHERE code = '5100' AND name = 'HPP'");
    }
};
