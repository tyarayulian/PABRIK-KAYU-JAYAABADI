<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('storage/images/logo 2.png')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - Jaya Cash</title>
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

        <?php echo $__env->yieldContent('styles'); ?>
        
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
        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="main-content">
            <div class="page-content">
                <div class="toast-container" id="toastContainer"></div>
                <?php if(session('success')): ?>
                    <div id="globalFlashMessage" data-type="success" data-message="<?php echo e(session('success')); ?>" style="display: none;"></div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div id="globalFlashMessage" data-type="error" data-message="<?php echo e(session('error')); ?>" style="display: none;"></div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/auto-refresh.js')); ?>"></script>
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

        function showNotification(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast-item ${type}`;
            
            const icons = {
                success: 'check-circle',
                error: 'alert-circle',
                info: 'info'
            };
            const icon = icons[type] || 'info';

            toast.innerHTML = `
                <div class="toast-icon">
                    <i data-feather="${icon}"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${type === 'success' ? 'Berhasil' : (type === 'error' ? 'Gagal' : 'Informasi')}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <div class="toast-close" onclick="this.parentElement.remove()">
                    <i data-feather="x"></i>
                </div>
            `;

            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 10);

            // Auto hide
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const flash = document.getElementById('globalFlashMessage');
            if (flash) {
                const type = flash.getAttribute('data-type');
                const message = flash.getAttribute('data-message');
                if (message) showNotification(message, type);
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
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/layouts/app.blade.php ENDPATH**/ ?>