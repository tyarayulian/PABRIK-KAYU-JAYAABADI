@extends('layouts.app')

@section('title', 'Tambah Akun COA')
@section('breadcrumb', 'Master Data > Akun > Tambah')

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
    .form-control.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
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
    }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30, 42, 120, 0.2); }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Akun COA Baru</h2>
            <a href="{{ route('master.accounts') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="{{ route('master.accounts.store') }}" method="POST">
            @csrf
            
            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda @endif
                    </div>
                @endif

                <!-- Section 1: Identitas Akun -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Identitas Akun</h3>
                        <p>Tentukan kode akun, nama akun, dan kategori sesuai dengan Chart of Accounts standar akuntansi.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Kode Akun*</label>
                            <input type="text" 
                                   name="code" 
                                   id="code"
                                   class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" 
                                   placeholder="Contoh: 1101"
                                   required
                                   autofocus
                                   inputmode="numeric"
                                   pattern="[0-9]*">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori Akun*</label>
                            <select name="type" 
                                    class="form-control @error('type') is-invalid @enderror" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="asset" {{ old('type') == 'asset' ? 'selected' : '' }}>Asset (Aktiva)</option>
                                <option value="liability" {{ old('type') == 'liability' ? 'selected' : '' }}>Liability (Kewajiban)</option>
                                <option value="equity" {{ old('type') == 'equity' ? 'selected' : '' }}>Equity (Modal)</option>
                                <option value="revenue" {{ old('type') == 'revenue' ? 'selected' : '' }}>Revenue (Pendapatan)</option>
                                <option value="cogs" {{ old('type') == 'cogs' ? 'selected' : '' }}>COGS (Harga Pokok Penjualan)</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense (Beban)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label>Nama Akun*</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Contoh: Kas Utama"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Saldo Awal -->
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Saldo Awal</h3>
                        <p>Isi saldo awal akun sebelum sistem mulai digunakan.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nominal Saldo Awal (Rp)</label>
                            <input type="text" 
                                   id="opening_balance"
                                   name="opening_balance" 
                                   class="form-control" 
                                   value="{{ old('opening_balance') }}" 
                                   placeholder="Contoh: 50.000.000"
                                   inputmode="numeric"
                                   pattern="[0-9.]*">
                            <small style="color: #94a3b8; font-size: 11px; margin-top: 6px; display: block;">Kosongkan jika tidak ada saldo awal</small>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Saldo Awal</label>
                            <input type="date" 
                                   name="opening_balance_date" 
                                   class="form-control" 
                                   value="{{ old('opening_balance_date', date('Y-m-d')) }}"
                                   placeholder="Tanggal mulai saldo">
                            <small style="color: #94a3b8; font-size: 11px; margin-top: 6px; display: block;">Tanggal saat saldo awal berlaku</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Kode Akun - hanya angka
    const codeInput = document.getElementById('code');
    if (codeInput) {
        codeInput.addEventListener('keypress', function (e) {
            if ([8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        codeInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        codeInput.addEventListener('paste', function (e) {
            e.preventDefault();
            let pastedData = (e.clipboardData || window.clipboardData).getData('text');
            let numericValue = pastedData.replace(/[^0-9]/g, '');
            this.value = numericValue;
        });
    }

    // Opening Balance - format ribuan
    const input = document.getElementById('opening_balance');
    if (!input) return;

    function formatNumber(v) {
        return v ? new Intl.NumberFormat('id-ID').format(v) : '';
    }
    function parseNumber(v) {
        return parseInt(v.toString().replace(/[^0-9]/g, '')) || 0;
    }

    if (input.value) input.value = formatNumber(parseNumber(input.value));

    // Prevent non-numeric input
    input.addEventListener('keypress', function (e) {
        // Allow: backspace, delete, tab, escape, enter, and .
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

    input.addEventListener('input', function () {
        let v = this.value.replace(/[^0-9]/g, '');
        if (v) this.value = formatNumber(parseInt(v));
        else this.value = '';
    });

    // Handle paste event
    input.addEventListener('paste', function (e) {
        e.preventDefault();
        let pastedData = (e.clipboardData || window.clipboardData).getData('text');
        let numericValue = pastedData.replace(/[^0-9]/g, '');
        if (numericValue) {
            this.value = formatNumber(parseInt(numericValue));
        }
    });

    input.closest('form').addEventListener('submit', function () {
        input.value = parseNumber(input.value) || 0;
    });
});
</script>
@endsection
