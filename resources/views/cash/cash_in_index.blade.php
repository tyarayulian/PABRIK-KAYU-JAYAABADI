@extends('layouts.app')

@section('title', 'Penjualan')
@section('breadcrumb', 'Penjualan')

@section('styles')
<style>
    body {
        background: #f8fafc;
    }

    .page-content {
        background: #f8fafc;
        padding: 40px;
        border-radius: 0;
    }

    .page-header {
        padding: 0 0 24px 0;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 6px 0;
        letter-spacing: -0.5px;
    }

    .page-header p {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        /* NO BLUR */
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 24px;
        color: #111827;
        font-weight: 700;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #f3f4f6;
        color: #111827;
        border-radius: 6px;
    }

    .modal-body {
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #8b6f47;
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group textarea[required] {
        border-color: #8b6f47;
    }

    .form-group textarea[required]:focus {
        border-color: #8b6f47;
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .form-group small {
        display: inline-block;
        color: #6b7280;
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 10px 20px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background-color: #ffffff;
        color: #6b7280;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #8b6f47;
        color: white;
    }

    .btn-primary:hover {
        background: #7a5e3a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 111, 71, 0.2);
    }

    table thead tr {
        background-color: #fdfaf7;
        border-bottom: 1px solid #e5e7eb;
    }

    table thead th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #8b6f47;
        font-size: 14px;
    }

    table tbody tr {
        border-bottom: 1px solid #e5e7eb;
    }

    table tbody td {
        padding: 12px;
        color: #6b7280;
    }

    .notification-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 2000;
        background: #fdfaf7;
        color: #8b6f47;
        padding: 16px 20px;
        border-radius: 8px;
        border-left: 4px solid #8b6f47;
        box-shadow: 0 4px 12px rgba(139, 111, 71, 0.15);
        animation: slideIn 0.3s ease-out;
        font-weight: 600;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 14px;
        max-width: 450px;
    }

    .notification-toast.error {
        background: #fef2f2;
        color: #dc2626;
        border-left-color: #ef4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
    }

    .toast-icon {
        width: 32px;
        height: 32px;
        background: #8b6f47;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-toast.error .toast-icon {
        background: #ef4444;
    }

    .checkmark-icon {
        width: 18px;
        height: 18px;
        color: white;
        stroke: white;
    }

    .toast-close {
        background: none;
        border: none;
        color: #8b6f47;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .toast-close:hover {
        color: #7a5e3a;
        transform: scale(1.1);
    }

    .notification-toast.error .toast-close {
        color: #dc2626;
    }

    .notification-toast.error .toast-close:hover {
        color: #991b1b;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
</style>
@endsection

@section('content')
<div id="notificationToast" class="notification-toast" style="display: none;">
    <div class="toast-icon">
        <svg class="checkmark-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="toast-content">
        <span id="toastMessage"></span>
    </div>
    <button class="toast-close" onclick="closeNotification()">&times;</button>
</div>

<div class="page-header">
    <h1>Pencatatan Penjualan</h1>
    <p>Catat semua penerimaan kas untuk operasional pabrik kayu</p>
</div>

<div style="margin-bottom: 25px;">
    <button class="btn btn-primary" onclick="openModal('addCashInModal')">+ Tambah Penjualan</button>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px; color: #111827; font-size: 18px; font-weight: 600;">Daftar Penjualan</h2>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: left;">Tanggal</th>
                <th style="text-align: left;">Akun</th>
                <th style="text-align: left;">Deskripsi</th>
                <th style="text-align: right;">Jumlah</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashIns as $cashIn)
                <tr>
                    <td>{{ $cashIn->date->format('d/m/Y') }}</td>
                    <td>{{ $cashIn->account->code ?? '?' }} - {{ $cashIn->account->name ?? 'N/A' }}</td>
                    <td>{{ $cashIn->description ?? '-' }}</td>
                    <td style="text-align: right; font-weight: 600;">Rp {{ number_format($cashIn->amount, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <button type="button" onclick="deleteCashIn({{ $cashIn->id }})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-size: 12px; transition: all 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #9ca3af;">
                        Belum ada pencatatan kas masuk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="addCashInModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Penjualan</h2>
            <button class="modal-close" onclick="closeModal('addCashInModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="cashInForm">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="date" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori Penerimaan</label>
                    <select id="category" name="category_id" required onchange="updateDescriptionLabel()">
                        <option value="">-- Pilih Kategori --</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}" data-code="{{ $category->account->code ?? '' }}" data-name="{{ $category->account->name ?? '' }}" data-account-id="{{ $category->account_id }}">
                                {{ $category->name }}{{ $category->account ? ' (' . $category->account->code . ')' : '' }}
                            </option>
                        @empty
                            <option value="">Tidak ada kategori</option>
                        @endforelse
                    </select>
                </div>
                <input type="hidden" id="accountId" name="account_id" value="">
                <div class="form-group">
                    <label for="deskripsi" id="descriptionLabel">Keterangan / Deskripsi</label>
                    <textarea id="deskripsi" name="description" placeholder="Masukkan keterangan..." style="min-height: 100px;"></textarea>
                    <small id="descriptionHint" style="color: #666; font-size: 12px; display: none; margin-top: 5px;">
                        ⚠️ Silakan isi jenis jasa apa yang Anda terima
                    </small>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" id="jumlah" name="amount" placeholder="0" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="file">Lampiran (Opsional)</label>
                    <input type="file" id="file" name="file" accept=".jpeg,.png,.jpg,.pdf">
                    <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                        Format: JPEG, PNG, JPG, PDF (Max. 2MB)
                    </small>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('addCashInModal')">Batal</button>
            <button class="btn btn-primary" onclick="saveCashIn()">Simpan</button>
        </div>
    </div>
</div>

<script>
    let notificationTimeout;

    function showNotification(message, isError = false) {
        const toast = document.getElementById('notificationToast');
        const toastMessage = document.getElementById('toastMessage');
        
        clearTimeout(notificationTimeout);
        
        toast.classList.remove('error');
        if (isError) {
            toast.classList.add('error');
        }
        
        toastMessage.textContent = message;
        toast.style.display = 'flex';
        
        notificationTimeout = setTimeout(() => {
            closeNotification();
        }, 8000);
    }

    function closeNotification() {
        const toast = document.getElementById('notificationToast');
        clearTimeout(notificationTimeout);
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            toast.style.display = 'none';
            toast.style.animation = 'slideIn 0.3s ease-out';
        }, 300);
    }

    const jasaLainnnyaAccountNames = ['Jasa Lainnya', 'Pendapatan Lainnya', 'Revenue Lainnya'];

    function updateDescriptionLabel() {
        const selectElement = document.getElementById('category');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';
        const selectedCode = selectedOption.dataset.code || '';
        const accountId = selectedOption.dataset.accountId || '';
        const descriptionLabel = document.getElementById('descriptionLabel');
        const descriptionHint = document.getElementById('descriptionHint');
        const descriptionField = document.getElementById('deskripsi');
        const accountIdField = document.getElementById('accountId');

        accountIdField.value = accountId;

        if (jasaLainnnyaAccountNames.some(name => selectedName.includes(name))) {
            descriptionLabel.textContent = 'Jenis Jasa (Wajib Diisi) *';
            descriptionHint.style.display = 'block';
            descriptionField.placeholder = 'Contoh: Jasa Reparasi, Jasa Konsultasi, dll';
            descriptionField.required = true;
            descriptionField.style.borderColor = '#ffc107';
        } else if (selectedCode === '4100' || selectedName.includes('Penjualan')) {
            descriptionLabel.textContent = 'Detail Penjualan (Opsional)';
            descriptionHint.style.display = 'none';
            descriptionField.placeholder = 'Masukkan detail produk atau deskripsi...';
            descriptionField.required = false;
            descriptionField.style.borderColor = '';
        } else {
            descriptionLabel.textContent = 'Keterangan / Deskripsi';
            descriptionHint.style.display = 'none';
            descriptionField.placeholder = 'Masukkan keterangan...';
            descriptionField.required = false;
            descriptionField.style.borderColor = '';
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function saveCashIn() {
        const form = document.getElementById('cashInForm');
        const descriptionField = document.getElementById('deskripsi');
        const selectElement = document.getElementById('category');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';

        if (!selectElement.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan pilih kategori penerimaan terlebih dahulu!',
                background: '#ffffff',
                color: '#111827'
            });
            selectElement.focus();
            return;
        }

        if (jasaLainnnyaAccountNames.some(name => selectedName.includes(name)) && !descriptionField.value.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan isi jenis jasa terlebih dahulu!',
                background: '#ffffff',
                color: '#111827'
            });
            descriptionField.focus();
            return;
        }

        const formData = new FormData(form);

        fetch('{{ route("cash.in.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Gagal menyimpan data');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification(data.message);
                closeModal('addCashInModal');
                form.reset();
                setTimeout(() => location.reload(), 8300);
            } else {
                showNotification(data.message || 'Terjadi kesalahan saat menyimpan', true);
            }
        })
        .catch(error => {
            showNotification('Error: ' + error.message, true);
            console.error('Detailed error:', error);
        });
    }

    window.onclick = function(event) {
        const modal = document.getElementById('addCashInModal');
        if (event.target === modal) {
            closeModal('addCashInModal');
        }
    }

    function deleteCashIn(id) {
        if (typeof Modal !== 'undefined') {
            Modal.delete('pencatatan kas masuk ini', function() {
                // Use POST with _method=DELETE
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('_method', 'DELETE');
                
                fetch('{{ route("cash.in.destroy", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Gagal menghapus data');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (typeof Toast !== 'undefined') {
                            Toast.success(data.message);
                        } else {
                            showNotification(data.message);
                        }
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        if (typeof Toast !== 'undefined') {
                            Toast.error(data.message || 'Terjadi kesalahan');
                        } else {
                            showNotification(data.message || 'Terjadi kesalahan', true);
                        }
                    }
                })
                .catch(error => {
                    if (typeof Toast !== 'undefined') {
                        Toast.error('Error: ' + error.message);
                    } else {
                        showNotification('Error: ' + error.message, true);
                    }
                });
            });
        } else {
            // Fallback
            if (confirm('Apakah Anda yakin ingin menghapus pencatatan kas masuk ini?')) {
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('_method', 'DELETE');
                
                fetch('{{ route("cash.in.destroy", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    }
                })
                .catch(error => alert('Error: ' + error.message));
            }
        }
    }            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
    });
</script>
@endsection
