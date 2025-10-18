@extends('admin.layouts.app')

@section('title', __('admin.settings'))
@section('page-title', __('admin.settings'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.settings') }}</h3>
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
            <div class="text-tiny">{{ __('admin.settings') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Logo Settings -->
                    <div class="settings-section mb-30">
                        <h4 class="section-title">{{ __('admin.logo_settings') }}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_name" class="form-label">{{ __('admin.site_name') }}</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" placeholder="{{ __('admin.site_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="site_logo" class="form-label">{{ __('admin.site_logo') }}</label>
                                    
                                    <div class="upload-image flex-grow">
                                        <!-- Current Logo Display -->
                                        @if($settings['site_logo'])
                                        <div class="current-images mb-20">
                                            <div class="current-images-container">
                                                <div class="current-image-item">
                                                    <img src="{{ asset($settings['site_logo']) }}" 
                                                         alt="Current Logo" 
                                                         class="current-image"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div class="logo-error" style="display: none; color: #dc3545; font-size: 14px;">
                                                        {{ __('admin.logo_not_found') }}
                                                    </div>
                                                    <button type="button" class="remove-current-image" 
                                                            data-logo="{{ $settings['site_logo'] }}" 
                                                            title="{{ __('admin.remove_logo') }}">
                                                        <i class="icon-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Preview area for new logo -->
                                        <div id="images-preview" class="images-preview" style="display: none;">
                                            <div class="preview-title">{{ __('admin.new_logo_preview') }}</div>
                                            <div id="preview-container">
                                                <!-- New logo will be added here dynamically -->
                                            </div>
                                        </div>
                                        
                                        <!-- Upload area -->
                                        <div id="upload-file" class="item up-load">
                                            <label class="uploadfile" for="site_logo">
                                                <span class="icon">
                                                    <i class="icon-upload-cloud"></i>
                                                </span>
                                                <span class="body-text">{{ __('admin.drag_logo_here') }} <span class="tf-color">{{ __('admin.click_to_browse') }}</span></span>
                                                <input type="file" id="site_logo" name="site_logo" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    @error('site_logo')
                                        <div class="text-tiny tf-color-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Points System -->
                    <div class="settings-section mb-30">
                        <h4 class="section-title">{{ __('admin.points_system') }}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="points_system_enabled" 
                                                   name="points_system_enabled" 
                                                   value="1"
                                                   {{ old('points_system_enabled', $settings['points_system_enabled']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="points_system_enabled">
                                                {{ __('admin.enable_points_system') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="points_count" class="form-label">{{ __('admin.points_count') }}</label>
                                        <input type="number" 
                                               class="form-control @error('points_count') is-invalid @enderror" 
                                               id="points_count" 
                                               name="points_count" 
                                               value="{{ old('points_count', $settings['points_count']) }}" 
                                               min="1">
                                        @error('points_count')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="points_discount" class="form-label">{{ __('admin.points_discount') }}</label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   class="form-control @error('points_discount') is-invalid @enderror" 
                                                   id="points_discount" 
                                                   name="points_discount" 
                                                   value="{{ old('points_discount', $settings['points_discount']) }}" 
                                                   min="1" 
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('points_discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Wheel of Fortune -->
                    <div class="settings-section mb-30">
                        <h4 class="section-title">{{ __('admin.wheel_of_fortune') }}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="wheel_enabled" 
                                                   name="wheel_enabled" 
                                                   value="1"
                                                   {{ old('wheel_enabled', $settings['wheel_enabled']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="wheel_enabled">
                                                {{ __('admin.enable_wheel') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_wheel_spins_per_day" class="form-label">{{ __('admin.max_spins_per_day') }}</label>
                                        <input type="number" 
                                               class="form-control @error('max_wheel_spins_per_day') is-invalid @enderror" 
                                               id="max_wheel_spins_per_day" 
                                               name="max_wheel_spins_per_day" 
                                               value="{{ old('max_wheel_spins_per_day', $settings['max_wheel_spins_per_day']) }}" 
                                               min="1" 
                                               max="10">
                                        @error('max_wheel_spins_per_day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Wheel Prizes -->
                            <div class="row wheel-prizes-section">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('admin.wheel_prizes') }}</label>
                                        <div id="wheel-prizes-container">
                                            @if(isset($settings['wheel_prizes']) && is_array($settings['wheel_prizes']))
                                                @foreach($settings['wheel_prizes'] as $index => $prize)
                                                    <div class="wheel-prize-item mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       name="wheel_prizes[{{ $index }}][name]" 
                                                                       value="{{ $prize['name'] ?? '' }}" 
                                                                       placeholder="{{ __('admin.prize_name') }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="number" 
                                                                       class="form-control" 
                                                                       name="wheel_prizes[{{ $index }}][value]" 
                                                                       value="{{ $prize['value'] ?? '' }}" 
                                                                       placeholder="{{ __('admin.prize_value') }}" 
                                                                       min="0">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-select" name="wheel_prizes[{{ $index }}][type]">
                                                                    <option value="points" {{ ($prize['type'] ?? '') == 'points' ? 'selected' : '' }}>{{ __('admin.points') }}</option>
                                                                    <option value="discount" {{ ($prize['type'] ?? '') == 'discount' ? 'selected' : '' }}>{{ __('admin.discount') }}</option>
                                                                    <option value="cash" {{ ($prize['type'] ?? '') == 'cash' ? 'selected' : '' }}>{{ __('admin.cash') }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger btn-sm remove-prize">
                                                                    <i class="icon-trash-2"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="wheel-prize-item mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   name="wheel_prizes[0][name]" 
                                                                   value="" 
                                                                   placeholder="{{ __('admin.prize_name') }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="wheel_prizes[0][value]" 
                                                                   value="" 
                                                                   placeholder="{{ __('admin.prize_value') }}" 
                                                                   min="0">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-select" name="wheel_prizes[0][type]">
                                                                <option value="points">{{ __('admin.points') }}</option>
                                                                <option value="discount">{{ __('admin.discount') }}</option>
                                                                <option value="cash">{{ __('admin.cash') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger btn-sm remove-prize">
                                                                <i class="icon-trash-2"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success btn-sm mt-2" id="add-prize">
                                            <i class="icon-plus"></i> {{ __('admin.add_prize') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="tf-button style-1 w208">
                            <i class="icon-save"></i> {{ __('admin.save_settings') }}
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
    .settings-section {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: #007bff;
        border-radius: 2px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fff;
    }
    
    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }
    
    .input-group {
        display: flex;
        align-items: stretch;
    }
    
    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        background-color: #e9ecef;
        border: 2px solid #e9ecef;
        border-left: none;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    
    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    
    /* Wheel Prizes Styling */
    .wheel-prize-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .wheel-prize-item:hover {
        background: #e9ecef;
        border-color: #007bff;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-sm {
        padding: 8px 16px;
        font-size: 14px;
        min-width: 40px;
        min-height: 40px;
    }
    
    .btn-success {
        background: #28a745;
        color: white;
    }
    
    .btn-success:hover {
        background: #218838;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }
    
    .btn-danger {
        background: #dc3545;
        color: white;
    }
    
    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }
    
    /* Special styling for remove prize button */
    .remove-prize {
        width: 45px !important;
        height: 45px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        min-width: 45px !important;
        min-height: 45px !important;
    }
    
    .remove-prize i {
        font-size: 18px !important;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-check-input {
        width: 20px !important;
        height: 20px !important;
        border: 2px solid #e9ecef !important;
        border-radius: 4px !important;
        cursor: pointer !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        position: relative !important;
        transition: all 0.3s ease !important;
        background: #fff !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
    }
    
    .form-check-input:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    .form-check-input:checked::after {
        content: '✓' !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        color: white !important;
        font-size: 14px !important;
        font-weight: bold !important;
        line-height: 1 !important;
        display: block !important;
    }
    
    .form-check-input:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25) !important;
    }
    
    /* Force checkbox styling */
    input[type="checkbox"].form-check-input {
        width: 20px !important;
        height: 20px !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        background: #fff !important;
        border: 2px solid #e9ecef !important;
        border-radius: 4px !important;
        position: relative !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
    }
    
    input[type="checkbox"].form-check-input:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    input[type="checkbox"].form-check-input:checked::before {
        content: '✓' !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        color: white !important;
        font-size: 14px !important;
        font-weight: bold !important;
        line-height: 1 !important;
        display: block !important;
    }
    
    /* Additional checkbox styling */
    .form-check-input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        background: #fff !important;
        border: 2px solid #e9ecef !important;
        border-radius: 4px !important;
        position: relative !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
    }
    
    .form-check-input[type="checkbox"]:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    .form-check-input[type="checkbox"]:checked::after {
        content: '✓' !important;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        color: white !important;
        font-size: 14px !important;
        font-weight: bold !important;
        line-height: 1 !important;
        display: block !important;
    }
    
    .form-check-label {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .tf-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .tf-button.style-1 {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }
    
    .tf-button.style-1:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .tf-button.style-2 {
        background: #6c757d;
        color: white;
    }
    
    .tf-button.style-2:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    /* Dark Theme */
    .dark-theme .settings-section {
        background: #2d3748;
        border-color: #4a5568;
    }
    
    .dark-theme .section-title {
        color: #fff;
        border-bottom-color: #007bff;
    }
    
    .dark-theme .form-label {
        color: #fff;
    }
    
    .dark-theme .form-control,
    .dark-theme .form-select {
        background: #4a5568;
        border-color: #718096;
        color: #fff;
    }
    
    .dark-theme .form-control:focus,
    .dark-theme .form-select:focus {
        border-color: #007bff;
    }
    
    .dark-theme .input-group-text {
        background-color: #4a5568;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    .dark-theme .form-text {
        color: #a0aec0;
    }
    
    .dark-theme .form-check-input {
        border-color: #718096 !important;
        background: #4a5568 !important;
    }
    
    .dark-theme .form-check-input:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    .dark-theme .form-check-input:checked::after {
        content: '✓' !important;
        color: white !important;
    }
    
    /* Dark theme for forced checkbox styling */
    .dark-theme input[type="checkbox"].form-check-input {
        background: #4a5568 !important;
        border-color: #718096 !important;
    }
    
    .dark-theme input[type="checkbox"].form-check-input:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    .dark-theme input[type="checkbox"].form-check-input:checked::before {
        content: '✓' !important;
        color: white !important;
    }
    
    /* Dark theme for additional checkbox styling */
    .dark-theme .form-check-input[type="checkbox"] {
        background: #4a5568 !important;
        border-color: #718096 !important;
    }
    
    .dark-theme .form-check-input[type="checkbox"]:checked {
        background: #007bff !important;
        border-color: #007bff !important;
    }
    
    .dark-theme .form-check-input[type="checkbox"]:checked::after {
        content: '✓' !important;
        color: white !important;
    }
    
    .dark-theme .form-check-label {
        color: #fff;
    }
    
    /* Dark Theme Wheel Prizes */
    .dark-theme .wheel-prize-item {
        background: #4a5568;
        border-color: #718096;
    }
    
    .dark-theme .wheel-prize-item:hover {
        background: #718096;
        border-color: #007bff;
    }
    
    /* Smooth transitions for field visibility */
    .col-md-3, .col-md-6, .wheel-prizes-section {
        transition: all 0.3s ease;
    }
    
    .col-md-3[style*="display: none"], 
    .col-md-6[style*="display: none"], 
    .wheel-prizes-section[style*="display: none"] {
        opacity: 0;
        transform: translateY(-10px);
    }
    
    .dark-theme .form-actions {
        border-top-color: #4a5568;
    }
    
    /* Image Upload Styles (Same as Products) */
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
    
    /* عرض الشعار بشكل دائرة كما كان سابقًا */
    .current-image {
        width: 120px;
        height: 80px;
        object-fit: contain;
        display: block;
        background: #fff;
        padding: 10px;
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
        width: 120px;
        height: 120px;
        object-fit: cover;
        display: block;
        background: #fff;
        padding: 6px;
        border: 2px solid #e9ecef;
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        .current-image,
        .image-preview-item img {
            width: 100px;
            height: 100px;
        }
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
    
    /* Dark Theme Image Styles */
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
    
    .dark-theme .current-image,
    .dark-theme .image-preview-item img {
        background: #2d3748;
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
    
    /* SweetAlert Custom Styles for Settings */
    .swal-wide {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 500px !important;
        max-width: 90vw !important;
    }
    
    .swal-popup {
        width: 500px !important;
        max-width: 90vw !important;
        padding: 30px !important;
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
    
    .swal-cancel {
        font-size: 18px !important;
        font-weight: 500 !important;
        padding: 15px 30px !important;
        border-radius: 8px !important;
        background: #6c757d !important;
        border: none !important;
        transition: all 0.3s ease !important;
        margin: 0 10px !important;
    }
    
    .swal-cancel:hover {
        background: #545b62 !important;
        transform: translateY(-2px) !important;
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Force checkbox styling
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.style.appearance = 'none';
        checkbox.style.webkitAppearance = 'none';
        checkbox.style.mozAppearance = 'none';
        checkbox.style.width = '20px';
        checkbox.style.height = '20px';
        checkbox.style.border = '2px solid #e9ecef';
        checkbox.style.borderRadius = '4px';
        checkbox.style.position = 'relative';
        checkbox.style.cursor = 'pointer';
        checkbox.style.transition = 'all 0.3s ease';
        checkbox.style.background = '#fff';
        checkbox.style.margin = '0';
        checkbox.style.padding = '0';
        checkbox.style.flexShrink = '0';
        
        // Add checkmark when checked
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.style.background = '#007bff';
                this.style.borderColor = '#007bff';
                if (!this.querySelector('.checkmark')) {
                    const checkmark = document.createElement('span');
                    checkmark.className = 'checkmark';
                    checkmark.innerHTML = '✓';
                    checkmark.style.position = 'absolute';
                    checkmark.style.top = '50%';
                    checkmark.style.left = '50%';
                    checkmark.style.transform = 'translate(-50%, -50%)';
                    checkmark.style.color = 'white';
                    checkmark.style.fontSize = '14px';
                    checkmark.style.fontWeight = 'bold';
                    checkmark.style.lineHeight = '1';
                    this.appendChild(checkmark);
                }
            } else {
                this.style.background = '#fff';
                this.style.borderColor = '#e9ecef';
                const checkmark = this.querySelector('.checkmark');
                if (checkmark) {
                    checkmark.remove();
                }
            }
        });
        
        // Initialize checkmark if already checked
        if (checkbox.checked) {
            checkbox.dispatchEvent(new Event('change'));
        }
    });
    
    // Initialize field visibility on page load
    setTimeout(function() {
        if (pointsEnabled) {
            togglePointsFields();
        }
        if (wheelEnabled) {
            toggleWheelFields();
        }
    }, 100);
    
    // Image upload functionality (Same as Products)
    const fileInput = document.getElementById('site_logo');
    let selectedImages = [];
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                selectedImages = [];
                const previewContainer = document.getElementById('preview-container');
                previewContainer.innerHTML = '';
                
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
                            const previewItem = document.createElement('div');
                            previewItem.className = 'image-preview-item';
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="Preview ${index + 1}" style="width: 120px; height: 80px; object-fit: contain;">
                                <button type="button" class="remove-image-btn" onclick="removeImage(${index})" title="إزالة الشعار">
                                    ×
                                </button>
                            `;
                            
                            previewContainer.appendChild(previewItem);
                            
                            processedCount++;
                            if (processedCount === files.filter(f => f.type.startsWith('image/')).length) {
                                document.getElementById('images-preview').style.display = 'block';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    }
    
    // Remove image function
    window.removeImage = function(index) {
        selectedImages.splice(index, 1);
        updatePreview();
        updateFileInput();
    };
    
    // Update preview after removing images
    function updatePreview() {
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';
        
        selectedImages.forEach((imageData, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'image-preview-item';
            previewItem.innerHTML = `
                <img src="${imageData.url}" alt="Preview ${index + 1}" style="width: 120px; height: 80px; object-fit: contain;">
                <button type="button" class="remove-image-btn" onclick="removeImage(${index})" title="إزالة الشعار">
                    ×
                </button>
            `;
            previewContainer.appendChild(previewItem);
        });
        
        if (selectedImages.length === 0) {
            document.getElementById('images-preview').style.display = 'none';
        }
    }
    
    // Update file input
    function updateFileInput() {
        if (fileInput && selectedImages.length > 0) {
            const dt = new DataTransfer();
            selectedImages.forEach(imageData => {
                dt.items.add(imageData.file);
            });
            fileInput.files = dt.files;
        }
    }
    
    // Remove current image functionality
    const removeCurrentImageBtns = document.querySelectorAll('.remove-current-image');
    removeCurrentImageBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const logoPath = this.getAttribute('data-logo');
            
            // Here you would typically make an AJAX call to remove the logo
            // For now, we'll just hide the current logo display
            this.closest('.current-images').style.display = 'none';
            
            // You might want to add a hidden input to track removed logos
            // or make an AJAX call to delete the logo from storage
        });
    });
    
    // Toggle points system fields
    const pointsEnabled = document.getElementById('points_system_enabled');
    const pointsCount = document.getElementById('points_count');
    const pointsDiscount = document.getElementById('points_discount');
    
    function togglePointsFields() {
        const pointsCountGroup = pointsCount ? pointsCount.closest('.col-md-3') : null;
        const pointsDiscountGroup = pointsDiscount ? pointsDiscount.closest('.col-md-3') : null;
        
        if (pointsEnabled.checked) {
            // Show fields
            if (pointsCountGroup) {
                pointsCountGroup.style.display = 'block';
                pointsCount.disabled = false;
            }
            if (pointsDiscountGroup) {
                pointsDiscountGroup.style.display = 'block';
                pointsDiscount.disabled = false;
            }
        } else {
            // Hide fields
            if (pointsCountGroup) {
                pointsCountGroup.style.display = 'none';
                pointsCount.disabled = true;
                pointsCount.value = '';
            }
            if (pointsDiscountGroup) {
                pointsDiscountGroup.style.display = 'none';
                pointsDiscount.disabled = true;
                pointsDiscount.value = '';
            }
        }
    }
    
    if (pointsEnabled) {
        pointsEnabled.addEventListener('change', function() {
            togglePointsFields();
        });
        togglePointsFields();
    }
    
    // Toggle wheel fields
    const wheelEnabled = document.getElementById('wheel_enabled');
    const maxSpins = document.getElementById('max_wheel_spins_per_day');
    
    function toggleWheelFields() {
        const maxSpinsGroup = maxSpins ? maxSpins.closest('.col-md-6') : null;
        const wheelPrizesSection = document.querySelector('.wheel-prizes-section');
        
        if (wheelEnabled.checked) {
            // Show fields
            if (maxSpinsGroup) {
                maxSpinsGroup.style.display = 'block';
                maxSpins.disabled = false;
            }
            if (wheelPrizesSection) {
                wheelPrizesSection.style.display = 'block';
            }
        } else {
            // Hide fields
            if (maxSpinsGroup) {
                maxSpinsGroup.style.display = 'none';
                maxSpins.disabled = true;
                maxSpins.value = '';
            }
            if (wheelPrizesSection) {
                wheelPrizesSection.style.display = 'none';
            }
        }
    }
    
    if (wheelEnabled) {
        wheelEnabled.addEventListener('change', function() {
            toggleWheelFields();
        });
        toggleWheelFields();
    }
    
    // Wheel Prizes Dynamic Fields
    let prizeIndex = {{ isset($settings['wheel_prizes']) && is_array($settings['wheel_prizes']) ? count($settings['wheel_prizes']) : 1 }};
    
    // Add prize function
    document.getElementById('add-prize').addEventListener('click', function() {
        const container = document.getElementById('wheel-prizes-container');
        const prizeItem = document.createElement('div');
        prizeItem.className = 'wheel-prize-item mb-3';
        prizeItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <input type="text" 
                           class="form-control" 
                           name="wheel_prizes[${prizeIndex}][name]" 
                           value="" 
                           placeholder="{{ __('admin.prize_name') }}">
                </div>
                <div class="col-md-3">
                    <input type="number" 
                           class="form-control" 
                           name="wheel_prizes[${prizeIndex}][value]" 
                           value="" 
                           placeholder="{{ __('admin.prize_value') }}" 
                           min="0">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="wheel_prizes[${prizeIndex}][type]">
                        <option value="points">{{ __('admin.points') }}</option>
                        <option value="discount">{{ __('admin.discount') }}</option>
                        <option value="cash">{{ __('admin.cash') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-prize">
                        <i class="icon-trash-2"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(prizeItem);
        prizeIndex++;
        
        // Add event listener to the new remove button
        prizeItem.querySelector('.remove-prize').addEventListener('click', function() {
            prizeItem.remove();
        });
    });
    
    // Remove prize function
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-prize')) {
            e.target.closest('.wheel-prize-item').remove();
        }
    });
    
    // Handle form submission with SweetAlert
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading SweetAlert
            Swal.fire({
                title: '{{ __("admin.saving_settings") }}',
                text: '{{ __("admin.please_wait_processing") }}',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    popup: 'swal-wide',
                    title: 'swal-title',
                    content: 'swal-content'
                }
            });
            
            // Submit the form
            this.submit();
        });
    }
    
    // Show success/error messages if they exist
    @if(session('success'))
        Swal.fire({
            title: '{{ __("admin.success") }}',
            text: '{{ __("admin.settings_updated_successfully") }}',
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
