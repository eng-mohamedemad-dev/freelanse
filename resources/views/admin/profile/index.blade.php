@extends('admin.layouts.app')

@section('title', __('admin.profile'))
@section('page-title', __('admin.profile'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.profile') }}</h3>
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
            <div class="text-tiny">{{ __('admin.profile') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Profile Image Section -->
        <div class="profile-section mb-30">
            <h4 class="section-title">{{ __('admin.profile_image') }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="upload-image flex-grow">
                            {{-- <!-- Current Avatar Display -->
                            @if($user->avatar)
                            <div class="current-images mb-20">
                                <div class="current-images-container">
                                    <div class="current-image-item">
                                        <img src="{{ asset($user->avatar) }}" 
                                             alt="Current Avatar" 
                                             class="current-image"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="avatar-error" style="display: none; color: #dc3545; font-size: 14px;">
                                            {{ __('admin.avatar_not_found') }}
                                        </div>
                                        <button type="button" class="remove-current-image" 
                                                data-avatar="{{ $user->avatar }}" 
                                                title="{{ __('admin.remove_avatar') }}">
                                            <i class="icon-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                            
                            <!-- Preview area for new avatar -->
                            <div id="images-preview" class="images-preview" style="display: none;">
                                <div class="preview-title">{{ __('admin.new_avatar_preview') }}</div>
                                <div id="preview-container">
                                    <!-- New avatar will be added here dynamically -->
                                </div>
                            </div>
                            
                            <!-- Upload area -->
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="avatar">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">{{ __('admin.drag_avatar_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                                    <input type="file" id="avatar" name="avatar" accept="image/*">
                                </label>
                            </div>
                        </div>
                        @error('avatar')
                            <div class="text-tiny tf-color-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="profile-section mb-30">
            <h4 class="section-title">{{ __('admin.personal_information') }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('admin.full_name') }} <span class="tf-color-1">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               placeholder="{{ __('admin.enter_full_name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('admin.email_address') }} <span class="tf-color-1">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               placeholder="{{ __('admin.enter_email_address') }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">{{ __('admin.phone_number') }}</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}" 
                               placeholder="{{ __('admin.enter_phone_number') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Change Section -->
        <div class="profile-section mb-30">
            <h4 class="section-title">{{ __('admin.password_change') }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_password" class="form-label">{{ __('admin.current_password') }}</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               placeholder="{{ __('admin.enter_current_password') }}">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(session('password_error'))
                            <div class="text-tiny tf-color-1">{{ session('password_error') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="new_password" class="form-label">{{ __('admin.new_password') }}</label>
                        <input type="password" 
                               class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" 
                               name="new_password" 
                               placeholder="{{ __('admin.enter_new_password') }}">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">{{ __('admin.confirm_new_password') }}</label>
                        <input type="password" 
                               class="form-control" 
                               id="new_password_confirmation" 
                               name="new_password_confirmation" 
                               placeholder="{{ __('admin.confirm_new_password') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="tf-button style-1 w208">
                <i class="icon-save"></i> {{ __('admin.save_changes') }}
            </button>
            <a href="{{ route('admin.dashboard') }}" class="tf-button style-2 w208">
                <i class="icon-arrow-left"></i> {{ __('admin.back') }}
            </a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .profile-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fff;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .tf-color-1 {
        color: #dc3545 !important;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        margin-top: 30px;
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
        font-size: 14px;
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
    
    .w208 {
        width: 208px;
    }
    
    /* Image Upload Styles */
    .upload-image {
        position: relative;
    }
    
    .current-images {
        margin-bottom: 20px;
    }
    
    .current-images-container {
        display: flex;
        justify-content: center;
    }
    
    .current-image-item {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .current-image {
        width: 150px;
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
        width: 30px;
        height: 30px;
        font-size: 14px;
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
        border-radius: 12px;
        padding: 20px;
        background: #f0f8ff;
        margin-bottom: 20px;
        min-height: 120px;
    }
    
    .preview-title {
        font-weight: 600;
        color: #007bff;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .image-preview-item {
        position: relative;
        display: inline-block;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 2px solid #007bff;
    }
    
    .image-preview-item img {
        width: 150px;
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
        width: 30px;
        height: 30px;
        font-size: 16px;
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
    
    .up-load {
        border: 2px dashed #ddd;
        border-radius: 12px;
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
    
    /* Dark Theme Styles */
    .dark-theme .profile-section {
        background: #4a5568;
    }
    
    .dark-theme .section-title {
        color: #e2e8f0;
        border-bottom-color: #007bff;
    }
    
    .dark-theme .form-label {
        color: #e2e8f0;
    }
    
    .dark-theme .form-control {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    .dark-theme .form-control:focus {
        border-color: #007bff;
        background: #2d3748;
    }
    
    .dark-theme .form-control::placeholder {
        color: #a0aec0;
    }
    
    .dark-theme .up-load {
        background: #4a5568;
        border-color: #718096;
    }
    
    .dark-theme .up-load:hover {
        background: #2d3748;
        border-color: #007bff;
    }
    
    .dark-theme .images-preview {
        background: #2d3748;
        border-color: #007bff;
    }
    
    .dark-theme .preview-title {
        color: #007bff;
    }
    
    .dark-theme .current-image-item {
        border-color: #718096;
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
    
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .tf-button.w208 {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let selectedImage = null;
    let removeCurrentImageFlag = false;
    
    // Handle removal of current image
    $('.remove-current-image').on('click', function() {
        Swal.fire({
            title: '{{ __("admin.delete_avatar_confirmation") }}',
            text: '{{ __("admin.delete_avatar_confirmation_text") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("admin.yes") }}',
            cancelButtonText: '{{ __("admin.cancel") }}',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                removeCurrentImageFlag = true;
                $('.current-images').fadeOut(300);
            }
        });
    });
    
    // Single image upload functionality
    $('#avatar').on('change', function(e) {
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
                        <img src="${e.target.result}" alt="Preview" style="width: 150px; height: 150px; object-fit: cover;">
                        <button type="button" class="remove-image-btn" onclick="removeImage()" title="{{ __('admin.remove_image') }}">
                            ×
                        </button>
                    </div>
                `);
                
                $('#images-preview').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Remove image function
    window.removeImage = function() {
        selectedImage = null;
        $('#images-preview').hide();
        $('#avatar').val('');
    };
    
    // Add hidden input for removed current image
    $('form').on('submit', function() {
        if (removeCurrentImageFlag) {
            $(this).append('<input type="hidden" name="remove_current_avatar" value="1">');
        }
    });
    
    // Show success/error messages if they exist
    @if(session('success'))
        Swal.fire({
            title: '{{ __("admin.success") }}',
            text: '{{ __("admin.profile_updated_successfully") }}',
            icon: 'success',
            confirmButtonText: '{{ __("admin.ok") }}',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm'
            }
        }).then(() => {
            // Reload page to update header image
            window.location.reload();
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
    
    @if(session('password_error'))
        Swal.fire({
            title: '{{ __("admin.password_error") }}',
            text: '{{ __("admin.current_password_incorrect") }}',
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
