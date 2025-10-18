@extends('admin.layouts.app')

@section('title', __('admin.edit_coupon'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>{{ __('admin.edit_coupon') }}</h3>
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
                        <a href="{{ route('admin.coupons.index') }}">
                            <div class="text-tiny">{{ __('admin.coupons') }}</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">{{ __('admin.edit_coupon') }}</div>
                    </li>
                </ul>
            </div>
            <!-- form-edit-coupon -->
            <form class="tf-section-2 form-add-product" method="POST" action="{{ route('admin.coupons.update', $coupon) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.coupon_name') }} <span class="tf-color-1">*</span></div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <input class="mb-10 @error('name_ar') is-invalid @enderror" type="text" placeholder="{{ __('admin.coupon_name') }} (AR)" name="name_ar" value="{{ old('name_ar', $coupon->name_ar) }}" required>
                            <input class="mb-10 @error('name_en') is-invalid @enderror" type="text" placeholder="{{ __('admin.coupon_name') }} (EN)" name="name_en" value="{{ old('name_en', $coupon->name_en) }}" required>
                        </div>
                        @error('name_ar')<div class="text-danger">{{ $message }}</div>@enderror
                        @error('name_en')<div class="text-danger">{{ $message }}</div>@enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">{{ __('admin.coupon_code') }} <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('code') is-invalid @enderror" type="text" placeholder="{{ __('admin.coupon_code') }}" name="code" value="{{ old('code', $coupon->code) }}" required>
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">{{ __('admin.coupon_type') }} <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="type" required onchange="toggleValueField()">
                                    <option value="">{{ __('admin.select_type') }}</option>
                                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>{{ __('admin.fixed_amount') }}</option>
                                    <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>{{ __('admin.percentage') }}</option>
                                </select>
                            </div>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <!-- Fixed Amount Field -->
                    <div class="gap22 cols" id="fixed-amount-field" style="{{ old('type', $coupon->type) == 'fixed' ? 'display: flex;' : 'display: none;' }}">
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.fixed_amount_value') }} <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('value') is-invalid @enderror" type="number" step="0.01" placeholder="{{ __('admin.fixed_amount_value') }}" name="fixed_value" value="{{ old('fixed_value', $coupon->type=='fixed' ? $coupon->value : '') }}">
                            @error('value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                        
                    </div>

                    <!-- Percentage Field -->
                    <div class="gap22 cols" id="percentage-field" style="{{ old('type', $coupon->type) == 'percentage' ? 'display: flex;' : 'display: none;' }}">
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.percentage_value') }} <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('value') is-invalid @enderror" type="number" min="1" max="100" placeholder="{{ __('admin.percentage_value') }}" name="percentage_value" value="{{ old('percentage_value', $coupon->type=='percentage' ? $coupon->value : '') }}">
                            @error('value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                        
                    </div>

                    <div class="gap22 cols">
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.usage_limit') }}</div>
                            <input class="mb-10 @error('usage_limit') is-invalid @enderror" type="number" placeholder="{{ __('admin.usage_limit') }}" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1">
                            @error('usage_limit')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">{{ __('admin.expires_at') }}</div>
                            <input class="mb-10 @error('expires_at') is-invalid @enderror" type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}">
                            @error('expires_at')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                </div>

                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">{{ __('admin.coupon_image') }}</div>
                        <div class="upload-image flex-grow">
                            @if($coupon->image)
                                <div class="item" id="current-image">
                                    <img src="{{ asset($coupon->image) }}" class="effect8" alt="{{ $coupon->name }}">
                                </div>
                            @endif
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
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">{{ __('admin.coupon_description') }}</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <textarea class="mb-10 @error('description_ar') is-invalid @enderror" name="description_ar" rows="4" placeholder="{{ __('admin.coupon_description') }} (AR)">{{ old('description_ar', $coupon->description_ar) }}</textarea>
                            <textarea class="mb-10 @error('description_en') is-invalid @enderror" name="description_en" rows="4" placeholder="{{ __('admin.coupon_description') }} (EN)">{{ old('description_en', $coupon->description_en) }}</textarea>
                        </div>
                        @error('description_ar')<div class="text-danger">{{ $message }}</div>@enderror
                        @error('description_en')<div class="text-danger">{{ $message }}</div>@enderror
                    </fieldset>

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">{{ __('admin.update_coupon') }}</button>
                    </div>
                </div>
            </form>
            <!-- /form-edit-coupon -->
        

<script>
function toggleValueField() {
    const type = document.querySelector('select[name="type"]').value;
    const fixedField = document.getElementById('fixed-amount-field');
    const percentageField = document.getElementById('percentage-field');
    
    fixedField.style.display = 'none';
    percentageField.style.display = 'none';
    
    if (type === 'fixed') {
        fixedField.style.display = 'flex';
    } else if (type === 'percentage') {
        percentageField.style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleValueField();
});
</script>
@endsection