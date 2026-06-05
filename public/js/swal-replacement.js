/**
 * SweetAlert2 Replacement Helper
 * 
 * This file provides backward compatibility for code using Swal
 * by redirecting calls to Modal and Toast helpers
 */

// Create Swal object if it doesn't exist
if (typeof Swal === 'undefined') {
    window.Swal = {
        fire: function(arg1, arg2, arg3) {
            // Handle different call signatures
            
            // Swal.fire(title, text, icon)
            if (typeof arg1 === 'string' && typeof arg2 === 'string' && typeof arg3 === 'string') {
                const icon = arg3; // 'success', 'error', 'warning', 'info'
                const message = arg2;
                
                if (typeof Toast !== 'undefined') {
                    if (icon === 'success') {
                        Toast.success(message);
                    } else if (icon === 'error') {
                        Toast.error(message);
                    } else if (icon === 'warning') {
                        Toast.warning(message);
                    } else {
                        Toast.info(message);
                    }
                } else {
                    alert(`${arg1}: ${message}`);
                }
                
                // Return a promise that resolves immediately
                return Promise.resolve({ isConfirmed: true });
            }
            
            // Swal.fire({ options object })
            if (typeof arg1 === 'object') {
                const options = arg1;
                
                // If it has showCancelButton, it's a confirmation dialog
                if (options.showCancelButton) {
                    return new Promise((resolve) => {
                        if (typeof Modal !== 'undefined') {
                            Modal.confirm({
                                title: options.title || 'Konfirmasi',
                                message: options.text || options.html || '',
                                icon: options.icon === 'warning' ? 'warning' : (options.icon === 'error' ? 'danger' : 'info'),
                                confirmText: options.confirmButtonText || 'Ya',
                                cancelText: options.cancelButtonText || 'Batal',
                                onConfirm: () => resolve({ isConfirmed: true }),
                                onCancel: () => resolve({ isConfirmed: false, isDismissed: true })
                            });
                        } else {
                            // Fallback to native confirm
                            const result = confirm(`${options.title}\n${options.text || options.html}`);
                            resolve({ isConfirmed: result, isDismissed: !result });
                        }
                    });
                } else {
                    // Simple alert
                    const icon = options.icon || 'info';
                    const message = options.text || options.html || '';
                    
                    if (typeof Toast !== 'undefined') {
                        if (icon === 'success') {
                            Toast.success(message);
                        } else if (icon === 'error') {
                            Toast.error(message);
                        } else if (icon === 'warning') {
                            Toast.warning(message);
                        } else {
                            Toast.info(message);
                        }
                    } else {
                        alert(`${options.title || ''}: ${message}`);
                    }
                    
                    return Promise.resolve({ isConfirmed: true });
                }
            }
            
            // Fallback
            return Promise.resolve({ isConfirmed: true });
        },
        
        // Additional methods that might be called
        getConfirmButton: function() {
            return document.querySelector('.btn-confirm') || document.createElement('button');
        },
        
        getCancelButton: function() {
            return document.querySelector('.btn-cancel') || document.createElement('button');
        }
    };
    
    console.log('Swal compatibility layer loaded - redirecting to Modal/Toast');
}
