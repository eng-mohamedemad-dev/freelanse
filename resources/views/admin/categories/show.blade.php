@extends('admin.layouts.app')

@section('title', __('admin.view_category'))
@section('page-title', __('admin.view_category'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.view_category') }}</h3>
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
            <a href="{{ route('admin.categories.index') }}">
                <div class="text-tiny">{{ __('admin.categories') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ __('admin.view_category') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap mb-20">
        <div class="flex items-center gap10">
            <a href="{{ route('admin.categories.edit', $category) }}" class="tf-button style-1">
                <i class="icon-edit"></i> {{ __('admin.edit_category') }}
            </a>
            <a href="{{ route('admin.categories.index') }}" class="tf-button style-2">
                <i class="icon-arrow-left"></i> {{ __('admin.back_to_categories') }}
            </a>
        </div>
    </div>

    <div class="category-view-container">
        <div class="category-main-info">
            <div class="category-image-section">
                <h5 class="section-title">{{ __('admin.category_image') }}</h5>
                @if($category->image)
                    <div class="image-display">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="category-image-large">
                    </div>
                @else
                    <div class="no-image">
                        <div class="no-image-icon">
                            <i class="icon-image"></i>
                        </div>
                        <p class="no-image-text">{{ __('admin.no_image_found') }}</p>
                    </div>
                @endif
            </div>
            
            <div class="category-details-section">
                <h5 class="section-title">{{ __('admin.category_details') }}</h5>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.category_name') }}</div>
                        <div class="detail-value">{{ $category->display_name }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.category_description') }}</div>
                        <div class="detail-value">{{ $category->display_description }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.products_count') }}</div>
                        <div class="detail-value products-count">{{ $category->products_count ?? 0 }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.created_at') }}</div>
                        <div class="detail-value">{{ $category->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">{{ __('admin.updated_at') }}</div>
                        <div class="detail-value">{{ $category->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .category-view-container {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .category-main-info {
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
    
    .category-image-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
    }
    
    .image-display {
        text-align: center;
    }
    
    .category-image-large {
        width: 100%;
        max-width: 300px;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .no-image {
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
    
    .category-details-section {
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
    
    .products-count {
        color: #007bff;
        font-weight: 600;
        font-size: 16px;
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
        .category-main-info {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .detail-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }
    
    /* Dark Theme Styles */
    .dark-theme .category-view-container {
        background: #2d3748;
        color: #e2e8f0;
    }
    
    .dark-theme .section-title {
        color: #e2e8f0;
        border-bottom-color: #007bff;
    }
    
    .dark-theme .category-image-section,
    .dark-theme .category-details-section {
        background: #4a5568;
    }
    
    .dark-theme .detail-item {
        background: #2d3748;
        border-left-color: #007bff;
    }
    
    .dark-theme .detail-label {
        color: #a0aec0;
    }
    
    .dark-theme .detail-value {
        color: #e2e8f0;
    }
    
    .dark-theme .no-image {
        background: #4a5568;
        border-color: #718096;
    }
    
    .dark-theme .no-image-icon {
        color: #a0aec0;
    }
    
    .dark-theme .no-image-text {
        color: #a0aec0;
    }
</style>
@endpush
