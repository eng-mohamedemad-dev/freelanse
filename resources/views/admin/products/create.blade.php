@extends('admin.layouts.app')

@section('title', __('admin.add_product'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('admin.add_product') }}</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> {{ __('admin.back') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.basic_information') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ __('admin.product_name') }} *</label>
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name') }}" 
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku" class="form-label">{{ __('admin.sku') }}</label>
                                                <input type="text" 
                                                       class="form-control @error('sku') is-invalid @enderror" 
                                                       id="sku" 
                                                       name="sku" 
                                                       value="{{ old('sku') }}">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="description" class="form-label">{{ __('admin.product_description') }}</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.pricing') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price" class="form-label">{{ __('admin.product_price') }} *</label>
                                                <input type="number" 
                                                       class="form-control @error('price') is-invalid @enderror" 
                                                       id="price" 
                                                       name="price" 
                                                       value="{{ old('price') }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sale_price" class="form-label">{{ __('admin.sale_price') }}</label>
                                                <input type="number" 
                                                       class="form-control @error('sale_price') is-invalid @enderror" 
                                                       id="sale_price" 
                                                       name="sale_price" 
                                                       value="{{ old('sale_price') }}" 
                                                       step="0.01" 
                                                       min="0">
                                                @error('sale_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.inventory') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stock" class="form-label">{{ __('admin.stock_quantity') }}</label>
                                                <input type="number" 
                                                       class="form-control @error('stock') is-invalid @enderror" 
                                                       id="stock" 
                                                       name="stock" 
                                                       value="{{ old('stock', 0) }}" 
                                                       min="0">
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="low_stock_threshold" class="form-label">{{ __('admin.low_stock_threshold') }}</label>
                                                <input type="number" 
                                                       class="form-control @error('low_stock_threshold') is-invalid @enderror" 
                                                       id="low_stock_threshold" 
                                                       name="low_stock_threshold" 
                                                       value="{{ old('low_stock_threshold', 5) }}" 
                                                       min="0">
                                                @error('low_stock_threshold')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Product Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.product_image') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               data-preview-target="image-preview">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="image-preview mt-3">
                                        <img id="image-preview" 
                                             src="{{ asset('assets/admin/images/placeholder.jpg') }}" 
                                             alt="Image Preview" 
                                             class="img-fluid" 
                                             style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <!-- Categories & Brands -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.categories_brands') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">{{ __('admin.product_category') }} *</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" 
                                                name="category_id" 
                                                required>
                                            <option value="">{{ __('admin.select_category') }}</option>
                                            @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="brand_id" class="form-label">{{ __('admin.product_brand') }}</label>
                                        <select class="form-select @error('brand_id') is-invalid @enderror" 
                                                id="brand_id" 
                                                name="brand_id">
                                            <option value="">{{ __('admin.select_brand') }}</option>
                                            @foreach($brands ?? [] as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __('admin.status') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('admin.product_status') }}</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status">
                                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                                {{ __('admin.active') }}
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                {{ __('admin.inactive') }}
                                            </option>
                                        </select>
                                        @error('status')
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
                                    <i class="fa fa-save"></i> {{ __('admin.save') }}
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> {{ __('admin.cancel') }}
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
    // Image preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush
