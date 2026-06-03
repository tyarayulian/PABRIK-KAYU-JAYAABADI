@extends('layouts.app')

@section('title', 'Edit Retur Penjualan')
@section('breadcrumb', 'Transaksi / Retur Penjualan / Edit')

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
        background: #f0f7ff;
        border: 1px solid #dbeafe;
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
        color: #64748b;
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
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #166534;
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
    <a href="{{ route('sales-return.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1>Edit Retur</h1>
        <p class="text-muted">Perbarui data transaksi pengembalian barang pelanggan.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Perbarui Formulir Retur</h2>
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

        @if($sale)
        <div class="info-sale">
            <div>
                <div class="info-label">Produk Terkait</div>
                <div class="info-value">{{ $sale->product ? $sale->product->name : ($sale->category->name ?? 'Penjualan Umum') }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                    Penjualan: {{ $sale->date->format('d M Y') }} | Total: Rp {{ number_format($sale->amount, 0, ',', '.') }}
                </div>
            </div>
            <div style="text-align: right;">
                <div class="info-label">Sisa Bisa Diretur</div>
                <div class="info-value" style="color: #1e2a78; font-size: 18px;">
                    {{ number_format($maxQty, 0, ',', '.') }} {{ $sale->product->unit ?? 'Unit' }}
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('sales-return.update', $salesReturn->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="sale_price" value="{{ $sale->price ?? ($salesReturn->quantity > 0 ? $salesReturn->amount / $salesReturn->quantity : 0) }}">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>TANGGAL RETUR</label>
                    <input type="date" name="date" value="{{ old('date', $salesReturn->date->format('Y-m-d')) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>JUMLAH (QTY) RETUR</label>
                    <input type="number" step="1" id="quantity" name="quantity" max="{{ $maxQty }}" placeholder="0" value="{{ old('quantity', $salesReturn->quantity) }}" class="form-control" oninput="calculateAmount()" required>
                </div>

                <div class="form-group full-width">
                    <label>NILAI RETUR (RP)</label>
                    <div class="amount-display-box" id="amount_text">Rp {{ number_format($salesReturn->amount, 0, ',', '.') }}</div>
                    <input type="hidden" id="amount" name="amount" value="{{ old('amount', $salesReturn->amount) }}">
                    @if($sale)
                    <small style="color: #94a3b8; margin-top: 8px; display: block; font-weight: 500;">
                        Dihitung ulang: Qty x Harga Jual (Rp {{ number_format($sale->price, 0, ',', '.') }})
                    </small>
                    @endif
                </div>

                <div class="form-group full-width">
                    <label>ALASAN RETUR / KETERANGAN</label>
                    <textarea name="description" placeholder="Jelaskan alasan perubahan retur..." class="form-control" rows="3" style="resize: none;">{{ old('description', $salesReturn->description) }}</textarea>
                </div>
                
                <div class="form-group full-width" style="margin-top: 20px;">
                    <button type="submit" class="btn-save">Simpan Perubahan Retur</button>
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
</script>
@endsection
