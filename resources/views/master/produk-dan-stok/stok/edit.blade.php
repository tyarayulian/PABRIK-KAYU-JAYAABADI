@extends('layouts.app')

@section('title', 'Edit History Stok: ' . $product->name)
@section('breadcrumb', 'Master Data > Produk > Edit History Stok')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        font-weight: 800; 
        color: #334155; 
        font-size: 12px;
        text-transform: uppercase;
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
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Edit History Stok: {{ $product->name }}</h2>
            <a href="{{ route('master.products.index') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="{{ route('master.products.update-stock', $stock->id) }}" method="POST" onsubmit="return stripFormattingBeforeSubmit(this)">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda @endif
                    </div>
                @endif

                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Detail History Stok</h3>
                        <p>Edit data riwayat stok produk.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Keterangan*</label>
                            <input type="text" name="description" class="form-control" value="{{ old('description', $stock->description) }}" placeholder="Contoh: Penyesuaian stok awal" required autofocus>
                        </div>

                        <div class="form-group">
                            <label>Tanggal*</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', $stock->date->format('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label>QTY / Kubik*</label>
                            <input type="text" inputmode="decimal" name="quantity" class="form-control" value="{{ old('quantity', (float)$stock->quantity) }}" placeholder="0" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label>Harga Pembelian (Satuan)*</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', (int)$stock->price) }}" placeholder="Rp 0" required>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('price');
        const quantityInput = document.querySelector('input[name="quantity"]');
        const descriptionInput = document.querySelector('input[name="description"]');
        const dateInput = document.querySelector('input[name="date"]');
        
        const formatValue = (val) => {
            let value = val.toString().replace(/[^0-9]/g, '');
            if (value) {
                return formatCurrency(parseInt(value));
            }
            return '';
        };

        function formatCurrency(value) {
            if (!value) return '';
            let val = String(value).replace(/\D/g, '');
            if (!val) return '';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
        }

        // Initialize price format
        if (priceInput.value) {
            priceInput.value = formatValue(priceInput.value);
        }

        // Validation for Description
        if (descriptionInput) {
            descriptionInput.addEventListener('invalid', function() {
                this.setCustomValidity('Keterangan wajib diisi (contoh: Penyesuaian stok awal)');
            });
            descriptionInput.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }

        // Validation for Date
        if (dateInput) {
            dateInput.addEventListener('invalid', function() {
                this.setCustomValidity('Tanggal wajib dipilih');
            });
            dateInput.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }

        // Validation for QTY
        if (quantityInput) {
            // Prevent non-numeric keypress (allow decimal point)
            quantityInput.addEventListener('keypress', function (e) {
                // Allow: backspace, delete, tab, escape, enter, decimal point
                if ([8, 9, 27, 13, 46, 110, 190].indexOf(e.keyCode) !== -1 ||
                    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true)) {
                    return;
                }
                // Ensure that it is a number and stop the keypress if not
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

            quantityInput.addEventListener('input', function() {
                // Allow only numbers and one decimal point
                let value = this.value.replace(/[^0-9.]/g, '');
                // Prevent multiple decimal points
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                this.value = value;
                this.setCustomValidity('');
            });

            // Handle paste event
            quantityInput.addEventListener('paste', function (e) {
                e.preventDefault();
                let pastedData = (e.clipboardData || window.clipboardData).getData('text');
                let numericValue = pastedData.replace(/[^0-9.]/g, '');
                // Prevent multiple decimal points
                const parts = numericValue.split('.');
                if (parts.length > 2) {
                    numericValue = parts[0] + '.' + parts.slice(1).join('');
                }
                this.value = numericValue;
            });

            quantityInput.addEventListener('invalid', function() {
                this.setCustomValidity('QTY wajib diisi dengan angka yang valid (contoh: 10 atau 10.5)');
            });
        }

        // Validation for HPP (Price)
        // Prevent non-numeric keypress
        priceInput.addEventListener('keypress', function (e) {
            // Allow: backspace, delete, tab, escape, enter
            if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            // Ensure that it is a number and stop the keypress if not
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        priceInput.addEventListener('input', function(e) {
            this.value = formatValue(this.value);
            this.setCustomValidity('');
        });

        // Handle paste event
        priceInput.addEventListener('paste', function (e) {
            e.preventDefault();
            let pastedData = (e.clipboardData || window.clipboardData).getData('text');
            let numericValue = pastedData.replace(/[^0-9]/g, '');
            if (numericValue) {
                this.value = formatCurrency(parseInt(numericValue));
            }
        });

        priceInput.addEventListener('invalid', function() {
            this.setCustomValidity('HPP wajib diisi dengan angka yang valid (contoh: Rp 1.000.000)');
        });
    });

    function stripFormattingBeforeSubmit(form) {
        const priceInput = form.querySelector('#price');
        const quantityInput = form.querySelector('input[name="quantity"]');
        
        if (priceInput) {
            priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
        }
        if (quantityInput) {
            quantityInput.value = quantityInput.value.replace(',', '.');
        }
        return true;
    }
</script>
@endsection
