@extends('layouts.app')

@section('title', 'Tambah Retur Penjualan')
@section('breadcrumb', 'Transaksi / Retur Penjualan / Tambah')

@section('styles')
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
        align-items: center;
        gap: 20px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 8px;
    }

    .btn-back {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #f0f0f0;
        color: #1a1a1a;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateX(-3px);
        color: #1e2a78;
    }

    .card {
        background: white;
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .card-header {
        padding: 30px 40px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #000;
    }

    .card-body {
        padding: 40px;
    }

    .info-sale {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 32px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-label {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 700;
        color: #1e293b;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        box-sizing: border-box;
        outline: none;
    }

    .form-control:focus {
        border-color: #1e2a78;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05);
    }

    .btn-save {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
    }

    .btn-save:hover {
        background: #151d54;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.2);
    }

    .amount-display-box {
        background: #f0f7ff;
        border: 1px solid #dbeafe;
        color: #1e2a78;
        padding: 16px;
        border-radius: 12px;
        font-size: 24px;
        font-weight: 800;
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <a href="{{ route('sales-return.create') }}" class="btn-back" title="Ganti Penjualan">
        <i class="fas fa-chevron-left"></i>
    </a>
    <div>
        <h1>Tambah Retur</h1>
        <p class="text-muted">Lengkapi detail pengembalian barang di bawah ini.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Formulir Retur Penjualan</h2>
    </div>

    <div class="card-body">
        @if(session('error') || $errors->any())
            <div style="background-color: #fef2f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #fee2e2;">
                @if(session('error')) {{ session('error') }} @else 
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <div class="info-sale">
            <div>
                <div class="info-label">Produk / Item</div>
                <div class="info-value">{{ $sale->product ? $sale->product->name : ($sale->category->name ?? 'Penjualan Umum') }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                    {{ $sale->date->format('d M Y') }} | Total: Rp {{ number_format($sale->amount, 0, ',', '.') }}
                </div>
            </div>
            <div style="text-align: right;">
                <div class="info-label">Maksimal Retur</div>
                <div class="info-value" style="color: #1e2a78; font-size: 18px;">
                    {{ number_format($maxQty, 0, ',', '.') }} {{ $sale->product->unit ?? 'Unit' }}
                </div>
            </div>
        </div>

        <form action="{{ route('sales-return.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kas_masuk_id" value="{{ $sale->id }}">
            <input type="hidden" id="sale_price" value="{{ $sale->price }}">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>TANGGAL RETUR</label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>JUMLAH (QTY) RETUR</label>
                    <input type="number" step="1" id="quantity" name="quantity" max="{{ $maxQty }}" placeholder="0" value="{{ old('quantity') }}" class="form-control" oninput="calculateAmount()" required>
                </div>

                <div class="form-group full-width">
                    <label>ESTIMASI NILAI RETUR (RP)</label>
                    <div class="amount-display-box" id="amount_text">Rp 0</div>
                    <input type="hidden" id="amount" name="amount" value="{{ old('amount') }}">
                    <small style="color: #94a3b8; margin-top: 8px; display: block; font-weight: 500;">
                        Otomatis: Qty x Harga Jual Asli (Rp {{ number_format($sale->price, 0, ',', '.') }})
                    </small>
                </div>

                <div class="form-group full-width">
                    <label>ALASAN RETUR / KETERANGAN</label>
                    <textarea name="description" placeholder="Jelaskan alasan pengembalian (misal: barang cacat)..." class="form-control" rows="3" style="resize: none;">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group full-width" style="margin-top: 20px;">
                    <button type="submit" class="btn-save">Simpan Transaksi Retur</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function calculateAmount() {
        const qty = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseFloat(document.getElementById('sale_price').value) || 0;
        const total = qty * price;
        document.getElementById('amount_text').innerText = formatCurrency(total);
        document.getElementById('amount').value = total;
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value).replace('Rp', 'Rp ');
    }

    window.onload = function() {
        if(document.getElementById('quantity').value) {
            calculateAmount();
        }
    };
</script>
@endsection
