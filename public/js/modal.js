// Modal Helper - Jaya Cash

class Modal {
    constructor(options = {}) {
        this.title = options.title || 'Konfirmasi';
        this.message = options.message || 'Apakah Anda yakin?';
        this.icon = options.icon || 'warning'; // warning, danger, success, info
        this.confirmText = options.confirmText || 'Ya, Lanjutkan';
        this.cancelText = options.cancelText || 'Batal';
        this.onConfirm = options.onConfirm || (() => {});
        this.onCancel = options.onCancel || (() => {});
        
        this.create();
    }
    
    create() {
        // Create modal HTML
        const modalHTML = `
            <div class="modal-overlay" id="confirmModal">
                <div class="modal active">
                    <button class="modal-close" onclick="Modal.close()">&times;</button>
                    <div class="modal-header">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="modal-icon ${this.icon}">
                                ${this.getIcon()}
                            </div>
                            <h3>${this.title}</h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>${this.message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline" onclick="Modal.close()">${this.cancelText}</button>
                        <button type="button" class="btn-${this.icon === 'danger' ? 'danger' : 'primary'}" id="modalConfirmBtn">${this.confirmText}</button>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal if any
        const existing = document.getElementById('confirmModal');
        if (existing) existing.remove();
        
        // Insert modal
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Show modal
        setTimeout(() => {
            document.getElementById('confirmModal').classList.add('active');
        }, 10);
        
        // Attach events
        document.getElementById('modalConfirmBtn').addEventListener('click', () => {
            this.onConfirm();
            Modal.close();
        });
        
        // Close on overlay click
        document.getElementById('confirmModal').addEventListener('click', (e) => {
            if (e.target.id === 'confirmModal') {
                Modal.close();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', this.handleEscape);
    }
    
    getIcon() {
        const icons = {
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            danger: '<i class="fas fa-trash-alt"></i>',
            success: '<i class="fas fa-check-circle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };
        return icons[this.icon] || icons.warning;
    }
    
    handleEscape(e) {
        if (e.key === 'Escape') {
            Modal.close();
        }
    }
    
    static close() {
        const modal = document.getElementById('confirmModal');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 200);
        }
        document.removeEventListener('keydown', this.handleEscape);
    }
}

// Quick confirmation methods
Modal.confirm = (options) => new Modal(options);

Modal.logout = (onConfirm) => {
    return new Modal({
        title: 'Keluar dari Akun',
        message: 'Apakah Anda yakin ingin keluar dari sistem? Anda perlu login kembali untuk mengakses dashboard.',
        icon: 'warning',
        confirmText: 'Ya, Keluar',
        cancelText: 'Batal',
        onConfirm: onConfirm
    });
};

Modal.delete = (itemName, onConfirm) => {
    return new Modal({
        title: 'Hapus Data',
        message: `Apakah Anda yakin ingin menghapus ${itemName}? Data yang sudah dihapus tidak dapat dikembalikan.`,
        icon: 'danger',
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        onConfirm: onConfirm
    });
};

Modal.save = (onConfirm) => {
    return new Modal({
        title: 'Simpan Perubahan',
        message: 'Apakah Anda yakin ingin menyimpan perubahan ini?',
        icon: 'info',
        confirmText: 'Ya, Simpan',
        cancelText: 'Batal',
        onConfirm: onConfirm
    });
};
