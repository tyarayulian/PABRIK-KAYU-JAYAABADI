<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Laporan\ArusKasController;
use App\Http\Controllers\Laporan\BukuBesarController;
use App\Http\Controllers\Laporan\IncomeStatementController;
use App\Http\Controllers\Laporan\JurnalController;
use App\Http\Controllers\Laporan\NeracaController;
use App\Http\Controllers\Laporan\NeracaSaldoController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Master\ChartOfAccountController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Pengaturan\SettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Transaksi\CashTransactionController;
use App\Http\Controllers\Transaksi\KasKeluarController;
use App\Http\Controllers\Transaksi\KasMasukController;
use App\Http\Controllers\Transaksi\SalesReturnController;
use App\Http\Controllers\Transaksi\TransaksiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing');
});

// Debug route - remove in production
Route::get('/debug-auth', function () {
    return [
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
        'session' => session()->all()
    ];
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    // Registration - disable in production, only for initial setup
    // Comment out these lines to disable public registration:
    // Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Reset Password Routes
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/storage/{path}', function ($path) {
        $filePath = storage_path('app/public/'.$path);
        if (! file_exists($filePath)) {
            abort(404);
        }

        return response()->fileubah($filePath);
    })->where('path', '.*');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard-data', [DashboardController::class, 'apiData'])->name('api.dashboard.data');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi-kas', [CashTransactionController::class, 'index'])->name('cash.index');
    Route::get('/api/cash/{type}/{id}', [CashTransactionController::class, 'show'])->name('api.cash-transaction.detail');
    Route::resource('kas-masuk', KasMasukController::class);
    Route::resource('kas-keluar', KasKeluarController::class);
    Route::resource('sales-return', SalesReturnController::class);

    Route::prefix('cash')->group(function () {
        Route::get('/', [ArusKasController::class, 'index'])->name('cash.flow.index');
        Route::get('/api/data', [ArusKasController::class, 'apiCashFlow'])->name('api.cash.flow');
        Route::get('/api/{type}/{id}', [ArusKasController::class, 'getTransactionDetail'])->name('api.cash.detail');
        Route::delete('/destroy-bulk', [ArusKasController::class, 'destroyBulk'])->name('cash.destroyBulk');

        Route::get('/in/create', [CashTransactionController::class, 'createIn'])->name('cash.in.create');
        Route::get('/out/create', [CashTransactionController::class, 'createOut'])->name('cash.out.create');
        Route::get('/in/{id}/edit', [CashTransactionController::class, 'editIn'])->name('cash.in.edit');
        Route::get('/out/{id}/edit', [CashTransactionController::class, 'editOut'])->name('cash.out.edit');

        Route::get('/in/get-items', [KasMasukController::class, 'getCategoryItems'])->name('cash.in.getItems');
        Route::post('/in', [KasMasukController::class, 'store'])->name('cash.in.store');
        Route::get('/in/{kasMasuk}', [KasMasukController::class, 'show'])->name('cash.in.show');
        Route::put('/in/{kasMasuk}', [KasMasukController::class, 'update'])->name('cash.in.update');
        Route::delete('/in/{kasMasuk}', [KasMasukController::class, 'destroy'])->name('cash.in.destroy');

        Route::get('/out/get-items', [KasKeluarController::class, 'getCategoryItems'])->name('cash.out.getItems');
        Route::post('/out', [KasKeluarController::class, 'store'])->name('cash.out.store');
        Route::get('/out/{kasKeluar}', [KasKeluarController::class, 'show'])->name('cash.out.show');
        Route::put('/out/{kasKeluar}', [KasKeluarController::class, 'update'])->name('cash.out.update');
        Route::delete('/out/{kasKeluar}', [KasKeluarController::class, 'destroy'])->name('cash.out.destroy');
    });

    Route::prefix('master')->group(function () {
        Route::get('/categories', [KategoriController::class, 'index'])->name('master.categories');
        Route::get('/categories/create', [KategoriController::class, 'create'])->name('master.categories.create');
        Route::post('/categories', [KategoriController::class, 'store'])->name('master.categories.store');
        Route::get('/categories/{id}/edit', [KategoriController::class, 'edit'])->name('master.categories.edit');
        Route::put('/categories/{id}', [KategoriController::class, 'update'])->name('master.categories.update');
        Route::delete('/categories/bulk', [KategoriController::class, 'destroyBulk'])->name('master.categories.destroyBulk');
        Route::get('/categories/{type}', [KategoriController::class, 'getCategoriesByType'])->name('master.categories.byType');
        Route::delete('/categories/{id}', [KategoriController::class, 'destroy'])->name('master.categories.destroy');

        Route::get('/accounts', [ChartOfAccountController::class, 'index'])->name('master.accounts');
        Route::get('/accounts/create', [ChartOfAccountController::class, 'create'])->name('master.accounts.create');
        Route::post('/accounts', [ChartOfAccountController::class, 'store'])->name('master.accounts.store');
        Route::get('/accounts/{account}/edit', [ChartOfAccountController::class, 'edit'])->name('master.accounts.edit');
        Route::delete('/accounts/bulk-delete', [ChartOfAccountController::class, 'destroyBulk'])->name('master.accounts.destroyBulk');
        Route::put('/accounts/{account}', [ChartOfAccountController::class, 'update'])->name('master.accounts.update');
        Route::delete('/accounts/{id}', [ChartOfAccountController::class, 'destroy'])->name('master.accounts.destroy')->where('id', '[0-9]+');
        Route::patch('/accounts/{account}/toggle', [ChartOfAccountController::class, 'toggleStatus'])->name('master.accounts.toggle');

        Route::get('/products/menu', [ProductController::class, 'menu'])->name('master.products.menu');
        Route::get('/products', [ProductController::class, 'index'])->name('master.products.index');

        Route::get('/products/create', [ProductController::class, 'create'])->name('master.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('master.products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('master.products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('master.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('master.products.destroy');
        Route::get('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('master.products.add-stock');
        Route::post('/products/{product}/add-stock', [ProductController::class, 'storeStock'])->name('master.products.store-stock');
        Route::get('/products/stock/{stock}/edit', [ProductController::class, 'editStock'])->name('master.products.edit-stock');
        Route::put('/products/stock/{stock}', [ProductController::class, 'updateStock'])->name('master.products.update-stock');
        Route::delete('/products/stock/{stock}', [ProductController::class, 'destroyStock'])->name('master.products.destroy-stock');
    });

    Route::prefix('report')->group(function () {
        Route::get('/cash-flow', [ArusKasController::class, 'reportIndex'])->name('report.cash-flow');
        Route::get('/cash-flow/export', [ArusKasController::class, 'exportExcel'])->name('report.cash-flow.export');
        Route::get('/cash', [ArusKasController::class, 'reportCash'])->name('report.cash');
        Route::get('/cash/export', [ArusKasController::class, 'exportCashExcel'])->name('report.cash.export');
        Route::get('/api/cash', [ArusKasController::class, 'apiCashReport'])->name('api.report.cash');

        Route::get('/income-statement', [IncomeStatementController::class, 'index'])->name('report.income-statement');
        Route::get('/income-statement/print', [IncomeStatementController::class, 'print'])->name('report.income-statement.print');
        Route::get('/neraca', [NeracaController::class, 'index'])->name('report.neraca');
        Route::get('/neraca/export', [NeracaController::class, 'exportExcel'])->name('report.neraca.export');

        Route::get('/journal', [JurnalController::class, 'index'])->name('report.journal');
        Route::get('/journal/print', [JurnalController::class, 'print'])->name('report.journal.print');
        Route::post('/journal/sync', [JurnalController::class, 'sync'])->name('report.journal.sync');
        Route::get('/journal/export', [JurnalController::class, 'exportExcel'])->name('report.journal.export');
        Route::get('/ledger', [BukuBesarController::class, 'index'])->name('report.ledger');
        Route::get('/ledger/print', [BukuBesarController::class, 'print'])->name('report.ledger.print');
        Route::get('/ledger/export', [BukuBesarController::class, 'exportExcel'])->name('report.ledger.export');
        Route::get('/trial-balance', [NeracaSaldoController::class, 'index'])->name('report.trial-balance');
        Route::get('/trial-balance/print', [NeracaSaldoController::class, 'print'])->name('report.trial-balance.print');
        Route::get('/trial-balance/export', [NeracaSaldoController::class, 'exportExcel'])->name('report.trial-balance.export');
        Route::get('/neraca', [NeracaController::class, 'index'])->name('report.neraca');
        Route::get('/neraca/print', [NeracaController::class, 'print'])->name('report.neraca.print');
        Route::get('/neraca/export', [NeracaController::class, 'exportExcel'])->name('report.neraca.export');
        Route::get('/cash-flow/print', [ArusKasController::class, 'printCashFlow'])->name('report.cash-flow.print');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/profile', [SettingsController::class, 'profile'])->name('settings.profile');
        Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        
        // User Management (Admin only)
        Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });
});
