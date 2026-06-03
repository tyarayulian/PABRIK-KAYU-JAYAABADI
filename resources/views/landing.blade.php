<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo 2.png') }}">
    <title>Jaya Cash - Smart ERP for Wood Industries</title>
    
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
            --primary-soft: rgba(30, 42, 120, 0.05);
            --primary-hover: #151d54;
            --secondary: #0f172a;
            --accent: #3b82f6;
            --text-main: #1a1a1a;
            --text-muted: #64748b;
            --bg-page: #f8fafc;
            --white: #ffffff;
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
            --header-blur: rgba(248, 250, 252, 0.8);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #nprogress .bar { background: var(--primary) !important; height: 3px !important; }
        #nprogress .spinner { display: none !important; }

        html { scroll-behavior: smooth; }
        body { background-color: var(--bg-page); color: var(--text-main); overflow-x: hidden; line-height: 1.6; }

        /* Animations */
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        .animate-fade-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-down { animation: fadeInDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* Layout */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* Navigation */
        nav {
            position: fixed; top: 0; left: 0; width: 100%; padding: 20px 0;
            background: var(--header-blur); backdrop-filter: blur(12px);
            z-index: 1000; transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }
        nav.scrolled { padding: 12px 0; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }

        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo img { height: 36px; width: auto; }
        .logo-text { font-size: 20px; font-weight: 800; color: var(--secondary); letter-spacing: -0.5px; }

        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--text-muted); font-size: 14px; font-weight: 600; transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary); }

        .btn-login {
            background: var(--primary); color: var(--white) !important;
            padding: 10px 24px; border-radius: 14px; font-weight: 700;
            box-shadow: 0 4px 12px rgba(30, 42, 120, 0.15);
            transition: all 0.2s;
        }
        .btn-login:hover { transform: translateY(-2px); background: var(--primary-hover); box-shadow: 0 8px 20px rgba(30, 42, 120, 0.25); }

        /* Hero */
        .hero { padding: 160px 0 100px; position: relative; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }

        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px; background: var(--primary-soft);
            color: var(--primary); border-radius: 100px;
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.5px; margin-bottom: 24px;
        }

        .hero h1 {
            font-size: clamp(40px, 5vw, 64px); line-height: 1.1;
            font-weight: 800; color: var(--secondary);
            letter-spacing: -2px; margin-bottom: 24px;
        }
        .hero h1 span { color: var(--primary); }

        .hero p { font-size: 18px; color: var(--text-muted); margin-bottom: 40px; max-width: 520px; }

        .hero-actions { display: flex; gap: 16px; }
        
        .btn-primary {
            background: var(--primary); color: var(--white);
            padding: 18px 36px; border-radius: 18px; text-decoration: none;
            font-weight: 700; font-size: 16px; transition: all 0.2s;
            box-shadow: 0 10px 25px rgba(30, 42, 120, 0.15);
        }
        .btn-primary:hover { transform: translateY(-4px); background: var(--primary-hover); box-shadow: 0 15px 35px rgba(30, 42, 120, 0.25); }

        .btn-outline {
            background: var(--white); color: var(--secondary);
            padding: 18px 36px; border-radius: 18px; text-decoration: none;
            font-weight: 700; font-size: 16px; border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .btn-outline:hover { background: #fcfcfc; border-color: var(--primary); color: var(--primary); }

        .hero-mockup {
            position: relative; border-radius: 32px;
            background: var(--white); padding: 12px;
            box-shadow: 0 40px 100px -20px rgba(0,0,0,0.12);
            border: 1px solid rgba(0,0,0,0.03);
            transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);
            transition: transform 0.5s ease;
        }
        .hero-mockup:hover { transform: perspective(1000px) rotateY(0) rotateX(0) scale(1.02); }
        .hero-mockup img { width: 100%; border-radius: 24px; display: block; }

        /* Features */
        .section { padding: 100px 0; }
        .section-header { text-align: center; margin-bottom: 64px; }
        .section-header h2 { font-size: 36px; font-weight: 800; color: var(--secondary); letter-spacing: -1px; margin-bottom: 16px; }
        .section-header p { color: var(--text-muted); max-width: 600px; margin: 0 auto; font-size: 16px; }

        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .feature-card {
            background: var(--white); padding: 48px 40px; border-radius: 32px;
            border: 1px solid rgba(0,0,0,0.02); transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
        }
        .feature-card:hover { transform: translateY(-10px); border-color: var(--primary); }

        .feature-icon {
            width: 64px; height: 64px; background: var(--primary-soft);
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            color: var(--primary); font-size: 24px; margin-bottom: 32px;
        }

        .feature-card h3 { font-size: 22px; font-weight: 700; margin-bottom: 16px; color: var(--secondary); }
        .feature-card p { color: var(--text-muted); font-size: 15px; }

        /* Steps */
        .steps-container {
            display: flex; gap: 40px; margin-top: 60px;
            background: var(--white); padding: 60px; border-radius: 40px;
            box-shadow: var(--card-shadow);
        }
        .step { flex: 1; }
        .step-num {
            font-size: 14px; font-weight: 800; color: var(--primary);
            background: var(--primary-soft); width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; margin-bottom: 24px;
        }
        .step h4 { font-size: 18px; font-weight: 700; margin-bottom: 12px; color: var(--secondary); }
        .step p { font-size: 14px; color: var(--text-muted); }

        /* CTA */
        .cta { padding: 120px 0; }
        .cta-content {
            background: var(--secondary); padding: 80px 40px; border-radius: 48px;
            text-align: center; color: var(--white); position: relative; overflow: hidden;
            background-image: linear-gradient(45deg, var(--secondary) 0%, #1e293b 100%);
        }
        .cta-content::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: url('{{ asset("storage/images/landing foto.jpeg") }}') center/cover;
            opacity: 0.1; mix-blend-mode: overlay;
        }
        .cta h2 { font-size: clamp(32px, 4vw, 48px); font-weight: 800; margin-bottom: 24px; letter-spacing: -2px; }
        .cta p { font-size: 18px; opacity: 0.8; margin-bottom: 40px; max-width: 640px; margin-left: auto; margin-right: auto; }

        /* Footer */
        footer { padding: 80px 0 40px; border-top: 1px solid rgba(0,0,0,0.03); background: #fff; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 80px; margin-bottom: 60px; }
        .footer-info p { margin-top: 24px; color: var(--text-muted); font-size: 14px; max-width: 320px; }
        
        .footer-links h4 { font-size: 16px; font-weight: 700; color: var(--secondary); margin-bottom: 24px; }
        .footer-links ul { list-style: none; }
        .footer-links li { margin-bottom: 14px; }
        .footer-links a { text-decoration: none; color: var(--text-muted); font-size: 14px; transition: color 0.2s; }
        .footer-links a:hover { color: var(--primary); }

        .footer-bottom { padding-top: 40px; border-top: 1px solid rgba(0,0,0,0.03); display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); }

        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero h1, .hero p { margin-left: auto; margin-right: auto; }
            .hero-actions { justify-content: center; }
            .features-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 48px; }
            .hero-mockup { transform: none; max-width: 600px; margin: 40px auto 0; }
            .steps-container { flex-direction: column; padding: 40px; }
        }
    </style>
