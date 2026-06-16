<?php $__env->startSection('title', 'Tambah Retur Penjualan'); ?>
<?php $__env->startSection('breadcrumb', 'Transaksi > Retur Penjualan > Tambah'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .page-container {
        padding: 40px 24px;
        background-color: #f8fafc;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .card {
        background: white;
        border-radius: 24px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        width: 100%;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    .card-header {
        padding: 32px 48px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header h2 { margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
    .btn-cancel-header { color: #64748b; text-decoration: none; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 6px; transition: 0.2s; }
    .btn-cancel-header:hover { color: #0f172a; }
    .card-body { padding: 48px; }

    .form-section { display: grid; grid-template-columns: 280px 1fr; gap: 48px; margin-bottom: 48px; }
    .section-info h3 { margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .section-info p { margin: 0; font-size: 14px; color: #64748b; line-height: 1.6; }

    .info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info-box-left { display: flex; flex-direction: column; gap: 4px; }
    .info-box-label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }
    .info-box-value { font-size: 15px; font-weight: 700; color: #1e293b; }
    .info-box-sub { font-size: 12px; color: #64748b; margin-top: 2px; }
    .info-box-right { text-align: right; }
    .info-box-right .info-box-value { font-size: 20px; color: #1e2a78; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { position: relative; }
    .form-group.full-width { grid-column: span 2; }
    .form-group label { display: block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 12px; text-transform: uppercase; }
    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #f1f5f9;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #1e2a78; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05); }

    .amount-box {
        background: #f0f7ff;
        border: 1.5px solid #dbeafe;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 20px;
        font-weight: 800;
        color: #1e2a78;
        text-align: right;
    }

    .card-footer {
        padding: 32px 48px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }
    .btn-save {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30, 42, 120, 0.2); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Retur Penjualan</h2>
            <a href="<?php echo e(route('sales-return.create')); ?>" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

        <form action="<?php echo e(route('sales-return.store')); ?>" method="POST" onsubmit="return validateBeforeSubmit()">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="kas_masuk_id" value="<?php echo e($sale->id); ?>">
            <input type="hidden" id="sale_price" value="<?php echo e($sale->price); ?>">

            <div class="card-body">
                <?php if(session('error') || $errors->any()): ?>
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        <?php if(session('error')): ?> <?php echo e(session('error')); ?> <?php else: ?>
                            <ul style="margin: 0; padding-left: 20px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Informasi Penjualan Asal -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Informasi Retur</h3>
                        <p>Halaman ini berfungsi untuk mencatat pengembalian produk dari transaksi penjualan yang telah terjadi.</p>
                    </div>
                    <div>
                        <div class="info-box">
                            <div class="info-box-left">
                                <div class="info-box-label">Produk / Item</div>
                                <div class="info-box-value"><?php echo e($sale->product ? $sale->product->name : ($sale->category->name ?? 'Penjualan Umum')); ?></div>
                                <div class="info-box-sub"><?php echo e($sale->date->format('d M Y')); ?> &nbsp;|&nbsp; Total: Rp <?php echo e(number_format($sale->amount, 0, ',', '.')); ?></div>
                            </div>
                            <div class="info-box-right">
                                <div class="info-box-label">Maksimal Retur</div>
                                <div class="info-box-value"><?php echo e(number_format($maxQty, 0, ',', '.')); ?> <?php echo e($sale->product->unit ?? 'Kubik'); ?></div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>Tanggal Retur*</label>
                                <input type="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>QTY / Kubik Retur*</label>
                                <input type="number" step="1" min="1" max="<?php echo e($maxQty); ?>" id="quantity" name="quantity"
                                    placeholder="0" value="<?php echo e(old('quantity')); ?>" class="form-control"
                                    oninput="calculateAmount()" required>
                                <small style="color: #94a3b8; margin-top: 6px; display: block; font-weight: 500;">
                                    Maks: <?php echo e($maxQty); ?> <?php echo e($sale->product->unit ?? 'kubik'); ?>

                                </small>
                            </div>

                            <div class="form-group full-width">
                                <label>Estimasi Nilai Retur (Rp)</label>
                                <div class="amount-box" id="amount_text">Rp 0</div>
                                <input type="hidden" id="amount" name="amount" value="<?php echo e(old('amount', 0)); ?>">
                                <small style="color: #94a3b8; margin-top: 8px; display: block; font-weight: 500;">
                                    Otomatis: QTY × Harga Jual (Rp <?php echo e(number_format($sale->price, 0, ',', '.')); ?>/kubik)
                                </small>
                            </div>

                            <div class="form-group full-width">
                                <label>Alasan Retur / Keterangan</label>
                                <textarea name="description" placeholder="Jelaskan alasan pengembalian (contoh: barang cacat, tidak sesuai pesanan)..."
                                    class="form-control" rows="3" style="resize: none;"><?php echo e(old('description')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Retur</button>
            </div>
        </form>
    </div>
</div>

<script>
    const maxQty = <?php echo e($maxQty); ?>;

    function validateBeforeSubmit() {
        const qty = parseInt(document.getElementById('quantity').value) || 0;
        if (qty <= 0) {
            document.getElementById('quantity').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        if (qty > maxQty) {
            document.getElementById('quantity').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    function calculateAmount() {
        const qtyInput = document.getElementById('quantity');
        let qty = parseInt(qtyInput.value) || 0;
        const price = parseFloat(document.getElementById('sale_price').value) || 0;

        // Paksa angka positif
        if (qty < 0) {
            qty = 0;
            qtyInput.value = '';
        }

        const total = qty * price;
        document.getElementById('amount_text').innerText = formatCurrency(total);
        document.getElementById('amount').value = total;

        // Validasi maks
        let errMsg = document.getElementById('qty-error-msg');
        if (qty > maxQty) {
            qtyInput.style.borderColor = '#ef4444';
            qtyInput.style.backgroundColor = '#fef2f2';
            if (!errMsg) {
                errMsg = document.createElement('small');
                errMsg.id = 'qty-error-msg';
                errMsg.style.cssText = 'color:#ef4444;font-weight:700;margin-top:4px;display:block;';
                qtyInput.parentNode.appendChild(errMsg);
            }
            errMsg.textContent = `⚠ Melebihi batas retur (maks: ${maxQty} kubik)`;
        } else {
            qtyInput.style.borderColor = '';
            qtyInput.style.backgroundColor = '';
            if (errMsg) errMsg.remove();
        }
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value).replace('Rp', 'Rp ');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('quantity').value) calculateAmount();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/transaksi-produk/retur-penjualan/create.blade.php ENDPATH**/ ?>