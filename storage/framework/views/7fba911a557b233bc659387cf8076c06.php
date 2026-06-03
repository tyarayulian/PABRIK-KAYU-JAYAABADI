<?php $__env->startSection('title', 'Daftar Harga Produk'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Menu Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 30px;
        padding-bottom: 50px;
    }

    .wood-card {
        background: white;
        border-radius: 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .wood-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }

    .wood-card-header {
        background: #1e2a78;
        padding: 24px 32px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .wood-card-header h2 { font-size: 18px; font-weight: 800; margin: 0; letter-spacing: 0.5px; }

    .category-block { border-bottom: 1px solid #f8fafc; }
    .category-block:last-child { border-bottom: none; }

    .category-block-header {
        padding: 16px 32px;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .category-label {
        font-weight: 800;
        font-size: 12px;
        color: #1e2a78;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-price-tag {
        background: #ecfdf5;
        color: #059669;
        font-weight: 800;
        font-size: 14px;
        padding: 4px 12px;
        border-radius: 10px;
    }

    .size-list { list-style: none; padding: 0; margin: 0; }
    .size-item {
        padding: 16px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #f1f5f9;
        transition: background 0.2s;
    }
    .size-item:last-child { border-bottom: none; }
    .size-item:hover { background: #fdfdfd; }

    .size-text { font-weight: 700; color: #334155; font-size: 14px; }
    .size-info { display: flex; align-items: center; gap: 10px; }
    .cubic-badge {
        background: #f1f5f9;
        color: #1e2a78;
        font-weight: 800;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 6px;
        min-width: 80px;
        text-align: center;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="margin-bottom: 40px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Menu Produk (Daftar Harga)</h1>
    <p style="color: #64748b; font-weight: 500;">Daftar harga per kubik dan rincian ukuran untuk masing-masing jenis kayu.</p>
</div>

<div class="menu-grid">
    <?php $__empty_1 = true; $__currentLoopData = $menuData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wood): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="wood-card">
        <div class="wood-card-header">
            <h2><i class="fas fa-tree" style="margin-right: 12px; opacity: 0.8;"></i> <?php echo e($wood['wood_type']); ?></h2>
            <div style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase;">PER KUBIK</div>
        </div>
        <div class="wood-card-body">
            <?php $__currentLoopData = $wood['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="category-block">
                <div class="category-block-header">
                    <span class="category-label">
                        <i class="fas fa-layer-group" style="font-size: 14px; opacity: 0.6;"></i> <?php echo e($category['name']); ?>

                    </span>
                    <span class="category-price-tag">
                        Rp <?php echo e(number_format($category['price'], 0, ',', '.')); ?>

                    </span>
                </div>
                <div class="size-list">
                    <?php $__currentLoopData = $category['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="size-item">
                        <span class="size-text"><?php echo e($item['size']); ?></span>
                        <div class="size-info">
                            <span style="font-size: 14px; font-weight: 700; color: #94a3b8;">=</span>
                            <span class="cubic-badge"><?php echo e($item['quantity']); ?> <?php echo e($item['unit']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div style="grid-column: 1/-1; text-align: center; padding: 100px; background: white; border-radius: 24px; color: #94a3b8;">
        <i class="fas fa-clipboard-list fa-4x mb-4"></i>
        <h3>Belum Ada Data Produk</h3>
        <p>Silakan tambahkan produk dan atur harganya di menu "Stok Produk".</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/products/menu.blade.php ENDPATH**/ ?>