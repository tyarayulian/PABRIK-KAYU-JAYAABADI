@extends('layouts.app')

@section('title', 'Edit Kas Masuk')
@section('breadcrumb', 'Transaksi Kas > Pemasukan > Edit')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    .btn-back {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: white;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #1e2a78;
        color: #1e2a78;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin: 0;
    }

    .card {
        background: white;
        border-radius: 24px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        padding: 24px 32px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .btn-cancel-header {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cancel-header:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .card-body {
        padding: 32px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #334155;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1e2a78;
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.1);
    }

    .form-group small {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-top: 4px;
    }

    .card-footer {
        padding: 24px 32px;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-save {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(30, 42, 120, 0.2);
    }

    .btn-save:hover {
        background: #16205a;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-label {
        display: block;
        padding: 12px;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fafb;
        color: #64748b;
    }

    .file-input-label:hover {
        border-color: #1e2a78;
        background: #f0f7ff;
        color: #1e2a78;
    }

    #file_path {
        display: none;
    }

    .current-file {
        margin-top: 12px;
        padding: 12px;
        background: #f0f7ff;
        border: 1px solid #e0e7ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #1e2a78;
    }
</style>
@endsection

@section('content')
<div style="padding: 0 20px 40px 20px;">
    <div class="page-header">
        <a href="{{ route('cash.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Edit Kas Masuk</h1>
            <p style="font-size: 14px; color: #666; margin: 4px 0 0 0;">Perbarui data transaksi pemasukan kas</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Edit Pemasukan</h2>
            <a href="{{ route('cash.index') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

        <form action="{{ route('cash.in.update', $kasMasuk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Tanggal Transaksi*</label>
                    <input type="date" name="date" value="{{ old('date', $kasMasuk->date->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Kategori*</label>
                    <select name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $kasMasuk->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Keterangan*</label>
                    <textarea name="description" required>{{ old('description', $kasMasuk->description) }}</textarea>
                    <small>Deskripsikan detail transaksi pemasukan</small>
                </div>

                <div class="form-group">
                    <label>Jumlah (Rp)*</label>
                    <input type="number" name="amount" value="{{ old('amount', $kasMasuk->amount) }}" required min="1" step="0.01">
                    <small>Masukkan nominal transaksi</small>
                </div>

                <div class="form-group">
                    <label>Lampiran File (Optional)</label>
                    @php
                        $hasFile = $kasMasuk->file_path;
                        $fileUrl = $hasFile ? asset('storage/' . $kasMasuk->file_path) : '';
                        $fileName = $hasFile ? basename($kasMasuk->file_path) : '';
                        $fileExt = $hasFile ? strtolower(pathinfo($kasMasuk->file_path, PATHINFO_EXTENSION)) : '';
                        $isImage = in_array($fileExt, ['jpg','jpeg','png','gif','webp']);
                        $isPdf = $fileExt === 'pdf';
                    @endphp
                    
                    <div id="upload-container" class="upload-area {{ $hasFile ? 'has-file' : '' }}" onclick="document.getElementById('file_path').click()" style="border: 2px dashed #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.2s; background: #f8fafc;">
                        <div id="upload-placeholder" class="upload-placeholder" style="display: {{ $hasFile ? 'none' : 'block' }}">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #94a3b8; margin-bottom: 8px;"></i>
                            <p style="margin: 8px 0 4px 0; font-weight: 600; color: #1e293b;">Klik untuk upload file</p>
                            <small style="color: #64748b;">Format: JPG, PNG, PDF (Max: 2MB)</small>
                        </div>

                        @if($hasFile)
                        <div id="file-preview-content" class="file-preview-content" style="display: block;">
                            <div class="preview-file-header" onclick="event.stopPropagation()" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <div class="preview-file-info" style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-file-alt" style="color: #1e2a78; font-size: 18px;"></i>
                                    <span id="preview-filename" style="font-size: 13px; font-weight: 600; color: #1e293b;">{{ $fileName }}</span>
                                </div>
                                <div class="preview-actions" style="display: flex; gap: 6px;">
                                    <button type="button" onclick="event.stopPropagation(); openViewer('{{ $fileUrl }}', '{{ $fileName }}')" style="background: #1e2a78; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">LIHAT</button>
                                    <a href="{{ $fileUrl }}" download="{{ $fileName }}" onclick="event.stopPropagation()" style="background: #f1f5f9; color: #64748b; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;"><i class="fas fa-download"></i></a>
                                </div>
                            </div>
                            <div class="thumbnail-container" onclick="event.stopPropagation()" style="max-height: 200px; overflow: hidden; border-radius: 8px; background: #fff;">
                                @if($isImage)
                                    <img src="{{ $fileUrl }}" style="width: 100%; height: auto; display: block; object-fit: contain;">
                                @elseif($isPdf)
                                    <div style="padding: 40px; text-align: center; background: #fef2f2;">
                                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #dc2626;"></i>
                                        <p style="margin-top: 12px; color: #1e293b; font-weight: 600;">Dokumen PDF</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" id="file_path" name="file_path" accept="image/*,application/pdf" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Update Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file_path').addEventListener('change', function(e) {
        const label = document.querySelector('.file-input-label');
        if (e.target.files.length > 0) {
            label.innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 24px; margin-bottom: 8px; color: #1e2a78;"></i>
                <div style="color: #1e2a78; font-weight: 600;">${e.target.files[0].name}</div>
                <small style="display: block; margin-top: 4px;">Klik untuk ganti file</small>
            `;
        }
    });
</script>

@include('components.file-viewer')

@endsection
