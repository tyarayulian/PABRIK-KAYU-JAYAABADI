<?php $__env->startSection('title', 'Master Akun'); ?>
<?php $__env->startSection('breadcrumb', 'Master Data > Akun'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    .action-btn.delete:hover {
        background: #fff1f2;
        color: #dc2626;
        border-color: #fecdd3;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
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
            <button class="btn-action btn-action-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Tambah Akun
            </button>
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
                <th style="width: 15%">Kode</th>
                <th>Nama Akun</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 15%; text-align: center;">Aksi</th>
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
                <td>
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <button class="action-btn" title="Edit" onclick="openEditModal(<?php echo e(json_encode($account)); ?>)">
                            <i class="fas fa-edit" style="color: #1e2a78;"></i>
                        </button>
                        <button class="action-btn delete" title="Hapus" onclick="deleteAccount(<?php echo e($account->id); ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada akun terdaftar.</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- MODAL TAMBAH/EDIT -->
<div id="accountModal" class="modal-overlay">
    <div class="modal-card">
        <h2 id="modalTitle">Tambah Akun Baru</h2>
        <form id="accountForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" id="accountId">
            
            <div class="form-group">
                <label>Kode Akun</label>
                <input type="text" name="code" id="accCode" placeholder="Contoh: 1101" required>
                <div id="error-code" class="error-text"></div>
            </div>

            <div class="form-group">
                <label>Nama Akun</label>
                <input type="text" name="name" id="accName" placeholder="Contoh: Kas Utama" required>
                <div id="error-name" class="error-text"></div>
            </div>

            <div class="form-group">
                <label>Kategori Akun</label>
                <select name="type" id="accType" required>
                    <option value="">Pilih Kategori</option>
                    <option value="asset">Asset (Aktiva)</option>
                    <option value="liability">Liability (Kewajiban)</option>
                    <option value="equity">Equity (Modal)</option>
                    <option value="revenue">Revenue (Pendapatan)</option>
                    <option value="expense">Expense (Beban)</option>
                </select>
                <div id="error-type" class="error-text"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmit">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('accountModal');
    const form = document.getElementById('accountForm');
    
    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Akun Baru';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('accountId').value = '';
        form.reset();
        clearErrors();
        modal.classList.add('active');
    }

    function openEditModal(account) {
        document.getElementById('modalTitle').textContent = 'Edit Informasi Akun';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('accountId').value = account.id;
        document.getElementById('accCode').value = account.code;
        document.getElementById('accName').value = account.name;
        document.getElementById('accType').value = account.type;
        clearErrors();
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => {
            el.textContent = '';
            el.classList.remove('active');
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();
        
        const id = document.getElementById('accountId').value;
        const isEdit = id !== '';
        const url = isEdit ? `/master/accounts/${id}` : '/master/accounts';
        
        const formData = new FormData(this);
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, showConfirmButton: false, timer: 1500 })
                .then(() => location.reload());
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(`error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                            errorEl.classList.add('active');
                        }
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            }
        });
    });

    function deleteAccount(id) {
        Swal.fire({
            title: 'Hapus Akun?',
            text: "Pastikan akun ini tidak memiliki transaksi aktif!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e2a78',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/master/accounts/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                });
            }
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
        Swal.fire({
            title: `Hapus ${selectedIds.length} Akun?`,
            text: "Akun dengan riwayat transaksi tidak akan terhapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e2a78',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: 'Ya, Hapus Semua'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?php echo e(route("master.accounts.destroyBulk")); ?>', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, showConfirmButton: false, timer: 1500 })
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Hasil Operasi', data.message, 'info');
                    }
                });
            }
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
    Swal.fire({ icon: 'success', title: 'Berhasil', text: "<?php echo e(session('success')); ?>", timer: 2000, showConfirmButton: false, background: '#fff', color: '#1e2a78' });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp_new\htdocs\tyara\resources\views/master/accounts.blade.php ENDPATH**/ ?>