<?php $__env->startSection('title', 'Master Akun'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Akun'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>?v=<?php echo e(time()); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .stat-card-label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 12px;
    }

    .stat-card-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e2a78;
        margin: 0 0 8px 0;
    }

    .stat-card-meta {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
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

    .account-code {
        font-weight: 800;
        color: #1e2a78;
        font-size: 14px;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-status-active {
        background: #ecfdf5;
        color: #059669;
    }

    .badge-status-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-type {
        background: #f1f5f9;
        color: #475569;
    }

    .action-btn {
        background: #f8fafc;
        color: #1e2a78;
        border: 1px solid #e2e8f0;
        padding: 0;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .action-btn:hover {
        background: #f1f5f9;
        color: #1e2a78;
        border-color: #1e2a78;
    }

    .action-btn.delete {
        background: #fff1f2;
        color: #f43f5e;
        border: 1px solid #ffe4e6;
    }

    .action-btn.delete:hover {
        background: #ffe4e6;
        color: #f43f5e;
        border-color: #fecdd3;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        /* NO BLUR */
        z-index: 2000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-card {
        background: #fff;
        width: 90%;
        max-width: 500px;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-card h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 24px;
        color: #0f172a;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.05em;
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus, .form-group select:focus {
        border-color: #1e2a78;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05);
    }

    .modal-footer {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
    }

    .btn-modal-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
    }

    .btn-modal-submit {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Master Akun</h1>
    <p>Manajemen Chart of Accounts (COA) untuk pencatatan keuangan pabrik.</p>
</div>

<!-- STATS SUMMARY -->
<div class="stat-cards-grid">
    <div class="stat-card">
        <div class="stat-card-label">Total Akun Terdaftar</div>
        <div class="stat-card-value"><?php echo e($accounts->count()); ?></div>
        <div class="stat-card-meta">Seluruh akun dalam sistem</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Kategori Akun</div>
        <div class="stat-card-value"><?php echo e($accounts->pluck('type')->unique()->count()); ?></div>
        <div class="stat-card-meta">Struktur klasifikasi COA</div>
    </div>
</div>

<!-- TABLE SECTION -->
<div class="table-section">
    <div class="table-title-section">
        <div>
            <h2>Daftar Akun</h2>
            <p>Menampilkan total <strong><?php echo e($accounts->count()); ?></strong> akun</p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="<?php echo e(route('master.accounts.create')); ?>" class="btn-action btn-action-primary" style="background: #f0f4ff; color: #1e2a78; border: 1px solid #e2e8f0; box-shadow: none;">
                <i class="fas fa-plus"></i> Tambah Akun
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
                <th style="width: 12%">Kode</th>
                <th>Nama Akun</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 18%; text-align: right;">Saldo Awal</th>
                <th style="width: 18%; text-align: right;">Saldo Berjalan</th>
                <th style="width: 12%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td id="checkboxCell-<?php echo e($account->id); ?>" style="display: none; text-align: center;">
                    <input type="checkbox" class="account-checkbox" value="<?php echo e($account->id); ?>" onchange="toggleBulkDeleteBtn()" style="width: 16px; height: 16px; cursor: pointer;">
                </td>
                <td><span class="account-code"><?php echo e($account->code); ?></span></td>
                <td style="font-weight: 700; color: #1e2a78;"><?php echo e($account->name); ?></td>
                <td><span class="badge-modern badge-type"><?php echo e(ucfirst($account->type)); ?></span></td>
                <td style="text-align: right; font-weight: 600; color: #64748b;">
                    <?php if($account->opening_balance > 0): ?>
                        Rp <?php echo e(number_format($account->opening_balance, 0, ',', '.')); ?>

                    <?php else: ?>
                        <span style="color: #cbd5e1;">-</span>
                    <?php endif; ?>
                </td>
                <td style="text-align: right; font-weight: 700; color: <?php echo e($account->current_balance >= 0 ? '#059669' : '#ef4444'); ?>;">
                    <?php if($account->current_balance != 0): ?>
                        Rp <?php echo e(number_format(abs($account->current_balance), 0, ',', '.')); ?>

                        <?php if($account->current_balance < 0): ?>
                            <span style="font-size: 11px;">(minus)</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="color: #cbd5e1;">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <a href="<?php echo e(route('master.accounts.edit', $account->id)); ?>" class="action-btn" title="Edit">
                            <i class="fas fa-edit" style="color: #1e2a78;"></i>
                        </a>
                        <button class="action-btn delete" title="Hapus" onclick="deleteAccount(<?php echo e($account->id); ?>)" data-account-id="<?php echo e($account->id); ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada akun terdaftar.</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function deleteAccount(id) {
        // If id is not provided or invalid, try to get from data attribute
        if (!id || id === 'undefined') {
            const button = event.target.closest('button[data-account-id]');
            if (button) {
                id = button.getAttribute('data-account-id');
                console.log('Got ID from data-attribute:', id);
            }
        }
        
        // Debug logging
        console.log('deleteAccount called with ID:', id, 'Type:', typeof id);
        
        // Validate that ID is provided
        if (!id || id === 'undefined' || id === 'null') {
            console.error('Account ID is missing or invalid');
            if (typeof Toast !== 'undefined') {
                Toast.error('ID akun tidak valid');
            } else {
                alert('ID akun tidak valid');
            }
            return;
        }
        
        const row = event.target.closest('tr');
        // Find the account name column (skip checkbox column if visible)
        const nameCell = row.querySelector('.account-code').closest('td').nextElementSibling;
        const accountName = nameCell ? nameCell.textContent.trim() : 'akun ini';
        
        console.log('Deleting account:', accountName, 'with ID:', id);
        
        Modal.delete(`akun "${accountName}"`, function() {
            // Use POST with _method=DELETE (method spoofing)
            const formData = new FormData();
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            formData.append('_method', 'DELETE');
            
            const deleteUrl = `<?php echo e(url('/master/accounts')); ?>/${id}`;
            console.log('DELETE URL (POST):', deleteUrl);
            
            fetch(deleteUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Gagal menghapus akun');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    if (typeof Toast !== 'undefined') {
                        Toast.success(data.message);
                    } else {
                        alert(data.message);
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.error(error.message || 'Terjadi kesalahan saat menghapus akun');
                } else {
                    alert('Error: ' + (error.message || 'Terjadi kesalahan saat menghapus akun'));
                }
            });
        });
    }

    function toggleSelectMode() {
        const header = document.getElementById('checkboxHeader');
        const cells = document.querySelectorAll('[id^="checkboxCell-"]');
        const isVisible = header.style.display !== 'none';
        
        header.style.display = isVisible ? 'none' : 'table-cell';
        cells.forEach(c => c.style.display = isVisible ? 'none' : 'table-cell');
        document.getElementById('selectModeBtn').style.display = isVisible ? 'inline-flex' : 'none';
        document.getElementById('cancelSelectBtn').style.display = isVisible ? 'none' : 'inline-flex';
        if (isVisible) {
            document.querySelectorAll('.account-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('bulkDeleteBtn').style.display = 'none';
        }
    }

    function selectAllCheckboxes() {
        const checked = document.getElementById('selectAll').checked;
        document.querySelectorAll('.account-checkbox').forEach(cb => cb.checked = checked);
        toggleBulkDeleteBtn();
    }

    function toggleBulkDeleteBtn() {
        const count = document.querySelectorAll('.account-checkbox:checked').length;
        document.getElementById('bulkDeleteBtn').style.display = count > 0 ? 'inline-flex' : 'none';
    }

    function bulkDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.account-checkbox:checked')).map(cb => cb.value);
        
        if (selectedIds.length === 0) {
            if (typeof Toast !== 'undefined') {
                Toast.error('Pilih minimal satu akun untuk dihapus');
            } else {
                alert('Pilih minimal satu akun untuk dihapus');
            }
            return;
        }
        
        Modal.delete(`${selectedIds.length} akun terpilih`, function() {
            // Use POST with _method=DELETE (method spoofing)
            const formData = new FormData();
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            formData.append('_method', 'DELETE');
            formData.append('ids', selectedIds.join(','));
            
            const deleteUrl = '<?php echo e(route("master.accounts.destroyBulk")); ?>';
            console.log('Bulk DELETE URL (POST):', deleteUrl, 'IDs:', selectedIds);
            
            fetch(deleteUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Bulk delete response status:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Gagal menghapus akun');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Bulk delete success:', data);
                if (data.success) {
                    if (typeof Toast !== 'undefined') {
                        Toast.success(data.message);
                    } else {
                        alert(data.message);
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Bulk delete error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.error(error.message || 'Terjadi kesalahan saat menghapus akun');
                } else {
                    alert('Error: ' + (error.message || 'Terjadi kesalahan saat menghapus akun'));
                }
            });
        });
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>


<?php if(session('success')): ?>
<script>
    Toast.success('<?php echo e(session("success")); ?>');
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/master/akun/index.blade.php ENDPATH**/ ?>