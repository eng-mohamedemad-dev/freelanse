<!-- JavaScript Libraries -->
<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
<script src="{{ asset('assets/admin/js/zoom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js -->
<script src="{{ asset('assets/admin/js/apexcharts/apexcharts.js') }}"></script>

<!-- Morris Charts -->
<script src="{{ asset('assets/admin/js/raphael.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/morris.min.js') }}"></script>

<!-- Vector Maps -->
<script src="{{ asset('assets/admin/js/jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jvectormap-us-lcc.js') }}"></script>

<script>
// Global Admin JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap Select
    $('.selectpicker').selectpicker();
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Confirm delete actions
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const itemName = $(this).data('item-name') || 'هذا العنصر';
        
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.are_you_sure_you_want_to_delete') }} ' + itemName + '؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
    
    // Confirm status change actions
    $('.btn-status-change').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const action = $(this).data('action');
        const itemName = $(this).data('item-name') || 'هذا العنصر';
        
        let title = '';
        let text = '';
        
        switch(action) {
            case 'approve':
                title = '{{ __('admin.confirm_approve') }}';
                text = '{{ __('admin.are_you_sure_you_want_to_approve') }} ' + itemName + '؟';
                break;
            case 'reject':
                title = '{{ __('admin.confirm_reject') }}';
                text = '{{ __('admin.are_you_sure_you_want_to_reject') }} ' + itemName + '؟';
                break;
            case 'activate':
                title = '{{ __('admin.confirm_activate') }}';
                text = '{{ __('admin.are_you_sure_you_want_to_activate') }} ' + itemName + '؟';
                break;
            case 'deactivate':
                title = '{{ __('admin.confirm_deactivate') }}';
                text = '{{ __('admin.are_you_sure_you_want_to_deactivate') }} ' + itemName + '؟';
                break;
        }
        
        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: action === 'reject' || action === 'deactivate' ? '#dc3545' : '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        const requiredFields = $(this).find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: '{{ __('admin.validation_error') }}',
                text: '{{ __('admin.please_fill_all_required_fields') }}',
                confirmButtonText: '{{ __('admin.ok') }}'
            });
        }
    });
    
    // Real-time search
    $('.search-input').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        const targetTable = $(this).data('target');
        
        $(targetTable + ' tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(searchTerm) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
    
    // Loading states for buttons
    $('.btn-loading').on('click', function() {
        const btn = $(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true);
        btn.html('<span class="admin-spinner me-2"></span>{{ __('admin.loading') }}...');
        
        // Re-enable after 3 seconds (adjust as needed)
        setTimeout(function() {
            btn.prop('disabled', false);
            btn.html(originalText);
        }, 3000);
    });
    
    // Auto-save functionality
    let autoSaveTimeout;
    $('.auto-save').on('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function() {
            // Implement auto-save logic here
        }, 2000);
    });
    
    // Image preview
    $('.image-input').on('change', function() {
        const file = this.files[0];
        const preview = $(this).siblings('.image-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Copy to clipboard
    $('.btn-copy').on('click', function() {
        const text = $(this).data('copy-text');
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: '{{ __('admin.copied') }}',
                text: '{{ __('admin.text_copied_to_clipboard') }}',
                timer: 2000,
                showConfirmButton: false
            });
        });
    });
    
    // Print functionality
    $('.btn-print').on('click', function() {
        window.print();
    });
    
    // Export functionality
    $('.btn-export').on('click', function() {
        const format = $(this).data('format');
        const tableId = $(this).data('table');
        
        // Implement export logic based on format
    });
    
    // Bulk actions
    $('.select-all').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.item-checkbox').prop('checked', isChecked);
        updateBulkActions();
    });
    
    $('.item-checkbox').on('change', function() {
        updateBulkActions();
    });
    
    function updateBulkActions() {
        const checkedItems = $('.item-checkbox:checked').length;
        const bulkActions = $('.bulk-actions');
        
        if (checkedItems > 0) {
            bulkActions.show();
            $('.bulk-count').text(checkedItems);
        } else {
            bulkActions.hide();
        }
    }
    
    // Initialize charts if present
    if (typeof ApexCharts !== 'undefined') {
        // Chart initialization will be handled in individual pages
    }
    
    // Initialize Morris charts if present
    if (typeof Morris !== 'undefined') {
        // Morris chart initialization will be handled in individual pages
    }
});

// Global functions
window.adminUtils = {
    // Show success message
    showSuccess: function(message) {
        Swal.fire({
            icon: 'success',
            title: '{{ __('admin.success') }}',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    },
    
    // Show error message
    showError: function(message) {
        Swal.fire({
            icon: 'error',
            title: '{{ __('admin.error') }}',
            text: message,
            confirmButtonText: '{{ __('admin.ok') }}'
        });
    },
    
    // Show loading
    showLoading: function() {
        Swal.fire({
            title: '{{ __('admin.loading') }}...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },
    
    // Hide loading
    hideLoading: function() {
        Swal.close();
    },
    
    // Format currency
    formatCurrency: function(amount, currency = 'EGP') {
        return new Intl.NumberFormat('ar-EG', {
            style: 'currency',
            currency: currency
        }).format(amount);
    },
    
    // Format date
    formatDate: function(date, format = 'short') {
        const options = {
            short: { year: 'numeric', month: 'short', day: 'numeric' },
            long: { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }
        };
        
        return new Intl.DateTimeFormat('ar-EG', options[format]).format(new Date(date));
    },
    
    // Validate email
    validateEmail: function(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },
    
    // Validate phone
    validatePhone: function(phone) {
        const re = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        return re.test(phone);
    },
    
    // Generate random string
    generateRandomString: function(length = 10) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }
};
</script>

@stack('scripts')
