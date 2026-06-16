@extends('layouts.app')

@section('title', 'Edit Penjualan')
@section('breadcrumb', 'Transaksi > Penjualan > Edit')

@section('styles')
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
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Penjualan</h2>
            <a href="{{ route('transaksi.index') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="{{ route('kas-masuk.update', $kasMasuk->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateStokBeforeSubmit()">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda @endif
                    </div>
                @endif

                <!-- Section 1: Informasi Transaksi -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Informasi Transaksi</h3>
                        <p>Sesuaikan detail transaksi penjualan produk Anda.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal Transaksi*</label>
                            <input type="date" name="date" value="{{ old('date', $kasMasuk->date->format('Y-m-d')) }}" class="form-control">
                        </div>

                        <div id="product-group" class="form-group">
                            <label>Produk*</label>
                            <select id="product_id" name="product_id" class="form-control" onchange="handleProductChange(this)">
                                <option value="">Pilih Produk...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-category-id="{{ $product->category_id }}" data-price="{{ (int)$product->price }}" data-unit="{{ $product->unit }}" data-stock="{{ (float)$product->stock }}" {{ old('product_id', $kasMasuk->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                            <div id="stock-info" style="display: {{ $kasMasuk->product_id ? 'block' : 'none' }}; font-size: 11px; color: #1e2a78; margin-top: 6px; font-weight: 700;">
                                Sisa stok: <span id="stock-value">{{ (int)($kasMasuk->product->stock ?? 0) }}</span> <span id="stock-unit">{{ $kasMasuk->product->unit ?? '' }}</span>
                            </div>
                        </div>

                        <input type="hidden" id="category_id" name="category_id" value="{{ old('category_id', $kasMasuk->category_id) }}">
                        <input type="hidden" id="account_id" name="account_id" value="{{ old('account_id', $kasMasuk->account_id) }}">

                        <div class="form-group full-width">
                            <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <label>QTY <span id="unit-label" style="text-transform: none; color: #64748b;">{{ $kasMasuk->product->unit ? '('.$kasMasuk->product->unit.')' : '' }}</span>*</label>
                                    <input type="number" step="1" id="quantity" name="quantity" placeholder="0" value="{{ old('quantity', (int)$kasMasuk->quantity) }}" class="form-control" oninput="calculateAmount()">
                                </div>
                                <div>
                                    <label>Harga Satuan (RP)*</label>
                                    <input type="text" id="price" name="price" placeholder="Rp 0" value="{{ old('price', (int)$kasMasuk->price) }}" class="form-control" oninput="calculateAmount()">
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>Jumlah Nominal (RP)*</label>
                            <input type="text" id="amount" name="amount" placeholder="Rp 0" value="{{ old('amount', (int)$kasMasuk->amount) }}" class="form-control" readOnly style="background-color: #f1f5f9;">
                        </div>

                        <div class="form-group full-width">
                            <label>Keterangan / Deskripsi</label>
                            <textarea name="description" placeholder="Misal: Pembayaran piutang dari Customer A" class="form-control" rows="3" style="resize: none;">{{ old('description', $kasMasuk->description) }}</textarea>
                        </div>

                        <div class="form-group full-width">
                            <label>Diterima Via*</label>
                            <select name="payment_account_id" class="form-control" required>
                                <option value="">-- Pilih Kas / Bank --</option>
                                @foreach($cashAccounts as $acc)
                                    <option value="{{ $acc->id }}" {{ old('payment_account_id', $kasMasuk->payment_account_id) == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->code }} - {{ $acc->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Lampiran Bukti -->
                @php
                    $hasFile = $kasMasuk->file_path;
                    $fileUrl = $hasFile ? Storage::url($kasMasuk->file_path) : '';
                    $fileName = $hasFile ? basename($kasMasuk->file_path) : '';
                    $fileExt = $hasFile ? strtolower(pathinfo($kasMasuk->file_path, PATHINFO_EXTENSION)) : '';
                @endphp
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Lampiran Bukti</h3>
                        <p>Unggah foto atau dokumen bukti transaksi sebagai pendukung laporan.</p>
                    </div>
                    <div class="form-group full-width">
                        <div id="upload-container" class="upload-area {{ $hasFile ? 'has-file' : '' }}" onclick="document.getElementById('file-input').click()">
                            <div id="upload-placeholder" class="upload-placeholder" style="display: {{ $hasFile ? 'none' : 'block' }}">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik untuk memilih file lampiran</p>
                                <span>Format: JPG, PNG, PDF (Maks. 2MB)</span>
                            </div>

                            <div id="file-preview-content" class="file-preview-content" style="display: {{ $hasFile ? 'block' : 'none' }}">
                                <div class="preview-file-header" onclick="event.stopPropagation()">
                                    <div class="preview-file-info">
                                        <i class="fas fa-file-alt"></i>
                                        <span id="preview-filename">{{ $fileName }}</span>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" id="btn-view-file" class="preview-btn-sm" onclick="openViewer('{{ $fileUrl }}', '{{ $fileName }}')">LIHAT</button>
                                        <a id="btn-download-file" href="{{ $fileUrl }}" download="{{ $fileName }}" class="preview-btn-sm" title="Unduh"><i class="fas fa-download"></i></a>
                                        <button type="button" class="preview-btn-sm" style="color: #ef4444;" onclick="removeFile(event)">HAPUS</button>
                                    </div>
                                </div>
                                <div class="thumbnail-container" onclick="event.stopPropagation()">
                                    <img id="image-preview" src="{{ in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? $fileUrl : '' }}" class="preview-image" style="display: {{ in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? 'block' : 'none' }}">
                                    <iframe id="pdf-frame" src="{{ $fileExt === 'pdf' ? $fileUrl . '#toolbar=0' : '' }}" class="pdf-preview-frame" style="display: {{ $fileExt === 'pdf' ? 'block' : 'none' }}"></iframe>
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
    function handleMainCategoryChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        const productGroup = document.getElementById('product-group');
        const qtyPriceGroup = document.getElementById('qty-price-group');
        const amountInput = document.getElementById('amount');
        const categoryIdInput = document.getElementById('category_id');
        
        if (select.value) {
            const isProduct = selectedOption.getAttribute('data-is-product') === '1';
            categoryIdInput.value = select.value;
            
            if (isProduct) {
                productGroup.style.display = 'block';
                qtyPriceGroup.style.display = 'block';
                amountInput.readOnly = true;
                amountInput.style.backgroundColor = '#f1f5f9';
            } else {
                productGroup.style.display = 'none';
                qtyPriceGroup.style.display = 'none';
                amountInput.readOnly = false;
                amountInput.style.backgroundColor = '#f8fafc';
                document.getElementById('product_id').value = '';
                document.getElementById('quantity').value = '';
                document.getElementById('price').value = '';
            }
        } else {
            productGroup.style.display = 'none';
            qtyPriceGroup.style.display = 'none';
            amountInput.readOnly = false;
            amountInput.style.backgroundColor = '#f8fafc';
        }
        calculateAmount();
    }

    function handleProductChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        const unitLabel = document.getElementById('unit-label');
        const priceInput = document.getElementById('price');
        const stockInfo = document.getElementById('stock-info');
        const stockValue = document.getElementById('stock-value');
        const stockUnit = document.getElementById('stock-unit');
        
        if (select.value) {
            const unit = selectedOption.getAttribute('data-unit');
            const price = selectedOption.getAttribute('data-price');
            const stock = parseFloat(selectedOption.getAttribute('data-stock') || 0);
            
            unitLabel.textContent = unit ? `(${unit})` : '';
            priceInput.value = formatNumber(price);
            
            stockValue.textContent = stock;
            stockUnit.textContent = unit;
            stockInfo.style.display = 'block';
        } else {
            unitLabel.textContent = '';
            stockInfo.style.display = 'none';
        }
        calculateAmount();
    }

    function validateStokBeforeSubmit() {
        const stockInfo = document.getElementById('stock-info');
        if (stockInfo && stockInfo.style.display !== 'none') {
            const qty = parseFloat(document.getElementById('quantity').value) || 0;
            const stockValue = parseFloat(document.getElementById('stock-value')?.textContent || 0);
            if (qty > stockValue) {
                document.getElementById('quantity').scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Tampilkan pesan error
                const qtyInput = document.getElementById('quantity');
                qtyInput.style.borderColor = '#ef4444';
                qtyInput.style.backgroundColor = '#fef2f2';
                let errMsg = document.getElementById('stock-error-msg');
                if (!errMsg) {
                    errMsg = document.createElement('div');
                    errMsg.id = 'stock-error-msg';
                    errMsg.style.cssText = 'color:#ef4444;font-size:12px;font-weight:700;margin-top:6px;';
                    qtyInput.parentNode.appendChild(errMsg);
                }
                errMsg.textContent = `⚠ Stok tidak cukup! Sisa stok: ${stockValue} kubik`;
                return false;
            }
        }
        return true;
    }

    function calculateAmount() {
        const productGroup = document.getElementById('product-group');
        if (productGroup.style.display === 'none') return;

        const qty = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseCurrency(document.getElementById('price').value) || 0;
        const total = qty * price;
        document.getElementById('amount').value = formatCurrency(total);

        // Validasi stok real-time
        const stockInfo = document.getElementById('stock-info');
        const stockValue = parseFloat(document.getElementById('stock-value')?.textContent || 0);
        const qtyInput = document.getElementById('quantity');

        if (stockInfo && stockInfo.style.display !== 'none' && qty > stockValue) {
            qtyInput.style.borderColor = '#ef4444';
            qtyInput.style.backgroundColor = '#fef2f2';
            let errMsg = document.getElementById('stock-error-msg');
            if (!errMsg) {
                errMsg = document.createElement('div');
                errMsg.id = 'stock-error-msg';
                errMsg.style.cssText = 'color:#ef4444;font-size:12px;font-weight:700;margin-top:6px;';
                qtyInput.parentNode.appendChild(errMsg);
            }
            errMsg.textContent = `⚠ Stok tidak cukup! Sisa stok: ${stockValue} kubik`;
        } else {
            if (qtyInput) {
                qtyInput.style.borderColor = '';
                qtyInput.style.backgroundColor = '';
            }
            const errMsg = document.getElementById('stock-error-msg');
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
        
        if (priceInput && priceInput.value) {
            priceInput.value = formatNumber(parseCurrency(priceInput.value));
        }
        if (amountInput && amountInput.value) {
            amountInput.value = formatCurrency(parseCurrency(amountInput.value));
        }

        if (priceInput) {
            priceInput.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    this.value = formatNumber(parseInt(value));
                }
                calculateAmount();
            });
        }
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
</script>

@include('components.file-viewer')
@endsection
