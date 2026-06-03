<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo 2.png') }}">
    <title>Daftar - Jaya Cash</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Instant.page for prefetching on hover -->
    <script src="https://instant.page/5.2.0" type="module"></script>
    
    <!-- NProgress for YouTube-style loading bar -->
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <style>
        #nprogress .bar {
            background: #1e2a78 !important;
            height: 3px !important;
            box-shadow: none !important;
            transition: all 50ms linear !important;
        }
        #nprogress .peg {
            box-shadow: none !important;
            display: none !important;
        }
        #nprogress .spinner {
            display: none !important;
        }
    </style>
    <style>
        :root {
            --primary: #1e2a78;
            --secondary: #0f172a;
            --bg: #f8fafc;
            --white: #ffffff;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Page Transition Animation */
        .page-fade-in {
            animation: fadeInPage 0.2s ease-out forwards;
        }

        @keyframes fadeInPage {
            from { opacity: 0.7; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-card {
            background: var(--white);
            padding: 48px;
            border-radius: 32px;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.03);
            animation: fadeInUp 0.6s ease-out;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-img {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            margin-bottom: 16px;
            object-fit: cover;
        }

        .logo-section h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--secondary);
            letter-spacing: -0.025em;
        }

        .logo-section p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.3s;
            color: var(--secondary);
        }

        .form-group input:focus {
            outline: none;
            background: var(--white);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.1);
        }

        .error-alert {
            background: #fef2f2;
            color: #dc2626;
            padding: 16px;
            border-radius: 14px;
            font-size: 14px;
            margin-bottom: 24px;
            border: 1px solid #fee2e2;
        }

        .error-list {
            list-style: none;
            margin-top: 8px;
            font-size: 13px;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 12px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
            background: #16205a;
        }

        .footer-links {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            padding: 10px 16px;
            background: var(--white);
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .back-link:hover {
            color: var(--primary);
            transform: translateX(-4px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="page-fade-in">
    <a href="/" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Beranda
    </a>
    <div class="register-card">
        <div class="logo-section">
            <a href="/" style="text-decoration: none;">
                <img src="/storage/images/logo.jpeg" alt="Jaya Cash Logo" class="logo-img">
                <h1>Jaya Cash</h1>
            </a>
            <p>Bergabunglah dengan Jaya Cash</p>
        </div>

        @if($errors->any())
            <div class="error-alert">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="nama@perusahaan.com" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required>
            </div>

            <button type="submit" class="btn-register">Buat Akun Sekarang</button>
        </form>

        <div class="footer-links">
            Sudah memiliki akun? <a href="/login">Masuk di sini</a>
        </div>
    </div>
    <script>
        // NProgress Configuration for ultra-instant feel
        NProgress.configure({ 
            showSpinner: false,
            trickleSpeed: 5,
            minimum: 0.99,
            easing: 'linear',
            speed: 50
        });

        // Start NProgress on page load
        NProgress.start();

        document.addEventListener('DOMContentLoaded', function() {
            NProgress.done();
        });

        // Start NProgress on any link click (excluding external/fragment links)
        document.addEventListener('click', function(e) {
            const target = e.target.closest('a');
            if (target && 
                target.href && 
                !target.hasAttribute('data-no-progress') &&
                target.hostname === window.location.hostname &&
                !target.href.includes('#') &&
                target.target !== '_blank' &&
                !e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey) {
                NProgress.start();
            }
        });

        // Start NProgress on form submission
        document.addEventListener('submit', function() {
            NProgress.start();
        });
    </script>
</body>
</html>
