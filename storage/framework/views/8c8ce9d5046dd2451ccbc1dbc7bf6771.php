<?php $__env->startSection('title', 'Tambah Produk Massal'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Produk > Tambah Massal'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .page-container { padding: 40px 24px; background-color: #f8fafc; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
    .card { background: white; border-radius: 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; overflow: hidden; max-width: 1100px; margin: 0 auto; }
    .card-header { padding: 32px 48px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
    .card-header h2 { margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; }
    .card-body { padding: 48px; }

    .form-section { display: grid; grid-template-columns: 280px 1fr; gap: 48px; margin-bottom: 48px; }
    .section-info h3 { margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .section-info p { font-size: 14px; color: #64748b; line-height: 1.6; }

    .form-group label { display: block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 12px 16px; border: 1.5px solid #f1f5f9; border-radius: 12px; font-size: 14px; font-weight: 500; background-color: #ffffff; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: #1e2a78; background-color: #fff; box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05); }

    /* Checklist Kategori */
    .category-checklist { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 10px; }
    .check-item { position: relative; }
    .check-item input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
    .check-label { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        padding: 10px 24px; 
        background: #ffffff; 
        border: 1.5px solid #e2e8f0; 
        border-radius: 12px; 
        font-weight: 700; 
        color: #64748b; 
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer; 
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    .check-label i { font-size: 14px; opacity: 0.5; }
    .check-item input:checked + .check-label { 
        background: #1e2a78; 
        border-color: #1e2a78; 
        color: white; 
        box-shadow: 0 4px 12px rgba(30, 42, 120, 0.15); 
    }
    .check-item input:checked + .check-label i { opacity: 1; color: white; }
    .check-label:hover { border-color: #1e2a78; color: #1e2a78; background: #f9fbff; }
    .check-item input:checked + .check-label:hover { background: #151d54; color: white; }

    /* Category Panels */
    .category-panel { background: #fff; border: 1.5px solid #f1f5f9; border-radius: 20px; padding: 24px; margin-bottom: 24px; display: none; }
    .category-panel.active { display: block; animation: slideDown 0.3s ease-out; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .panel-header h4 { font-weight: 800; color: #1e2a78; text-transform: uppercase; letter-spacing: 1px; margin: 0; font-size: 14px; }

    .size-row { display: grid; grid-template-columns: 1.5fr 1fr 1.5fr 1.5fr 40px; gap: 15px; margin-bottom: 20px; align-items: flex-end; }
    .size-row .form-group label { font-size: 11px; margin-bottom: 10px; white-space: nowrap; font-weight: 800; color: #475569; }
    .size-row .form-control { padding: 12px 14px; font-size: 14px; border-radius: 12px; font-weight: 600; }
    
    .btn-add-size { background: #f1f5f9; color: #1e2a78; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 800; font-size: 11px; cursor: pointer; transition: 0.2s; }
    .btn-add-size:hover { background: #e2e8f0; }
    .btn-remove-row { color: #ef4444; background: #fff1f2; border: none; cursor: pointer; height: 42px; width: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: 0.2s; margin-bottom: 0px; }
    .btn-remove-row:hover { background: #fee2e2; transform: scale(1.05); }

    .card-footer { padding: 32px 48px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 16px; }
    .btn-save { background: #1e2a78; color: white; border: none; padding: 14px 40px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); box-shadow: 0 8px 15px rgba(30, 42, 120, 0.2); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Produk Massal</h2>
            <a href="<?php echo e(route('master.products.index')); ?>" style="color: #64748b; text-decoration: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-xmark"></i> Batal
            </a>
        </div>
        
        <form action="<?php echo e(route('master.products.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="card-body">
                <?php if(session('error')): ?>
                    <div style="background: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-weight: 600; border: 1px solid #ffe4e6;">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <!-- Identitas Utama -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Identitas Produk</h3>
                        <p>Tentukan jenis kayu dan pilih kategori bentuk yang ingin didaftarkan.</p>
                    </div>
                    <div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            <label>Jenis Kayu*</label>
                            <input type="text" name="wood_type" id="wood_type" class="form-control" placeholder="Contoh: Duren, Senggon, Racuk" value="<?php echo e(request('wood_type')); ?>" required <?php echo e(request('wood_type') ? 'readonly' : ''); ?>>
                        </div>
                        <div class="form-group">
                            <label>Kategori Bentuk (Pilih Checklist)*</label>
                            <div class="category-checklist">
                                <?php $__currentLoopData = ['Balok', 'Papan', 'Kasau']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="check-item">
                                    <input type="checkbox" id="check-<?php echo e($cat); ?>" class="cat-checkbox" data-category="<?php echo e($cat); ?>">
                                    <label for="check-<?php echo e($cat); ?>" class="check-label">
                                        <i class="fas fa-check-circle"></i> <?php echo e($cat); ?>

                                    </label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Dinamis -->
                <div id="category-panels-container">
                    <!-- Panel akan muncul di sini via JS -->
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Semua Produk</button>
            </div>
        </form>
    </div>
</div>

<!-- Template untuk Row Ukuran -->
<template id="size-row-template">
    <div class="size-row">
        <div class="form-group">
            <label>UKURAN*</label>
            <input type="text" name="products[CAT_IDX][items][ROW_IDX][size]" class="form-control" placeholder="Contoh: 8x12x4" required>
        </div>
        <div class="form-group">
            <label>ISI/KUBIK</label>
            <input type="text" inputmode="numeric" name="products[CAT_IDX][items][ROW_IDX][cubic_content]" class="form-control" placeholder="0">
        </div>
        <div class="form-group">
            <label>STOK AWAL (KUBIK)*</label>
            <input type="text" inputmode="decimal" name="products[CAT_IDX][items][ROW_IDX][stock]" class="form-control stock-input" value="0" required>
        </div>
        <div class="form-group">
            <label>HPP / KUBIK*</label>
            <input type="text" name="products[CAT_IDX][items][ROW_IDX][cost]" class="form-control currency-input hpp-input" placeholder="Rp 0" required>
        </div>
        <button type="button" class="btn-remove-row" onclick="removeSizeRow(this)"><i class="fas fa-trash"></i></button>
    </div>
</template>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const container = document.getElementById('category-panels-container');
    const template = document.getElementById('size-row-template').innerHTML;
    let categoryCounters = {};

    document.querySelectorAll('.cat-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const cat = this.dataset.category;
            if (this.checked) {
                createCategoryPanel(cat);
            } else {
                const panel = document.getElementById(`panel-${cat}`);
                if (panel) panel.remove();
            }
        });
    });

    function createCategoryPanel(cat) {
        const catIdx = Object.keys(categoryCounters).length;
        categoryCounters[cat] = 0;

        const panel = document.createElement('div');
        panel.id = `panel-${cat}`;
        panel.className = 'category-panel active';
        panel.innerHTML = `
            <div class="panel-header">
                <h4>Bagian: ${cat}</h4>
                <button type="button" class="btn-add-size" onclick="addSizeRow('${cat}', ${catIdx})">+ Tambah Ukuran ${cat}</button>
                <input type="hidden" name="products[${catIdx}][category]" value="${cat}">
            </div>
            <div class="size-rows-container" id="rows-${cat}"></div>
        `;
        container.appendChild(panel);
        addSizeRow(cat, catIdx); // Tambah baris pertama otomatis
    }

    function addSizeRow(cat, catIdx) {
        const rowIdx = categoryCounters[cat]++;
        const rowsContainer = document.getElementById(`rows-${cat}`);
        
        let rowHtml = template
            .replace(/CAT_IDX/g, catIdx)
            .replace(/ROW_IDX/g, rowIdx);
            
        const div = document.createElement('div');
        div.innerHTML = rowHtml;
        const newRow = div.firstElementChild;
        rowsContainer.appendChild(newRow);

        // Init currency for new row
        const costInput = newRow.querySelector('.currency-input');
        if (typeof initCurrencyInput === 'function') {
            initCurrencyInput(costInput);
        }
    }

    function removeSizeRow(btn) {
        const row = btn.closest('.size-row');
        const container = row.parentElement;
        if (container.children.length > 1) {
            row.remove();
        } else {
            alert('Minimal harus ada satu ukuran untuk kategori ini.');
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number).replace('Rp', 'Rp ').trim();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/products/create.blade.php ENDPATH**/ ?>