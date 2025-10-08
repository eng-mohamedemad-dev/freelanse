@extends('website.layouts.app')

@section('title', __('website.products'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">{{ __('website.products') }}</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Filters -->
            <div class="filters-sidebar">
                <h3>{{ __('website.filters') }}</h3>
                
                <!-- Category Filter -->
                <div class="filter-group">
                    <h4>{{ __('website.categories') }}</h4>
                    <div class="category-list">
                        @foreach($categories ?? [] as $category)
                            <a href="{{ route('website.products.category', $category->id) }}" 
                               class="category-link {{ request()->route('category') == $category->id ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Products Grid -->
            <div class="products-grid">
                @forelse($products ?? [] as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('assets/website/images/products/' . ($product->image ?? 'default.jpg')) }}" 
                                 alt="{{ $product->name }}">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="discount-badge">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            
                            <div class="product-price">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="sale-price">{{ number_format($product->sale_price, 2) }} {{ __('website.currency') }}</span>
                                    <span class="original-price">{{ number_format($product->price, 2) }} {{ __('website.currency') }}</span>
                                @else
                                    <span class="price">{{ number_format($product->price, 2) }} {{ __('website.currency') }}</span>
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
                @empty
                    <div class="no-products">
                        <h3>{{ __('website.no_products_found') }}</h3>
                        <p>{{ __('website.try_different_filters') }}</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if(isset($products) && $products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            if (this.disabled) {
                return;
            }
            
            fetch('{{ route("website.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '{{ __("website.success") }}',
                        text: data.message,
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

    // Add to wishlist functionality
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            fetch('{{ route("website.wishlist.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '{{ __("website.success") }}',
                        text: data.message,
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
        });
    });
</script>
@endpush