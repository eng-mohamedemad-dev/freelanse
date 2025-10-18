// SweetAlert Configuration for the entire site
window.SwalConfig = {
    // Default configuration
    default: {
        confirmButtonText: 'موافق',
        cancelButtonText: 'إلغاء',
        closeButtonText: 'إغلاق',
        timer: 3000,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInUp'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutDown'
        }
    },
    
    // Success messages
    success: function(message, title = 'نجح!') {
        return window.Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonText: 'موافق',
            width: '560px',
            padding: '2rem',
            timer: 3000,
            timerProgressBar: true,
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    },
    
    // Error messages
    error: function(message, title = 'خطأ!') {
        return window.Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonText: 'موافق',
            width: '560px',
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    },
    
    // Warning messages
    warning: function(message, title = 'تحذير!') {
        return window.Swal.fire({
            icon: 'warning',
            title: title,
            text: message,
            confirmButtonText: 'موافق',
            width: '560px',
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    },
    
    // Info messages
    info: function(message, title = 'معلومة') {
        return window.Swal.fire({
            icon: 'info',
            title: title,
            text: message,
            confirmButtonText: 'موافق',
            width: '560px',
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    },
    
    // Confirmation dialog
    confirm: function(message, title = 'تأكيد', confirmText = 'نعم', cancelText = 'لا') {
        return window.Swal.fire({
            title: title,
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            width: '560px',
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    },
    
    // Delete confirmation
    deleteConfirm: function(message = 'هل أنت متأكد من الحذف؟', title = 'تأكيد الحذف') {
        return window.Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            width: '560px',
            padding: '2rem',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        });
    }
};

// Global functions for easy access
window.showSuccess = SwalConfig.success;
window.showError = SwalConfig.error;
window.showWarning = SwalConfig.warning;
window.showInfo = SwalConfig.info;
window.showConfirm = SwalConfig.confirm;
window.showDeleteConfirm = SwalConfig.deleteConfirm;

// Auto-show session messages
$(document).ready(function() {
    // Success message
    if (typeof successMessage !== 'undefined' && successMessage) {
        SwalConfig.success(successMessage);
    }
    
    // Error message
    if (typeof errorMessage !== 'undefined' && errorMessage) {
        SwalConfig.error(errorMessage);
    }
    
    // Warning message
    if (typeof warningMessage !== 'undefined' && warningMessage) {
        SwalConfig.warning(warningMessage);
    }
    
    // Info message
    if (typeof infoMessage !== 'undefined' && infoMessage) {
        SwalConfig.info(infoMessage);
    }
});

console.log('SweetAlert Configuration loaded successfully!');
