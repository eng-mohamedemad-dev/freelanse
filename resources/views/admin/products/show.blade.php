@extends('admin.layouts.app')

@section('title', __('admin.view_product'))
@section('page-title', __('admin.view_product'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.view_product') }}</h3>
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
            <a href="{{ route('admin.products.index') }}">
                <div class="text-tiny">{{ __('admin.products') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ __('admin.view_product') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap mb-20">
        <h4>{{ $product->display_name }}</h4>
        <div class="flex items-center gap10">
            <a href="{{ route('admin.products.edit', $product) }}" class="tf-button style-1">
                <i class="icon-edit"></i> {{ __('admin.edit_product') }}
            </a>
            <a href="{{ route('admin.products.index') }}" class="tf-button style-2">
                <i class="icon-arrow-left"></i> {{ __('admin.back_to_products') }}
            </a>
        </div>
    </div>

    <div class="product-view-container">
        <div class="product-main-info">
            <div class="product-image-section">
                <h5 class="section-title">{{ __('admin.product_images') }}</h5>
                @if($product->images && count($product->images) > 0)
                    <div class="image-gallery">
                        @foreach($product->images as $index => $image)
                            <div class="image-item">
                                <img src="{{ asset($image) }}" alt="{{ $product->display_name }}" class="product-image">
                                <div class="image-overlay">
                                    <span class="image-number">{{ $index + 1 }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-images">
                        <div class="no-image-icon">
                            <i class="icon-image"></i>
                        </div>
                        <p class="no-image-text">{{ __('admin.no_images_found') }}</p>
                    </div>
                @endif
            </div>
            
            <div class="product-details-section">
                <h5 class="section-title">{{ __('admin.product_details') }}</h5>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.product_name') }}</div>
                        <div class="detail-value">{{ $product->display_name }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.description') }}</div>
                        <div class="detail-value">{{ $product->display_description }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.category') }}</div>
                        <div class="detail-value">
                            <span class="category-badge">{{ $product->category->name ?? __('admin.no_data') }}</span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.regular_price') }}</div>
                        <div class="detail-value price-regular">${{ number_format($product->price, 2) }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.sale_price') }}</div>
                        <div class="detail-value price-sale">${{ number_format($product->sale_price ?? $product->price, 2) }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.quantity') }}</div>
                        <div class="detail-value stock-quantity">{{ $product->stock ?? 0 }}</div>
                    </div>
                    
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.created_at') }}</div>
                        <div class="detail-value">{{ $product->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.updated_at') }}</div>
                        <div class="detail-value">{{ $product->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($product->variants && $product->variants->count() > 0)
        <div class="product-variants-section">
            <h5 class="section-title">{{ __('admin.product_variants') }}</h5>
            <div class="variants-grid">
                @foreach($product->variants as $index => $variant)
                    <div class="variant-card">
                        <div class="variant-header">
                            <h6 class="variant-title">{{ __('admin.variant') }} {{ $index + 1 }}</h6>
                        </div>
                        
                        <div class="variant-content">
                            <div class="variant-details">
                                <div class="variant-detail-item">
                                    <span class="variant-label">{{ __('admin.size') }}:</span>
                                    <span class="variant-value">{{ $variant->size->display_name ?? __('admin.no_data') }}</span>
                                </div>
                                
                                <div class="variant-detail-item">
                                    <span class="variant-label">{{ __('admin.color') }}:</span>
                                    <span class="variant-value">
                                        @if($variant->color)
                                            <span class="color-indicator" style="background-color: {{ $variant->color->hex ?? '#ccc' }};"></span>
                                            {{ $variant->color->display_name }}
                                        @else
                                            {{ __('admin.no_data') }}
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="variant-detail-item">
                                    <span class="variant-label">{{ __('admin.price') }}:</span>
                                    <span class="variant-value price">${{ number_format($variant->price, 2) }}</span>
                                </div>
                                
                                <div class="variant-detail-item">
                                    <span class="variant-label">{{ __('admin.stock') }}:</span>
                                    <span class="variant-value stock">{{ $variant->stock }}</span>
                                </div>
                            </div>
                            
                            @if($variant->images && count($variant->images) > 0)
                                <div class="variant-images">
                                    <h6 class="variant-images-title">{{ __('admin.variant_images') }}</h6>
                                    <div class="variant-image-gallery">
                                        @foreach($variant->images as $imgIndex => $image)
                                            <div class="variant-image-item">
                                                <img src="{{ asset($image) }}" alt="Variant Image {{ $imgIndex + 1 }}" class="variant-image">
                                                <div class="variant-image-overlay">
                                                    <span class="image-number">{{ $imgIndex + 1 }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-view-container {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .product-main-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }
    
    .product-image-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
    }
    
    .image-item {
        position: relative;
        border: 3px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .image-item:hover {
        border-color: #007bff;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,123,255,0.2);
    }
    
    .product-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        display: block;
    }
    
    .image-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,123,255,0.9);
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .no-images {
        text-align: center;
        padding: 60px 20px;
        border: 3px dashed #dee2e6;
        border-radius: 12px;
        background: #f8f9fa;
    }
    
    .no-image-icon {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    .no-image-text {
        color: #6c757d;
        font-size: 16px;
        margin: 0;
    }
    
    .product-details-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
    }
    
    .details-grid {
        display: grid;
        gap: 20px;
    }
    
    .detail-item {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 15px;
        align-items: center;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border-left: 4px solid #007bff;
        transition: all 0.3s ease;
    }
    
    .detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }
    
    .detail-value {
        color: #212529;
        font-size: 15px;
    }
    
    .category-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .price-regular {
        color: #6c757d;
        text-decoration: line-through;
        font-size: 14px;
    }
    
    .price-sale {
        color: #28a745;
        font-weight: 600;
        font-size: 16px;
    }
    
    .stock-quantity {
        color: #007bff;
        font-weight: 600;
        font-size: 16px;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }
    
    .status-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }
    
    .tf-button {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .tf-button.style-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .tf-button.style-1:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .tf-button.style-2 {
        background: #6c757d;
        color: white;
    }
    
    .tf-button.style-2:hover {
        background: #545b62;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }
    
    /* Product Variants Styles */
    .product-variants-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #e9ecef;
    }
    
    .variants-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }
    
    .variant-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .variant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    
    .variant-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .variant-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .variant-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .variant-content {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .variant-details {
        display: grid;
        gap: 12px;
    }
    
    .variant-detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: white;
        border-radius: 6px;
        border-left: 3px solid #007bff;
    }
    
    .variant-label {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
    }
    
    .variant-value {
        color: #212529;
        font-size: 14px;
        font-weight: 500;
    }
    
    .variant-value.price {
        color: #28a745;
        font-weight: 600;
    }
    
    .variant-value.stock {
        color: #007bff;
        font-weight: 600;
    }
    
    .color-indicator {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 8px;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #dee2e6;
        vertical-align: middle;
        position: relative;
    }
    
    .color-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: inherit;
    }
    
    .variant-images {
        margin-top: 15px;
    }
    
    .variant-images-title {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
    }
    
    .variant-image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
    }
    
    .variant-image-item {
        position: relative;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .variant-image-item:hover {
        border-color: #007bff;
        transform: scale(1.05);
    }
    
    .variant-image {
        width: 100%;
        height: 80px;
        object-fit: cover;
        display: block;
    }
    
    .variant-image-overlay {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(0,123,255,0.9);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
    }
    
    /* Dark Theme Support */
    .dark-theme .product-view-container {
        background: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .section-title {
        color: #e2e8f0 !important;
        border-bottom-color: #4299e1 !important;
    }
    
    .dark-theme .product-image-section {
        background: #1a202c !important;
    }
    
    .dark-theme .product-details-section {
        background: #1a202c !important;
    }
    
    .dark-theme .detail-item {
        background: #2d3748 !important;
        border-left-color: #4299e1 !important;
    }
    
    .dark-theme .detail-item:hover {
        background: #4a5568 !important;
    }
    
    .dark-theme .detail-label {
        color: #a0aec0 !important;
    }
    
    .dark-theme .detail-value {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .no-images {
        background: #1a202c !important;
        border-color: #4a5568 !important;
    }
    
    .dark-theme .no-image-icon {
        color: #a0aec0 !important;
    }
    
    .dark-theme .no-image-text {
        color: #a0aec0 !important;
    }
    
    .dark-theme .image-item {
        border-color: #4a5568 !important;
    }
    
    .dark-theme .image-item:hover {
        border-color: #4299e1 !important;
    }
    
    .dark-theme .product-variants-section {
        border-top-color: #4a5568;
    }
    
    .dark-theme .variant-card {
        background: #1a202c;
        border-color: #4a5568;
    }
    
    .dark-theme .variant-card:hover {
        border-color: #4299e1;
    }
    
    .dark-theme .variant-title {
        color: #e2e8f0;
    }
    
    .dark-theme .variant-header {
        border-bottom-color: #4a5568;
    }
    
    .dark-theme .variant-detail-item {
        background: #2d3748;
        border-left-color: #4299e1;
    }
    
    .dark-theme .variant-label {
        color: #a0aec0;
    }
    
    .dark-theme .variant-value {
        color: #e2e8f0;
    }
    
    .dark-theme .variant-images-title {
        color: #a0aec0;
    }
    
    .dark-theme .variant-image-item {
        border-color: #4a5568;
    }
    
    .dark-theme .variant-image-item:hover {
        border-color: #4299e1;
    }
    
    /* Additional Dark Theme Support */
    .dark-theme .wg-box {
        background: #2d3748 !important;
        border-color: #4a5568 !important;
    }
    
    .dark-theme .breadcrumbs a {
        color: #a0aec0 !important;
    }
    
    .dark-theme .breadcrumbs .text-tiny {
        color: #a0aec0 !important;
    }
    
    .dark-theme h3,
    .dark-theme h4,
    .dark-theme h5 {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .price-regular {
        color: #a0aec0 !important;
    }
    
    .dark-theme .price-sale {
        color: #68d391 !important;
    }
    
    .dark-theme .stock-quantity {
        color: #4299e1 !important;
    }
    
    .dark-theme .category-badge {
        background: linear-gradient(135deg, #4299e1 0%, #667eea 100%) !important;
    }
    
    @media (max-width: 768px) {
        .product-main-info {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .detail-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        
        .image-gallery {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
        
        .variants-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .variant-detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>
@endpush
