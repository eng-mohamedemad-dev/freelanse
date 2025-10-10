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
        <h4>{{ $product->name }}</h4>
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
                                <img src="{{ asset($image) }}" alt="{{ $product->name }}" class="product-image">
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
                        <div class="detail-value">{{ $product->name }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.description') }}</div>
                        <div class="detail-value">{{ $product->description }}</div>
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
    }
</style>
@endpush
