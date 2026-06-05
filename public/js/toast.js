// Toast Notification Component - Jaya Cash

class Toast {
    static show(message, type = 'success', duration = 3000) {
        // Remove existing toast if any
        const existingToast = document.getElementById('globalToast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.id = 'globalToast';
        
        // Set styles based on type - CLEAN MODERN DESIGN dengan border kiri
        let borderColor, iconBg, iconColor, icon;
        switch(type) {
            case 'success':
                borderColor = '#1e2a78'; // Navy Blue
                iconBg = '#f0f7ff';
                iconColor = '#1e2a78';
                icon = '✓';
                break;
            case 'error':
                borderColor = '#dc2626'; // Red
                iconBg = '#fef2f2';
                iconColor = '#dc2626';
                icon = '✕';
                break;
            case 'warning':
                borderColor = '#f59e0b'; // Orange
                iconBg = '#fff7ed';
                iconColor = '#f59e0b';
                icon = '⚠';
                break;
            case 'info':
                borderColor = '#3b82f6'; // Light Blue
                iconBg = '#eff6ff';
                iconColor = '#3b82f6';
                icon = 'ℹ';
                break;
            default:
                borderColor = '#1e2a78';
                iconBg = '#f0f7ff';
                iconColor = '#1e2a78';
                icon = '✓';
        }

        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            color: #1e293b;
            padding: 16px 20px;
            border-radius: 12px;
            border-left: 4px solid ${borderColor};
            z-index: 10000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            animation: slideInRight 0.3s ease-out;
        `;

        toast.innerHTML = `
            <div style="
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: ${iconBg};
                color: ${iconColor};
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                font-weight: 700;
                flex-shrink: 0;
            ">${icon}</div>
            <div style="flex: 1;">
                <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;">
                    ${type === 'success' ? 'Berhasil' : (type === 'error' ? 'Error' : (type === 'warning' ? 'Peringatan' : 'Informasi'))}
                </div>
                <div style="font-weight: 500; color: #64748b; font-size: 13px;">${message}</div>
            </div>
        `;
        
        document.body.appendChild(toast);

        // Auto remove after duration
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, duration);
    }

    static success(message, duration = 3000) {
        this.show(message, 'success', duration);
    }

    static error(message, duration = 3000) {
        this.show(message, 'error', duration);
    }

    static warning(message, duration = 3000) {
        this.show(message, 'warning', duration);
    }

    static info(message, duration = 3000) {
        this.show(message, 'info', duration);
    }
}

// Add CSS animations
if (!document.getElementById('toastAnimations')) {
    const style = document.createElement('style');
    style.id = 'toastAnimations';
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Export untuk global usage
window.Toast = Toast;
