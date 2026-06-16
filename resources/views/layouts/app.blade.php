<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Preconnect to external resources for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    
    <!-- DNS Prefetch for instant.page -->
    <link rel="dns-prefetch" href="https://instant.page">
    <link rel="dns-prefetch" href="https://unpkg.com">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo 2.png') }}">
    <title>@yield('title') - Jaya Cash</title>
    
    <!-- Critical CSS - Load font asynchronously -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"></noscript>
    
    <!-- Font Awesome - Async -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    
    <!-- NProgress CSS - Async -->
    <link rel="preload" href="https://unpkg.com/nprogress@0.2.0/nprogress.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css"></noscript>
    
    <!-- Scripts - Load di head dengan defer -->
    <script defer src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script defer src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <script defer src="https://instant.page/5.2.0" type="module"></script>
    <style>
        /* Critical CSS - Inline untuk fast first paint */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            background-color: #f8fafc;
            overflow-x: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #1a1a1a;
            min-height: 100vh;
        }

        /* Font akan di-load async, fallback ke system fonts dulu */
        .font-loaded {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        .container-wrapper {
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: transparent;
            overflow: hidden;
            min-height: calc(100vh - 40px);
        }

        .page-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #d0d0d0; }

        /* NProgress inline styles */
        #nprogress .bar { background: #1e2a78 !important; height: 3px !important; z-index: 99999 !important; }
        #nprogress .spinner { display: none !important; }
        #nprogress .peg { box-shadow: 0 0 10px #1e2a78, 0 0 5px #1e2a78 !important; }

        /* Print Styles */
        @media print {
            .container-wrapper { padding: 0 !important; }
            .sidebar, .sidebar-container { display: none !important; }
            .main-content { margin: 0 !important; padding: 0 !important; }
            .toast-container, button:not(.print-only), .btn, .actions-column,
            input[type="text"], input[type="date"], input[type="month"],
            select, .filter-section, .page-header-actions { display: none !important; }
        }

        @yield('styles')
        
        <style>
            /* Toast Notification Styles */
            .toast-container {
                position: fixed;
                top: 24px;
                right: 24px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 12px;
                pointer-events: none;
            }

            .toast-item {
                min-width: 320px;
                max-width: 400px;
                background: white;
                border-radius: 16px;
                padding: 16px 20px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.08);
                display: flex;
                align-items: center;
                gap: 16px;
                pointer-events: auto;
                transform: translateX(120%);
                transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                border-left: 6px solid #e2e8f0;
            }

            .toast-item.show {
                transform: translateX(0);
            }

            .toast-item.success { border-left-color: #10b981; }
            .toast-item.error { border-left-color: #ef4444; }
            .toast-item.info { border-left-color: #3b82f6; }

            .toast-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .success .toast-icon { background: #ecfdf5; color: #10b981; }
            .error .toast-icon { background: #fef2f2; color: #ef4444; }
            .info .toast-icon { background: #eff6ff; color: #3b82f6; }

            .toast-content { flex: 1; }
            .toast-title {
                font-weight: 800;
                font-size: 14px;
                color: #1e293b;
                margin-bottom: 2px;
                text-transform: capitalize;
            }
            .toast-message {
                font-size: 13px;
                color: #64748b;
                font-weight: 500;
                line-height: 1.4;
            }

            .toast-close {
                color: #94a3b8;
                cursor: pointer;
                padding: 4px;
                transition: 0.2s;
            }
            .toast-close:hover { color: #1e293b; }
        </style>
    </head>
<body>
    <!-- Loading Screen (hilang otomatis setelah page ready) -->
    <div id="page-loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #f8fafc; z-index: 999999; display: flex; align-items: center; justify-content: center; transition: opacity 0.3s ease;">
        <div style="text-align: center;">
            <div style="width: 50px; height: 50px; border: 3px solid #e2e8f0; border-top-color: #1e2a78; border-radius: 50%; animation: spin 0.8s linear infinite;"></div>
            <p style="margin-top: 16px; color: #64748b; font-size: 14px; font-weight: 600;">Loading...</p>
        </div>
    </div>
    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <div class="container-wrapper">
        @include('layouts.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="toast-container" id="toastContainer"></div>
                @if(session('success'))
                    <div id="globalFlashMessage" data-type="success" data-message="{{ session('success') }}" style="display: none;"></div>
                @endif
                @if(session('error'))
                    <div id="globalFlashMessage" data-type="error" data-message="{{ session('error') }}" style="display: none;"></div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- App Scripts - Load setelah Turbo -->
    <script defer src="{{ asset('js/auto-refresh.js') }}"></script>
    <script defer src="{{ asset('js/toast.js') }}?v={{ time() }}"></script>
    <script defer src="{{ asset('js/modal.js') }}?v={{ time() }}"></script>
    <script defer src="{{ asset('js/swal-replacement.js') }}?v={{ time() }}"></script>
    
    <script>
        // Hide page loader
        function hideLoader() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => { if (loader.parentNode) loader.remove(); }, 300);
            }
        }

        // Hide on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            hideLoader();
            document.body.classList.add('font-loaded');

            // Flash message
            const flash = document.getElementById('globalFlashMessage');
            if (flash) {
                const type = flash.getAttribute('data-type');
                const message = flash.getAttribute('data-message');
                if (message && typeof Toast !== 'undefined') {
                    Toast[type] ? Toast[type](message) : Toast.success(message);
                }
            }

            // Restore Sidebar Scroll Position
            const sidebarMenu = document.querySelector('.sidebar-menu-container');
            if (sidebarMenu) {
                const scrollPos = sessionStorage.getItem('sidebarScroll');
                if (scrollPos) sidebarMenu.scrollTop = parseInt(scrollPos);

                sidebarMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        sessionStorage.setItem('sidebarScroll', sidebarMenu.scrollTop);
                    });
                });
            }

            // Initialize feather icons
            if (typeof feather !== 'undefined' && feather.replace) {
                feather.replace();
            }
        });

        // Hard timeout fallback - 1.5s maksimal
        setTimeout(hideLoader, 1500);

        // Global utilities
        window.formatRupiah = function(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number).replace('Rp', 'Rp ').trim();
        };

        window.showNotification = function(message, type = 'success') {
            if (typeof Toast !== 'undefined') {
                Toast[type] ? Toast[type](message) : Toast.success(message);
            }
        };
    </script>
    @yield('scripts')
</body>
</html>
