@extends('website.layouts.app')

@section('title', __('website.products'))

@section('content')
<!-- Products Header -->
<section class="products-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">{{ __('website.products') }}</h1>
                <p class="page-description">{{ __('website.products_description') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Filters and Search -->
<section class="products-filters">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="filters-card">
                    <form id="filter-form" method="GET" action="{{ route('website.products.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">{{ __('website.search') }}</label>
                                    <input type="text" 
                                           name="search" 
                                           id="search" 
                                           class="form-control" 
                                           placeholder="{{ __('website.search_placeholder') }}"
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category">{{ __('website.category') }}</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">{{ __('website.all_categories') }}</option>
                                        @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="brand">{{ __('website.brand') }}</label>
                                    <select name="brand" id="brand" class="form-select">
                                        <option value="">{{ __('website.all_brands') }}</option>
                                        @foreach($brands ?? [] as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sort">{{ __('website.sort_by') }}</label>
                                    <select name="sort" id="sort" class="form-select">
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                            {{ __('website.name_asc') }}
                                        </option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                            {{ __('website.name_desc') }}
                                        </option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            {{ __('website.price_low_high') }}
                                        </option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            {{ __('website.price_high_low') }}
                                        </option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                            {{ __('website.newest') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-filter"></i> {{ __('website.apply_filters') }}
                                </button>
                                <a href="{{ route('website.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa fa-refresh"></i> {{ __('website.clear_filters') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="products-grid">
    <div class="container">
        <div class="row">
            @forelse($products ?? [] as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ?? asset('assets/website/images/placeholder.jpg') }}" 
                             alt="{{ $product->name }}"
                             class="img-fluid">
                        <div class="product-overlay">
                            <a href="{{ route('website.products.show', $product) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> {{ __('website.view_details') }}
                            </a>
                        </div>
                        @if($product->discount_percentage > 0)
                        <div class="product-discount">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h5 class="product-title">
                            <a href="{{ route('website.products.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                            @endfor
                            <span class="rating-count">({{ $product->reviews_count ?? 0 }})</span>
                        </div>
                        <div class="product-price">
                            @if($product->discount_price)
                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="product-actions">
                            <button class="btn btn-primary add-to-cart" 
                                    data-product-id="{{ $product->id }}"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa fa-shopping-cart"></i> 
                                {{ $product->stock <= 0 ? __('website.out_of_stock') : __('website.add_to_cart') }}
                            </button>
                            <button class="btn btn-success quick-order" 
                                    data-product-id="{{ $product->id }}"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa fa-bolt"></i> 
                                {{ __('website.quick_order') }}
                            </button>
                            <button class="btn btn-outline-primary add-to-wishlist" 
                                    data-product-id="{{ $product->id }}">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <div class="no-products text-center">
                    <i class="fa fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">{{ __('website.no_products_found') }}</h4>
                    <p class="text-muted">{{ __('website.try_different_filters') }}</p>
                    <a href="{{ route('website.products.index') }}" class="btn btn-primary">
                        {{ __('website.view_all_products') }}
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($products) && $products->hasPages())
        <div class="row">
            <div class="col-md-12">
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.products-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.page-description {
    font-size: 1.2rem;
    opacity: 0.9;
}

.filters-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.products-grid {
    padding: 2rem 0;
}

.product-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    position: relative;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-discount {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e74c3c;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: bold;
}

.product-info {
    padding: 1.5rem;
}

.product-title a {
    color: #333;
    text-decoration: none;
    font-weight: 600;
}

.product-title a:hover {
    color: #007bff;
}

.product-rating {
    margin: 0.5rem 0;
}

.product-rating .fa-star {
    color: #f39c12;
}

.rating-count {
    color: #666;
    font-size: 0.9rem;
    margin-left: 0.5rem;
}

.product-price {
    margin: 1rem 0;
}

.current-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #27ae60;
}

.original-price {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
    margin-left: 0.5rem;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
}

.product-actions .btn {
    flex: 1;
}

.no-products {
    padding: 3rem 0;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .filters-card {
        padding: 1rem;
    }
    
    .product-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            if (this.disabled) {
                return;
            }
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ __("website.adding") }}...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                showAlert('{{ __("website.product_added_to_cart") }}', 'success');
            }, 1000);
        });
    });

    // Add to wishlist functionality
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            // Toggle wishlist state
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.className = 'fa fa-heart';
                showAlert('{{ __("website.product_added_to_wishlist") }}', 'success');
            } else {
                icon.className = 'fa fa-heart-o';
                showAlert('{{ __("website.product_removed_from_wishlist") }}', 'info');
            }
        });
    });

    // Quick order functionality
    const quickOrderButtons = document.querySelectorAll('.quick-order');
    quickOrderButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            if (this.disabled) {
                return;
            }
            
            // Show quick order form
            Swal.fire({
                title: '{{ __("website.quick_order") }}',
                html: `
                    <div class="quick-order-form">
                        <div class="mb-3">
                            <label class="form-label">{{ __("website.quantity") }}</label>
                            <input type="number" id="quantity" class="form-control" value="1" min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("website.customer_name") }} *</label>
                            <input type="text" id="customer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("website.customer_phone") }} *</label>
                            <input type="tel" id="customer_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("website.customer_address") }} *</label>
                            <textarea id="customer_address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '{{ __("website.place_order") }}',
                cancelButtonText: '{{ __("website.cancel") }}',
                preConfirm: () => {
                    const quantity = document.getElementById('quantity').value;
                    const customerName = document.getElementById('customer_name').value;
                    const customerPhone = document.getElementById('customer_phone').value;
                    const customerAddress = document.getElementById('customer_address').value;
                    
                    if (!customerName || !customerPhone || !customerAddress) {
                        Swal.showValidationMessage('{{ __("website.please_fill_all_fields") }}');
                        return false;
                    }
                    
                    return {
                        product_id: productId,
                        quantity: quantity,
                        customer_name: customerName,
                        customer_phone: customerPhone,
                        customer_address: customerAddress
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit quick order
                    fetch('{{ route("website.quick-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '{{ __("website.success") }}',
                                text: '{{ __("website.order_placed_successfully") }}',
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: '{{ __("website.error") }}',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: '{{ __("website.error") }}',
                            text: '{{ __("website.something_went_wrong") }}',
                            icon: 'error'
                        });
                    });
                }
            });
        });
    });
});
</script>
@endpush
