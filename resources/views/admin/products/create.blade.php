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
            <input class="mb-10" type="text" placeholder="{{ __('admin.enter_product_name') }}" name="name" tabindex="0" value="{{ old('name') }}" aria-required="true" required>
            <div class="text-tiny">{{ __('admin.product_name_hint') }}</div>
            @error('name')
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
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="description">
            <div class="body-title mb-10">{{ __('admin.description') }} <span class="tf-color-1">*</span></div>
            <textarea class="mb-10" name="description" placeholder="{{ __('admin.description') }}" tabindex="0" aria-required="true" required>{{ old('description') }}</textarea>
            <div class="text-tiny">{{ __('admin.description_hint') }}</div>
            @error('description')
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

        <div class="cols gap22">
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.quantity') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="{{ __('admin.enter_quantity') }}" name="stock" tabindex="0" value="{{ old('stock') }}" aria-required="true" required>
                @error('stock')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
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
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        console.log('Image upload script loaded');
        let selectedImages = [];
        
        // Multiple image upload functionality
        $('#myFile').on('change', function(e) {
            console.log('File input changed');
            const files = Array.from(e.target.files);
            console.log('Selected files:', files.length);
            
            if (files.length > 0) {
                selectedImages = [];
                const previewContainer = $('#preview-container');
                previewContainer.empty();
                
                let processedCount = 0;
                
                files.forEach((file, index) => {
                    console.log('Processing file:', file.name, file.type);
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            console.log('File read successfully');
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
                            console.log('Preview item added');
                            
                            processedCount++;
                            if (processedCount === files.filter(f => f.type.startsWith('image/')).length) {
                                $('#images-preview').show();
                                console.log('Preview area shown');
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
        
        // Remove image function
        window.removeImage = function(index) {
            console.log('Removing image at index:', index);
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
        
        // Test if jQuery is loaded
        console.log('jQuery version:', $.fn.jquery);
    });
</script>
@endpush