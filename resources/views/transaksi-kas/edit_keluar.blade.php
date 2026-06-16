@extends('layouts.app')

@section('title', 'Edit Pengeluaran')
@section('breadcrumb', 'Transaksi Kas > Pengeluaran > Edit')

@section('styles')
<style>
    .page-container { padding: 40px 24px; background-color: #f8fafc; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
    .card { background: white; border-radius: 24px; padding: 0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); width: 100%; border: 1px solid #f1f5f9; overflow: hidden; }
    .card-header { padding: 32px 48px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
    .card-header h2 { margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
    .btn-cancel-header { color: #64748b; text-decoration: none; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 6px; transition: 0.2s; }
    .btn-cancel-header:hover { color: #0f172a; }
    .card-body { padding: 48px; }
    .form-section { display: grid; grid-template-columns: 280px 1fr; gap: 48px; margin-bottom: 48px; }
    .section-info h3 { margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .section-info p { margin: 0; font-size: 14px; color: #64748b; line-height: 1.6; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { position: relative; }
    .form-group.full-width { grid-column: span 2; }
    .form-group label { display: block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 12px; text-transform: uppercase; }
    .form-control { width: 100%; padding: 14px 16px; border: 1.5px solid #f1f5f9; border-radius: 12px; font-size: 14px; font-weight: 500; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; background-color: #f8fafc; transition: all 0.2s ease; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #1e2a78; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05); }

    .upload-area { border: 2px dashed #e2e8f0; border-radius: 12px; padding: 40px 32px; text-align: center; cursor: pointer; background: #f8fafc; transition: 0.2s; position: relative; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .upload-area:hover { border-color: #1e2a78; background: #f1f5f9; }
    .upload-area.has-file { border-style: solid; border-color: #1e2a78; background: white; padding: 20px; }
    .upload-placeholder i { font-size: 32px; color: #1e2a78; margin-bottom: 12px; }
    .upload-placeholder p { margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; }
    .file-preview-content { display: none; width: 100%; }
    .preview-file-header { display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; }
    .preview-file-info { display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 700; color: #0f172a; }
    .preview-file-info i { color: #1e2a78; font-size: 18px; }
    .preview-actions { display: flex; gap: 8px; }
    .preview-btn-sm { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; background: white; color: #1e2a78; border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s; }
    .thumbnail-container { width: 100%; border-radius: 10px; overflow: hidden; border: 1px solid #f1f5f9; }
    .preview-image { max-width: 100%; max-height: 300px; display: block; margin: 0 auto; }
    .pdf-preview-frame { width: 100%; height: 400px; border: none; }

    .card-footer { padding: 32px 48px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 16px; }
    .btn-save { background: #dc2626; color: white; border: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: all 0.2s ease; }
    .btn-save:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2); }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Pengeluaran Kas</h2>
            <a href="{{ route('cash.index') }}" class="btn-cancel-header">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

        <form action="{{ route('cash.out.update', $kasKeluar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background-color: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-size: 14px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda @endif
                    </div>
                @endif

                <div class="form-section">
                    <div class="section-info">
                        <h3>Informasi Pengeluaran</h3>
                        <p>Sesuaikan detail transaksi pengeluaran kas.</p>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal*</label>
                            <input type="date" name="date" value="{{ old('date', $kasKeluar->date->format('Y-m-d')) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori Pengeluaran*</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $kasKeluar->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label>Jumlah (Rp)*</label>
                            <input type="text" id="amount" name="amount" placeholder="Rp 0" value="{{ old('amount', (int)$kasKeluar->amount) }}" class="form-control" required>
                        </div>

                        <div class="form-group full-width">
                            <label>Keterangan / Deskripsi</label>
                            <textarea name="description" placeholder="Contoh: Pembelian alat tulis kantor" class="form-control" rows="3" style="resize: none;">{{ old('description', $kasKeluar->description) }}</textarea>
                        </div>

                        <div class="form-group full-width">
                            <label>Dibayar Via*</label>
                            <select name="payment_account_id" class="form-control" required>
                                <option value="">-- Pilih Kas / Bank --</option>
                                @foreach($cashAccounts as $acc)
                                    <option value="{{ $acc->id }}" {{ old('payment_account_id', $kasKeluar->payment_account_id) == $acc->id ? 'selected' : '' }}>
                                        {{ $acc->code }} - {{ $acc->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @php
                    $hasFile = $kasKeluar->file_path;
                    $fileUrl = $hasFile ? Storage::url($kasKeluar->file_path) : '';
                    $fileName = $hasFile ? basename($kasKeluar->file_path) : '';
                    $fileExt = $hasFile ? strtolower(pathinfo($kasKeluar->file_path, PATHINFO_EXTENSION)) : '';
                @endphp
                <div class="form-section" style="margin-bottom: 0;">
                    <div class="section-info">
                        <h3>Lampiran Bukti</h3>
                        <p>Unggah foto atau dokumen bukti transaksi (opsional).</p>
                    </div>
                    <div class="form-group full-width">
                        <div id="upload-container" class="upload-area {{ $hasFile ? 'has-file' : '' }}" onclick="document.getElementById('file-input').click()">
                            <div id="upload-placeholder" class="upload-placeholder" style="display: {{ $hasFile ? 'none' : 'block' }}">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik untuk memilih file lampiran</p>
                            </div>
                            <div id="file-preview-content" class="file-preview-content" style="display: {{ $hasFile ? 'block' : 'none' }}">
                                <div class="preview-file-header" onclick="event.stopPropagation()">
                                    <div class="preview-file-info">
                                        <i class="fas fa-file-alt"></i>
                                        <span id="preview-filename">{{ $fileName }}</span>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" class="preview-btn-sm" onclick="openViewer('{{ $fileUrl }}', '{{ $fileName }}')">LIHAT</button>
                                        <a href="{{ $fileUrl }}" download="{{ $fileName }}" class="preview-btn-sm"><i class="fas fa-download"></i></a>
                                        <button type="button" class="preview-btn-sm" style="color: #ef4444;" onclick="removeFile(event)">HAPUS</button>
                                    </div>
                                </div>
                                <div class="thumbnail-container" onclick="event.stopPropagation()">
                                    <img id="image-preview" src="{{ in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? $fileUrl : '' }}" class="preview-image" style="display: {{ in_array($fileExt, ['jpg','jpeg','png','gif','webp']) ? 'block' : 'none' }}">
                                    <iframe id="pdf-frame" src="{{ $fileExt === 'pdf' ? $fileUrl.'#toolbar=0' : '' }}" class="pdf-preview-frame" style="display: {{ $fileExt === 'pdf' ? 'block' : 'none' }}"></iframe>
                                </div>
                            </div>
                            <input type="file" id="file-input" name="file" accept="image/*,.pdf" style="display: none;" onchange="handleFileSelect(this)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-save">Update Pengeluaran</button>
            </div>
        </form>
    </div>
</div>

<script>
    const amountInput = document.getElementById('amount');
    function formatNumber(v) { return v ? new Intl.NumberFormat('id-ID').format(v) : ''; }
    function parseCurrency(v) { return v ? parseInt(v.toString().replace(/[^0-9]/g, '')) || 0 : 0; }

    document.addEventListener('DOMContentLoaded', function () {
        if (amountInput.value) amountInput.value = formatNumber(parseCurrency(amountInput.value));
        amountInput.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) this.value = formatNumber(parseInt(value));
        });
    });
    amountInput.closest('form').addEventListener('submit', function () {
        amountInput.value = parseCurrency(amountInput.value);
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
            filenameSpan.textContent = `${file.name} (${(file.size / 1048576).toFixed(2)} MB)`;
            const fileUrl = URL.createObjectURL(file);
            if (btnView) { btnView.onclick = (e) => { e.preventDefault(); e.stopPropagation(); openViewer(fileUrl, file.name); }; }
            if (btnDownload) { btnDownload.onclick = (e) => e.stopPropagation(); btnDownload.href = fileUrl; btnDownload.download = file.name; }
            if (file.type.startsWith('image/')) { imgPreview.src = fileUrl; imgPreview.style.display = 'block'; pdfFrame.style.display = 'none'; }
            else if (file.type === 'application/pdf') { imgPreview.style.display = 'none'; pdfFrame.style.display = 'block'; pdfFrame.src = fileUrl + '#toolbar=0'; }
            placeholder.style.display = 'none';
            previewContent.style.display = 'block';
            uploadArea.classList.add('has-file');
        }
    }
    function removeFile(event) {
        event.stopPropagation();
        document.getElementById('file-input').value = '';
        document.getElementById('upload-placeholder').style.display = 'flex';
        document.getElementById('file-preview-content').style.display = 'none';
        document.getElementById('upload-container').classList.remove('has-file');
        document.getElementById('image-preview').src = '';
        document.getElementById('pdf-frame').src = '';
    }
</script>
@include('components.file-viewer')
@endsection
