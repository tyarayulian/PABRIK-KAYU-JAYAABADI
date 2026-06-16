<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/_debugbar/open' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.openhandler',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/queries/explain' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.queries.explain',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::w3MtL1iFJaphKc61',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bAQnAqK7nNXeITBj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/debug-auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::d2Wf1xtTJSNARZ37',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/dashboard-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.dashboard.data',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transaksi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transaksi.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transaksi-kas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kas-masuk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kas-masuk/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kas-keluar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kas-keluar/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales-return' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales-return/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.flow.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/api/data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.cash.flow',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/destroy-bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.destroyBulk',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/in/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/out/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/in/get-items' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.getItems',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/in' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/out/get-items' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.getItems',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cash/out' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/accounts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/accounts/bulk-delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.destroyBulk',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/products/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/arus-kas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.cash-flow',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/arus-kas/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.cash-flow.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/arus-kas/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.cash-flow.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/buku-kas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.cash',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/buku-kas/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.cash.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/api/cash' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.report.cash',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/laba-rugi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.income-statement',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/laba-rugi/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.income-statement.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/jurnal-umum' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.journal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/jurnal-umum/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.journal.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/jurnal-umum/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.journal.sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/jurnal-umum/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.journal.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/buku-besar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.ledger',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/buku-besar/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.ledger.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/buku-besar/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.ledger.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca-saldo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.trial-balance',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca-saldo/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.trial-balance.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca-saldo/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.trial-balance.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.neraca',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca/print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.neraca.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/neraca/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'report.neraca.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'settings.profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/users/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/_debugbar/c(?|ache/(.*)(*:31)|lockwork/([^/]++)(*:55))|/reset\\-password/([^/]++)(*:88)|/s(?|torage/(.*)(*:111)|ales\\-return/([^/]++)(?|(*:143)|/edit(*:156)|(*:164))|ettings/users/([^/]++)(*:195))|/api/cash/([^/]++)/([^/]++)(*:231)|/kas\\-(?|masuk/([^/]++)(?|(*:265)|/edit(*:278)|(*:286))|keluar/([^/]++)(?|(*:313)|/edit(*:326)|(*:334)))|/cash/(?|api/([^/]++)/([^/]++)(*:374)|in/([^/]++)(?|/edit(*:401)|(*:409))|out/([^/]++)(?|/edit(*:438)|(*:446)))|/master/(?|categories/(?|([^/]++)(?|/edit(*:497)|(*:505))|bulk(*:518)|([^/]++)(?|(*:537)|(*:545)))|accounts/(?|([^/]++)(?|/edit(*:583)|(*:591))|([0-9]+)(*:608)|([^/]++)/toggle(*:631))|products/(?|([^/]++)(?|/(?|edit(*:671)|add\\-stock(?|(*:692)))|(*:702))|stock/([^/]++)(?|/edit(*:733)|(*:741))|([^/]++)/(?|edit\\-initial\\-stock(*:782)|update\\-initial\\-stock(*:812)))))/?$}sDu',
    ),
    3 => 
    array (
      31 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.cache.delete',
          ),
          1 => 
          array (
            0 => 'key',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      55 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.clockwork',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      88 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      111 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      143 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.show',
          ),
          1 => 
          array (
            0 => 'sales_return',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      156 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.edit',
          ),
          1 => 
          array (
            0 => 'sales_return',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      164 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.update',
          ),
          1 => 
          array (
            0 => 'sales_return',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'sales-return.destroy',
          ),
          1 => 
          array (
            0 => 'sales_return',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.destroy',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      231 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.cash-transaction.detail',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      265 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.show',
          ),
          1 => 
          array (
            0 => 'kas_masuk',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      278 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.edit',
          ),
          1 => 
          array (
            0 => 'kas_masuk',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      286 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.update',
          ),
          1 => 
          array (
            0 => 'kas_masuk',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'kas-masuk.destroy',
          ),
          1 => 
          array (
            0 => 'kas_masuk',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      313 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.show',
          ),
          1 => 
          array (
            0 => 'kas_keluar',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      326 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.edit',
          ),
          1 => 
          array (
            0 => 'kas_keluar',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      334 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.update',
          ),
          1 => 
          array (
            0 => 'kas_keluar',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'kas-keluar.destroy',
          ),
          1 => 
          array (
            0 => 'kas_keluar',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      374 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.cash.detail',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      401 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      409 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.show',
          ),
          1 => 
          array (
            0 => 'kasMasuk',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.update',
          ),
          1 => 
          array (
            0 => 'kasMasuk',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'cash.in.destroy',
          ),
          1 => 
          array (
            0 => 'kasMasuk',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      438 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      446 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.show',
          ),
          1 => 
          array (
            0 => 'kasKeluar',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.update',
          ),
          1 => 
          array (
            0 => 'kasKeluar',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'cash.out.destroy',
          ),
          1 => 
          array (
            0 => 'kasKeluar',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      497 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      505 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      518 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.destroyBulk',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      537 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.byType',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      545 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.categories.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      583 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.edit',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      591 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.update',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      608 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      631 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.accounts.toggle',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      671 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.edit',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      692 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.add-stock',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.store-stock',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      702 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.update',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.destroy',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      733 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.edit-stock',
          ),
          1 => 
          array (
            0 => 'stock',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      741 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.update-stock',
          ),
          1 => 
          array (
            0 => 'stock',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.destroy-stock',
          ),
          1 => 
          array (
            0 => 'stock',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.edit-initial-stock',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      812 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.products.update-initial-stock',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'debugbar.openhandler' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/open',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Fruitcake\\LaravelDebugbar\\Middleware\\DebugbarEnabled',
          1 => 'Fruitcake\\LaravelDebugbar\\Middleware\\StopRecordingTelescope',
        ),
        'uses' => 'Fruitcake\\LaravelDebugbar\\Controllers\\OpenHandlerController@handle',
        'controller' => 'Fruitcake\\LaravelDebugbar\\Controllers\\OpenHandlerController@handle',
        'namespace' => NULL,
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
        'as' => 'debugbar.openhandler',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.cache.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => '_debugbar/cache/{key}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Fruitcake\\LaravelDebugbar\\Middleware\\DebugbarEnabled',
          1 => 'Fruitcake\\LaravelDebugbar\\Middleware\\StopRecordingTelescope',
        ),
        'uses' => 'Fruitcake\\LaravelDebugbar\\Controllers\\CacheController@delete',
        'controller' => 'Fruitcake\\LaravelDebugbar\\Controllers\\CacheController@delete',
        'namespace' => NULL,
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
        'as' => 'debugbar.cache.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'key' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.queries.explain' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_debugbar/queries/explain',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Fruitcake\\LaravelDebugbar\\Middleware\\DebugbarEnabled',
          1 => 'Fruitcake\\LaravelDebugbar\\Middleware\\StopRecordingTelescope',
        ),
        'uses' => 'Fruitcake\\LaravelDebugbar\\Controllers\\QueriesController@explain',
        'controller' => 'Fruitcake\\LaravelDebugbar\\Controllers\\QueriesController@explain',
        'namespace' => NULL,
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
        'as' => 'debugbar.queries.explain',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.clockwork' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/clockwork/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Fruitcake\\LaravelDebugbar\\Middleware\\DebugbarEnabled',
          1 => 'Fruitcake\\LaravelDebugbar\\Middleware\\StopRecordingTelescope',
        ),
        'uses' => 'Fruitcake\\LaravelDebugbar\\Controllers\\OpenHandlerController@clockwork',
        'controller' => 'Fruitcake\\LaravelDebugbar\\Controllers\\OpenHandlerController@clockwork',
        'namespace' => NULL,
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
        'as' => 'debugbar.clockwork',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.assets' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Fruitcake\\LaravelDebugbar\\Middleware\\DebugbarEnabled',
          1 => 'Fruitcake\\LaravelDebugbar\\Middleware\\StopRecordingTelescope',
        ),
        'uses' => 'Fruitcake\\LaravelDebugbar\\Controllers\\AssetController@getAssets',
        'controller' => 'Fruitcake\\LaravelDebugbar\\Controllers\\AssetController@getAssets',
        'namespace' => NULL,
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
        'as' => 'debugbar.assets',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::w3MtL1iFJaphKc61' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:833:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'D:\\\\xampp4\\\\htdocs\\\\pabrik-kayu1\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000008b70000000000000000";}}',
        'as' => 'generated::w3MtL1iFJaphKc61',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bAQnAqK7nNXeITBj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:46:"function () {
    return \\view(\'landing\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008bb0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::bAQnAqK7nNXeITBj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::d2Wf1xtTJSNARZ37' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:210:"function () {
    return [
        \'authenticated\' => \\Illuminate\\Support\\Facades\\Auth::check(),
        \'user\' => \\Illuminate\\Support\\Facades\\Auth::user(),
        \'session\' => \\session()->all()
    ];
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008bd0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::d2Wf1xtTJSNARZ37',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Login\\AuthController@showLogin',
        'controller' => 'App\\Http\\Controllers\\Login\\AuthController@showLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Login\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Login\\AuthController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Login\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Login\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:49:"D:\\xampp4\\htdocs\\pabrik-kayu1\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000008c00000000000000000";}}',
        'as' => 'storage.local',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Dashboard\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Dashboard\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.dashboard.data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/dashboard-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Dashboard\\DashboardController@apiData',
        'controller' => 'App\\Http\\Controllers\\Dashboard\\DashboardController@apiData',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.dashboard.data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transaksi.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transaksi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiProdukController@index',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiProdukController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transaksi.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transaksi-kas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@index',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'cash.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.cash-transaction.detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/cash/{type}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.cash-transaction.detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-masuk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.index',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@index',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-masuk/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.create',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@create',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'kas-masuk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.store',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@store',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-masuk/{kas_masuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.show',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-masuk/{kas_masuk}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.edit',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@edit',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'kas-masuk/{kas_masuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.update',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@update',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-masuk.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'kas-masuk/{kas_masuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-masuk.destroy',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@destroy',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-keluar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.index',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@index',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-keluar/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.create',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@create',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'kas-keluar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.store',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@store',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-keluar/{kas_keluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.show',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kas-keluar/{kas_keluar}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.edit',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@edit',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'kas-keluar/{kas_keluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.update',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@update',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'kas-keluar.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'kas-keluar/{kas_keluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'kas-keluar.destroy',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@destroy',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-return',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.index',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@index',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-return/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.create',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@create',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales-return',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.store',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@store',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-return/{sales_return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.show',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-return/{sales_return}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.edit',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@edit',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'sales-return/{sales_return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.update',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@update',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales-return.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'sales-return/{sales_return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'as' => 'sales-return.destroy',
        'uses' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@destroy',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\ReturPenjualanController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.flow.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@index',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.flow.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.cash.flow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/api/data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@apiCashFlow',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@apiCashFlow',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'api.cash.flow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.cash.detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/api/{type}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@getTransactionDetail',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@getTransactionDetail',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'api.cash.detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.destroyBulk' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'cash/destroy-bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@destroyBulk',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@destroyBulk',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.destroyBulk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/in/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@createIn',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@createIn',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/out/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@createOut',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@createOut',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/in/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@editIn',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@editIn',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/out/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@editOut',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\TransaksiKasController@editOut',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.getItems' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/in/get-items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@getCategoryItems',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@getCategoryItems',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.getItems',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cash/in',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@store',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@store',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/in/{kasMasuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@show',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'cash/in/{kasMasuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@update',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@update',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.in.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'cash/in/{kasMasuk}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@destroy',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasMasukController@destroy',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.in.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.getItems' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/out/get-items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@getCategoryItems',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@getCategoryItems',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.getItems',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cash/out',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@store',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@store',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cash/out/{kasKeluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@show',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@show',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'cash/out/{kasKeluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@update',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@update',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cash.out.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'cash/out/{kasKeluar}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@destroy',
        'controller' => 'App\\Http\\Controllers\\Transaksi\\KasKeluarController@destroy',
        'namespace' => NULL,
        'prefix' => '/cash',
        'where' => 
        array (
        ),
        'as' => 'cash.out.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@index',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@index',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@create',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@create',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@store',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@store',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/categories/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@edit',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@edit',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'master/categories/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@update',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@update',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.destroyBulk' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/categories/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@destroyBulk',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@destroyBulk',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.destroyBulk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.byType' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/categories/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@getCategoriesByType',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@getCategoriesByType',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.byType',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/categories/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\KategoriController@destroy',
        'controller' => 'App\\Http\\Controllers\\Master\\KategoriController@destroy',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.categories.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@index',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@index',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/accounts/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@create',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@create',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@store',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@store',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/accounts/{account}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@edit',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@edit',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.destroyBulk' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/accounts/bulk-delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@destroyBulk',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@destroyBulk',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.destroyBulk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'master/accounts/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@update',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@update',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/accounts/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@destroy',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@destroy',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.accounts.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'master/accounts/{account}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Master\\ChartOfAccountController@toggleStatus',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.accounts.toggle',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@index',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@create',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@create',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@store',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@store',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products/{product}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@edit',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@edit',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'master/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@update',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@update',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@destroy',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@destroy',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.add-stock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products/{product}/add-stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@addStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@addStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.add-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.store-stock' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/products/{product}/add-stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@storeStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@storeStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.store-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.edit-stock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products/stock/{stock}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@editStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@editStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.edit-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.update-stock' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'master/products/stock/{stock}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@updateStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@updateStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.update-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.destroy-stock' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'master/products/stock/{stock}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@destroyStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@destroyStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.destroy-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.edit-initial-stock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/products/{product}/edit-initial-stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@editInitialStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@editInitialStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.edit-initial-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.products.update-initial-stock' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'master/products/{product}/update-initial-stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Master\\ProductController@updateInitialStock',
        'controller' => 'App\\Http\\Controllers\\Master\\ProductController@updateInitialStock',
        'namespace' => NULL,
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.products.update-initial-stock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.cash-flow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/arus-kas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@reportIndex',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@reportIndex',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.cash-flow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.cash-flow.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/arus-kas/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@exportExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.cash-flow.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.cash-flow.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/arus-kas/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@printCashFlow',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@printCashFlow',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.cash-flow.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.cash' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/buku-kas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@reportCash',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@reportCash',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.cash',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.cash.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/buku-kas/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@exportCashExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@exportCashExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.cash.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.report.cash' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/api/cash',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@apiCashReport',
        'controller' => 'App\\Http\\Controllers\\Laporan\\ArusKasController@apiCashReport',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'api.report.cash',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.income-statement' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/laba-rugi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\LabaRugiController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\LabaRugiController@index',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.income-statement',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.income-statement.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/laba-rugi/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\LabaRugiController@print',
        'controller' => 'App\\Http\\Controllers\\Laporan\\LabaRugiController@print',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.income-statement.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.journal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/jurnal-umum',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@index',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.journal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.journal.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/jurnal-umum/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@print',
        'controller' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@print',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.journal.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.journal.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'report/jurnal-umum/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@sync',
        'controller' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@sync',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.journal.sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.journal.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/jurnal-umum/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\JurnalUmumController@exportExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.journal.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.ledger' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/buku-besar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@index',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.ledger',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.ledger.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/buku-besar/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@print',
        'controller' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@print',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.ledger.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.ledger.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/buku-besar/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\BukuBesarController@exportExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.ledger.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.trial-balance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca-saldo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@index',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.trial-balance',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.trial-balance.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca-saldo/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@print',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@print',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.trial-balance.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.trial-balance.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca-saldo/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaSaldoController@exportExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.trial-balance.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.neraca' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaController@index',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaController@index',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.neraca',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.neraca.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaController@print',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaController@print',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.neraca.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'report.neraca.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/neraca/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Laporan\\NeracaController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\Laporan\\NeracaController@exportExcel',
        'namespace' => NULL,
        'prefix' => '/report',
        'where' => 
        array (
        ),
        'as' => 'report.neraca.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@profile',
        'controller' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@profile',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'settings.profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@updateProfile',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'settings.profile.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@updatePassword',
        'controller' => 'App\\Http\\Controllers\\Pengaturan\\SettingsController@updatePassword',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'settings.password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@index',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'admin.users.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/users/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@create',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'admin.users.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@store',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'admin.users.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'settings/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\UserManagementController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserManagementController@destroy',
        'namespace' => NULL,
        'prefix' => '/settings',
        'where' => 
        array (
        ),
        'as' => 'admin.users.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
