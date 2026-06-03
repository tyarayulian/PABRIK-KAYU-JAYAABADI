<?php $__env->startSection('title', 'Retur Penjualan'); ?>
<?php $__env->startSection('breadcrumb', 'Transaksi / Retur Penjualan'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .main-content {
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 14px;
        color: #666;
        margin: 0;
    }

    .table-section {
        background: white;
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .table-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-title-section h2 {
        font-size: 20px;
        font-weight: 800;
        color: #000;
        margin: 0;
    }

    .btn-add {
        background: #1e2a78;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 15px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-add:hover {
        background: #151d54;
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.2);
    }

    .clean-table {
        width: 100%;
        border-collapse: collapse;
    }

    .clean-table th {
        background: #f8fafc;
        padding: 18px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }

    .clean-table td {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #1e293b;
    }

    .clean-table tr:last-child td {
        border-bottom: none;
    }

    .clean-table tr:hover td {
        background-color: #fcfdfe;
    }

    .amount {
        font-weight: 800;
        color: #1e2a78;
    }

    .badge-qty {
        background: #f0f7ff;
        color: #1e2a78;
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: 1px solid #f1f5f9;
        background: #fff;
        color: #64748b;
        text-decoration: none;
    }

    .btn-action:hover {
        background: #f8fafc;
        color: #1e2a78;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .btn-delete:hover {
        color: #dc2626;
        border-color: #fee2e2;
        background: #fef2f2;
    }

    .empty-state {
        padding: 80px 40px;
        text-align: center;
    }

    .empty-state i {
        font-size: 48px;
        color: #e2e8f0;
        margin-bottom: 20px;
    }

    .empty-state p {
        color: #94a3b8;
        font-weight: 500;
    }

    /* Stat Cards */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 18px 24px;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.total-amount {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .stat-icon.total-qty {
        background-color: #f0f9ff;
        color: #0369a1;
    }

    .stat-icon.total-count {
        background-color: #f8fafc;
        color: #475569;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .stat-card-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 4px;
    }

    .stat-card-value {
        font-size: 20px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="stat-cards-grid">
    <div class="stat-card">
        <div class="stat-icon total-amount">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-info">
            <p class="stat-card-label">Total Nilai Retur</p>
            <h3 class="stat-card-value">Rp <?php echo e(number_format($totalReturnAmount, 0, ',', '.')); ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon total-qty">
            <i class="fas fa-cubes"></i>
        </div>
        <div class="stat-info">
            <p class="stat-card-label">Total Qty Retur</p>
            <h3 class="stat-card-value"><?php echo e(number_format($totalReturnQty, 0, ',', '.')); ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon total-count">
            <i class="fas fa-history"></i>
        </div>
        <div class="stat-info">
            <p class="stat-card-label">Jumlah Transaksi</p>
            <h3 class="stat-card-value"><?php echo e($returnCount); ?> Transaksi</h3>
        </div>
    </div>
</div>

<div class="table-section">
    <div class="table-title-section">
        <h2>Daftar Transaksi Retur</h2>
        <a href="<?php echo e(route('sales-return.create')); ?>" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Retur</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="clean-table">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>PRODUK</th>
                    <th style="text-align: center;">JUMLAH</th>
                    <th style="text-align: right;">TOTAL NILAI</th>
                    <th>KETERANGAN</th>
                    <th style="text-align: center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $salesReturns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #1e293b;"><?php echo e($return->date->format('d M Y')); ?></div>
                            <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;"><?php echo e($return->date->format('H:i')); ?></div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #1e293b;"><?php echo e($return->product->name ?? 'N/A'); ?></div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;"><?php echo e($return->product->wood_type ?? ''); ?> - <?php echo e($return->product->size ?? ''); ?></div>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-qty"><?php echo e(number_format($return->quantity, 0, ',', '.')); ?> <?php echo e($return->product->unit ?? 'Unit'); ?></span>
                        </td>
                        <td style="text-align: right;">
                            <span class="amount">Rp <?php echo e(number_format($return->amount, 0, ',', '.')); ?></span>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #64748b; max-width: 200px; line-height: 1.5;">
                                <?php echo e($return->description ?: '-'); ?>

                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <a href="<?php echo e(route('sales-return.edit', $return->id)); ?>" class="btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('sales-return.destroy', $return->id)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-undo-alt"></i>
                                <p>Belum ada transaksi retur yang tercatat.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/transaksi/sales-return/index.blade.php ENDPATH**/ ?>