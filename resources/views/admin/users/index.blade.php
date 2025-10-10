@extends('admin.layouts.app')

@section('title', __('admin.users'))
@section('page-title', __('admin.users'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.users') }}</h3>
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
                <div class="text-tiny">{{ __('admin.users') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
            <form class="form-search" method="GET" action="{{ route('admin.users.index') }}">
                <fieldset class="name">
                    <input type="text" placeholder="{{ __('admin.search_here') }}" class="search-input" name="search" tabindex="2" value="{{ request('search') }}" aria-required="true" id="user-search">
                </fieldset>
                <div class="button-submit">
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>
        
    </div>
    
    <!-- Users Table -->
    <div class="table-responsive">
        @include('admin.users.partials.table')
    </div>
    
    <!-- Pagination -->
    <div class="pagination-wrapper">
        @if($users->hasPages())
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Table Font Size */
    .table {
        font-size: 16px !important;
    }
    
    .table th {
        font-size: 16px !important;
        font-weight: 600 !important;
        padding: 15px 10px !important;
    }
    
    .table td {
        font-size: 16px !important;
        padding: 15px 10px !important;
        vertical-align: middle !important;
    }
    
    /* Icon Styling */
    .list-icon-function {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .list-icon-function .item {
        width: 35px;
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
    
    .swal-popup {
        width: 500px !important;
        max-width: 90vw !important;
        padding: 30px !important;
    }
    
    .swal-title {
        font-size: 28px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 20px !important;
    }
    
    .swal-content {
        font-size: 18px !important;
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
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4) !important;
    }
    
    .swal-cancel {
        font-size: 18px !important;
        font-weight: 500 !important;
        padding: 15px 30px !important;
        border-radius: 8px !important;
        background: #6c757d !important;
        border: none !important;
        transition: all 0.3s ease !important;
        margin: 0 10px !important;
    }
    
    .swal-cancel:hover {
        background: #5a6268 !important;
        transform: translateY(-2px) !important;
    }
    
    /* Dark Theme SweetAlert */
    .dark-theme .swal-title {
        color: #fff !important;
        font-size: 28px !important;
    }
    
    .dark-theme .swal-content {
        color: #ccc !important;
        font-size: 18px !important;
    }
    
    .dark-theme .swal-popup {
        background: #2d3748 !important;
        color: #fff !important;
        width: 500px !important;
        padding: 30px !important;
    }
    
    .dark-theme .swal-confirm {
        font-size: 18px !important;
        padding: 15px 30px !important;
    }
    
    .dark-theme .swal-cancel {
        font-size: 18px !important;
        padding: 15px 30px !important;
    }
    
    /* Dark Theme Table */
    .dark-theme .table {
        font-size: 16px !important;
    }
    
    .dark-theme .table th {
        font-size: 16px !important;
        color: #fff !important;
        background-color: #404040 !important;
    }
    
    .dark-theme .table td {
        font-size: 16px !important;
        color: #ccc !important;
    }
    
    .dark-theme .list-icon-function .item {
        width: 30px;
        height: 30px;
    }
    
    .dark-theme .list-icon-function .item i {
        font-size: 14px;
    }
    
    .dark-theme .list-icon-function .item.eye {
        background: #1a2332;
        color: #1976d2;
    }
    
    .dark-theme .list-icon-function .item.delete {
        background: #3a1e1e;
        color: #d32f2f;
    }
    
    .dark-theme .list-icon-function .item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Users page loaded, initializing search');
    var searchTimeout;
    
    // Real-time search for users
    $('#user-search').on('input', function() {
        const searchTerm = $(this).val();
        console.log('Search input changed:', searchTerm);
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search
        searchTimeout = setTimeout(function() {
            console.log('Performing search after timeout:', searchTerm);
            performSearch(searchTerm);
        }, 300);
    });
    
    function performSearch(searchTerm = '') {
        console.log('performSearch called with:', searchTerm);
        
        $.ajax({
            url: '{{ route("admin.users.index") }}',
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                search: searchTerm,
                ajax: 1
            },
            success: function(response) {
                console.log('Search successful, updating table');
                console.log('Response:', response);
                console.log('Response type:', typeof response);
                
                if (typeof response === 'string') {
                    // Handle HTML response
                    console.log('Received HTML response, parsing...');
                    $('.table-responsive').html($(response).find('.table-responsive').html());
                    if ($(response).find('.pagination-wrapper').length > 0) {
                        $('.pagination-wrapper').html($(response).find('.pagination-wrapper').html());
                    } else {
                        $('.pagination-wrapper').empty();
                    }
                } else if (response && response.html) {
                    // Handle JSON response
                    console.log('Received JSON response, parsing...');
                    console.log('HTML content:', response.html);
                    
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
                    console.error('Response structure:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Search failed:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    
    // Delete user functionality
    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');
        const userName = $(this).data('name');
        
        Swal.fire({
            title: '{{ __("admin.are_you_sure") }}',
            text: '{{ __("admin.delete_user_confirmation") }}: ' + userName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("admin.delete") }}',
            cancelButtonText: '{{ __("admin.cancel") }}',
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
                    url: '/admin/users/' + userId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '{{ __("admin.success") }}',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'swal-wide',
                                    title: 'swal-title',
                                    content: 'swal-content'
                                }
                            });
                            
                            // Reload the table
                            performSearch($('#user-search').val());
                        } else {
                            Swal.fire({
                                title: '{{ __("admin.error") }}',
                                text: response.message,
                                icon: 'error',
                                customClass: {
                                    popup: 'swal-wide',
                                    title: 'swal-title',
                                    content: 'swal-content',
                                    confirmButton: 'swal-confirm'
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: '{{ __("admin.error") }}',
                            text: '{{ __("admin.error_deleting_user") }}',
                            icon: 'error',
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
});
</script>
@endpush
