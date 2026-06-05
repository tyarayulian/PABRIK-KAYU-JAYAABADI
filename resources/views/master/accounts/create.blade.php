@extends('layouts.app')

@section('title', 'Tambah Akun COA')
@section('breadcrumb', 'Master Data > Akun > Tambah')

@section('styles')
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
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Identitas Akun</h3>
                        <p>Tentukan kode akun, nama akun, dan kategori sesuai dengan Chart of Accounts standar akuntansi.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Kode Akun*</label>
                            <input type="text" 
                                   name="code" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" 
                                   placeholder="Contoh: 1101"
                                   required
                                   autofocus>
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
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
