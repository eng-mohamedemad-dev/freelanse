@extends('admin.layouts.app')

@section('title', __('admin.add_product'))
@section('page-title', __('admin.add_product'))


@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.add_product') }}</h3>
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
            <div class="text-tiny">{{ __('admin.add_product') }}</div>
        </li>
    </ul>
</div>

<!-- form-add-product -->
<form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
    @csrf
    <div class="wg-box">
        <fieldset class="name">
            <div class="body-title mb-10">{{ __('admin.product_name') }} <span class="tf-color-1">*</span></div>
            <div class="grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:8px;">
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_product_name') }} (AR)" name="name_ar" value="{{ old('name_ar') }}" required>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_product_name') }} (EN)" name="name_en" value="{{ old('name_en') }}" required>
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
                    <option>{{ __('admin.select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_regular_price') }}" name="price" tabindex="0" value="{{ old('price') }}" aria-required="true" required>
                @error('price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.sale_price') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_sale_price') }}" name="sale_price" tabindex="0" value="{{ old('sale_price') }}" aria-required="true" required>
                @error('sale_price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
        </div>

        <fieldset class="name">
            <div class="body-title mb-10">{{ __('admin.quantity') }} <span class="tf-color-1">*</span></div>
            <input class="mb-10" type="text" placeholder="{{ __('admin.enter_quantity') }}" name="stock" tabindex="0" value="{{ old('stock') }}" aria-required="true" required>
            @error('stock')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="description">
            <div class="body-title mb-10">{{ __('admin.description') }}</div>
            <div class="stack">
                <textarea class="mb-10 no-mb" name="description_ar" rows="4" placeholder="{{ __('admin.description') }} (AR)">{{ old('description_ar') }}</textarea>
                <textarea class="mb-10 no-mb" name="description_en" rows="4" placeholder="{{ __('admin.description') }} (EN)">{{ old('description_en') }}</textarea>
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
            <div class="body-title">{{ __('admin.upload_images') }} <span class="tf-color-1">*</span></div>
            <div class="upload-image flex-grow">
                <!-- Current Images (for edit mode) -->
                <div id="current-images" class="current-images mb-20" style="display: none;">
                    <div class="current-images-container">
                        <!-- Current images will be shown here -->
                    </div>
                </div>
                
                <!-- Preview area for new images -->
                <div id="images-preview" class="images-preview" style="display: none;">
                    <div class="preview-title">{{ __('admin.new_images_preview') }}</div>
                    <div id="preview-container">
                        <!-- New images will be added here dynamically -->
                    </div>
                </div>
                
                <!-- Upload area -->
                <div id="upload-file" class="item up-load">
                    <label class="uploadfile" for="myFile">
                        <span class="icon">
                            <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">{{ __('admin.drag_images_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
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



        <div class="cols gap10">
            <button class="tf-button w-full" type="submit">{{ __('admin.add_product') }}</button>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .current-images {
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 20px;
        background: #f8fff8;
        margin-bottom: 20px;
    }
    
    .current-images-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .current-image-item {
        position: relative;
        display: inline-block;
        margin: 5px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        vertical-align: top;
        border: 2px solid #28a745;
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
        font-size: 14px;
        font-weight: bold;
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
    
    .preview-title {
        font-weight: 600;
        color: #007bff;
        margin-bottom: 15px;
        font-size: 14px;
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

    /* Variants Styles */
    .variants {
        margin-top: 30px;
        padding: 20px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: #f8f9fa;
    }

    /* Dark theme support for variants */
    [data-theme="dark"] .variants {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .body-title {
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .variants-description {
        color: #a0aec0;
    }

    [data-theme="dark"] .variants .optional-text {
        color: #a0aec0;
    }

    [data-theme="dark"] .variants .variant-item {
        background: #1a202c;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .variant-item .body-title {
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .variant-item input,
    [data-theme="dark"] .variants .variant-item select {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .variant-item input::placeholder,
    [data-theme="dark"] .variants .variant-item select option {
        color: #a0aec0;
    }

    [data-theme="dark"] .variants .variant-upload-file {
        background: #2d3748;
        border-color: #4a5568;
    }

    [data-theme="dark"] .variants .variant-upload-file .body-text {
        color: #e2e8f0;
    }

    [data-theme="dark"] .variants .variant-upload-file .tf-color {
        color: #63b3ed;
    }

    /* Dark theme support for all form elements */
    [data-theme="dark"] .select select,
    [data-theme="dark"] .select-wrapper select,
    [data-theme="dark"] select {
        background: #1a202c !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .select select option,
    [data-theme="dark"] .select-wrapper select option,
    [data-theme="dark"] select option {
        background: #1a202c !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .select select:focus,
    [data-theme="dark"] .select-wrapper select:focus,
    [data-theme="dark"] select:focus {
        border-color: #63b3ed !important;
        box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.2) !important;
    }

    /* Dark theme for all input fields */
    [data-theme="dark"] input[type="text"],
    [data-theme="dark"] input[type="number"],
    [data-theme="dark"] input[type="email"],
    [data-theme="dark"] input[type="password"],
    [data-theme="dark"] textarea {
        background: #1a202c !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] input[type="text"]::placeholder,
    [data-theme="dark"] input[type="number"]::placeholder,
    [data-theme="dark"] input[type="email"]::placeholder,
    [data-theme="dark"] input[type="password"]::placeholder,
    [data-theme="dark"] textarea::placeholder {
        color: #a0aec0 !important;
    }

    [data-theme="dark"] input[type="text"]:focus,
    [data-theme="dark"] input[type="number"]:focus,
    [data-theme="dark"] input[type="email"]:focus,
    [data-theme="dark"] input[type="password"]:focus,
    [data-theme="dark"] textarea:focus {
        border-color: #63b3ed !important;
        box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.2) !important;
    }

    /* Dark theme for variant specific elements */
    [data-theme="dark"] .variant-size select,
    [data-theme="dark"] .variant-color select,
    [data-theme="dark"] .variant-price,
    [data-theme="dark"] .variant-stock {
        background: #1a202c !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }

    [data-theme="dark"] .variant-size select option,
    [data-theme="dark"] .variant-color select option {
        background: #1a202c !important;
        color: #e2e8f0 !important;
    }

    .optional-text {
        color: #6c757d;
        font-weight: normal;
        font-size: 14px;
    }

    .variants-description {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 20px;
        font-style: italic;
    }

    .add-variant-initial {
        margin-top: 30px;
        text-align: center;
    }

    .add-variant-initial .tf-button {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        color: #6c757d;
        padding: 20px 40px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .add-variant-initial .tf-button:hover {
        background: #e9ecef;
        border-color: #007bff;
        color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }

    /* Dark theme support for initial button */
    [data-theme="dark"] .add-variant-initial .tf-button {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .add-variant-initial .tf-button:hover {
        background: #4a5568;
        border-color: #63b3ed;
        color: #63b3ed;
        box-shadow: 0 4px 12px rgba(99, 179, 237, 0.15);
    }

    .variant-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
    }

    .variant-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .variant-header h5 {
        margin: 0;
        color: #495057;
        font-size: 16px;
        font-weight: 600;
    }

    .variant-number {
        background: #007bff;
        color: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        margin-left: 8px;
    }

    .remove-variant {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 12px;
        cursor: pointer;
    }

    .remove-variant:hover {
        background: #c82333;
    }

    .variant-image-upload {
        border: 2px dashed #007bff;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .variant-image-upload:hover {
        border-color: #0056b3;
        background: #e3f2fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }

    .variant-image-upload.dragover {
        border-color: #28a745;
        background: #d4edda;
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .variant-image-upload .upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .variant-image-upload .upload-content i {
        font-size: 48px;
        color: #007bff;
        margin-bottom: 15px;
    }

    .variant-image-upload .upload-content p {
        margin: 0;
        color: #495057;
        font-size: 16px;
        font-weight: 500;
    }

    .variant-images-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .variant-image-preview-item {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #e9ecef;
    }

    .variant-image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .variant-image-preview-item .remove-variant-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }

    .add-variant-container {
        text-align: center;
        margin-top: 20px;
    }

    .add-variant-container .tf-button {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .add-variant-container .tf-button:hover {
        background: #218838;
    }
    
    /* Dark Theme Styles for Product Create */
    .dark-theme .current-images {
        background: #1e3a1e;
        border-color: #28a745;
    }
    
    .dark-theme .images-preview {
        background: #1a2332;
        border-color: #007bff;
    }
    
    .dark-theme .preview-title {
        color: #007bff;
    }
    
    .dark-theme .up-load {
        background: #404040;
        border-color: #555555;
        color: #ffffff;
    }
    
    .dark-theme .up-load:hover {
        background: #555555;
        border-color: #007bff;
    }
    
    .dark-theme .up-load .body-text {
        color: #ffffff;
    }
    
    .dark-theme .up-load .tf-color {
        color: #007bff;
    }
    
    .dark-theme .up-load .icon {
        color: #007bff;
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
    .form-add-product .description .no-mb { margin-bottom: 0 !important; }
    .form-add-product .description .stack { display: grid; grid-template-columns: 1fr; gap: 8px; }
    
    /* Force light theme ONLY for this specific form */
    .form-add-product {
        background: #ffffff !important;
        color: #212529 !important;
    }
    
    /* Force light theme when force-light-theme class is present */
    body.force-light-theme .form-add-product {
        background: #ffffff !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .wg-box {
        background: #ffffff !important;
        border-color: #e9ecef !important;
    }
    
    body.force-light-theme .form-add-product .body-title {
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .text-tiny {
        color: #6c757d !important;
    }
    
    body.force-light-theme .form-add-product .breadcrumbs a {
        color: #6c757d !important;
    }
    
    body.force-light-theme .form-add-product .breadcrumbs .text-tiny {
        color: #6c757d !important;
    }
    
    body.force-light-theme .form-add-product input,
    body.force-light-theme .form-add-product textarea,
    body.force-light-theme .form-add-product select {
        background-color: #ffffff !important;
        border-color: #ced4da !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product input:focus,
    body.force-light-theme .form-add-product textarea:focus,
    body.force-light-theme .form-add-product select:focus {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        color: #212529 !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    }
    
    body.force-light-theme .form-add-product select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product input::placeholder,
    body.force-light-theme .form-add-product textarea::placeholder {
        color: #6c757d !important;
    }
    
    body.force-light-theme .form-add-product .variant-item {
        background: #ffffff !important;
        border-color: #e9ecef !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .variant-item .body-title {
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .variant-item input,
    body.force-light-theme .form-add-product .variant-item select,
    body.force-light-theme .form-add-product .variant-item textarea {
        background-color: #ffffff !important;
        border-color: #ced4da !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .variant-item input:focus,
    body.force-light-theme .form-add-product .variant-item select:focus,
    body.force-light-theme .form-add-product .variant-item textarea:focus {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .variant-item select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    body.force-light-theme .form-add-product .variant-item input::placeholder,
    body.force-light-theme .form-add-product .variant-item textarea::placeholder {
        color: #6c757d !important;
    }
    
    .form-add-product .wg-box {
        background: #ffffff !important;
        border-color: #e9ecef !important;
    }
    
    .form-add-product .body-title {
        color: #212529 !important;
    }
    
    .form-add-product .text-tiny {
        color: #6c757d !important;
    }
    
    .form-add-product .breadcrumbs a {
        color: #6c757d !important;
    }
    
    .form-add-product .breadcrumbs .text-tiny {
        color: #6c757d !important;
    }
    
    .form-add-product input,
    .form-add-product textarea,
    .form-add-product select {
        background-color: #ffffff !important;
        border-color: #ced4da !important;
        color: #212529 !important;
    }
    
    .form-add-product input:focus,
    .form-add-product textarea:focus,
    .form-add-product select:focus {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        color: #212529 !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    }
    
    .form-add-product select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    .form-add-product input::placeholder,
    .form-add-product textarea::placeholder {
        color: #6c757d !important;
    }
    
    /* Variant items in this form only */
    .form-add-product .variant-item {
        background: #ffffff !important;
        border-color: #e9ecef !important;
        color: #212529 !important;
    }
    
    .form-add-product .variant-item .body-title {
        color: #212529 !important;
    }
    
    .form-add-product .variant-item input,
    .form-add-product .variant-item select,
    .form-add-product .variant-item textarea {
        background-color: #ffffff !important;
        border-color: #ced4da !important;
        color: #212529 !important;
    }
    
    .form-add-product .variant-item input:focus,
    .form-add-product .variant-item select:focus,
    .form-add-product .variant-item textarea:focus {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        color: #212529 !important;
    }
    
    .form-add-product .variant-item select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    .form-add-product .variant-item input::placeholder,
    .form-add-product .variant-item textarea::placeholder {
        color: #6c757d !important;
    }
    
    /* Override dark theme only for this form */
    .dark-theme .form-add-product {
        background: #1a1a1a !important;
        color: #ffffff !important;
    }
    
    .dark-theme .form-add-product .wg-box {
        background: #2d2d2d !important;
        border-color: #404040 !important;
    }
    
    .dark-theme .form-add-product .body-title {
        color: #ffffff !important;
    }
    
    .dark-theme .form-add-product .text-tiny {
        color: #cccccc !important;
    }
    
    .dark-theme .form-add-product .breadcrumbs a {
        color: #cccccc !important;
    }
    
    .dark-theme .form-add-product .breadcrumbs .text-tiny {
        color: #cccccc !important;
    }
    
    .dark-theme .form-add-product input,
    .dark-theme .form-add-product textarea,
    .dark-theme .form-add-product select {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product input:focus,
    .dark-theme .form-add-product textarea:focus,
    .dark-theme .form-add-product select:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
    }
    
    .dark-theme .form-add-product select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product input::placeholder,
    .dark-theme .form-add-product textarea::placeholder {
        color: #a0aec0 !important;
    }
    
    .dark-theme .form-add-product .variant-item {
        background: #1a202c !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product .variant-item .body-title {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product .variant-item input,
    .dark-theme .form-add-product .variant-item select,
    .dark-theme .form-add-product .variant-item textarea {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product .variant-item input:focus,
    .dark-theme .form-add-product .variant-item select:focus,
    .dark-theme .form-add-product .variant-item textarea:focus {
        background-color: #2d3748 !important;
        border-color: #4299e1 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product .variant-item select option {
        background-color: #2d3748 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme .form-add-product .variant-item input::placeholder,
    .dark-theme .form-add-product .variant-item textarea::placeholder {
        color: #a0aec0 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Force light theme ONLY for this page - don't affect other pages
        if (window.location.pathname.includes('/admin/products/create')) {
            // Only force light theme on this specific page
            $('body').addClass('force-light-theme');
            $('body').removeClass('dark-theme');
            $('#theme-icon').removeClass('icon-moon').addClass('icon-sun');
            
            // Don't save to localStorage to avoid affecting other pages
            // localStorage.setItem('theme', 'light');
            
            // Additional force to ensure light theme
            setTimeout(function() {
                if (window.location.pathname.includes('/admin/products/create')) {
                    $('body').addClass('force-light-theme');
                    $('body').removeClass('dark-theme');
                    $('#theme-icon').removeClass('icon-moon').addClass('icon-sun');
                }
            }, 100);
        }
        
        // Clean up when leaving the page
        $(window).on('beforeunload', function() {
            $('body').removeClass('force-light-theme');
        });
        
        let selectedImages = [];
        
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
        
    });

    // Variants Management
    let variantIndex = 0;
    let variantsContainer = null;

    // Add variant directly when button is clicked
    $('#show-variants').on('click', function() {
        // Create container if it doesn't exist
        if (!variantsContainer) {
            variantsContainer = $(`
                <div class="variants-container" style="margin-top: 20px;">
                    <div class="body-title mb-10">{{ __('admin.product_variants') }} <span class="optional-text">({{ __('admin.optional') }})</span></div>
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
        if (variantIndex === 0) {
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
            variantIndex = 0;
        }
    });

    // Create variant HTML
    function createVariantHtml(index) {
        return `
            <div class="variant-item" data-variant-index="${index}" style="background: #1a202c; border: 1px solid #4a5568; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <div class="variant-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h5 style="margin: 0; color: #e2e8f0;">{{ __('admin.variant') }} <span class="variant-number">${index + 1}</span></h5>
                    <button type="button" class="btn btn-sm btn-danger remove-variant" style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 50%; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="{{ __('admin.remove_variant') }}">
                        <i class="icon-trash"></i>
                    </button>
                </div>
                
                <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <fieldset class="name">
                        <div class="body-title mb-10" style="color: #e2e8f0;">{{ __('admin.size') }}</div>
                        <div class="select">
                            <select name="variants[${index}][size_id]" class="variant-size" style="width: 100%; padding: 8px; border: 1px solid #4a5568; border-radius: 4px; background: #1a202c; color: #e2e8f0;">
                                <option value="">{{ __('admin.select_size') }}</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10" style="color: #e2e8f0;">{{ __('admin.color') }}</div>
                        <div class="select">
                            <select name="variants[${index}][color_id]" class="variant-color" style="width: 100%; padding: 8px; border: 1px solid #4a5568; border-radius: 4px; background: #1a202c; color: #e2e8f0;">
                                <option value="">{{ __('admin.select_color') }}</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" data-hex="{{ $color->hex }}">
                                        {{ $color->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>
                
                <div class="cols gap22" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <fieldset class="name">
                        <div class="body-title mb-10" style="color: #e2e8f0;">{{ __('admin.price') }} <span class="tf-color-1">*</span></div>
                        <input type="number" step="0.01" min="0" placeholder="{{ __('admin.enter_price') }}" name="variants[${index}][price]" class="variant-price" style="width: 100%; padding: 8px; border: 1px solid #4a5568; border-radius: 4px; background: #1a202c; color: #e2e8f0;">
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10" style="color: #e2e8f0;">{{ __('admin.stock') }} <span class="tf-color-1">*</span></div>
                        <input type="number" min="0" placeholder="{{ __('admin.enter_stock') }}" name="variants[${index}][stock]" class="variant-stock" style="width: 100%; padding: 8px; border: 1px solid #4a5568; border-radius: 4px; background: #1a202c; color: #e2e8f0;">
                    </fieldset>
                </div>
                
                <fieldset class="variant-images">
                    <div class="body-title mb-10" style="color: #e2e8f0;">{{ __('admin.variant_images') }}</div>
                    
                    <!-- Variant Images Preview -->
                    <div class="variant-images-preview" style="display: none; margin-bottom: 15px; padding: 10px; background: #1a202c; border-radius: 6px; border: 1px solid #4a5568;">
                        <div class="preview-title" style="color: #e2e8f0; font-size: 14px; margin-bottom: 10px;">{{ __('admin.variant_images_preview') }}</div>
                        <div class="variant-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <!-- Preview images will be added here -->
                        </div>
                    </div>
                    
                    <div class="upload-image flex-grow">
                        <div class="variant-upload-file item up-load" style="border: 2px dashed #007bff; padding: 20px; text-align: center; border-radius: 8px;">
                            <label class="uploadfile variant-upload-label" for="variantFile${index}" style="cursor: pointer;">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">{{ __('admin.drag_images_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                                <input type="file" id="variantFile${index}" name="variants[${index}][images][]" accept="image/*" multiple style="display: none;">
                            </label>
                        </div>
                    </div>
                </fieldset>
                
                <div class="add-variant-in-variant" style="margin-top: 15px; text-align: center;">
                    <button type="button" class="add-variant-btn" style="background: #f8f9fa; border: 2px dashed #dee2e6; color: #6c757d; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
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
            $(this).attr('data-variant-index', index);
            
            // Update field names
            $(this).find('input, select').each(function() {
                const name = $(this).attr('name');
                if (name && name.includes('variants[')) {
                    const newName = name.replace(/variants\[\d+\]/, `variants[${index}]`);
                    $(this).attr('name', newName);
                }
            });
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
</script>
@endpush