</head>
<body>

    <nav id="navbar">
        <div class="container nav-content">
            <a href="/" class="logo">
                <img src="{{ asset('storage/images/logo 2.png') }}" alt="Jaya Cash">
                <span class="logo-text">Jaya Cash</span>
            </a>
            <div class="nav-links">
                <a href="#fitur">Fitur</a>
                <a href="#alur">Alur Kerja</a>
                <a href="/login" class="btn-login">Mulai Sekarang</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="animate-fade-up">
                    <div class="hero-tag">Accounting Reinvented</div>
                    <h1>Kuasai Keuangan <span>Pabrik Anda</span> dengan Cerdas</h1>
                    <p>Sistem ERP minimalis yang dirancang khusus untuk industri kayu. Kelola arus kas, inventory, dan laporan keuangan dalam satu platform yang intuitif.</p>
                    <div class="hero-actions">
                        <a href="/login" class="btn-primary">Akses Dashboard</a>
                        <a href="#fitur" class="btn-outline">Pelajari Fitur</a>
                    </div>
                </div>
                <div class="animate-fade-in" style="animation-delay: 0.3s">
                    <div class="hero-mockup">
                        <img src="{{ asset('storage/images/landing foto.jpeg') }}" alt="Dashboard Preview">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="fitur" class="section">
        <div class="container">
            <div class="section-header reveal">
                <h2>Fitur Analitik & Operasional</h2>
                <p>Platform Jaya Cash dibangun untuk menjawab tantangan spesifik dalam manajemen keuangan industri manufaktur.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal" style="transition-delay: 0.1s">
                    <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Dashboard Real-Time</h3>
                    <p>Pantau saldo bersih, total penjualan, dan pengeluaran harian secara visual melalui antarmuka yang bersih.</p>
                </div>
                <div class="feature-card reveal" style="transition-delay: 0.2s">
                    <div class="feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h3>Laporan Otomatis</h3>
                    <p>Hasilkan Laba Rugi, Buku Besar, dan Neraca secara instan. Tidak ada lagi rekonsiliasi manual yang rumit.</p>
                </div>
                <div class="feature-card reveal" style="transition-delay: 0.3s">
                    <div class="feature-icon"><i class="fas fa-boxes-stacked"></i></div>
                    <h3>Manajemen Produk</h3>
                    <p>Kelola inventory kayu dan produk jadi Anda dengan integrasi langsung ke akun HPP secara otomatis.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="section" style="background: #fff">
        <div class="container">
            <div class="section-header reveal">
                <h2>Alur Kerja yang Efisien</h2>
                <p>Implementasi Jaya Cash ke dalam bisnis Anda sangat sederhana dan terstruktur.</p>
            </div>
            <div class="steps-container reveal">
                <div class="step">
                    <div class="step-num">01</div>
                    <h4>Setup Akun</h4>
                    <p>Daftarkan profil bisnis dan sesuaikan pengaturan dasar sistem.</p>
                </div>
                <div class="step">
                    <div class="step-num">02</div>
                    <h4>Master Data</h4>
                    <p>Atur Bagan Akun (COA) dan daftar produk industri Anda.</p>
                </div>
                <div class="step">
                    <div class="step-num">03</div>
                    <h4>Pencatatan</h4>
                    <p>Input transaksi kas masuk dan keluar dengan lampiran bukti digital.</p>
                </div>
                <div class="step">
                    <div class="step-num">04</div>
                    <h4>Analisis</h4>
                    <p>Dapatkan insight mendalam dari laporan keuangan yang akurat.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <div class="cta-content reveal">
                <h2>Siap Melakukan Transformasi Digital?</h2>
                <p>Bergabunglah dengan ekosistem Jaya Cash dan tingkatkan efisiensi pengelolaan keuangan pabrik Anda hari ini.</p>
                <a href="/login" class="btn-primary" style="background: var(--white); color: var(--primary)">Mulai Sekarang</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <a href="/" class="logo">
                        <img src="{{ asset('storage/images/logo 2.png') }}" alt="Jaya Cash">
                        <span class="logo-text">Jaya Cash</span>
                    </a>
                    <p>Solusi ERP modern yang berfokus pada transparansi dan akuntabilitas keuangan untuk industri pengolahan kayu.</p>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#fitur">Fitur Utama</a></li>
                        <li><a href="#alur">Cara Kerja</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Kontak Support</a></li>
                        <li><a href="#">Keamanan Data</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Jaya Cash. Seluruh hak cipta dilindungi.</p>
                <p>Powered by PK Jaya Abadi</p>
            </div>
        </div>
    </footer>

    <script>
        // Scroll Reveal
        window.addEventListener('scroll', reveal);
        function reveal() {
            var reveals = document.querySelectorAll('.reveal');
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var revealTop = reveals[i].getBoundingClientRect().top;
                var revealPoint = 150;
                if (revealTop < windowHeight - revealPoint) {
                    reveals[i].classList.add('active');
                }
            }
        }
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Initialize reveal on load
        window.onload = function() {
            reveal();
        };

        // NProgress
        window.addEventListener('beforeunload', function() {
            NProgress.start();
        });
    </script>
</body>
</html>