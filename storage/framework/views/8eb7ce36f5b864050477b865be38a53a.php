<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('storage/images/logo 2.png')); ?>">
    <title>Lupa Password - Jaya Cash</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Button Components -->
    <link rel="stylesheet" href="<?php echo e(asset('css/buttons.css')); ?>">
    
    <style>
        :root {
            --primary: #1e2a78;
            --text-main: #1a1a1a;
            --text-muted: #64748b;
            --white: #ffffff;
            --success: #16a34a;
            --error: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .container {
            width: 100%;
            max-width: 480px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 32px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--text-main);
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 12px;
            letter-spacing: -1px;
        }

        .form-header p {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .success-alert {
            background: #f0fdf4;
            color: var(--success);
            padding: 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid #bbf7d0;
        }

        .error-alert {
            background: #fff1f2;
            color: var(--error);
            padding: 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid #ffe4e6;
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 0 16px 0;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid #f1f5f9;
            font-size: 16px;
            font-weight: 400;
            color: var(--text-main);
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-bottom-color: var(--primary);
        }

        .btn-submit {
            /* Removed - using .btn-primary from buttons.css */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo e(route('login')); ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Login
        </a>

        <div class="form-header">
            <h2>Lupa Password?</h2>
            <p>Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password.</p>
        </div>

        <?php if(session('status')): ?>
            <div class="success-alert">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="error-alert">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.email')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="nama@perusahaan.com" required value="<?php echo e(old('email')); ?>">
            </div>

            <button type="submit" class="btn-primary btn-block">Kirim Link Reset Password</button>
        </form>
    </div>
</body>
</html>
<?php /**PATH D:\xampp_new\htdocs\tyara\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>