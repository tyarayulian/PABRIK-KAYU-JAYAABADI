<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('storage/images/logo 2.png')); ?>">
    <title>Masuk - Jaya Cash</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    <script src="https://instant.page/5.2.0" type="module"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    
    <style>
        :root {
            --primary: #1e2a78;
            --primary-vibrant: #2d3bb1;
            --secondary: #0f172a;
            --text-main: #1a1a1a;
            --text-muted: #64748b;
            --white: #ffffff;
            --error: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #nprogress .bar { background: var(--white) !important; height: 3px !important; }
        #nprogress .spinner { display: none !important; }

        body {
            background-color: var(--white);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* Left Side - Vibrant Blue */
        .left-panel {
            background-color: var(--primary);
            background-image: radial-gradient(circle at 20% 30%, var(--primary-vibrant) 0%, var(--primary) 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        /* Subtle Geometric Patterns */
        .left-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L400 400 M-100 0 L300 400 M100 0 L400 300' stroke='rgba(255,255,255,0.03)' fill='none' /%3E%3C/svg%3E");
            opacity: 0.5;
            pointer-events: none;
        }

        .left-content { position: relative; z-index: 2; width: 100%; max-width: 500px; }

        .star-icon {
            font-size: clamp(40px, 8vw, 80px);
            margin-bottom: 30px;
            color: var(--white);
            opacity: 0.9;
        }

        .left-panel h1 {
            font-size: clamp(32px, 6vw, 64px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
        }

        .left-panel p {
            font-size: clamp(14px, 2vw, 18px);
            line-height: 1.6;
            opacity: 0.8;
        }

        .copyright {
            font-size: 12px;
            opacity: 0.5;
            z-index: 2;
            margin-top: 40px;
        }

        /* Right Side - Form */
        .right-panel {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Shift content up */
            padding-top: 100px; /* Adjust top padding */
            align-items: center;
            background: var(--white);
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
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
            margin-bottom: 50px;
            line-height: 1.6;
        }

        .form-header a {
            color: var(--text-main);
            font-weight: 700;
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 35px;
            position: relative;
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
            background: transparent !important;
            border: none;
            border-bottom: 1.5px solid #f1f5f9;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-main);
            transition: all 0.3s;
            border-radius: 0;
            outline: none;
        }

        .form-group input:focus {
            border-bottom-color: var(--primary);
        }

        /* Fix for Chrome Autofill background */
        .form-group input:-webkit-autofill,
        .form-group input:-webkit-autofill:hover, 
        .form-group input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text-main);
            -webkit-box-shadow: 0 0 0px 1000px white inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }

        .password-toggle {
            position: absolute;
            right: 0;
            bottom: 18px;
            cursor: pointer;
            color: #cbd5e1;
            transition: color 0.2s;
            padding: 5px;
            font-size: 18px;
        }

        .password-toggle:hover {
            color: var(--text-main);
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

        .btn-login-now {
            width: 100%;
            padding: 16px;
            background: #111111;
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 16px;
            margin-bottom: 12px;
        }

        .btn-login-now:hover {
            background: #222222;
            transform: translateY(-1px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 32px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .forgot-password a {
            color: var(--text-main);
            font-weight: 800;
            text-decoration: none;
        }

        @media (max-width: 1024px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 40px 24px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="left-content">
                <div class="star-icon">
                    <i class="fas fa-asterisk"></i>
                </div>
                <h1>Hello<br>Jaya Cash! 👋</h1>
                <p>Singkirkan tugas pencatatan manual yang berulang. Kelola pabrik Anda dengan automasi akuntansi yang cerdas dan hemat waktu!</p>
            </div>
            <div class="copyright">
                &copy; <?php echo e(date('Y')); ?> Jaya Cash. All rights reserved.
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Selamat Datang!</h2>
                    <p>Belum punya akun? <a href="/register">Daftar akun baru sekarang</a>, GRATIS! Hanya butuh waktu kurang dari semenit.</p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="error-alert">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="/login">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="nama@perusahaan.com" required value="<?php echo e(old('email')); ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" placeholder="Kata Sandi" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>

                    <button type="submit" class="btn-login-now">Masuk</button>
                </form>

                <div class="forgot-password">
                    Lupa kata sandi? <a href="#">Klik di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        NProgress.configure({ showSpinner: false });
        NProgress.start();
        window.onload = function() { NProgress.done(); };
        
        document.addEventListener('submit', function() {
            NProgress.start();
        });

        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye-slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/auth/login.blade.php ENDPATH**/ ?>