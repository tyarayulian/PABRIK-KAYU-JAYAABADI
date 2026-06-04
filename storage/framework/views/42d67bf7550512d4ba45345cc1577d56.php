<?php $__env->startSection('title', 'Manajemen Stok Produk'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Stok Produk'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    .main-content { background-color: transparent !important; box-shadow: none !important; border: none !important; padding: 0 !important; }

    .stok-layout {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 20px;
        min-height: calc(100vh - 150px);
        align-items: start;
    }

    /* Sidebar Kiri: Jenis Kayu */
    .wood-sidebar {
        background: white;
        border-radius: 20px;
        padding: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 20px;
        z-index: 10;
    }

    .wood-sidebar-title {
        font-size: 9px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
        padding-left: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .wood-sidebar-title::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

    .wood-nav { display: flex; flex-direction: column; gap: 4px; }
    
    .wood-nav-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 10px;
        color: #64748b;
        text-decoration: none;
        font-weight: 700;
        font-size: 12px;
        transition: all 0.2s;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .wood-nav-item:hover { background: #f8fafc; color: #1e2a78; }
    
    .wood-nav-item.active {
        background: #1e2a78;
        color: white;
        box-shadow: 0 8px 12px -3px rgba(30, 42, 120, 0.2);
    }

    /* Konten Utama */
    .stok-main { min-width: 0; }

    /* Tab Kategori */
    .category-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        padding: 5px;
        background: #f1f5f9;
        border-radius: 12px;
        width: fit-content;
    }

    .category-tab-item {
        padding: 8px 18px;
        font-weight: 800;
        font-size: 12px;
        color: #64748b;
        cursor: pointer;
        border-radius: 9px;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-tab-item:hover { color: #1e2a78; }
    
    .category-tab-item.active { 
        background: white;
        color: #1e2a78;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Card Ukuran (Produk) */
    .product-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .product-card-header {
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }

    .product-title-group { display: flex; align-items: baseline; gap: 10px; }
    .product-title-group h2 { font-size: 18px; font-weight: 800; color: #1e2a78; margin: 0; }
    .product-title-group span { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

    /* Table Styling */
    .table-responsive { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 10px 16px;
        background: #f8fafc;
        text-align: left;
        font-size: 9px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }

    td { padding: 10px 16px; font-size: 11px; color: #334155; border-bottom: 1px solid #f8fafc; }
    
    .mono { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 11px; }
    
    .btn-action-circle {
        width: 36px; height: 36px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid #e2e8f0; background: #fff; color: #1e293b;
        cursor: pointer; transition: all 0.2s; text-decoration: none;
    }
    .btn-action-circle:hover { background: #f8fafc; transform: scale(1.05); }

    .detail-row { background-color: #fcfdfe; display: none; }
    .detail-container { padding: 30px 40px; border-left: 5px solid #1e2a78; background: #f9fbff; }

    .total-footer {
        padding: 20px 40px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
        font-weight: 800;
        color: #1e2a78;
    }

    .btn-tambah-stok {
        background: white;
        color: #059669;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        border: 1px solid #059669;
        transition: all 0.2s;
    }
    .btn-tambah-stok:hover { 
        background: #ecfdf5; 
        color: #047857;
        transform: translateY(-1px);
    }

    .btn-jual {
        background: white;
        color: #1e2a78;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        border: 1px solid #1e2a78;
        transition: all 0.2s;
    }
    .btn-jual:hover { 
        background: #f0f4ff; 
        color: #151d54;
        transform: translateY(-1px);
    }

    .btn-tambah-kategori {
        background: transparent;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-tambah-kategori:hover { 
        background: #f8fafc; 
        color: #1e2a78; 
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    /* Hide/Show Logic */
    .wood-content { display: none; }
    .wood-content.active { display: block; }
    .cat-content { display: none; }
    .cat-content.active { display: block; }

    .header-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .header-content {
        padding: 30px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .header-content h1 {
        font-size: 24px;
        font-weight: 800;
        color: #1e2a78;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .header-content h2 {
        font-size: 18px;
        font-weight: 700;
        color: #1e2a78;
        margin: 5px 0;
        text-transform: uppercase;
    }

    .header-content p {
        font-size: 14px;
        color: #94a3b8;
        margin: 5px 0 0 0;
        font-weight: 600;
    }

    .filter-section {
        padding: 20px 30px;
        background: #ffffff;
        display: flex;
        justify-content: center;
    }

    .filter-grid {
        display: flex;
        gap: 15px;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-custom {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
        width: 150px;
    }

    .form-control-custom:focus {
        border-color: #1e2a78;
        box-shadow: 0 0 0 3px rgba(30, 42, 120, 0.1);
    }

    .btn-apply {
        background: #1e2a78;
        color: white;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-apply:hover {
        background: #151d54;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: white;
        color: #64748b;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-reset:hover {
        background: #f8fafc;
        color: #1e2a78;
    }

    .empty-wood {
        text-align: center;
        padding: 100px 40px;
        background: white;
        border-radius: 24px;
        color: #94a3b8;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="stok-layout">
    <!-- Sidebar Kiri: Jenis Kayu -->
    <div class="wood-sidebar">
        <div class="wood-sidebar-title">Jenis Kayu</div>
        <div class="wood-nav">
            <?php $__empty_1 = true; $__currentLoopData = $groupedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $woodType => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="wood-nav-item <?php echo e($loop->first ? 'active' : ''); ?>" 
                 onclick="switchWood(this, 'wood-<?php echo e(\Str::slug($woodType ?: 'lain-lain')); ?>')">
                <span style="flex: 1;"><?php echo e($woodType ?: 'Jenis Kayu Lain'); ?></span>
                <i class="fas fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 13px;">
                <i class="fas fa-folder-open mb-2 fa-2x"></i><br>
                Belum ada data.
            </div>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 30px; padding: 0 10px;">
            <a href="<?php echo e(route('master.products.create')); ?>" style="display: flex; align-items: center; gap: 10px; color: #1e2a78; font-weight: 800; font-size: 13px; text-decoration: none;">
                <i class="fas fa-plus-circle"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="stok-main">
        <div class="header-card">
            <div class="header-content">
                <h1>STOK PRODUK</h1>
                <h2>PABRIK KAYU JAYA ABADI</h2>
                <p>PERIODE : <?php echo e($startDate && $endDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'BULAN INI'); ?></p>
            </div>
            <div class="filter-section">
                <form action="<?php echo e(route('master.products.index')); ?>" method="GET" class="filter-grid">
                    <div class="filter-group">
                        <label>MULAI</label>
                        <input type="date" name="start_date" class="form-control-custom" value="<?php echo e($startDate); ?>">
                    </div>
                    <div class="filter-group">
                        <label>AKHIR</label>
                        <input type="date" name="end_date" class="form-control-custom" value="<?php echo e($endDate); ?>">
                    </div>
                    <button type="submit" class="btn-apply">
                        <i class="fas fa-filter"></i> Terapkan
                    </button>
                    <a href="<?php echo e(route('master.products.index')); ?>" class="btn-reset">Reset</a>
                </form>
            </div>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $groupedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $woodType => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div id="wood-<?php echo e(\Str::slug($woodType ?: 'lain-lain')); ?>" class="wood-content <?php echo e($loop->first ? 'active' : ''); ?>">
            
            <!-- Tab Kategori -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <div class="category-tabs" style="margin-bottom: 0;">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="category-tab-item <?php echo e($loop->first ? 'active' : ''); ?>" 
                         onclick="switchCategory(this, 'cat-<?php echo e(\Str::slug(($woodType ?: 'lain-lain') . '-' . ($categoryName ?: 'umum'))); ?>')">
                        <?php echo e(strtoupper($categoryName ?: 'Umum')); ?>

                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <a href="<?php echo e(route('master.products.create', ['wood_type' => $woodType])); ?>" class="btn-tambah-kategori">
                    <i class="fas fa-plus-circle"></i> Tambah Kategori <?php echo e($woodType); ?>

                </a>
            </div>

            <!-- Konten per Kategori -->
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="cat-<?php echo e(\Str::slug(($woodType ?: 'lain-lain') . '-' . ($categoryName ?: 'umum'))); ?>" 
                 class="cat-content <?php echo e($loop->first ? 'active' : ''); ?>">
                
                <?php $__currentLoopData = $products->groupBy('size'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $sizeGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $firstProduct = $sizeGroup->first();
                    $allHistory = $sizeGroup->flatMap->all_stock_history->sort(function($a, $b) {
                        if ($a->date->equalTo($b->date)) {
                            if ($a->type === 'initial') return -1;
                            if ($b->type === 'initial') return 1;
                            return 0;
                        }
                        return $a->date->lt($b->date) ? -1 : 1;
                    })->values();

                    if ($startDate && $endDate) {
                        $allHistory = $allHistory->filter(function($h) use ($startDate, $endDate) {
                            $date = \Carbon\Carbon::parse($h->date)->format('Y-m-d');
                            return $date >= $startDate && $date <= $endDate;
                        });
                    }
                    
                    // Identify the very first initial stock entry
                    $firstInitialKey = null;
                    foreach($allHistory as $h) {
                        if ($h->type == 'initial') {
                            $firstInitialKey = $h->type . '_' . $h->id;
                            break;
                        }
                    }

                    $totalStockInGroup = $sizeGroup->sum('stock');
                    
                    // Correct FIFO allocation across all products in this group
                    $inflows = $allHistory->whereIn('type', ['initial', 'adjustment', 'purchase'])->values();
                    $outflows = $allHistory->where('type', 'sale')->values();

                    $allocation = [];
                    $outflowQueue = [];
                    foreach ($outflows as $o) {
                        $outflowQueue[] = [
                            'date' => $o->date,
                            'quantity' => abs((float) $o->quantity),
                            'description' => $o->description ?? 'Penjualan',
                        ];
                    }

                    foreach ($inflows as $inflow) {
                        $key = $inflow->type.'_'.$inflow->id;
                        $remaining = (float) $inflow->quantity;
                        $soldTo = [];

                        if ($remaining > 0) {
                            for ($i = 0; $i < count($outflowQueue); $i++) {
                                if ($remaining <= 0) break;
                                if ($outflowQueue[$i]['quantity'] <= 0) continue;

                                $deduct = min($remaining, $outflowQueue[$i]['quantity']);
                                
                                $outflowQueue[$i]['quantity'] -= $deduct;
                                $remaining -= $deduct;

                                $soldTo[] = [
                                    'date' => $outflowQueue[$i]['date'],
                                    'quantity' => $deduct,
                                    'description' => $outflowQueue[$i]['description'],
                                ];
                            }
                        }

                        $allocation[$key] = [
                            'sold_items' => $soldTo,
                            'remaining' => $remaining,
                        ];
                    }
                ?>
                <div class="product-card" id="product-<?php echo e($firstProduct->id); ?>">
                    <div class="product-card-header">
                        <div class="product-title-group">
                            <h2 style="font-size: 1.5rem; color: #1e2a78; font-weight: 800;"><?php echo e($size ?: $firstProduct->name); ?></h2>
                            <span style="background: #eef2ff; padding: 4px 12px; border-radius: 6px; font-size: 11px; color: #4338ca; font-weight: 700;"><?php echo e(strtoupper($firstProduct->unit)); ?></span>
                        </div>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <button type="button" class="btn-jual" style="border-color: #fecaca; color: #ef4444;" onclick="confirmDeleteHistory('<?php echo e(route('master.products.destroy', $firstProduct->id)); ?>', 'initial')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <a href="<?php echo e(route('master.products.add-stock', $firstProduct->id)); ?>" class="btn-tambah-stok">
                                <i class="fas fa-plus"></i> Tambah Stok
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 140px;">Tanggal</th>
                                    <th>Keterangan</th>
                                    <th style="text-align: right; width: 150px;">HPP</th>
                                    <th style="text-align: right; width: 120px;">Qty</th>
                                    <th style="text-align: right; width: 140px;">Stok Akhir</th>
                                    <th style="width: 100px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $processedHistory = [];
                                    
                                    foreach($allHistory as $history) {
                                        if ($history->type != 'sale') {
                                            $processedHistory[] = (object) [
                                                'id' => $history->id,
                                                'date' => $history->date,
                                                'description' => $history->description,
                                                'type' => $history->type,
                                                'quantity' => (float)$history->quantity,
                                                'price' => (float)$history->price
                                            ];
                                        }
                                    }
                                ?>

                                <?php $__empty_2 = true; $__currentLoopData = $processedHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <?php
                                        $allocKey = $history->type . '_' . $history->id;
                                        $soldItems = (isset($allocation[$allocKey]) && isset($allocation[$allocKey]['sold_items'])) ? $allocation[$allocKey]['sold_items'] : [];
                                        $isInflow = true;
                                        $remStock = isset($allocation[$allocKey]) ? $allocation[$allocKey]['remaining'] : $history->quantity;
                                        
                                        // Label logic: Only the very first initial is "Stok Awal"
                                        $isRealInitial = ($history->type == 'initial' && $allocKey == $firstInitialKey);
                                        $labelColor = $isRealInitial ? '#6366f1' : '#94a3b8';
                                        $labelText = $isRealInitial ? 'Stok Awal' : 'Stok Masuk';
                                        
                                        if ($history->type == 'purchase') {
                                            $labelColor = '#10b981';
                                            $labelText = 'Pembelian';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($history->date)->format('d/m/Y')); ?></td>
                                        <td>
                                            <div style="font-weight: 700; color: <?php echo e($labelColor); ?>; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">
                                                <?php echo e($labelText); ?>

                                            </div>
                                        </td>
                                        <td style="text-align: right; font-weight: 600; color: #475569;" class="mono">
                                            <?php if($history->price > 0): ?>
                                                Rp <?php echo e(number_format($history->price, 0, ',', '.')); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;" class="mono">
                                            <span style="color: #10b981">
                                                +<?php echo e(number_format($history->quantity, fmod($history->quantity, 1) == 0 ? 0 : 2, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td style="text-align: right; color: #1e2a78; font-weight: 800;" class="mono">
                                            <?php echo e(number_format($remStock, fmod($remStock, 1) == 0 ? 0 : 2, ',', '.')); ?>

                                        </td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 8px; justify-content: center;">
                                                <button type="button" class="btn-action-circle toggle-detail" title="Detail Penggunaan Stok">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <?php
                                                    $editUrl = '#';
                                                    $deleteUrl = '#';
                                                    if ($history->type == 'initial') {
                                                        $editUrl = route('master.products.edit', $history->id);
                                                        $deleteUrl = route('master.products.destroy', $history->id);
                                                    } elseif ($history->type == 'adjustment') {
                                                        $editUrl = route('master.products.edit-stock', $history->id);
                                                        $deleteUrl = route('master.products.destroy-stock', $history->id);
                                                    } elseif ($history->type == 'purchase') {
                                                        $editUrl = route('kas-keluar.edit', $history->id);
                                                        $deleteUrl = route('kas-keluar.destroy', $history->id);
                                                    }
                                                ?>

                                                <a href="<?php echo e($editUrl); ?>" class="btn-action-circle" style="color: #1e2a78; background: #f0f4ff; border: none;" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button" class="btn-action-circle" style="color: #f43f5e; background: #fff1f2; border: none;" 
                                                        onclick="confirmDeleteHistory('<?php echo e($deleteUrl); ?>', '<?php echo e($history->type); ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="detail-row">
                                        <td colspan="6" style="padding: 0; background: #f9fbff;">
                                            <div class="detail-container" style="padding: 24px 40px; border-left: 5px solid #1e2a78;">
                                                <div style="font-weight: 800; color: #1e2a78; font-size: 12px; text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                                                    <i class="fas fa-history"></i> History Penjualan dari Batch Ini
                                                </div>
                                                <?php if(count($soldItems) > 0): ?>
                                                    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                                        <table style="width: 100%; border: none;">
                                                            <thead>
                                                                <tr style="background: #f8fafc;">
                                                                    <th style="padding: 12px 20px; border-bottom: 1px solid #e2e8f0; background: transparent; color: #64748b; font-size: 10px; font-weight: 800;">TANGGAL PENJUALAN</th>
                                                                    <th style="padding: 12px 20px; border-bottom: 1px solid #e2e8f0; background: transparent; color: #64748b; font-size: 10px; font-weight: 800;">KETERANGAN</th>
                                                                    <th style="padding: 12px 20px; border-bottom: 1px solid #e2e8f0; background: transparent; color: #64748b; font-size: 10px; font-weight: 800; text-align: right;">JUMLAH KELUAR</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $soldItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sold): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr style="background: transparent;">
                                                                    <td style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9; background: transparent; font-weight: 600; color: #334155;"><?php echo e(\Carbon\Carbon::parse($sold['date'])->format('d/m/Y H:i')); ?></td>
                                                                    <td style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9; background: transparent; color: #475569;"><?php echo e($sold['description']); ?></td>
                                                                    <td style="padding: 12px 20px; border-bottom: 1px solid #f1f5f9; background: transparent; text-align: right; color: #ef4444; font-weight: 800;">
                                                                        -<?php echo e(number_format($sold['quantity'], fmod($sold['quantity'], 1) == 0 ? 0 : 2, ',', '.')); ?>

                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div style="text-align: center; padding: 30px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                                                        <i class="fas fa-info-circle mb-2" style="color: #94a3b8;"></i><br>
                                                        <span style="color: #64748b; font-size: 13px; font-weight: 600;">Belum ada penjualan dari batch ini.</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 50px;">
                                            <i class="fas fa-history mb-3 fa-2x" style="opacity: 0.2;"></i><br>
                                            Belum ada riwayat stok untuk ukuran ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="total-footer">
                        <span style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Total Stok Saat Ini:</span>
                        <span style="font-size: 24px;"><?php echo e(number_format($totalStockInGroup, fmod($totalStockInGroup, 1) == 0 ? 0 : 2, ',', '.')); ?></span>
                        <span style="font-size: 14px; color: #64748b;"><?php echo e(strtoupper($firstProduct->unit)); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-wood">
            <i class="fas fa-box-open fa-4x mb-4"></i>
            <h3>Belum Ada Data Produk</h3>
            <p>Silakan klik "Tambah Produk" di sidebar untuk memulai.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<form id="delete-history-form" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<script>
    function switchWood(element, woodId) {
        // Update Sidebar
        document.querySelectorAll('.wood-nav-item').forEach(item => item.classList.remove('active'));
        element.classList.add('active');

        // Update Content
        document.querySelectorAll('.wood-content').forEach(content => content.classList.remove('active'));
        const activeWood = document.getElementById(woodId);
        activeWood.classList.add('active');

        // Auto-select first category tab in this wood
        const firstCatTab = activeWood.querySelector('.category-tab-item');
        if (firstCatTab) firstCatTab.click();
    }

    function switchCategory(element, catId) {
        const woodContainer = element.closest('.wood-content');
        
        // Update Tabs
        woodContainer.querySelectorAll('.category-tab-item').forEach(item => item.classList.remove('active'));
        element.classList.add('active');

        // Update Cat Content
        woodContainer.querySelectorAll('.cat-content').forEach(content => content.classList.remove('active'));
        woodContainer.querySelector('#' + catId).classList.add('active');
    }

    // Toggle Detail Row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.toggle-detail')) {
            const btn = e.target.closest('.toggle-detail');
            const mainRow = btn.closest('tr');
            const detailRow = mainRow.nextElementSibling;
            const icon = btn.querySelector('i');
            
            if (detailRow.style.display === 'table-row') {
                detailRow.style.display = 'none';
                icon.className = 'fas fa-eye';
            } else {
                detailRow.style.display = 'table-row';
                icon.className = 'fas fa-eye-slash';
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const woodParam = urlParams.get('wood');
        const catParam = urlParams.get('cat');
        const scrollTo = urlParams.get('scroll_to');

        if (woodParam) {
            const woodItem = document.querySelector(`.wood-nav-item[onclick*="${woodParam}"]`);
            if (woodItem) {
                woodItem.click();
                
                if (catParam) {
                    // Small delay to ensure wood content is visible before clicking category
                    setTimeout(() => {
                        const catItem = document.querySelector(`.category-tab-item[onclick*="${catParam}"]`);
                        if (catItem) catItem.click();
                    }, 100);
                }
            }
        }

        if (scrollTo) {
            const el = document.getElementById(scrollTo);
            if (el) {
                setTimeout(() => {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight effect
                    el.style.transition = 'all 0.5s';
                    el.style.ring = '4px solid #1e2a78';
                    el.style.boxShadow = '0 0 20px rgba(30, 42, 120, 0.2)';
                    setTimeout(() => {
                        el.style.ring = 'none';
                        el.style.boxShadow = 'none';
                    }, 2000);
                }, 800);
            }
        }
    });

    function confirmDeleteHistory(url, type) {
        let title = 'Hapus Riwayat?';
        let text = "Data stok akan terpengaruh oleh penghapusan ini!";
        
        if (type === 'initial') {
            title = 'Hapus Produk?';
            text = "Seluruh data produk dan riwayatnya akan dihapus permanen!";
        } else if (type === 'sale') {
            title = 'Hapus Transaksi Penjualan?';
            text = "Data kas masuk dan stok akan dikembalikan!";
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-history-form');
                form.action = url;
                form.submit();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp_new\htdocs\tyara\resources\views/master/products/index.blade.php ENDPATH**/ ?>