<?php
// Generate CSV Struktur Antar Tabel
// Akses: http://localhost/pabrik-kayu1/public/export_struktur_tabel.php

$fileName = 'Struktur_Antar_Tabel.csv';

header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=' . $fileName);
header('Pragma: no-cache');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

$file = fopen('php://output', 'w');
fwrite($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

fputcsv($file, ['No.', 'Nama Tabel', 'Atribut', 'Tipe Data', 'Keterangan']);

$tables = [
    [
        'no' => '1',
        'name' => 'users',
        'columns' => [
            ['id',                  'bigint(20)',        'Primary Key'],
            ['name',                'varchar(255)',      ''],
            ['email',               'varchar(255)',      ''],
            ['password',            'varchar(255)',      ''],
            ['remember_token',      'varchar(100)',      ''],
            ['email_verified_at',   'timestamp',        ''],
            ['created_at',          'timestamp',        ''],
            ['updated_at',          'timestamp',        ''],
        ]
    ],
    [
        'no' => '2',
        'name' => 'kas_masuk',
        'columns' => [
            ['id',              'bigint(20)',        'Primary Key'],
            ['date',            'datetime',         ''],
            ['category_id',     'bigint(20)',        'Foreign Key → categories'],
            ['product_id',      'bigint(20)',        'Foreign Key → products'],
            ['quantity',        'decimal(15,2)',     ''],
            ['price',           'decimal(15,2)',     ''],
            ['account_id',      'bigint(20)',        'Foreign Key → akun_coa'],
            ['description',     'text',             ''],
            ['amount',          'decimal(15,2)',     ''],
            ['file_path',       'varchar(255)',      ''],
            ['created_at',      'timestamp',        ''],
            ['updated_at',      'timestamp',        ''],
        ]
    ],
    [
        'no' => '3',
        'name' => 'kas_keluar',
        'columns' => [
            ['id',              'bigint(20)',        'Primary Key'],
            ['date',            'datetime',         ''],
            ['category_id',     'bigint(20)',        'Foreign Key → categories'],
            ['product_id',      'bigint(20)',        'Foreign Key → products'],
            ['quantity',        'decimal(15,2)',     ''],
            ['price',           'decimal(15,2)',     ''],
            ['account_id',      'bigint(20)',        'Foreign Key → akun_coa'],
            ['description',     'text',             ''],
            ['amount',          'decimal(15,2)',     ''],
            ['is_processed',    'tinyint(1)',        ''],
            ['file_path',       'varchar(255)',      ''],
            ['created_at',      'timestamp',        ''],
            ['updated_at',      'timestamp',        ''],
        ]
    ],
    [
        'no' => '4',
        'name' => 'akun_coa',
        'columns' => [
            ['id',          'bigint(20)',                                                    'Primary Key'],
            ['code',        'varchar(255)',                                                  ''],
            ['name',        'varchar(255)',                                                  ''],
            ['type',        "enum('asset','liability','equity','revenue','expense','cogs')", ''],
            ['description', 'text',                                                         ''],
            ['is_active',   'tinyint(1)',                                                    ''],
            ['created_at',  'timestamp',                                                    ''],
            ['updated_at',  'timestamp',                                                    ''],
        ]
    ],
    [
        'no' => '5',
        'name' => 'categories',
        'columns' => [
            ['id',                  'bigint(20)',                    'Primary Key'],
            ['name',                'varchar(255)',                  ''],
            ['code',                'varchar(255)',                  ''],
            ['description',         'text',                         ''],
            ['type',                "enum('cash_in','cash_out')",    ''],
            ['transaction_type',    'varchar(255)',                  ''],
            ['is_product',          'tinyint(1)',                    ''],
            ['account_id',          'bigint(20)',                    'Foreign Key → akun_coa'],
            ['is_active',           'tinyint(1)',                    ''],
            ['created_at',          'timestamp',                     ''],
            ['updated_at',          'timestamp',                     ''],
        ]
    ],
    [
        'no' => '6',
        'name' => 'products',
        'columns' => [
            ['id',                      'bigint(20)',    'Primary Key'],
            ['name',                    'varchar(255)',  ''],
            ['wood_type',               'varchar(100)',  ''],
            ['product_category',        'varchar(100)',  ''],
            ['size',                    'varchar(100)',  ''],
            ['cubic_content',           'int',           ''],
            ['unit',                    'varchar(50)',   ''],
            ['cost',                    'decimal(15,2)', ''],
            ['stock',                   'decimal(15,2)', ''],
            ['initial_stock',           'decimal(15,2)', ''],
            ['sales_account_id',        'bigint(20)',    'Foreign Key → akun_coa'],
            ['hpp_account_id',          'bigint(20)',    'Foreign Key → akun_coa'],
            ['inventory_account_id',    'bigint(20)',    'Foreign Key → akun_coa'],
            ['is_active',               'tinyint(1)',    ''],
            ['created_at',              'timestamp',     ''],
            ['updated_at',              'timestamp',     ''],
        ]
    ],
    [
        'no' => '7',
        'name' => 'product_stocks',
        'columns' => [
            ['id',          'bigint(20)',    'Primary Key'],
            ['product_id',  'bigint(20)',    'Foreign Key → products'],
            ['date',        'date',          ''],
            ['quantity',    'decimal(15,2)', ''],
            ['price',       'decimal(15,2)', ''],
            ['description', 'text',          ''],
            ['created_at',  'timestamp',     ''],
            ['updated_at',  'timestamp',     ''],
        ]
    ],
    [
        'no' => '8',
        'name' => 'general_journals',
        'columns' => [
            ['id',           'bigint(20)',                'Primary Key'],
            ['journal_date', 'datetime',                 ''],
            ['account_id',   'bigint(20)',                'Foreign Key → akun_coa'],
            ['type',         "enum('debit','credit')",    ''],
            ['amount',       'decimal(15,2)',             ''],
            ['reference',    'varchar(255)',              ''],
            ['source',       'varchar(255)',              ''],
            ['source_id',    'bigint(20)',                ''],
            ['created_at',   'timestamp',                ''],
            ['updated_at',   'timestamp',                ''],
        ]
    ],
    [
        'no' => '9',
        'name' => 'sales_returns',
        'columns' => [
            ['id',                'bigint(20)',    'Primary Key'],
            ['date',              'datetime',      ''],
            ['product_id',        'bigint(20)',    'Foreign Key → products'],
            ['kas_masuk_id',      'bigint(20)',    'Foreign Key → kas_masuk'],
            ['quantity',          'int',           ''],
            ['amount',            'decimal(15,2)', ''],
            ['description',       'text',          ''],
            ['account_id',        'bigint(20)',    'Foreign Key → akun_coa'],
            ['return_account_id', 'bigint(20)',    'Foreign Key → akun_coa'],
            ['file_path',         'varchar(255)',  ''],
            ['created_at',        'timestamp',     ''],
            ['updated_at',        'timestamp',     ''],
        ]
    ],
    [
        'no' => '10',
        'name' => 'general_ledgers',
        'columns' => [
            ['id',           'bigint(20)',    'Primary Key'],
            ['account_id',   'bigint(20)',    'Foreign Key → akun_coa'],
            ['debit_total',  'decimal(15,2)', ''],
            ['credit_total', 'decimal(15,2)', ''],
            ['balance',      'decimal(15,2)', ''],
            ['created_at',   'timestamp',     ''],
            ['updated_at',   'timestamp',     ''],
        ]
    ],
    [
        'no' => '11',
        'name' => 'productions',
        'columns' => [
            ['id',           'bigint(20)',    'Primary Key'],
            ['kas_keluar_id','bigint(20)',    'Foreign Key → kas_keluar'],
            ['wood_type',    'varchar(255)',  ''],
            ['total_cost',   'decimal(15,2)', ''],
            ['date',         'date',          ''],
            ['notes',        'text',          ''],
            ['created_at',   'timestamp',     ''],
            ['updated_at',   'timestamp',     ''],
        ]
    ],
    [
        'no' => '12',
        'name' => 'production_items',
        'columns' => [
            ['id',              'bigint(20)',    'Primary Key'],
            ['production_id',   'bigint(20)',    'Foreign Key → productions'],
            ['product_id',      'bigint(20)',    'Foreign Key → products'],
            ['quantity',        'decimal(15,2)', ''],
            ['allocated_cost',  'decimal(15,2)', ''],
            ['created_at',      'timestamp',     ''],
            ['updated_at',      'timestamp',     ''],
        ]
    ],
];

foreach ($tables as $table) {
    $firstRow = true;
    foreach ($table['columns'] as $col) {
        if ($firstRow) {
            fputcsv($file, [$table['no'], $table['name'], $col[0], $col[1], $col[2]]);
            $firstRow = false;
        } else {
            fputcsv($file, ['', '', $col[0], $col[1], $col[2]]);
        }
    }
    fputcsv($file, ['', '', '', '', '']);
}

fclose($file);
?>
