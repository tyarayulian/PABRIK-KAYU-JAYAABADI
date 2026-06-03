<style>
    .sidebar {
        width: 280px;
        background: #fff;
        display: flex;
        flex-direction: column;
        position: fixed;
        height: calc(100vh - 40px);
        left: 20px;
        top: 20px;
        z-index: 1000;
        transition: all 0.3s ease;
        border-radius: 40px;
        padding: 40px 0;
        color: #1a1a1a;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sidebar-header {
        padding: 0 30px;
        margin-bottom: 40px;
        text-align: center;
    }

    .sidebar-logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .logo-img {
        width: 120px;
        height: auto;
    }

    .sidebar-menu-container {
        flex: 1;
        overflow-y: auto;
        padding: 0 20px;
    }

    .menu-section-label {
        font-size: 11px;
        font-weight: 800;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 25px 15px 15px;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 20px;
        color: #666;
        text-decoration: none;
        border-radius: 18px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
    }

    .sidebar-menu a i {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .sidebar-menu a:hover {
        background: #f8f8f8;
        color: #1a1a1a;
    }

    .sidebar-menu a.active {
        background: #f0f7ff;
        color: #1e2a78;
        position: relative;
    }

    .sidebar-menu a.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 15%;
        height: 70%;
        width: 4px;
        background: #1e2a78;
        border-radius: 0 4px 4px 0;
    }

    .sidebar-footer {
        padding: 20px 20px 0;
        margin-top: auto;
    }

    .user-card {
        background: #f8f8f8;
        padding: 15px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: #1e2a78;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
    }

    .user-info {
        flex: 1;
        overflow: hidden;
    }

    .user-name {
        display: block;
        font-weight: 700;
        font-size: 14px;
        color: #1a1a1a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-email {
        display: block;
        font-size: 11px;
        color: #999;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .logout-btn {
        color: #999;
        font-size: 18px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        transition: all 0.2s;
    }

    .logout-btn:hover {
        color: #dc2626;
    }

    /* Adjust main content margin */
    .main-content {
        margin-left: 300px !important;
        flex: 1 !important;
        max-width: calc(100% - 320px) !important;
    }

    @media (max-width: 1024px) {
        .sidebar {
            width: 80px;
            padding: 30px 0;
        }
        .sidebar-header, .menu-section-label, .sidebar-menu a span, .user-info {
            display: none;
        }
        .sidebar-menu a {
            justify-content: center;
            padding: 15px;
        }
        .main-content {
            margin-left: 120px !important;
        }
        .user-card {
            padding: 10px;
            justify-content: center;
        }
        .logout-btn {
            display: none;
        }
    }
</style>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="<?php echo e(asset('storage/images/logo 2.png')); ?>" alt="Jaya Cash" class="logo-img">
        </div>
    </div>

    <div class="sidebar-menu-container">
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="menu-section-label">Penjualan & Pembelian</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('transaksi.index')); ?>" class="<?php echo e(request()->routeIs('transaksi.*') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Transaksi Produk</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('sales-return.index')); ?>" class="<?php echo e(request()->routeIs('sales-return.*') ? 'active' : ''); ?>">
                    <i class="fas fa-undo"></i>
                    <span>Retur Penjualan</span>
                </a>
            </li>
        </ul>

        <div class="menu-section-label">Pemasukan & Pengeluaran</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('cash.index')); ?>" class="<?php echo e(request()->routeIs('cash.index') ? 'active' : ''); ?>">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Transaksi Kas</span>
                </a>
            </li>
        </ul>

        <div class="menu-section-label">Master Data</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('master.categories')); ?>" class="<?php echo e(request()->routeIs('master.categories') ? 'active' : ''); ?>">
                    <i class="fas fa-tag"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('master.accounts')); ?>" class="<?php echo e(request()->routeIs('master.accounts') ? 'active' : ''); ?>">
                    <i class="fas fa-layer-group"></i>
                    <span>Akun (COA)</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('master.products.index')); ?>" class="<?php echo e(request()->routeIs('master.products.index') || (request()->routeIs('master.products.*') && !request()->routeIs('master.products.menu')) ? 'active' : ''); ?>">
                    <i class="fas fa-box"></i>
                    <span>Stok Produk</span>
                </a>
            </li>
        </ul>

        <div class="menu-section-label">Laporan</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('report.journal')); ?>" class="<?php echo e(request()->routeIs('report.journal') ? 'active' : ''); ?>">
                    <i class="fas fa-book"></i>
                    <span>Jurnal Umum</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('report.ledger')); ?>" class="<?php echo e(request()->routeIs('report.ledger') ? 'active' : ''); ?>">
                    <i class="fas fa-book-open"></i>
                    <span>Buku Besar</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('report.income-statement')); ?>" class="<?php echo e(request()->routeIs('report.income-statement') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>Laba Rugi</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('report.trial-balance')); ?>" class="<?php echo e(request()->routeIs('report.trial-balance') ? 'active' : ''); ?>">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Neraca Saldo</span>
                </a>
            </li>
        </ul>

        <div class="menu-section-label">General</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo e(route('settings.profile')); ?>" class="<?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <?php
                $userName = Auth::user()->name ?? 'Admin';
                $initial = strtoupper(substr($userName, 0, 1));
            ?>
            <div class="user-avatar"><?php echo e($initial); ?></div>
            <div class="user-info">
                <span class="user-name"><?php echo e($userName); ?></span>
                <span class="user-email"><?php echo e(Auth::user()->email ?? 'admin@jayaaba...'); ?></span>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-sidebar-form" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
            <button class="logout-btn" onclick="document.getElementById('logout-sidebar-form').submit()">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>
</aside>
<?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>