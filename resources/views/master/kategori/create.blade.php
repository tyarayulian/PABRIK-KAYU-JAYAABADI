@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('breadcrumb', 'Master Data > Kategori > Tambah')

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
            <h2>Tambah Kategori Baru</h2>
            <a href="{{ route('master.categories') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
        
        <form action="{{ route('master.categories.store') }}" method="POST">
            @csrf
            
            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda @endif
                    </div>
                @endif

                <!-- Section 1: Identitas Kategori -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Identitas Kategori</h3>
                        <p>Tentukan nama kategori dan tipe transaksi kas yang akan menggunakan kategori ini.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Nama Kategori*</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Pendapatan Lain-lain" required autofocus>
                        </div>

                        <div class="form-group full-width">
                            <label>Tipe Transaksi*</label>
                            <select name="type" class="form-control" required>
                                <option value="cash_in" {{ old('type') == 'cash_in' ? 'selected' : '' }}>Pemasukan Kas (Cash In)</option>
                                <option value="cash_out" {{ old('type') == 'cash_out' ? 'selected' : '' }}>Pengeluaran Kas (Cash Out)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pemetaan Akun -->
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Pemetaan Akun (COA)</h3>
                        <p>Hubungkan kategori ini dengan akun COA yang sesuai untuk pencatatan jurnal otomatis.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Pilih Akun*</label>
                            <select name="account_id" class="form-control">
                                <option value="">-- Pilih Akun --</option>
                                @foreach($allAccounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->code }} - {{ $account->name }} ({{ ucfirst($account->type) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
