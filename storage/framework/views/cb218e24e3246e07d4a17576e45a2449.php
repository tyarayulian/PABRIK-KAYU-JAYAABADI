<?php $__env->startSection('title', 'Edit Pembelian'); ?>
<?php $__env->startSection('breadcrumb', 'Transaksi > Pembelian > Edit'); ?>

<?php $__env->startSection('styles'); ?>
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
        font-family: 'Plus Jakarta Sans', sans-serif;
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
    .form-control:read-only { background-color: #f1f5f9; cursor: not-allowed; color: #64748b; }
    
    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 40px 32px;
        text-align: center;
        cursor: pointer;
        background: #f8fafc;
        transition: 0.2s;
        position: relative;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .upload-area:hover { border-color: #1e2a78; background: #f1f5f9; }
    .upload-area.has-file { border-style: solid; border-color: #1e2a78; background: white; padding: 20px; }
    
    .upload-placeholder i { font-size: 32px; color: #1e2a78; margin-bottom: 12px; }
    .upload-placeholder p { margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; }
    .upload-placeholder span { font-size: 12px; color: #64748b; margin-top: 8px; display: block; }

    .file-preview-content { display: none; width: 100%; }
    .preview-file-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 16px;
    }
    .preview-file-info {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }
    .preview-file-info i { color: #1e2a78; font-size: 18px; }
    .preview-actions { display: flex; gap: 8px; }
    .preview-btn-sm {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background: white;
        color: #1e2a78;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: 0.2s;
    }
    .preview-btn-sm:hover { border-color: #1e2a78; background: #f8fafc; }
    
    .thumbnail-container {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        background: #f8fafc;
    }
    .preview-image { max-width: 100%; max-height: 300px; display: block; margin: 0 auto; }
    .pdf-preview-frame { width: 100%; height: 400px; border: none; }

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
            <h2>Edit Pembelian</h2>
            <a href="<?php echo e(route('transaksi.index')); ?>" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="<?php echo e(route('kas-keluar.update', $kasKeluar->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="card-body">
                <?php if(session('error') || $errors->any()): ?>
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        <?php if(session('error')): ?> <?php echo e(session('error')); ?> <?php else: ?> Periksa kembali inputan Anda <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Section 1: Informasi Transaksi -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Informasi Transaksi</h3>
                        <p>Sesuaikan detail transaksi pembelian produk Anda.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal Transaksi*</label>
                            <input type="date" name="date" value="<?php echo e(old('date', $kasKeluar->date->format('Y-m-d'))); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Produk*</label>
                            <select id="product_id" name="product_id" class="form-control" onchange="handleProductChange(this)">
                                <option value="">Pilih Produk...</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>" data-category-id="<?php echo e($product->category_id); ?>" data-cost="<?php echo e((int)$product->cost); ?>" data-unit="<?php echo e($product->unit); ?>" data-stock="<?php echo e((float)$product->stock); ?>" <?php echo e(old('product_id', $kasKeluar->product_id) == $product->id ? 'selected' : ''); ?>><?php echo e($product->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div id="stock-info" style="display: <?php echo e($kasKeluar->product_id ? 'block' : 'none'); ?>; font-size: 11px; color: #1e2a78; margin-top: 6px; font-weight: 700;">
                                Sisa stok: <span id="stock-value"><?php echo e($kasKeluar->product->stock ?? 0); ?></span> <span id="stock-unit"><?php echo e($kasKeluar->product->unit ?? ''); ?></span>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Asal Kayu</label>
                            <input type="text" name="hutan" placeholder="Contoh: Kalimantan, Jepara, Hutan Produksi Riau" value="<?php echo e(old('hutan', $kasKeluar->hutan)); ?>" class="form-control">
                        </div>

                        <input type="hidden" id="category_id" name="category_id" value="<?php echo e(old('category_id', $kasKeluar->category_id)); ?>">
                        <input type="hidden" id="account_id" name="account_id" value="<?php echo e(old('account_id', $kasKeluar->account_id)); ?>">

                        <div class="form-group">
                            <label>QTY <span id="unit-label" style="text-transform: none; color: #64748b;"><?php echo e($kasKeluar->product->unit ? '('.$kasKeluar->product->unit.')' : ''); ?></span>*</label>
                            <input type="number" step="1" id="quantity" name="quantity" placeholder="0" value="<?php echo e(old('quantity', (int)$kasKeluar->quantity)); ?>" class="form-control" oninput="calculateAmount()">
                        </div>

                        <div class="form-group">
                            <label>Harga Satuan (RP)*</label>
                            <input type="text" id="price" name="price" placeholder="Rp 0" value="<?php echo e(old('price', (int)$kasKeluar->price)); ?>" class="form-control" oninput="calculateAmount()">
                        </div>

                        <div class="form-group full-width">
                            <label>Jumlah Nominal (RP)*</label>
                            <input type="text" id="amount" name="amount" placeholder="Rp 0" value="<?php echo e(old('amount', (int)$kasKeluar->amount)); ?>" class="form-control" readOnly style="background-color: #f1f5f9;">
                        </div>

                        <div class="form-group full-width">
                            <label>Keterangan / Deskripsi</label>
                            <textarea name="description" placeholder="Misal: Pembelian bahan baku dari UD. Rimba" class="form-control" rows="3" style="resize: none;"><?php echo e(old('description', $kasKeluar->description)); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Lampiran Bukti -->
                <?php
                    $hasFile = $kasKeluar->file_path;
                    $fileUrl = $hasFile ? Storage::url($kasKeluar->file_path) : '';
                    $fileName = $hasFile ? basename($kasKeluar->file_path) : '';
                    $fileExt = $hasFile ? strtolower(pathinfo($kasKeluar->file_path, PATHINFO_EXTENSION)) : '';
                ?>
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Lampiran Bukti</h3>
                        <p>Unggah foto atau dokumen bukti transaksi sebagai pendukung laporan.</p>
                    </div>
                    <div class="form-group full-width">
                        <div id="upload-container" class="upload-area <?php echo e($hasFile ? 'has-file' : ''); ?>" onclick="document.getElementById('file-input').click()">
                            <div id="upload-placeholder" class="upload-placeholder" style="display: <?php echo e($hasFile ? 'none' : 'block'); ?>">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik untuk memilih file lampiran</p>
                                <span>Format: JPG, PNG, PDF (Maks. 2MB)</span>
                            </div>

                            <div id="file-preview-content" class="file-preview-content" style="display: <?php echo e($hasFile ? 'block' : 'none'); ?>">
                                <div class="preview-file-header" onclick="event.stopPropagation()">
                                    <div class="preview-file-info">
                                        <i class="fas fa-file-alt"></i>
                                        <span id="preview-filename"><?php echo e($fileName); ?></span>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" id="btn-view-file" class="preview-btn-sm" onclick="openViewer('<?php echo e($fileUrl); ?>', '<?php echo e($fileName); ?>')">LIHAT</button>
                                        <a id="btn-download-file" href="<?php echo e($fileUrl); ?>" download="<?php echo e($fileName); ?>" class="preview-btn-sm" title="Unduh"><i class="fas fa-download"></i></a>
                                        <button type="button" class="preview-btn-sm" style="color: #ef4444;" onclick="removeFile(event)">HAPUS</button>
                                    </div>
                                </div>
                                <div class="thumbnail-container" onclick="event.stopPropagation()">
                                    <img id="image-preview" src="<?php echo e(in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? $fileUrl : ''); ?>" class="preview-image" style="display: <?php echo e(in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? 'block' : 'none'); ?>">
                                    <iframe id="pdf-frame" src="<?php echo e($fileExt === 'pdf' ? $fileUrl . '#toolbar=0' : ''); ?>" class="pdf-preview-frame" style="display: <?php echo e($fileExt === 'pdf' ? 'block' : 'none'); ?>"></iframe>
                                </div>
                            </div>

                            <input type="file" id="file-input" name="file" accept="image/*,.pdf" style="display: none;" onchange="handleFileSelect(this)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Update Transaksi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleProductChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        const unitLabel = document.getElementById('unit-label');
        const priceInput = document.getElementById('price');
        const stockInfo = document.getElementById('stock-info');
        const stockValue = document.getElementById('stock-value');
        const stockUnit = document.getElementById('stock-unit');
        const categoryIdInput = document.getElementById('category_id');
        
        if (select.value) {
            const unit = selectedOption.getAttribute('data-unit');
            const cost = selectedOption.getAttribute('data-cost');
            const stock = parseFloat(selectedOption.getAttribute('data-stock') || 0);
            const categoryId = selectedOption.getAttribute('data-category-id');
            
            unitLabel.textContent = unit ? `(${unit})` : '';
            priceInput.value = formatNumber(cost);
            categoryIdInput.value = categoryId;
            
            stockValue.textContent = stock;
            stockUnit.textContent = unit;
            stockInfo.style.display = 'block';
        } else {
            unitLabel.textContent = '';
            stockInfo.style.display = 'none';
            categoryIdInput.value = '';
        }
        calculateAmount();
    }

    function calculateAmount() {
        const qty = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseCurrency(document.getElementById('price').value) || 0;
        const total = qty * price;
        document.getElementById('amount').value = formatCurrency(total);
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value).replace('Rp', 'Rp ');
    }

    function formatNumber(value) {
        if (!value && value !== 0) return '';
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function parseCurrency(value) {
        if (!value) return 0;
        return parseInt(value.toString().replace(/[^0-9]/g, '')) || 0;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Format initial values
        const priceInput = document.getElementById('price');
        const amountInput = document.getElementById('amount');
        
        if (priceInput.value) {
            priceInput.value = formatNumber(parseCurrency(priceInput.value));
        }
        if (amountInput.value) {
            amountInput.value = formatCurrency(parseCurrency(amountInput.value));
        }

        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) {
                this.value = formatNumber(parseInt(value));
            }
            calculateAmount();
        });
    });

    function handleFileSelect(input) {
        const uploadArea = document.getElementById('upload-container');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContent = document.getElementById('file-preview-content');
        const filenameSpan = document.getElementById('preview-filename');
        const imgPreview = document.getElementById('image-preview');
        const pdfFrame = document.getElementById('pdf-frame');
        const btnView = document.getElementById('btn-view-file');
        const btnDownload = document.getElementById('btn-download-file');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            filenameSpan.textContent = `${file.name} (${fileSize} MB)`;
            
            const fileUrl = URL.createObjectURL(file);
            btnView.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                openViewer(fileUrl, file.name);
            };
            btnDownload.onclick = (e) => e.stopPropagation();
            btnDownload.href = fileUrl;
            btnDownload.download = file.name;
            
            if (file.type.startsWith('image/')) {
                imgPreview.src = fileUrl;
                imgPreview.style.display = 'block';
                pdfFrame.style.display = 'none';
                pdfFrame.src = "";
            } else if (file.type === 'application/pdf') {
                imgPreview.style.display = 'none';
                pdfFrame.style.display = 'block';
                pdfFrame.src = fileUrl + "#toolbar=0&navpanes=0&scrollbar=0";
            }
            
            placeholder.style.display = 'none';
            previewContent.style.display = 'block';
            uploadArea.classList.add('has-file');
        }
    }

    function removeFile(event) {
        event.stopPropagation();
        const input = document.getElementById('file-input');
        const uploadArea = document.getElementById('upload-container');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContent = document.getElementById('file-preview-content');
        const imgPreview = document.getElementById('image-preview');
        const pdfFrame = document.getElementById('pdf-frame');
        
        input.value = '';
        placeholder.style.display = 'flex';
        previewContent.style.display = 'none';
        uploadArea.classList.remove('has-file');
        imgPreview.src = '';
        pdfFrame.src = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof initCurrencyInput === 'function') {
            initCurrencyInput('#price');
        }
    });
</script>

<?php echo $__env->make('components.file-viewer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/transaksi/kas-keluar/edit.blade.php ENDPATH**/ ?>