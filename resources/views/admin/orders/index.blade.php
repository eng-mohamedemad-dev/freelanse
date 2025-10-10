@extends('admin.layouts.app')

@section('title', __('admin.orders'))
@section('page-title', __('admin.orders'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.orders') }}</h3>
    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-tiny">{{ __('admin.dashboard') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
                <div class="text-tiny">{{ __('admin.orders') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
            <form class="form-search" method="GET" action="{{ route('admin.orders.index') }}">
                <fieldset class="name">
                    <input type="text" placeholder="{{ __('admin.search_here') }}" class="search-input" name="search" tabindex="2" value="{{ request('search') }}" aria-required="true" id="order-search">
                </fieldset>
                <div class="button-submit">
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>
        
        <!-- Filters -->
        <div class="filters-container">
            <select name="status" class="form-control filter-select" id="status-filter">
                <option value="">{{ __('admin.all_status') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('admin.processing') }}</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('admin.shipped') }}</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('admin.delivered') }}</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('admin.cancelled') }}</option>
            </select>
            
        </div>
    </div>
    
    @include('admin.orders.partials.table')
</div>
@endsection

@push('styles')
<style>
    /* Icon Styling - Unified with Products */
    .list-icon-function {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .list-icon-function .item {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .list-icon-function .item i {
        font-size: 14px;
    }
    
    .list-icon-function .item.eye {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .list-icon-function .item.approve {
        background: #e8f5e8;
        color: #2e7d32;
    }
    
    .list-icon-function .item.reject {
        background: #fff3e0;
        color: #f57c00;
    }
    
    .list-icon-function .item.delete {
        background: #ffebee;
        color: #d32f2f;
        border: none;
    }
    
    .list-icon-function .item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Dark Theme Icons */
    .dark-theme .list-icon-function .item.eye {
        background: #1a2332;
        color: #1976d2;
    }
    
    .dark-theme .list-icon-function .item.approve {
        background: #1e3a1e;
        color: #4caf50;
    }
    
    .dark-theme .list-icon-function .item.reject {
        background: #3d2914;
        color: #ff9800;
    }
    
    .dark-theme .list-icon-function .item.delete {
        background: #3a1e1e;
        color: #f44336;
    }
    
    .dark-theme .list-icon-function .item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    .filters-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-select, .date-filter {
        min-width: 150px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .date-filter {
        min-width: 140px;
    }
    
    .order-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .order-status.pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .order-status.processing {
        background: #cce5ff;
        color: #004085;
    }
    
    .order-status.shipped {
        background: #d4edda;
        color: #155724;
    }
    
    .order-status.delivered {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .order-status.cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .list-icon-function {
        display: flex;
        gap: 5px;
    }
    
    .list-icon-function .item {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .list-icon-function .item.eye {
        background: #007bff;
        color: white;
    }
    
    .list-icon-function .item.approve {
        background: #28a745;
        color: white;
    }
    
    .list-icon-function .item.cancel {
        background: #dc3545;
        color: white;
    }
    
    .list-icon-function .item.reject {
        background: #ffc107;
        color: #212529;
    }
    
    .list-icon-function .item.delete {
        background: #dc3545;
        color: white;
    }
    
    .list-icon-function .item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Dark Theme Styles */
    .dark-theme .filter-select, .dark-theme .date-filter {
        background: #404040;
        border-color: #555555;
        color: #ffffff;
    }
    
    .dark-theme .filter-select:focus, .dark-theme .date-filter:focus {
        background: #404040;
        border-color: #007bff;
        color: #ffffff;
    }
    
    .dark-theme .filters-container {
        background: transparent;
    }
    
    /* Order Number Styling */
    .order-number {
        font-weight: 600;
        font-size: 14px;
        color: #007bff;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        min-width: 40px;
        text-align: center;
    }
    
    .dark-theme .order-number {
        background: #404040;
        color: #007bff;
    }
    
    
    
    
    /* Zebra Striping for Tables */
    .table tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }
    
    .table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
    
    .dark-theme .table tbody tr:nth-child(odd) {
        background-color: #404040;
    }
    
    .dark-theme .table tbody tr:nth-child(even) {
        background-color: #505050;
    }
    
    /* Sweet Alert Custom Styling */
    .swal2-popup {
        line-height: 1.4 !important;
    }
    
    .swal2-title {
        line-height: 1.3 !important;
        margin-bottom: 10px !important;
    }
    
    .swal2-content {
        line-height: 1.4 !important;
        margin-top: 10px !important;
        margin-bottom: 20px !important;
    }
    
    .swal2-html-container {
        line-height: 1.4 !important;
        margin: 10px 0 !important;
    }
    
    .swal2-actions {
        margin-top: 20px !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Orders page loaded, initializing search and filter');
    let searchTimeout;
    
    // Initialize event handlers
    initializeEventHandlers();
    
    // Real-time search for orders
    $('#order-search').on('input', function() {
        const searchTerm = $(this).val();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search
        searchTimeout = setTimeout(function() {
            performSearch(searchTerm);
        }, 300);
    });
    
    function performSearch(searchTerm) {
        const status = $('#status-filter').val();
        
        console.log('Performing search:', searchTerm, 'with status:', status);
        
        $.ajax({
            url: '{{ route("admin.orders.index") }}',
            method: 'GET',
            dataType: 'json',
            data: {
                search: searchTerm,
                status: status,
                ajax: 1
            },
            success: function(response) {
                console.log('Search successful, updating table');
                console.log('Response:', response);
                
                if (response.html) {
                    console.log('HTML content:', response.html);
                    
                    // Update table content directly
                    $('.table-responsive').html(response.html);
                    
                    // Update pagination if exists
                    if ($(response.html).find('.pagination-wrapper').length > 0) {
                        $('.pagination-wrapper').html($(response.html).find('.pagination-wrapper').html());
                    } else {
                        $('.pagination-wrapper').empty();
                    }
                    
                    // Re-initialize event handlers for new content
                    initializeEventHandlers();
                } else {
                    console.error('No HTML content in response');
                }
            },
            error: function(xhr, status, error) {
                console.error('Search failed:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    
    // Function to initialize event handlers
    function initializeEventHandlers() {
        // Re-initialize order action handlers
        $('.approve-order').off('click').on('click', function(e) {
            e.preventDefault();
            const orderId = $(this).data('order-id');
            const orderNumber = $(this).data('order-number');
            // Handle approve action
        });
        
        $('.reject-order').off('click').on('click', function(e) {
            e.preventDefault();
            const orderId = $(this).data('order-id');
            const orderNumber = $(this).data('order-number');
            // Handle reject action
        });
        
        $('.delete-order').off('click').on('click', function(e) {
            e.preventDefault();
            const orderId = $(this).data('order-id');
            const orderNumber = $(this).data('order-number');
            // Handle delete action
        });
    }
    
    // Filter change handlers
    $('#status-filter').on('change', function() {
        const searchTerm = $('#order-search').val();
        console.log('Filter changed, performing search:', searchTerm, 'with status:', $(this).val());
        performSearch(searchTerm);
    });
    
    // Handle order status actions
    $('.approve-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.approve_confirmation') }}',
            text: `{{ __('admin.approve_confirmation') }} "${orderNumber}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
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
                // Make AJAX request to approve order
                $.ajax({
                    url: `/admin/orders/${orderId}/mark-completed`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_approved_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء الموافقة على الطلب',
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
                });
            }
        });
    });
    
    // Handle reject order
    $('.reject-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.reject_confirmation') }}',
            text: `{{ __('admin.reject_confirmation') }} "${orderNumber}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
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
                $.ajax({
                    url: `/admin/orders/${orderId}/mark-cancelled`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_rejected_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء رفض الطلب',
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
                });
            }
        });
    });
    
    // Handle delete order
    $('.delete-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.delete_confirmation') }}',
            text: `{{ __('admin.delete_confirmation') }} "${orderNumber}"?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
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
                $.ajax({
                    url: `/admin/orders/${orderId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_deleted_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء حذف الطلب',
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
                });
            }
        });
    });
    
    // Filter change handlers
    $('#status-filter').on('change', function() {
        performSearch($('#order-search').val());
    });
});
</script>
@endpush