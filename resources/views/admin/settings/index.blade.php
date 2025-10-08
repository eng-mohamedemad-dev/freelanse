@extends('admin.layouts.app')

@section('title', __('admin.settings'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('admin.settings') }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Basic Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('admin.basic_settings') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_name" class="form-label">{{ __('admin.site_name') }} *</label>
                                        <input type="text" 
                                               class="form-control @error('site_name') is-invalid @enderror" 
                                               id="site_name" 
                                               name="site_name" 
                                               value="{{ old('site_name', $settings['site_name']) }}" 
                                               required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_logo" class="form-label">{{ __('admin.site_logo') }}</label>
                                        <input type="file" 
                                               class="form-control @error('site_logo') is-invalid @enderror" 
                                               id="site_logo" 
                                               name="site_logo" 
                                               accept="image/*">
                                        @error('site_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($settings['site_logo'])
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" 
                                                 alt="Current Logo" 
                                                 style="max-height: 50px;">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="default_language" class="form-label">{{ __('admin.default_language') }}</label>
                                        <select class="form-select @error('default_language') is-invalid @enderror" 
                                                id="default_language" 
                                                name="default_language">
                                            <option value="ar" {{ old('default_language', $settings['default_language']) == 'ar' ? 'selected' : '' }}>
                                                عربي
                                            </option>
                                            <option value="en" {{ old('default_language', $settings['default_language']) == 'en' ? 'selected' : '' }}>
                                                English
                                            </option>
                                        </select>
                                        @error('default_language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Points System -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('admin.points_system') }}</h5>
                        </div>
                        <div class="card-body">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points_per_dollar" class="form-label">{{ __('admin.points_per_dollar') }}</label>
                                        <input type="number" 
                                               class="form-control @error('points_per_dollar') is-invalid @enderror" 
                                               id="points_per_dollar" 
                                               name="points_per_dollar" 
                                               value="{{ old('points_per_dollar', $settings['points_per_dollar']) }}" 
                                               min="1">
                                        @error('points_per_dollar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wheel of Fortune -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('admin.wheel_of_fortune') }}</h5>
                        </div>
                        <div class="card-body">
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
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> {{ __('admin.save_settings') }}
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> {{ __('admin.back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle points system fields
    const pointsEnabled = document.getElementById('points_system_enabled');
    const pointsPerDollar = document.getElementById('points_per_dollar');
    
    function togglePointsFields() {
        pointsPerDollar.disabled = !pointsEnabled.checked;
    }
    
    pointsEnabled.addEventListener('change', togglePointsFields);
    togglePointsFields();
    
    // Toggle wheel fields
    const wheelEnabled = document.getElementById('wheel_enabled');
    const maxSpins = document.getElementById('max_wheel_spins_per_day');
    
    function toggleWheelFields() {
        maxSpins.disabled = !wheelEnabled.checked;
    }
    
    wheelEnabled.addEventListener('change', toggleWheelFields);
    toggleWheelFields();
});
</script>
@endpush
