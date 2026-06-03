<?php $__env->startSection('title', 'Edit Produk'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Produk > Edit'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .page-container { 
        padding: 40px 24px; 
        background-color: #f8fafc; 
        min-height: 100vh; 
        display: flex;
        justify-content: center;
        align-items: flex-start;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .card { 
        background: white; 
        border-radius: 24px; 
        padding: 0; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); 
        width: 100%;
        max-width: 1000px; 
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
    .card-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }
    .btn-cancel-header {
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }
    .btn-cancel-header:hover { color: #0f172a; }

    .card-body { padding: 48px; }

    .form-section {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 48px;
        margin-bottom: 48px;
    }
    .section-info h3 {
        margin: 0 0 12px 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }
    .section-info p {
        margin: 0;
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .form-group { position: relative; }
    .form-group.full-width { grid-column: span 2; }
    
    .form-group label { 
        display: block; 
        margin-bottom: 10px; 
        font-weight: 700; 
        color: #334155; 
        font-size: 12px;
    }
    .form-control { 
        width: 100%; 
        padding: 14px 16px; 
        border: 1.5px solid #f1f5f9; 
        border-radius: 12px; 
        font-size: 14px; 
        font-weight: 500;
        color: #1e293b;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control:focus {
        outline: none;
        border-color: #1e2a78;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05);
    }

    .card-footer {
        padding: 32px 48px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 16px;
    }
    .btn-save { 
        background: #1e2a78; 
        color: white; 
        border: none; 
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 700; 
        font-size: 15px;
        cursor: pointer; 
        transition: all 0.2s ease; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30, 42, 120, 0.2); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Produk</h2>
            <a href="<?php echo e(route('master.products.index')); ?>" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="<?php echo e(route('master.products.update', $product->id)); ?>" method="POST" onsubmit="return stripFormattingBeforeSubmit(this)">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="card-body">
                <?php if(session('error') || $errors->any()): ?>
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        <?php if(session('error')): ?> <?php echo e(session('error')); ?> <?php else: ?> Periksa kembali inputan Anda <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="form-section">
                    <div class="section-info">
                        <h3>Identitas Produk</h3>
                        <p>Perbarui informasi klasifikasi produk Anda.</p>
                    </div>
                    <div class="form-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="form-group">
                            <label>Jenis Kayu</label>
                            <input type="text" name="wood_type" id="wood_type" class="form-control" value="<?php echo e(old('wood_type', $product->wood_type)); ?>" placeholder="Contoh: Duren, Senggon, Racuk">
                        </div>
                        <div class="form-group">
                            <label>Kategori Bentuk</label>
                            <input type="text" name="product_category" id="product_category" class="form-control" value="<?php echo e(old('product_category', $product->product_category)); ?>" placeholder="Contoh: Balok, Papan, Kasau" list="category_list">
                            <datalist id="category_list">
                                <option value="Balok">
                                <option value="Papan">
                                <option value="Kasau">
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label>Ukuran</label>
                            <input type="text" name="size" id="size" class="form-control" value="<?php echo e(old('size', $product->size)); ?>" placeholder="Contoh: 8x12x4, 3x25x4">
                        </div>
                        <div class="form-group">
                            <label>Isi Per Kubik (Batang/Keping)</label>
                            <input type="text" inputmode="numeric" name="cubic_content" class="form-control" value="<?php echo e(old('cubic_content', $product->cubic_content)); ?>" placeholder="Contoh: 25">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label>Nama Produk Lengkap (Otomatis)*</label>
                            <input type="text" name="name" id="full_name" class="form-control" value="<?php echo e(old('name', $product->name)); ?>" placeholder="Akan terisi otomatis" required>
                        </div>
                        <div class="form-group">
                            <label>Satuan (Unit)*</label>
                            <input type="text" name="unit" class="form-control" value="<?php echo e(old('unit', $product->unit)); ?>" placeholder="Contoh: kubik, ikat, pcs" required>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Harga & Stok -->
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Harga & Stok</h3>
                        <p>Perbarui harga beli dasar (HPP) and jumlah stok produk ini.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Harga Beli / HPP Satuan (RP)*</label>
                            <input type="text" name="cost" id="cost" class="form-control" value="<?php echo e(old('cost', (int)$product->cost)); ?>" placeholder="Rp 0" required>
                        </div>

                        <div class="form-group">
                            <label>Stok*</label>
                            <input type="text" inputmode="decimal" name="stock" class="form-control" value="<?php echo e(old('stock', (float)$product->stock)); ?>" placeholder="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof initCurrencyInput === 'function') {
            initCurrencyInput('#cost');
        }

        const woodType = document.getElementById('wood_type');
        const productCategory = document.getElementById('product_category');
        const size = document.getElementById('size');
        const fullName = document.getElementById('full_name');

        function updateFullName() {
            let nameParts = [];
            if (woodType.value) nameParts.push('Kayu ' + woodType.value);
            if (productCategory.value && productCategory.value !== 'Lainnya') nameParts.push(productCategory.value);
            if (size.value) nameParts.push(size.value);
            
            if (nameParts.length > 0) {
                fullName.value = nameParts.join(' ');
            }
        }

        [woodType, productCategory, size].forEach(el => {
            el.addEventListener('input', updateFullName);
            el.addEventListener('change', updateFullName);
        });
    });
    
    function stripFormattingBeforeSubmit(form) {
        const costInput = form.querySelector('#cost');
        if (costInput) {
            costInput.value = costInput.value.replace(/[^0-9.]/g, '');
        }
        return true;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/products/edit.blade.php ENDPATH**/ ?>