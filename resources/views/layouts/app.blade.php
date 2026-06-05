<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo 2.png') }}">
    <title>@yield('title') - Jaya Cash</title>
    <!-- Feather Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Instant.page -->
    <script src="https://instant.page/5.2.0" type="module"></script>
    
    <!-- NProgress -->
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <style>
        #nprogress .bar { background: #1e2a78 !important; height: 3px !important; }
        #nprogress .spinner { display: none !important; }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            background-color: #f8fafc;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1a1a1a;
            min-height: 100vh;
        }

        button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* Print Styles - Hide Sidebar and Navigation */
        @media print {
            .container-wrapper {
                padding: 0 !important;
            }
            
            .sidebar,
            .sidebar-container {
                display: none !important;
            }
            
            .main-content {
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .toast-container,
            button:not(.print-only),
            .btn,
            .btn-primary,
            .btn-outline,
            .btn-outline-navy,
            .actions-column,
            input[type="text"],
            input[type="date"],
            input[type="month"],
            select,
            .filter-section,
            .page-header-actions {
                display: none !important;
            }
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

    <script src="{{ asset('js/auto-refresh.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/modal.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/swal-replacement.js') }}?v={{ time() }}"></script>
    <script>
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number).replace('Rp', 'Rp ').trim();
        }

        // Use Toast component for all notifications
        function showNotification(message, type = 'success') {
            if (typeof Toast !== 'undefined') {
                if (type === 'success') {
                    Toast.success(message);
                } else if (type === 'error') {
                    Toast.error(message);
                } else if (type === 'warning') {
                    Toast.warning(message);
                } else if (type === 'info') {
                    Toast.info(message);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const flash = document.getElementById('globalFlashMessage');
            if (flash) {
                const type = flash.getAttribute('data-type');
                const message = flash.getAttribute('data-message');
                if (message) {
                    if (type === 'success') {
                        Toast.success(message);
                    } else if (type === 'error') {
                        Toast.error(message);
                    }
                }
            }

            // Restore Sidebar Scroll Position
            const sidebarMenu = document.querySelector('.sidebar-menu-container');
            if (sidebarMenu) {
                const scrollPos = sessionStorage.getItem('sidebarScroll');
                if (scrollPos) {
                    sidebarMenu.scrollTop = scrollPos;
                }

                // Save Scroll Position on Click
                sidebarMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        sessionStorage.setItem('sidebarScroll', sidebarMenu.scrollTop);
                    });
                });
            }
        });

        NProgress.configure({ showSpinner: false });
        NProgress.start();
        window.addEventListener('load', () => NProgress.done());
    </script>
    @yield('scripts')
</body>
</html>
