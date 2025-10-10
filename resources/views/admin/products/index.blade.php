@extends('admin.layouts.app')

@section('title', __('admin.products'))
@section('page-title', __('admin.products'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.all_products') }}</h3>
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
                <div class="text-tiny">{{ __('admin.all_products') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
            <form class="form-search" method="GET" action="{{ route('admin.products.index') }}">
                <fieldset class="name">
                    <input type="text" placeholder="{{ __('admin.search_here') }}" class="search-input" name="search" tabindex="2" value="{{ request('search') }}" aria-required="true" id="product-search">
                </fieldset>
                <div class="button-submit">
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>
        <a class="tf-button style-1 w208" href="{{ route('admin.products.create') }}"><i class="icon-plus"></i>{{ __('admin.add_new') }}</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.price') }}</th>
                    <th>{{ __('admin.sale_price') }}</th>
                    <th>{{ __('admin.category') }}</th>
                    <th>{{ __('admin.stock') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td class="pname">
                            <div class="image">
                                <img src="{{ $product->images && count($product->images) > 0 ? asset($product->images[0]) : asset('uploads/products/default.png') }}" alt="{{ $product->name }}" class="image">
                            </div>
                            <div class="name">
                                <a href="{{ route('admin.products.show', $product) }}" class="body-title-2">{{ $product->name }}</a>
                                <div class="text-tiny mt-3">{{ Str::limit($product->description, 50) }}</div>
                            </div>
                        </td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>${{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                        <td>{{ $product->category->name ?? __('admin.no_data') }}</td>
                        <td>{{ $product->stock ?? 0 }}</td>
                        <td>
                            <div class="list-icon-function">
                                <a href="{{ route('admin.products.show', $product) }}" target="_blank">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}">
                                    <div class="item edit">
                                        <i class="icon-edit"></i>
                                    </div>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item delete">
                                        <i class="icon-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-20">
                            <div class="text-center">
                                <i class="icon-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                                <p class="mt-10">{{ __('admin.no_records_found') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
    @endif
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
    
    .pname .image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .pname .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .pname .name {
        flex-grow: 1;
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
    
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge.bg-success {
        background: #d4edda;
        color: #155724;
    }
    
    .badge.bg-danger {
        background: #f8d7da;
        color: #721c24;
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
    
    // Real-time search for products
    $('#product-search').on('input', function() {
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
            url: '{{ route("admin.products.index") }}',
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
});
</script>
@endpush
