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
            <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{ old('name', $product->name) }}" aria-required="true" required>
            <div class="text-tiny">{{ __('admin.do_not_exceed_100_chars') }}</div>
            @error('name')
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
            <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required>{{ old('description', $product->description) }}</textarea>
            <div class="text-tiny">{{ __('admin.do_not_exceed_100_chars') }}</div>
            @error('description')
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

        <div class="cols gap22">
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.regular_price') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="Enter regular price" name="price" tabindex="0" value="{{ old('price', $product->price) }}" aria-required="true" required>
                @error('price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.sale_price') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{ old('sale_price', $product->sale_price) }}" aria-required="true" required>
                @error('sale_price')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
        </div>

        <div class="cols gap22">
            <fieldset class="name">
                <div class="body-title mb-10">{{ __('admin.quantity') }} <span class="tf-color-1">*</span></div>
                <input class="mb-10" type="text" placeholder="Enter quantity" name="stock" tabindex="0" value="{{ old('stock', $product->stock) }}" aria-required="true" required>
                @error('stock')
                    <div class="text-tiny tf-color-1">{{ $message }}</div>
                @enderror
            </fieldset>
        </div>

        <div class="cols gap10">
            <button class="tf-button w-full" type="submit">{{ __('admin.update_product') }}</button>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
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
});
</script>
@endpush
