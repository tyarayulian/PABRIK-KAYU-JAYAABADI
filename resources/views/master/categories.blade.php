@extends('layouts.app')

@section('title', 'Master Kategori')
@section('breadcrumb', 'Master Data > Kategori')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/modal.css') }}?v={{ time() }}">
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
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 14px;
        color: #666;
    }

    .table-section {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .table-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        gap: 16px;
        border-bottom: 1px solid #f1f5f9;
        background: white;
    }

    .table-title-section h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.01em;
    }

    .table-title-section p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-action-primary {
        background: #1e2a78;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(30, 42, 120, 0.2);
    }

    .btn-action-primary:hover {
        background: #151f5e;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
        color: white;
    }

    .btn-outline {
        background: #fff;
        color: #1e2a78;
        border: 1px solid #1e2a78;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #151f5e;
        color: #151f5e;
        transform: translateY(-1px);
    }

    .btn-danger-action {
        background: #ef4444;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }

    .btn-danger-action:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    th {
        padding: 16px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }

    tbody tr:hover {
        background: #fcfcfd;
    }

    td {
        padding: 18px 24px;
        font-size: 14px;
        color: #1e293b;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-cash-in {
        background: #ecfdf5;
        color: #059669;
    }

    .badge-cash-out {
        background: #fef2f2;
        color: #dc2626;
    }

    .account-link {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-size: 14px;
    }

    .action-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .btn-delete {
        background: #fff1f2;
        color: #f43f5e;
        border: 1px solid #ffe4e6;
    }

    .btn-delete:hover {
        background: #ffe4e6;
        border-color: #fecdd3;
    }

    .pagination-wrapper {
        padding: 24px 32px;
        background: white;
        border-top: 1px solid #f1f5f9;
    }

    .empty-state {
        text-align: center;
        padding: 60px 32px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #e2e8f0;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>Master Kategori</h1>
    <p>Atur kategori transaksi untuk memudahkan klasifikasi arus kas.</p>
</div>

<!-- TABLE SECTION -->
<div class="table-section">
    <div class="table-title-section">
        <div>
            <h2>Daftar Kategori</h2>
            <p>Menampilkan total <strong>{{ $categories->total() }}</strong> kategori</p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="{{ route('master.categories.create') }}" class="btn-action btn-action-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
            <button class="btn-outline" id="selectModeBtn" onclick="toggleSelectMode()">
                <i class="fas fa-check-square"></i> Pilih
            </button>
            <button class="btn-danger-action" id="bulkDeleteBtn" onclick="bulkDelete()" style="display: none;">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
            <button class="btn-outline" id="cancelSelectBtn" onclick="toggleSelectMode()" style="display: none;">
                Batal
            </button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th id="checkboxHeader" style="width: 50px; display: none; text-align: center;">
                    <input type="checkbox" id="selectAll" onchange="selectAllCheckboxes()" style="width: 16px; height: 16px; cursor: pointer;">
                </th>
                <th style="width: 30%">Nama Kategori</th>
                <th style="width: 20%">Tipe</th>
                <th>Akun Terhubung (COA)</th>
                <th style="width: 15%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td id="checkboxCell-{{ $category->id }}" style="display: none; text-align: center;">
                    <input type="checkbox" class="category-checkbox" value="{{ $category->id }}" onchange="toggleBulkDeleteBtn()" style="width: 16px; height: 16px; cursor: pointer;">
                </td>
                <td style="font-weight: 700; color: #1e2a78;">{{ $category->name }}</td>
                <td>
                    <span class="badge-modern {{ $category->type == 'cash_in' ? 'badge-cash-in' : 'badge-cash-out' }}">
                        {{ $category->type == 'cash_in' ? 'Masuk' : 'Keluar' }}
                    </span>
                </td>
                <td>
                    @if($category->account)
                    <span class="account-link">
                        {{ $category->account->code }} — {{ $category->account->name }}
                    </span>
                    @else
                    <span style="color: #94a3b8; font-size: 13px; font-style: italic;">Belum diatur</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <a href="{{ route('master.categories.edit', $category->id) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit" style="color: #1e2a78;"></i>
                        </a>
                        <button class="action-btn btn-delete" title="Hapus" onclick="deleteCategory({{ $category->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada kategori ditemukan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($categories->hasPages())
    <div class="pagination-wrapper">
        {{ $categories->links() }}
    </div>
    @endif
</div>

<script>
    function toggleSelectMode() {
        const header = document.getElementById('checkboxHeader');
        const cells = document.querySelectorAll('[id^="checkboxCell-"]');
        const isVisible = header.style.display !== 'none';
        
        header.style.display = isVisible ? 'none' : 'table-cell';
        cells.forEach(c => c.style.display = isVisible ? 'none' : 'table-cell');
        document.getElementById('selectModeBtn').style.display = isVisible ? 'inline-flex' : 'none';
        document.getElementById('cancelSelectBtn').style.display = isVisible ? 'none' : 'inline-flex';
        if (isVisible) {
            document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('bulkDeleteBtn').style.display = 'none';
        }
    }

    function selectAllCheckboxes() {
        const checked = document.getElementById('selectAll').checked;
        document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = checked);
        toggleBulkDeleteBtn();
    }

    function toggleBulkDeleteBtn() {
        const count = document.querySelectorAll('.category-checkbox:checked').length;
        document.getElementById('bulkDeleteBtn').style.display = count > 0 ? 'inline-flex' : 'none';
    }

    function deleteCategory(id) {
        const categoryElement = event.target.closest('tr').querySelector('td:nth-child(2)').textContent.trim();
        Modal.delete(`kategori "${categoryElement}"`, function() {
            fetch(`/master/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        });
    }

    function bulkDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value);
        Modal.delete(`${selectedIds.length} kategori terpilih`, function() {
            fetch('{{ route("master.categories.destroyBulk") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        });
    }
</script>

<script src="{{ asset('js/modal.js') }}?v={{ time() }}"></script>

@if(session('success'))
<script>
    // Show success notification
    setTimeout(function() {
        const notification = document.createElement('div');
        notification.style.cssText = 'position:fixed;top:20px;right:20px;background:#1e2a78;color:white;padding:16px 24px;border-radius:12px;z-index:10000;box-shadow:0 10px 30px rgba(30,42,120,0.3);font-weight:600;';
        notification.textContent = '✓ {{ session("success") }}';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }, 100);
</script>
@endif
@endsection
