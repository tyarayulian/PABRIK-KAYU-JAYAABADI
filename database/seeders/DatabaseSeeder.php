<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pabrik Kayu',
            'email' => 'admin@pabrikkayu.com',
            'password' => bcrypt('admin123'),
        ]);

        $accounts = [
            ['code' => '1100', 'name' => 'Kas', 'type' => 'asset'],
            ['code' => '1110', 'name' => 'Bank', 'type' => 'asset'],
            ['code' => '1200', 'name' => 'Piutang', 'type' => 'asset'],
            ['code' => '2100', 'name' => 'Hutang Usaha', 'type' => 'liability'],
            ['code' => '2200', 'name' => 'Beban Akrual', 'type' => 'liability'],
            ['code' => '3100', 'name' => 'Modal Pemilik', 'type' => 'equity'],
            ['code' => '3200', 'name' => 'Laba Ditahan', 'type' => 'equity'],
            ['code' => '4100', 'name' => 'Penjualan Produk', 'type' => 'revenue'],
            ['code' => '4200', 'name' => 'Jasa Lainnya', 'type' => 'revenue'],
            ['code' => '5100', 'name' => 'Beban Gaji', 'type' => 'expense'],
            ['code' => '5200', 'name' => 'Beban Bahan Baku', 'type' => 'expense'],
            ['code' => '5300', 'name' => 'Beban Operasional', 'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::create([
                'code' => $account['code'],
                'name' => $account['name'],
                'type' => $account['type'],
                'is_active' => true,
            ]);
        }
    }
}
