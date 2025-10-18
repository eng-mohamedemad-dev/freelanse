@extends('admin.layouts.app')

@section('title', __('admin.edit_product'))
@section('page-title', __('admin.edit_product'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.edit_product') }}</h3>
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
            <div class="text-tiny">{{ __('admin.edit_product') }}</div>
        </li>
    </ul>
</div>

<!-- form-edit-product -->
<form class="tf-section-2 form-edit-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product) }}">
    @csrf
    @method('PUT')
    <div class="wg-box">
        <fieldset class="name">
            <div class="body-title mb-10">{{ __('admin.product_name') }} <span class="tf-color-1">*</span></div>
            <div class="grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:8px;">
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_product_name') }} (AR)" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_product_name') }} (EN)" name="name_en" value="{{ old('name_en', $product->name_en) }}" required>
            </div>
            @error('name_ar')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
            @error('name_en')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="category">
            <div class="body-title mb-10">{{ __('admin.category') }} <span class="tf-color-1">*</span></div>
            <div class="select">
                <select class="" name="category_id">
                    <option>{{ __('admin.choose_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <div class="cols gap22">
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.regular_price') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_regular_price') }}" name="price" tabindex="0" value="{{ old('price', $product->price) }}" aria-required="true" required>
                @error('price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.sale_price') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_sale_price') }}" name="sale_price" tabindex="0" value="{{ old('sale_price', $product->sale_price) }}" aria-required="true" required>
                @error('sale_price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
        </div>

        <fieldset class="name">
            <div class="body-title mb-10">{{ __('admin.quantity') }} <span class="tf-color-1">*</span></div>
            <input class="mb-10" type="text" placeholder="{{ __('admin.enter_quantity') }}" name="stock" tabindex="0" value="{{ old('stock', $product->stock) }}" aria-required="true" required>
            @error('stock')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="description">
            <div class="body-title mb-10">{{ __('admin.description') }}</div>
            <div class="stack">
                <textarea class="mb-10 no-mb" name="description_ar" rows="4" placeholder="{{ __('admin.description') }} (AR)">{{ old('description_ar', $product->description_ar) }}</textarea>
                <textarea class="mb-10 no-mb" name="description_en" rows="4" placeholder="{{ __('admin.description') }} (EN)">{{ old('description_en', $product->description_en) }}</textarea>
            </div>
            @error('description_ar')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
            @error('description_en')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>
    </div>

    <div class="wg-box">
        <fieldset>
            <div class="body-title">{{ __('admin.current_images') }}</div>
            @if($product->images && count($product->images) > 0)
                <div class="current-images mb-20">
                    @foreach($product->images as $index => $image)
                        <div class="current-image-item">
                            <img src="{{ asset($image) }}" alt="Current Image {{ $index + 1 }}" class="current-image">
                            <button type="button" class="remove-current-image" data-image="{{ $image }}" data-index="{{ $index }}">
                                <i class="icon-x"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-current-images mb-20">
                        <p class="text-muted">{{ __('admin.no_images_currently_uploaded') }}</p>
                </div>
            @endif
        </fieldset>

        <fieldset>
            <div class="body-title">{{ __('admin.upload_new_images') }}</div>
            <div class="upload-image flex-grow">
                <!-- Preview area for multiple images -->
                <div id="images-preview" class="images-preview" style="display: none;">
                    <div id="preview-container">
                        <!-- Images will be added here dynamically -->
                    </div>
                </div>
                
                <!-- Upload area -->
                <div id="upload-file" class="item up-load">
                    <label class="uploadfile" for="myFile">
                        <span class="icon">
                            <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">{{ __('admin.drop_your_images_here_or_select') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                        <input type="file" id="myFile" name="images[]" accept="image/*" multiple>
                    </label>
                </div>
            </div>
            @error('images')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <!-- Add Variant Button (Initially Visible) -->
        <div class="add-variant-initial" id="add-variant-initial">
            <button type="button" class="tf-button style-2" id="show-variants">
                <i class="icon-plus"></i> {{ __('admin.add_variant') }}
            </button>
        </div>
    </div>

    <div class="cols gap10">
        <button class="tf-button w-full" type="submit">{{ __('admin.update_product') }}</button>
    </div>
</form>
@endsection

@push('styles')
<style>
    /* تقليل المسافات أسفل حقول الوصف */
    .form-edit-product .description .no-mb { margin-bottom: 0 !important; }
    .form-edit-product .description .stack { display: grid; grid-template-columns: 1fr; gap: 8px; }
    .current-images {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .current-image-item {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .current-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        display: block;
    }
    
    .remove-current-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 12px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .current-image-item:hover .remove-current-image {
        display: flex;
    }
    
    .remove-current-image:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
    }
    
    .images-preview {
        border: 2px dashed #007bff;
        border-radius: 8px;
        padding: 20px;
        background: #f0f8ff;
        margin-bottom: 20px;
        min-height: 120px;
    }
    
    .image-preview-item {
        position: relative;
        display: inline-block;
        margin: 5px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        vertical-align: top;
        border: 2px solid #007bff;
    }
    
    .image-preview-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        display: block;
    }
    
    .remove-image-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .image-preview-item:hover .remove-image-btn {
        display: flex;
    }
    
    .remove-image-btn:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
    }
    
    .upload-image {
        position: relative;
    }
    
    .up-load {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        background: #f9f9f9;
        transition: all 0.3s ease;
    }
    
    .up-load:hover {
        border-color: #007bff;
        background: #f0f8ff;
    }
    
    .uploadfile {
        cursor: pointer;
        display: block;
    }
    
    .uploadfile input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    #preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .no-current-images {
        text-align: center;
        padding: 20px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }
    
    /* Variants Styles */
    .add-variant-initial {
        text-align: center;
        margin: 20px 0;
        width: 100%;
    }
    
    .add-variant-initial .tf-button {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        color: #6c757d;
        padding: 15px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .add-variant-initial .tf-button:hover {
        background: #e9ecef;
        border-color: #adb5bd;
        color: #495057;
    }
    
    .variants-container {
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }
    
    .variants-container .body-title {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .variant-item {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
    }
    
    .dark-theme .variants-container {
        background: #2d2d2d;
        border-color: #404040;
    }
    
    .dark-theme .variant-item {
        background: #1a202c;
        border: 1px solid #4a5568;
    }
    
    .variant-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .variant-title {
        margin: 0;
        color: #212529;
        font-size: 16px;
        font-weight: 600;
    }
    
    .dark-theme .variant-title {
        color: #e2e8f0;
    }
    
    .remove-variant {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .variant-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .variant-field {
        display: flex;
        flex-direction: column;
    }
    
    .variant-field label {
        color: #212529;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .variant-field select,
    .variant-field input {
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background: #ffffff;
        color: #212529;
    }
    
    .variant-field select:focus,
    .variant-field input:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .dark-theme .variant-field label {
        color: #e2e8f0;
    }
    
    .dark-theme .variant-field select,
    .dark-theme .variant-field input {
        border: 1px solid #4a5568;
        background: #1a202c;
        color: #e2e8f0;
    }
    
    .dark-theme .variant-field select:focus,
    .dark-theme .variant-field input:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
    }
    
    .variant-images {
        margin-top: 15px;
    }
    
    .variant-images-title {
        color: #212529;
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .dark-theme .variant-images-title {
        color: #e2e8f0;
    }
    
    .variant-upload-file {
        border: 2px dashed #007bff;
        padding: 20px;
        text-align: center;
        border-radius: 8px;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .variant-upload-file:hover {
        background: #e3f2fd;
        border-color: #0056b3;
    }
    
    .variant-upload-label {
        cursor: pointer;
        display: block;
    }
    
    .variant-upload-label input[type="file"] {
        display: none;
    }
    
    .variant-images-preview {
        display: none;
        margin-bottom: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    
    .dark-theme .variant-images-preview {
        background: #1a202c;
        border: 1px solid #4a5568;
    }
    
    .variant-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .variant-image-preview-item {
        position: relative;
        display: inline-block;
        margin: 5px;
    }
    
    .variant-image-preview-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        border: 2px solid #4a5568;
    }
    
    .remove-variant-image-btn {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
    }
    
    .add-variant-in-variant {
        margin-top: 15px;
        text-align: center;
    }
    
    .add-variant-btn {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        color: #6c757d;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }
    
    /* Full width for submit button */
    .cols.gap10 {
        width: 100%;
        margin: 20px 0;
    }
    
    /* Dark theme support for form elements - Override everything */
    .dark-theme select,
    .dark-theme input[type="text"],
    .dark-theme input[type="number"],
    .dark-theme input[type="email"],
    .dark-theme input[type="password"],
    .dark-theme textarea,
    .dark-theme input {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme select:focus,
    .dark-theme input:focus,
    .dark-theme textarea:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
    }
    
    .dark-theme select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme input::placeholder,
    .dark-theme textarea::placeholder {
        color: #a0aec0 !important;
    }
    
    /* Force dark theme for all form elements in dark mode */
    .dark-theme .form-edit-product select,
    .dark-theme .form-edit-product input,
    .dark-theme .form-edit-product textarea {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-edit-product select:focus,
    .dark-theme .form-edit-product input:focus,
    .dark-theme .form-edit-product textarea:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
    }
    
    .dark-theme .form-edit-product select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-edit-product input::placeholder,
    .dark-theme .form-edit-product textarea::placeholder {
        color: #a0aec0 !important;
    }
    
    /* Dark theme for variant elements */
    .dark-theme .variant-item {
        background: #1a202c !important;
        border: 1px solid #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .variant-item .body-title {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .variant-item input,
    .dark-theme .variant-item select,
    .dark-theme .variant-item textarea {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .variant-item input:focus,
    .dark-theme .variant-item select:focus,
    .dark-theme .variant-item textarea:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
    }
    
    .dark-theme .variant-item select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .variant-item input::placeholder,
    .dark-theme .variant-item textarea::placeholder {
        color: #a0aec0 !important;
    }
    
    /* Dark theme for image previews */
    .dark-theme .current-image-item {
        background: #2d3748 !important;
        border-color: #4a5568 !important;
    }
    
    .dark-theme .image-preview-item {
        background: #2d3748 !important;
        border-color: #4a5568 !important;
    }
    
    /* Override for dark theme when explicitly applied to form */
    .dark-theme .form-edit-product {
        background: #1a1a1a !important;
        color: #ffffff !important;
    }
    
    .dark-theme .form-edit-product .wg-box {
        background: #2d2d2d !important;
        border-color: #404040 !important;
    }
    
    .dark-theme .form-edit-product .body-title {
        color: #ffffff !important;
    }
    
    .dark-theme .form-edit-product .text-tiny {
        color: #cccccc !important;
    }
    
    .dark-theme .form-edit-product .breadcrumbs a {
        color: #cccccc !important;
    }
    
    .dark-theme .form-edit-product .breadcrumbs .text-tiny {
        color: #cccccc !important;
    }
    
    /* Light theme form elements */
    .form-edit-product select,
    .form-edit-product input,
    .form-edit-product textarea {
        background-color: #ffffff !important;
        border-color: #ced4da !important;
        color: #212529 !important;
    }
    
    .form-edit-product select:focus,
    .form-edit-product input:focus,
    .form-edit-product textarea:focus {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        color: #212529 !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    }
    
    .form-edit-product select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    .form-edit-product input::placeholder,
    .form-edit-product textarea::placeholder {
        color: #6c757d !important;
    }
    
    /* Override for dark theme */
    .dark-theme .form-edit-product select,
    .dark-theme .form-edit-product input,
    .dark-theme .form-edit-product textarea {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-edit-product select:focus,
    .dark-theme .form-edit-product input:focus,
    .dark-theme .form-edit-product textarea:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
    }
    
    .dark-theme .form-edit-product select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-edit-product input::placeholder,
    .dark-theme .form-edit-product textarea::placeholder {
        color: #a0aec0 !important;
    }
    
    /* Force light theme for product form - Override everything */
    .form-edit-product {
        background: #ffffff !important;
        color: #212529 !important;
    }
    
    .form-edit-product .wg-box {
        background: #ffffff !important;
        border-color: #e9ecef !important;
    }
    
    .form-edit-product .body-title {
        color: #212529 !important;
    }
    
    .form-edit-product .text-tiny {
        color: #6c757d !important;
    }
    
    .form-edit-product .breadcrumbs a {
        color: #6c757d !important;
    }
    
    .form-edit-product .breadcrumbs .text-tiny {
        color: #6c757d !important;
    }
    
    /* Override for dark theme when explicitly applied to form */
    .dark-theme .form-edit-product {
        background: #1a1a1a !important;
        color: #ffffff !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Force light theme for this page only
    $('body').removeClass('dark-theme');
    $('#theme-icon').removeClass('icon-moon').addClass('icon-sun');
    
    // Additional force to ensure light theme
    setTimeout(function() {
        $('body').removeClass('dark-theme');
        $('#theme-icon').removeClass('icon-moon').addClass('icon-sun');
    }, 100);
    
    let selectedImages = [];
    let removedImages = [];
    
    // Handle removal of current images
    $('.remove-current-image').on('click', function() {
        const imagePath = $(this).data('image');
        const imageIndex = $(this).data('index');
        
        SwalConfig.deleteConfirm('{{ __('admin.delete_image_confirmation') }}').then((result) => {
            if (result.isConfirmed) {
                removedImages.push(imagePath);
                $(this).closest('.current-image-item').fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });
    
    // Multiple image upload functionality
    $('#myFile').on('change', function(e) {
        const files = Array.from(e.target.files);
        
        if (files.length > 0) {
            selectedImages = [];
            const previewContainer = $('#preview-container');
            previewContainer.empty();
            
            let processedCount = 0;
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageData = {
                            file: file,
                            url: e.target.result,
                            index: index
                        };
                        selectedImages.push(imageData);
                        
                        // Create preview item
                        const previewItem = $(`
                            <div class="image-preview-item">
                                <img src="${e.target.result}" alt="Preview ${index + 1}" style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" class="remove-image-btn" onclick="removeImage(${index})" title="{{ __('admin.remove_image') }}">
                                    ×
                                </button>
                            </div>
                        `);
                        
                        previewContainer.append(previewItem);
                        
                        processedCount++;
                        if (processedCount === files.filter(f => f.type.startsWith('image/')).length) {
                            $('#images-preview').show();
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
    
    // Remove image function
    window.removeImage = function(index) {
        selectedImages.splice(index, 1);
        updatePreview();
        updateFileInput();
    };
    
    // Update preview after removing images
    function updatePreview() {
        const previewContainer = $('#preview-container');
        previewContainer.empty();
        
        selectedImages.forEach((imageData, index) => {
            const previewItem = $(`
                <div class="image-preview-item">
                    <img src="${imageData.url}" alt="Preview ${index + 1}" style="width: 100px; height: 100px; object-fit: cover;">
                    <button type="button" class="remove-image-btn" onclick="removeImage(${index})" title="{{ __('admin.remove_image') }}">
                        ×
                    </button>
                </div>
            `);
            previewContainer.append(previewItem);
        });
        
        if (selectedImages.length === 0) {
            $('#images-preview').hide();
        }
    }
    
    // Update file input with remaining files
    function updateFileInput() {
        const fileInput = document.getElementById('myFile');
        const dt = new DataTransfer();
        
        selectedImages.forEach(imageData => {
            dt.items.add(imageData.file);
        });
        
        fileInput.files = dt.files;
    }
    
    // Add hidden inputs for removed images
    $('form').on('submit', function() {
        removedImages.forEach(function(imagePath) {
            $(this).append('<input type="hidden" name="removed_images[]" value="' + imagePath + '">');
        }.bind(this));
    });

    // Variants Management
    let variantIndex = {{ $product->variants->count() }};
    let variantsContainer = null;

    // Add variant directly when button is clicked
    $('#show-variants').on('click', function() {
        // Create container if it doesn't exist
        if (!variantsContainer) {
            variantsContainer = $(`
                <div class="variants-container" style="margin-top: 20px; width: 100%;">
                    <div class="body-title mb-10" style="grid-column: 1 / -1; text-align: center; margin-bottom: 20px;">{{ __('admin.product_variants') }} <span class="optional-text">({{ __('admin.optional') }})</span></div>
                </div>
            `);
            $(this).parent().after(variantsContainer);
        }
        
        // Add new variant
        const variantHtml = createVariantHtml(variantIndex);
        variantsContainer.append(variantHtml);
        updateVariantNumbers();
        updateRemoveButtons();
        
        // Hide the initial button after first variant
        if (variantIndex === {{ $product->variants->count() }}) {
            $(this).hide();
        }
        
        variantIndex++;
    });

    // Add variant from within variant
    $(document).on('click', '.add-variant-btn', function() {
        const variantHtml = createVariantHtml(variantIndex);
        variantsContainer.append(variantHtml);
        updateVariantNumbers();
        updateRemoveButtons();
        variantIndex++;
    });

    // Handle variant image upload
    $(document).on('change', 'input[name*="[images][]"]', function(e) {
        const files = Array.from(e.target.files);
        const variantItem = $(this).closest('.variant-item');
        const previewContainer = variantItem.find('.variant-preview-container');
        const previewSection = variantItem.find('.variant-images-preview');
        
        console.log('Variant image upload triggered', files.length, 'files');
        
        if (files.length > 0) {
            previewContainer.empty();
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = $(`
                            <div class="variant-image-preview-item" style="position: relative; display: inline-block; margin: 5px;">
                                <img src="${e.target.result}" alt="Variant Preview ${index + 1}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #4a5568;">
                                <button type="button" class="remove-variant-image-btn" style="position: absolute; top: 2px; right: 2px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; cursor: pointer;">×</button>
                            </div>
                        `);
                        
                        previewContainer.append(previewItem);
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            previewSection.show();
        }
    });

    // Remove variant image
    $(document).on('click', '.remove-variant-image-btn', function() {
        $(this).closest('.variant-image-preview-item').remove();
    });

    // Remove variant
    $(document).on('click', '.remove-variant', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Remove button clicked');
        
        const variantItem = $(this).closest('.variant-item');
        console.log('Removing variant:', variantItem);
        
        variantItem.remove();
        updateVariantNumbers();
        updateRemoveButtons();
        
        // Show add button if no variants left
        if ($('.variant-item').length === 0) {
            $('#show-variants').show();
            variantIndex = {{ $product->variants->count() }};
        }
    });

    // Create variant HTML
    function createVariantHtml(index) {
        return `
            <div class="variant-item" data-variant-index="${index}">
                <div class="variant-header">
                    <h5 class="variant-title">{{ __('admin.variant') }} <span class="variant-number">${index + 1}</span></h5>
                    <button type="button" class="btn btn-sm btn-danger remove-variant" style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 50%; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="{{ __('admin.remove_variant') }}">
                        <i class="icon-trash"></i>
                    </button>
                </div>
                
                <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.size') }}</div>
                        <div class="select">
                            <select name="variants[${index}][size_id]" class="variant-size variant-field">
                                <option value="">{{ __('admin.select_size') }}</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.color') }}</div>
                        <div class="select">
                            <select name="variants[${index}][color_id]" class="variant-color variant-field">
                                <option value="">{{ __('admin.select_color') }}</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>
                
                <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.price') }} <span class="tf-color-1">*</span></div>
                        <input type="number" min="0" step="0.01" placeholder="{{ __('admin.enter_price') }}" name="variants[${index}][price]" class="variant-price variant-field">
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.stock') }} <span class="tf-color-1">*</span></div>
                        <input type="number" min="0" placeholder="{{ __('admin.enter_stock') }}" name="variants[${index}][stock]" class="variant-stock variant-field">
                    </fieldset>
                </div>
                
                <fieldset class="variant-images">
                    <div class="body-title mb-10">{{ __('admin.variant_images') }}</div>
                    
                    <!-- Variant Images Preview -->
                    <div class="variant-images-preview">
                        <div class="preview-title" style="font-size: 14px; margin-bottom: 10px;">{{ __('admin.variant_images_preview') }}</div>
                        <div class="variant-preview-container">
                            <!-- Preview images will be added here -->
                        </div>
                    </div>
                    
                    <div class="upload-image flex-grow">
                        <div class="variant-upload-file item up-load">
                            <label class="uploadfile variant-upload-label" for="variantFile${index}">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">{{ __('admin.drag_images_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                                <input type="file" id="variantFile${index}" name="variants[${index}][images][]" accept="image/*" multiple style="display: none;">
                            </label>
                        </div>
                    </div>
                </fieldset>
                
                <div class="add-variant-in-variant">
                    <button type="button" class="add-variant-btn">
                        <i class="icon-plus"></i> {{ __('admin.add_variant') }}
                    </button>
                </div>
            </div>
        `;
    }

    // Update variant numbers
    function updateVariantNumbers() {
        $('.variant-item').each(function(index) {
            $(this).find('.variant-number').text(index + 1);
        });
    }

    // Update remove buttons visibility
    function updateRemoveButtons() {
        const variantCount = $('.variant-item').length;
        console.log('Variant count:', variantCount);
        
        if (variantCount > 1) {
            $('.remove-variant').show();
        } else if (variantCount === 1) {
            $('.remove-variant').show();
        } else {
            $('.remove-variant').hide();
        }
    }

    // Load existing variants on page load
    @if($product->variants && $product->variants->count() > 0)
        // Create container for existing variants immediately
        variantsContainer = $(`
            <div class="variants-container" style="margin-top: 20px; width: 100%;">
                <div class="body-title mb-10" style="grid-column: 1 / -1; text-align: center; margin-bottom: 20px;">{{ __('admin.product_variants') }} <span class="optional-text">({{ __('admin.optional') }})</span></div>
            </div>
        `);
        $('#show-variants').parent().after(variantsContainer);
        
        // Hide the add button since we have existing variants
        $('#show-variants').hide();
        
        // Load existing variants
        @foreach($product->variants as $index => $variant)
            const existingVariantHtml{{ $index }} = `
                <div class="variant-item" data-variant-index="{{ $index }}">
                    <div class="variant-header">
                        <h5 class="variant-title">{{ __('admin.variant') }} <span class="variant-number">{{ $index + 1 }}</span></h5>
                        <button type="button" class="btn btn-sm btn-danger remove-variant" style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 50%; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="{{ __('admin.remove_variant') }}">
                            <i class="icon-trash"></i>
                        </button>
                    </div>
                    
                    <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.size') }}</div>
                            <div class="select">
                                <select name="variants[{{ $index }}][size_id]" class="variant-size variant-field">
                                    <option value="">{{ __('admin.select_size') }}</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>{{ $size->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.color') }}</div>
                            <div class="select">
                                <select name="variants[{{ $index }}][color_id]" class="variant-color variant-field">
                                    <option value="">{{ __('admin.select_color') }}</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>{{ $color->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.price') }} <span class="tf-color-1">*</span></div>
                            <input type="number" min="0" step="0.01" placeholder="{{ __('admin.enter_price') }}" name="variants[{{ $index }}][price]" class="variant-price variant-field" value="{{ $variant->price }}">
                        </fieldset>
                        
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.stock') }} <span class="tf-color-1">*</span></div>
                            <input type="number" min="0" placeholder="{{ __('admin.enter_stock') }}" name="variants[{{ $index }}][stock]" class="variant-stock variant-field" value="{{ $variant->stock }}">
                        </fieldset>
                    </div>
                    
                    <fieldset class="variant-images">
                        <div class="body-title mb-10">{{ __('admin.variant_images') }}</div>
                        
                        @if($variant->images && count($variant->images) > 0)
                            <div class="variant-images-preview" style="margin-bottom: 15px;">
                                <div class="preview-title" style="font-size: 14px; margin-bottom: 10px;">{{ __('admin.current_variant_images') }}</div>
                                <div class="variant-preview-container">
                                    @foreach($variant->images as $imgIndex => $image)
                                        <div class="variant-image-preview-item" style="position: relative; display: inline-block; margin: 5px;">
                                            <img src="{{ asset($image) }}" alt="Variant Image {{ $imgIndex + 1 }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #4a5568;">
                                            <button type="button" class="remove-variant-image-btn" style="position: absolute; top: 2px; right: 2px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; cursor: pointer;">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="upload-image flex-grow">
                            <div class="variant-upload-file item up-load">
                                <label class="uploadfile variant-upload-label" for="variantFile{{ $index }}">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">{{ __('admin.drag_images_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                                    <input type="file" id="variantFile{{ $index }}" name="variants[{{ $index }}][images][]" accept="image/*" multiple style="display: none;">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="add-variant-in-variant">
                        <button type="button" class="add-variant-btn">
                            <i class="icon-plus"></i> {{ __('admin.add_variant') }}
                        </button>
                    </div>
                </div>
            `;
            variantsContainer.append(existingVariantHtml{{ $index }});
        @endforeach
        
        updateVariantNumbers();
        updateRemoveButtons();
    @endif
});
</script>
@endpush
