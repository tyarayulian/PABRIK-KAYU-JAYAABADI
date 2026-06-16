<?php $__env->startSection('title', 'Pengaturan'); ?>
<?php $__env->startSection('breadcrumb', 'Pengaturan'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html {
        scrollbar-gutter: stable;
    }

    .page-container {
        max-width: 100%;
        margin: 0;
        padding: 24px;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px 0;
        letter-spacing: -0.025em;
    }

    .page-header p {
        font-size: 15px;
        color: #64748b;
        margin: 0;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .settings-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        padding: 32px;
        display: flex;
        flex-direction: column;
    }

    .settings-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .settings-card h2 i {
        color: #1e2a78;
    }

    .form-group {
        margin-bottom: 20px;
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

    .form-group input {
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

    .form-group input:focus {
        outline: none;
        border-color: #1e2a78;
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.1);
    }

    .password-input-group {
        position: relative;
    }

    .toggle-password-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 18px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .toggle-password-btn:hover {
        color: #0f172a;
    }

    .btn-save {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-save:hover {
        background: #16205a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 42, 120, 0.3);
    }

    .btn-outline {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .security-tips {
        background: #f0f7ff;
        border: 1px solid #e0e7ff;
        border-radius: 16px;
        padding: 24px;
        margin-top: 24px;
    }

    .security-tips h3 {
        color: #1e2a78;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .security-tips ul {
        margin: 0;
        padding-left: 20px;
        color: #1e2a78;
        font-size: 14px;
        line-height: 1.6;
    }

    .session-info {
        margin-top: 24px;
        padding: 20px;
        background: #f0f7ff;
        border-radius: 16px;
        border: 1px solid #e0e7ff;
    }

    .session-info p {
        margin: 8px 0;
        font-size: 13px;
        color: #1e2a78;
        display: flex;
        justify-content: space-between;
    }

    .session-info p span {
        font-weight: 600;
        color: #1e2a78;
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

    .alert-success {
        background: #f0f7ff;
        color: #1e2a78;
        border: 1px solid #e0e7ff;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <div class="page-header">
        <h1>Pengaturan Akun</h1>
        <p>Kelola profil personal, keamanan, dan preferensi akun Anda</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="settings-grid">
        <!-- Profil Card -->
        <div class="settings-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
                <h2 style="margin: 0;"><i class="fas fa-user-circle"></i> Profil Pengguna</h2>
                <button type="button" class="btn-outline" id="editProfileBtn" onclick="toggleProfileEdit()">
                    <i class="fas fa-edit" style="margin-right: 6px;"></i> Edit Profil
                </button>
            </div>
            
            <form id="profileForm" method="POST" action="<?php echo e(route('settings.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group" id="nameGroup">
                    <label>Nama Lengkap</label>
                    <input type="text" id="nameInput" name="name" value="<?php echo e(Auth::user()->name); ?>" readonly>
                </div>

                <div class="form-group" id="emailGroup">
                    <label>Alamat Email</label>
                    <input type="email" id="emailInput" name="email" value="<?php echo e(Auth::user()->email); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Terdaftar Sejak</label>
                    <input type="text" value="<?php echo e(Auth::user()->created_at->format('d F Y, H:i')); ?>" readonly style="background-color: #f1f5f9; color: #64748b;">
                </div>

                <div id="profileButtonGroup" style="display: none; gap: 12px; margin-top: 12px;">
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                    <button type="button" class="btn-outline" onclick="cancelProfileEdit()">Batal</button>
                </div>
            </form>
        </div>

        <!-- Password Card -->
        <div class="settings-card">
            <h2><i class="fas fa-shield-alt"></i> Keamanan & Password</h2>
            
            <form method="POST" action="<?php echo e(route('settings.password.update')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <div class="password-input-group">
                        <input type="password" name="current_password" placeholder="Konfirmasi password lama" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="password-input-group">
                        <input type="password" name="new_password" placeholder="Minimal 8 karakter unik" required minlength="8">
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ulangi Password Baru</label>
                    <div class="password-input-group">
                        <input type="password" name="new_password_confirmation" placeholder="Ketik ulang password baru" required minlength="8">
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-save" style="width: 100%;">
                    <i class="fas fa-key"></i> Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>

    <div class="settings-grid">
        <!-- Security Tips -->
        <div class="settings-card">
            <h2><i class="fas fa-lightbulb"></i> Tips Keamanan</h2>
            <div class="security-tips">
                <ul>
                    <li>Ganti password secara rutin setiap 3-6 bulan sekali.</li>
                    <li>Gunakan kombinasi simbol, angka, dan huruf kapital.</li>
                    <li>Hindari menggunakan password yang sama dengan situs lain.</li>
                    <li>Pastikan Anda selalu logout setelah selesai menggunakan sistem.</li>
                </ul>
            </div>
        </div>

        <!-- Session Info -->
        <div class="settings-card">
            <h2><i class="fas fa-info-circle"></i> Informasi Sesi</h2>
            <div class="session-info">
                <p>IP Address: <span><?php echo e($_SERVER['REMOTE_ADDR'] ?? 'Unknown'); ?></span></p>
                <p>Terakhir Login: <span><?php echo e(now()->format('d M Y, H:i')); ?></span></p>
                <p>Status: <span style="color: #10b981;">AKTIF</span></p>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: 24px;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-outline" style="width: 100%; border-color: #fecdd3; color: #e11d48;">
                    <i class="fas fa-sign-out-alt"></i> Logout dari Semua Perangkat
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(button) {
        const passwordInput = button.previousElementSibling;
        const icon = button.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function toggleProfileEdit() {
        const nameInput = document.getElementById('nameInput');
        const emailInput = document.getElementById('emailInput');
        const profileButtonGroup = document.getElementById('profileButtonGroup');
        const editBtn = document.getElementById('editProfileBtn');

        if (nameInput.readOnly) {
            nameInput.readOnly = false;
            emailInput.readOnly = false;
            nameInput.focus();
            nameInput.style.background = 'white';
            emailInput.style.background = 'white';
            profileButtonGroup.style.display = 'flex';
            editBtn.innerHTML = '<i class="fas fa-times"></i> Batal Edit';
        } else {
            cancelProfileEdit();
        }
    }

    function cancelProfileEdit() {
        const nameInput = document.getElementById('nameInput');
        const emailInput = document.getElementById('emailInput');
        const profileButtonGroup = document.getElementById('profileButtonGroup');
        const editBtn = document.getElementById('editProfileBtn');
        
        nameInput.value = "<?php echo e(Auth::user()->name); ?>";
        emailInput.value = "<?php echo e(Auth::user()->email); ?>";
        nameInput.readOnly = true;
        emailInput.readOnly = true;
        nameInput.style.background = '#f8fafc';
        emailInput.style.background = '#f8fafc';
        profileButtonGroup.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit Profil';
    }
</script>

<?php if(session('success')): ?>
<script>
    Toast.success('<?php echo e(session("success")); ?>');
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/settings/profile.blade.php ENDPATH**/ ?>