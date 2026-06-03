

<?php $__env->startSection('title', 'Riwayat Proses Produksi'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Produksi'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .btn-create {
        background: #1e2a78;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-create:hover { background: #151d54; transform: translateY(-1px); }
    
    .card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 14px 24px;
        background: #f8fafc;
        text-align: left;
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #f1f5f9;
    }
    td { padding: 16px 24px; font-size: 13px; color: #334155; border-bottom: 1px solid #f8fafc; }
    .item-list { font-size: 12px; color: #64748b; margin-top: 4px; }
    .amount { font-weight: 700; color: #1e2a78; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">Proses Produksi</h1>
        <p style="color: #64748b; margin: 4px 0 0 0;">Riwayat pengolahan bahan baku menjadi produk jadi.</p>
    </div>
    <a href="<?php echo e(route('master.productions.create')); ?>" class="btn-create">
        <i class="fas fa-plus"></i> Mulai Produksi Baru
    </a>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Bahan Baku (Asal Transaksi)</th>
                    <th>Hasil Produksi</th>
                    <th style="text-align: right;">Total Modal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $productions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $production): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="vertical-align: top; font-weight: 600;">
                        <?php echo e($production->date->format('d/m/Y')); ?>

                    </td>
                    <td style="vertical-align: top;">
                        <div style="font-weight: 700; color: #1e2a78;"><?php echo e($production->wood_type); ?></div>
                        <div style="font-size: 11px; color: #94a3b8;">Ref: #<?php echo e($production->kas_keluar_id); ?></div>
                    </td>
                    <td>
                        <?php $__currentLoopData = $production->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="margin-bottom: 8px;">
                            <span style="font-weight: 600; color: #334155;"><?php echo e($item->product->product_category); ?> - <?php echo e($item->product->size); ?></span><br>
                            <span class="item-list"><?php echo e(number_format($item->quantity, 2)); ?> <?php echo e($item->product->unit); ?> | Alokasi: Rp <?php echo e(number_format($item->allocated_cost, 0, ',', '.')); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td style="text-align: right; vertical-align: top;" class="amount">
                        Rp <?php echo e(number_format($production->total_cost, 0, ',', '.')); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fas fa-box-open fa-3x mb-3"></i><br>
                        Belum ada data produksi.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/productions/index.blade.php ENDPATH**/ ?>