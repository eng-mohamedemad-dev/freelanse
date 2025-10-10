@extends('admin.layouts.app')

@section('title', __('admin.all_categories'))
@section('page-title', __('admin.all_categories'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.all_categories') }}</h3>
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
            <div class="text-tiny">{{ __('admin.all_categories') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
            <form class="form-search" method="GET" action="{{ route('admin.categories.index') }}">
                <fieldset class="name">
                    <input type="text" placeholder="{{ __('admin.search_here') }}" class="search-input" name="search" tabindex="2" value="{{ request('search') }}" aria-required="true" id="category-search">
                </fieldset>
                <div class="button-submit">
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>
        <a class="tf-button style-1 w208" href="{{ route('admin.categories.create') }}"><i class="icon-plus"></i>{{ __('admin.add_new') }}</a>
    </div>
    @include('admin.categories.partials.table')
</div>
@endsection

@push('styles')
<style>
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
    
    .dark-theme .table tbody tr:nth-child(odd) td {
        color: #ffffff;
    }
    
    .dark-theme .table tbody tr:nth-child(even) td {
        color: #ffffff;
    }
    
    .pname {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .category-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .list-icon-function {
        display: flex;
        gap: 5px;
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
    }
    
    .list-icon-function .item.eye {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .list-icon-function .item.edit {
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
    
    /* SweetAlert Custom Styles */
    .swal-wide {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 500px !important;
        max-width: 90vw !important;
    }
    
    .swal-title {
        font-size: 32px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 20px !important;
    }
    
    .swal-content {
        font-size: 20px !important;
        line-height: 1.6 !important;
        color: #555 !important;
        margin: 20px 0 !important;
    }
    
    .swal-confirm {
        font-size: 18px !important;
        font-weight: 500 !important;
        padding: 15px 30px !important;
        border-radius: 8px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        transition: all 0.3s ease !important;
        margin: 0 10px !important;
    }
    
    .swal-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    }
    
    .swal2-popup {
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    
    .swal2-icon {
        margin: 20px auto 15px !important;
    }
    
    .swal2-icon.swal2-success {
        border-color: #28a745 !important;
        color: #28a745 !important;
    }
    
    .swal2-icon.swal2-error {
        border-color: #dc3545 !important;
        color: #dc3545 !important;
    }
    
    .swal2-icon.swal2-warning {
        border-color: #ffc107 !important;
        color: #ffc107 !important;
    }
    
    /* Dark Theme SweetAlert */
    .dark-theme .swal-title {
        color: #fff !important;
    }
    
    .dark-theme .swal-content {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .swal2-popup {
        background: #2d3748 !important;
        color: #fff !important;
    }
    
    /* Enhanced Pagination Styles */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
    }
    
    .pagination .page-item {
        margin: 0;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 8px 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: #fff;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .pagination .page-link:hover {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: #fff;
        font-weight: 600;
    }
    
    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .pagination .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
        background: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
    }
    
    /* Dark Theme Pagination */
    .dark-theme .pagination .page-link {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    .dark-theme .pagination .page-link:hover {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
    }
    
    .dark-theme .pagination .page-item.disabled .page-link {
        background: #4a5568;
        border-color: #718096;
        color: #a0aec0;
    }
    
    .dark-theme .pagination .page-item.disabled .page-link:hover {
        background: #4a5568;
        border-color: #718096;
        color: #a0aec0;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimeout;
    
    // Real-time search for categories
    $('#category-search').on('input', function() {
        const searchTerm = $(this).val();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search
        searchTimeout = setTimeout(function() {
            if (searchTerm.length >= 2 || searchTerm.length === 0) {
                performSearch(searchTerm);
            }
        }, 300);
    });
    
    function performSearch(searchTerm) {
        $.ajax({
            url: '{{ route("admin.categories.index") }}',
            method: 'GET',
            dataType: 'json',
            data: {
                search: searchTerm,
                ajax: 1
            },
            success: function(response) {
                console.log('Search successful, updating table');
                console.log('Response:', response);
                
                if (response && response.html) {
                    // Update table content directly
                    $('.table-responsive').html(response.html);
                    
                    // Update pagination if exists
                    if ($(response.html).find('.pagination-wrapper').length > 0) {
                        $('.pagination-wrapper').html($(response.html).find('.pagination-wrapper').html());
                    } else {
                        $('.pagination-wrapper').empty();
                    }
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
    
    // Show success/error messages if they exist
    @if(session('success'))
        Swal.fire({
            title: '{{ __("admin.success") }}',
            text: '{{ __("admin.category_created_successfully") }}',
            icon: 'success',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            title: '{{ __("admin.error_occurred") }}',
            text: '{{ __("admin.error_occurred_message") }}',
            icon: 'error',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    @endif
});
</script>
@endpush
