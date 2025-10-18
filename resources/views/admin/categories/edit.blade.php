@extends('admin.layouts.app')

@section('title', __('admin.edit_category'))
@section('page-title', __('admin.edit_category'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.edit_category') }}</h3>
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
            <div class="text-tiny">{{ __('admin.edit_category') }}</div>
        </li>
    </ul>
</div>

<!-- form-edit-category -->
<form class="tf-section-2 form-edit-category" method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')
    <div class="wg-box">
        <fieldset class="name">
            <div class="body-title">{{ __('admin.category_name') }} <span class="tf-color-1">*</span></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <input type="text" placeholder="{{ __('admin.enter_category_name') }} (AR)" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required>
                <input type="text" placeholder="{{ __('admin.enter_category_name') }} (EN)" name="name_en" value="{{ old('name_en', $category->name_en) }}" required>
            </div>
            @error('name_ar')<div class="text-tiny tf-color-1">{{ $message }}</div>@enderror
            @error('name_en')<div class="text-tiny tf-color-1">{{ $message }}</div>@enderror
        </fieldset>

        <fieldset class="description">
            <div class="body-title">{{ __('admin.category_description') }}</div>
            <div style="display:grid;grid-template-columns:1fr;gap:8px;">
                <textarea name="description_ar" placeholder="{{ __('admin.enter_category_description') }} (AR)">{{ old('description_ar', $category->description_ar) }}</textarea>
                <textarea name="description_en" placeholder="{{ __('admin.enter_category_description') }} (EN)">{{ old('description_en', $category->description_en) }}</textarea>
            </div>
            @error('description_ar')<div class="text-tiny tf-color-1">{{ $message }}</div>@enderror
            @error('description_en')<div class="text-tiny tf-color-1">{{ $message }}</div>@enderror
        </fieldset>
    </div>

    <div class="wg-box">
        <fieldset>
            <div class="body-title">{{ __('admin.category_image') }}</div>
            @if($category->image)
                <div class="current-image mb-20">
                    <div class="current-image-item">
                        <img src="{{ asset($category->image) }}" alt="Current Image" class="current-image-preview">
                        <button type="button" class="remove-current-image" onclick="removeCurrentImage()">
                            <i class="icon-x"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="no-current-image mb-20">
                    <p class="text-muted">{{ __('admin.no_image_found') }}</p>
                </div>
            @endif
        </fieldset>

        <fieldset>
            <div class="body-title">{{ __('admin.upload_images') }}</div>
            <div class="upload-image flex-grow">
                <!-- Preview area for new image -->
                <div id="image-preview" class="image-preview" style="display: none;">
                    <div id="preview-container">
                        <!-- Image will be added here dynamically -->
                    </div>
                </div>
                
                <!-- Upload area -->
                <div id="upload-file" class="item up-load">
                    <label class="uploadfile" for="myFile">
                        <span class="icon">
                            <i class="icon-upload-cloud"></i>
                        </span>
                        <span class="body-text">{{ __('admin.drop_your_images_here_or_select') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                        <input type="file" id="myFile" name="image" accept="image/*">
                    </label>
                </div>
            </div>
            @error('image')
                <div class="text-tiny tf-color-1">{{ $message }}</div>
            @enderror
        </fieldset>

        <div class="cols gap10">
            <button class="tf-button w-full" type="submit">{{ __('admin.update_category') }}</button>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .current-image {
        display: flex;
        justify-content: center;
    }
    
    .current-image-item {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .current-image-preview {
        width: 200px;
        height: 150px;
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
    
    .image-preview {
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
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid #007bff;
    }
    
    .image-preview-item img {
        width: 200px;
        height: 150px;
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
        justify-content: center;
    }
    
    .no-current-image {
        text-align: center;
        padding: 20px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }
    
    /* SweetAlert Custom Styles */
    .swal-wide {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 500px !important;
        max-width: 90vw !important;
    }
    
    .swal-title {
        font-size: 32px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 20px !important;
    }
    
    .swal-content {
        font-size: 20px !important;
        line-height: 1.6 !important;
        color: #555 !important;
        margin: 20px 0 !important;
    }
    
    .swal-confirm {
        font-size: 18px !important;
        font-weight: 500 !important;
        padding: 15px 30px !important;
        border-radius: 8px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        transition: all 0.3s ease !important;
        margin: 0 10px !important;
    }
    
    .swal-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    }
    
    .swal2-popup {
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    
    .swal2-icon {
        margin: 20px auto 15px !important;
    }
    
    .swal2-icon.swal2-success {
        border-color: #28a745 !important;
        color: #28a745 !important;
    }
    
    .swal2-icon.swal2-error {
        border-color: #dc3545 !important;
        color: #dc3545 !important;
    }
    
    .swal2-icon.swal2-warning {
        border-color: #ffc107 !important;
        color: #ffc107 !important;
    }
    
    /* Dark Theme SweetAlert */
    .dark-theme .swal-title {
        color: #fff !important;
    }
    
    .dark-theme .swal-content {
        color: #e2e8f0 !important;
    }
    
    .dark-theme .swal2-popup {
        background: #2d3748 !important;
        color: #fff !important;
    }
    
    /* Fix fieldset layout to show messages below fields */
    fieldset {
        display: block;
        width: 100%;
        margin-bottom: 20px;
    }
    
    fieldset .body-title {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    fieldset input,
    fieldset textarea {
        display: block;
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    fieldset input:focus,
    fieldset textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    fieldset .text-tiny {
        display: block;
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    
    fieldset .tf-color-1 {
        display: block;
        font-size: 12px;
        color: #dc3545;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    
    /* Dark theme for fieldsets */
    .dark-theme fieldset .body-title {
        color: #e2e8f0;
    }
    
    .dark-theme fieldset input,
    .dark-theme fieldset textarea {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    .dark-theme fieldset input:focus,
    .dark-theme fieldset textarea:focus {
        border-color: #007bff;
        background: #2d3748;
    }
    
    .dark-theme fieldset input::placeholder,
    .dark-theme fieldset textarea::placeholder {
        color: #a0aec0;
    }
    
    .dark-theme fieldset .text-tiny {
        color: #a0aec0;
    }
    
    .dark-theme fieldset .tf-color-1 {
        color: #ff6b6b;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let selectedImage = null;
    let removeCurrentImageFlag = false;
    
    // Handle removal of current image
    window.removeCurrentImage = function() {
        Swal.fire({
            title: '{{ __('admin.delete_image_confirmation') }}',
            text: '{{ __('admin.delete_image_confirmation') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            width: '500px',
            padding: '2rem'
        }).then((result) => {
            if (result.isConfirmed) {
                removeCurrentImageFlag = true;
                $('.current-image').fadeOut(300);
                $('.no-current-image').show();
            }
        });
    };
    
    // Single image upload functionality
    $('#myFile').on('change', function(e) {
        const file = e.target.files[0];
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                selectedImage = {
                    file: file,
                    url: e.target.result
                };
                
                // Create preview item
                const previewContainer = $('#preview-container');
                previewContainer.html(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Preview" style="width: 200px; height: 150px; object-fit: cover;">
                        <button type="button" class="remove-image-btn" onclick="removeImage()" title="{{ __('admin.remove_image') }}">
                            ×
                        </button>
                    </div>
                `);
                
                $('#image-preview').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Remove image function
    window.removeImage = function() {
        selectedImage = null;
        $('#image-preview').hide();
        $('#myFile').val('');
    };
    
    // Add hidden input for removed current image
    $('form').on('submit', function() {
        if (removeCurrentImageFlag) {
            $(this).append('<input type="hidden" name="remove_current_image" value="1">');
        }
    });
    
    // Show success/error messages if they exist
    @if(session('success'))
        Swal.fire({
            title: '{{ __("admin.success") }}',
            text: '{{ __("admin.category_updated_successfully") }}',
            icon: 'success',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            title: '{{ __("admin.error_occurred") }}',
            text: '{{ __("admin.error_occurred_message") }}',
            icon: 'error',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    @endif
    
    @if($errors->any())
        Swal.fire({
            title: '{{ __("admin.validation_error") }}',
            text: '{{ __("admin.please_fill_required_fields") }}',
            icon: 'error',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        });
    @endif
});
</script>
@endpush
