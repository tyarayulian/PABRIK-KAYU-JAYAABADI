@extends('layouts.app')

@section('title', 'Pembelian')
@section('breadcrumb', 'Pembelian')

@section('styles')
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        background: #f8fafc;
    }

    .page-container {
        max-width: 100%;
        margin: 0;
        padding: 20px;
        background-color: #f8fafc;
        border-radius: 12px;
    }

    .page-content {
        background: #f8fafc;
        padding: 0;
        border-radius: 0;
    }

    .page-header {
        margin-bottom: 30px;
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
        border-color: #ffc107;
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
        background-color: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
    }

    table thead th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }

    table tbody tr {
        border-bottom: 1px solid #e5e7eb;
    }

    table tbody td {
        padding: 12px;
        color: #6b7280;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>Pencatatan Pembelian</h1>
        <p>Catat semua pembelian kas untuk pabrik kayu</p>
    </div>

    <div style="margin-bottom: 20px;">
        <button class="btn btn-primary" onclick="openModal('addCashOutModal')">+ Tambah Pembelian</button>
    </div>

    <div class="card">
    <h2 style="margin-bottom: 20px; color: #111827; font-size: 18px; font-weight: 600;">Daftar Pembelian</h2>
    
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
            @forelse($cashOuts as $cashOut)
                <tr>
                    <td>{{ $cashOut->date->format('d/m/Y') }}</td>
                    <td>{{ $cashOut->account->code ?? '?' }} - {{ $cashOut->account->name ?? 'N/A' }}</td>
                    <td>{{ $cashOut->description ?? '-' }}</td>
                    <td style="text-align: right; font-weight: 600;">Rp {{ number_format($cashOut->amount, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <button type="button" onclick="deleteCashOut({{ $cashOut->id }})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-size: 12px; transition: all 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #9ca3af;">
                        Belum ada pencatatan kas keluar
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="addCashOutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Pembelian</h2>
            <button class="modal-close" onclick="closeModal('addCashOutModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="cashOutForm">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="date" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
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
                        ⚠️ Silakan isi detail pembelian
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
            <button class="btn-cancel" onclick="closeModal('addCashOutModal')">Batal</button>
            <button class="btn btn-primary" onclick="saveCashOut()">Simpan</button>
        </div>
    </div>
</div>

<script>
    const bebanLainnyaAccountNames = ['Beban Lainnya', 'Operasional Lainnya', 'Expense Lainnya'];

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

        if (bebanLainnyaAccountNames.some(name => selectedName.includes(name))) {
            descriptionLabel.textContent = 'Detail Pengeluaran (Wajib Diisi) *';
            descriptionHint.style.display = 'block';
            descriptionField.placeholder = 'Contoh: Biaya Akomodasi, Biaya Riset, dll';
            descriptionField.required = true;
            descriptionField.style.borderColor = '#ff6b6b';
        } else if (selectedCode === '5100' || selectedName.includes('Beban Gaji')) {
            descriptionLabel.textContent = 'Catatan Gaji (Opsional)';
            descriptionHint.style.display = 'none';
            descriptionField.placeholder = 'Masukkan catatan atau keterangan...';
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

    function saveCashOut() {
        const form = document.getElementById('cashOutForm');
        const descriptionField = document.getElementById('deskripsi');
        const selectElement = document.getElementById('category');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';

        if (bebanLainnyaAccountNames.some(name => selectedName.includes(name)) && !descriptionField.value.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: '⚠️ Silakan isi detail pembelian terlebih dahulu!'
            });
            descriptionField.focus();
            return;
        }

        const formData = new FormData(form);

        fetch('{{ route("cash.out.store") }}', {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    closeModal('addCashOutModal');
                    form.reset();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat menyimpan'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error: ' + error.message
            });
            console.error('Detailed error:', error);
        });
    }

    window.onclick = function(event) {
        const modal = document.getElementById('addCashOutModal');
        if (event.target === modal) {
            closeModal('addCashOutModal');
        }
    }

    function deleteCashOut(id) {
        Swal.fire({
            title: 'Hapus Pencatatan Kas Keluar?',
            text: 'Apakah Anda yakin ingin menghapus pencatatan kas keluar ini? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#111827',
            iconColor: '#f59e0b',
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                const cancelBtn = Swal.getCancelButton();
                if (confirmBtn) {
                    confirmBtn.style.borderRadius = '8px';
                    confirmBtn.style.fontWeight = '600';
                    confirmBtn.style.padding = '10px 24px';
                    confirmBtn.style.fontSize = '14px';
                }
                if (cancelBtn) {
                    cancelBtn.style.borderRadius = '8px';
                    cancelBtn.style.fontWeight = '600';
                    cancelBtn.style.padding = '10px 24px';
                    cancelBtn.style.fontSize = '14px';
                    cancelBtn.style.color = '#6b7280';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route("cash.out.destroy", ":id") }}'.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat menghapus'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + error.message
                    });
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
    });
</script>
@endsection
