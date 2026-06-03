

<?php $__env->startSection('title', 'Mulai Produksi Baru'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Produksi > Baru'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .page-container { padding: 30px 0; max-width: 1000px; margin: 0 auto; }
    .card { background: white; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
    .card-header { padding: 32px 40px; border-bottom: 1px solid #f1f5f9; }
    .card-body { padding: 40px; }
    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 12px; text-transform: uppercase; }
    .form-control { width: 100%; padding: 14px 16px; border: 1.5px solid #f1f5f9; border-radius: 12px; font-size: 14px; background: #f8fafc; transition: 0.2s; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #1e2a78; background: white; }
    
    .production-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .production-table th { padding: 12px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
    .production-table td { padding: 12px; border-bottom: 1px solid #f8fafc; }
    
    .btn-save { background: #1e2a78; color: white; border: none; padding: 16px 32px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.2s; }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); }
    
    .summary-box { background: #f9fbff; padding: 20px; border-radius: 16px; border: 1px solid #eef2ff; margin-top: 30px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
    .summary-total { font-weight: 800; color: #1e2a78; border-top: 1px solid #eef2ff; pt: 10px; margin-top: 10px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <form action="<?php echo e(route('master.productions.store')); ?>" method="POST" id="production-form">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: #0f172a;">Input Hasil Produksi</h2>
                        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13px;">Pilih bahan baku dan masukkan hasil jadinya.</p>
                    </div>
                    <a href="<?php echo e(route('master.productions.index')); ?>" style="color: #64748b; text-decoration: none; font-weight: 700; font-size: 14px;">Batal</a>
                </div>
            </div>
            
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="form-group">
                        <label>PILIH TRANSAKSI PEMBELIAN BAHAN BAKU*</label>
                        <select name="kas_keluar_id" id="raw_material_id" class="form-control" onchange="handleRawMaterialChange(this)" required>
                            <option value="">-- Pilih Pembelian --</option>
                            <?php $__currentLoopData = $rawMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $raw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($raw->id); ?>" data-amount="<?php echo e($raw->amount); ?>">
                                    #<?php echo e($raw->id); ?> | <?php echo e($raw->product->wood_type); ?> | Rp <?php echo e(number_format($raw->amount, 0, ',', '.')); ?> (<?php echo e($raw->date->format('d/m/Y')); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>TANGGAL PROSES PRODUKSI*</label>
                        <input type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>" class="form-control" required>
                    </div>
                </div>

                <div id="production-items-section" style="display: none; margin-top: 20px;">
                    <h3 style="font-size: 14px; font-weight: 800; color: #1e2a78; text-transform: uppercase; margin-bottom: 20px;">Hasil Gergajian (Produk Jadi)</h3>
                    
                    <table class="production-table" id="items-table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Ukuran / Produk Jadi</th>
                                <th style="width: 20%;">Qty (Kubik)</th>
                                <th style="width: 30%;">Alokasi Modal (Rp)</th>
                                <th style="width: 10%;"></th>
                            </tr>
                        </thead>
                        <tbody id="items-body">
                            <!-- Items will be added here -->
                        </tbody>
                    </table>

                    <button type="button" onclick="addRow()" style="background: none; border: 1px dashed #cbd5e1; color: #64748b; padding: 10px; border-radius: 8px; width: 100%; margin-top: 15px; cursor: pointer; font-weight: 700; font-size: 12px;">
                        <i class="fas fa-plus"></i> Tambah Ukuran Hasil Jadi
                    </button>

                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Total Modal Bahan Baku:</span>
                            <span id="total-raw-material-cost" style="font-weight: 700;">Rp 0</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Alokasi Saat Ini:</span>
                            <span id="total-allocated-display" style="font-weight: 700;">Rp 0</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Sisa Modal Belum Dialokasikan:</span>
                            <span id="remaining-cost" style="font-weight: 800; color: #ef4444;">Rp 0</span>
                        </div>
                    </div>
                    
                    <div style="margin-top: 40px; text-align: right;">
                        <button type="submit" class="btn-save" id="btn-submit" disabled>Simpan Hasil Produksi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="row-template">
    <tr>
        <td>
            <select name="items[INDEX][product_id]" class="form-control product-select" required>
                <option value="">-- Pilih Ukuran --</option>
            </select>
        </td>
        <td>
            <input type="number" step="0.01" name="items[INDEX][quantity]" class="form-control qty-input" placeholder="0" required oninput="calculateSummary()">
        </td>
        <td>
            <input type="text" class="form-control cost-display" placeholder="Rp 0" required oninput="handleCostInput(this)">
            <input type="hidden" name="items[INDEX][allocated_cost]" class="cost-hidden">
        </td>
        <td style="text-align: center;">
            <button type="button" onclick="this.closest('tr').remove(); calculateSummary();" style="color: #ef4444; background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
</template>

<script>
    let rawMaterialAmount = 0;
    let finishedProductsOptions = '';
    let rowIndex = 0;

    function handleRawMaterialChange(select) {
        const id = select.value;
        const section = document.getElementById('production-items-section');
        
        if (!id) {
            section.style.display = 'none';
            return;
        }

        rawMaterialAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
        document.getElementById('total-raw-material-cost').textContent = formatCurrency(rawMaterialAmount);

        fetch(`/master/productions/raw-details/${id}`)
            .then(res => res.json())
            .then(data => {
                finishedProductsOptions = '<option value="">-- Pilih Ukuran --</option>';
                data.finished_products.forEach(p => {
                    finishedProductsOptions += `<option value="${p.id}">${p.product_category} - ${p.size}</option>`;
                });
                
                document.getElementById('items-body').innerHTML = '';
                rowIndex = 0;
                addRow();
                section.style.display = 'block';
                calculateSummary();
            });
    }

    function addRow() {
        const template = document.getElementById('row-template').innerHTML;
        const newRow = template.replace(/INDEX/g, rowIndex);
        document.getElementById('items-body').insertAdjacentHTML('beforeend', newRow);
        
        const lastSelect = document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1];
        lastSelect.innerHTML = finishedProductsOptions;
        
        rowIndex++;
    }

    function handleCostInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        const hiddenInput = input.closest('td').querySelector('.cost-hidden');
        
        if (value) {
            const numValue = parseInt(value);
            hiddenInput.value = numValue;
            input.value = formatCurrency(numValue);
        } else {
            hiddenInput.value = 0;
            input.value = '';
        }
        calculateSummary();
    }

    function calculateSummary() {
        let totalAllocated = 0;
        document.querySelectorAll('.cost-hidden').forEach(input => {
            totalAllocated += parseFloat(input.value || 0);
        });

        const remaining = rawMaterialAmount - totalAllocated;
        
        document.getElementById('total-allocated-display').textContent = formatCurrency(totalAllocated);
        document.getElementById('remaining-cost').textContent = formatCurrency(remaining);
        
        const btn = document.getElementById('btn-submit');
        // Validasi: alokasi harus pas (selisih max 100 perak untuk pembulatan)
        if (Math.abs(remaining) < 100 && totalAllocated > 0) {
            document.getElementById('remaining-cost').style.color = '#10b981';
            btn.disabled = false;
        } else {
            document.getElementById('remaining-cost').style.color = '#ef4444';
            btn.disabled = true;
        }
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value).replace('Rp', 'Rp ');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/productions/create.blade.php ENDPATH**/ ?>