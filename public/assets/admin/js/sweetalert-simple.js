// Simple SweetAlert Configuration
$(document).ready(function() {
    // Success message
    if (typeof successMessage !== 'undefined' && successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'تم بنجاح!',
            text: successMessage,
            confirmButtonText: 'موافق',
            timer: 4000,
            timerProgressBar: true,
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    }
    
    // Error message
    if (typeof errorMessage !== 'undefined' && errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'حدث خطأ!',
            text: errorMessage,
            confirmButtonText: 'موافق',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    }
    
    // Handle delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const productName = form.closest('tr').find('.body-title-2').text();
        
        Swal.fire({
            title: 'تأكيد الحذف',
            text: `هل أنت متأكد من حذف المنتج "${productName}"؟`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm',
                cancelButton: 'swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.off('submit').submit();
            }
        });
    });
    
    console.log('SweetAlert Simple Configuration loaded successfully!');
});
