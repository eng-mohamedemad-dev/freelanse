@extends('admin.layouts.app')

@section('title', __('admin.create_user'))
@section('page-title', __('admin.create_user'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.create_user') }}</h3>
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
            <a href="{{ route('admin.users.index') }}">
                <div class="text-tiny">{{ __('admin.users') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ __('admin.create_user') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box modern-form-container">
    <form method="POST" action="{{ route('admin.users.store') }}" class="form modern-form">
        @csrf
        
        <!-- معلومات المستخدم الأساسية -->
        <div class="form-section">
            <div class="section-header">
                <h4 class="section-title">
                    <i class="icon-user"></i>
                    {{ __('admin.basic_info') }}
                </h4>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="name">
                            <i class="icon-user-circle"></i>
                            {{ __('admin.name') }} 
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="{{ __('admin.enter_name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="email">
                            <i class="icon-mail"></i>
                            {{ __('admin.email') }} 
                            <span class="required">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="{{ __('admin.enter_email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="role">
                            <i class="icon-shield"></i>
                            {{ __('admin.role') }} 
                            <span class="required">*</span>
                        </label>
                        <select class="form-control @error('role') is-invalid @enderror" 
                                id="role" 
                                name="role" 
                                required>
                            <option value="">{{ __('admin.select_role') }}</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                {{ __('admin.admin') }}
                            </option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>
                                {{ __('admin.manager') }}
                            </option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                {{ __('admin.user') }}
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="password">
                            <i class="icon-key"></i>
                            {{ __('admin.password') }}
                            <span class="required">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="password_confirmation">
                            <i class="icon-check-circle"></i>
                            {{ __('admin.confirm_password') }}
                            <span class="required">*</span>
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="••••••••"
                               required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group modern-input">
                        <label for="is_active">
                            <i class="icon-toggle-right"></i>
                            {{ __('admin.status') }} 
                            <span class="required">*</span>
                        </label>
                        <select class="form-control @error('is_active') is-invalid @enderror" 
                                id="is_active" 
                                name="is_active" 
                                required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                ✓ {{ __('admin.active') }}
                            </option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                ✗ {{ __('admin.inactive') }}
                            </option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- الصلاحيات -->
        <div class="form-section permissions-section">
            <div class="section-header">
                <h4 class="section-title">
                    <i class="icon-key"></i>
                    {{ __('admin.permissions') }}
                </h4>
                <small class="section-subtitle">{{ __('admin.select_user_permissions') }}</small>
            </div>
            
            <div class="permissions-wrapper">
                @foreach($permissions->groupBy('category') as $category => $categoryPermissions)
                    <div class="permission-category-card">
                        <div class="category-header">
                            <h5 class="category-name">
                                <span class="category-icon">📋</span>
                                {{ __('admin.' . $category) }}
                            </h5>
                            <div class="category-actions">
                                <span class="badge permissions-count">{{ $categoryPermissions->count() }}</span>
                                <button type="button" class="btn-select-all" data-category="{{ $category }}">
                                    <i class="icon-check-square"></i>
                                    {{ __('admin.select_all') }}
                                </button>
                            </div>
                        </div>
                        
                        <div class="permissions-grid">
                            @foreach($categoryPermissions as $permission)
                                <div class="permission-item">
                                    <input type="checkbox" 
                                           class="permission-checkbox" 
                                           id="permission_{{ $permission->id }}" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="permission-label" for="permission_{{ $permission->id }}">
                                        <span class="permission-name">{{ $permission->name_ar }}</span>
                                        <span class="permission-desc">{{ $permission->description_ar }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- أزرار الإجراءات -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-modern">
                <i class="icon-save"></i>
                <span>{{ __('admin.create_user') }}</span>
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-modern">
                <i class="icon-arrow-left"></i>
                <span>{{ __('admin.cancel') }}</span>
            </a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* ========== المتغيرات العامة ========== */
    :root {
        --primary-color: #4F46E5;
        --primary-hover: #4338CA;
        --success-color: #10B981;
        --danger-color: #EF4444;
        --warning-color: #F59E0B;
        --secondary-color: #6B7280;
        
        --bg-card: #FFFFFF;
        --bg-section: #F9FAFB;
        --bg-input: #FFFFFF;
        --bg-hover: #F3F4F6;
        
        --text-primary: #111827;
        --text-secondary: #6B7280;
        --text-muted: #9CA3AF;
        
        --border-color: #E5E7EB;
        --border-radius: 12px;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== الوضع الداكن ========== */
    [data-theme="dark"] {
        --bg-card: #1F2937;
        --bg-section: #111827;
        --bg-input: #374151;
        --bg-hover: #374151;
        
        --text-primary: #F9FAFB;
        --text-secondary: #D1D5DB;
        --text-muted: #9CA3AF;
        
        --border-color: #374151;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.5);
    }

    /* ========== Container الرئيسي ========== */
    .modern-form-container {
        background: var(--bg-card);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .modern-form {
        padding: 2rem;
    }

    /* ========== Form Sections ========== */
    .form-section {
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: var(--bg-section);
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        transition: var(--transition);
    }

    .form-section:hover {
        box-shadow: var(--shadow-sm);
    }

    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .section-subtitle {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-secondary);
        font-size: 1rem;
    }

    /* ========== Modern Input Styles ========== */
    .modern-input {
        margin-bottom: 0;
    }

    .modern-input label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .modern-input label i {
        color: var(--primary-color);
        font-size: 1.125rem;
    }

    .modern-input .required {
        color: var(--danger-color);
        font-weight: 700;
    }

    .modern-input .form-control,
    .modern-input .form-select {
        background: var(--bg-input);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        font-size: 1.125rem;
        color: var(--text-primary);
        transition: var(--transition);
        height: auto;
    }

    .modern-input .form-control:focus,
    .modern-input .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        background: var(--bg-input);
    }

    .modern-input .form-control::placeholder {
        color: var(--text-muted);
    }

    /* ========== Permissions Section ========== */
    .permissions-section {
        background: linear-gradient(135deg, var(--bg-section) 0%, var(--bg-card) 100%);
    }

    .permissions-wrapper {
        display: grid;
        gap: 1.5rem;
    }

    .permission-category-card {
        background: var(--bg-card);
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
    }

    .permission-category-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }
    
    .category-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .btn-select-all {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .btn-select-all:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    .btn-select-all i {
        font-size: 1rem;
    }

    .category-name {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.375rem;
        font-weight: 800;
        color: white;
        margin: 0;
    }

    .category-icon {
        font-size: 1.5rem;
    }

    .permissions-count {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
    }

    /* ========== Permission Items ========== */
    .permission-item {
        position: relative;
    }

    .permission-checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .permission-label {
        display: block;
        padding: 1rem 1.25rem;
        background: var(--bg-section);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        padding-right: 3rem;
    }

    .permission-label::after {
        content: '';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-input);
        transition: var(--transition);
    }

    .permission-checkbox:checked + .permission-label::after {
        background: var(--primary-color);
        border-color: var(--primary-color);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
        background-size: 20px;
        background-position: center;
        background-repeat: no-repeat;
    }

    .permission-label:hover {
        background: var(--bg-hover);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .permission-checkbox:checked + .permission-label {
        background: rgba(79, 70, 229, 0.05);
        border-color: var(--primary-color);
    }

    .permission-name {
        display: block;
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .permission-desc {
        display: block;
        font-size: 1rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* ========== Action Buttons ========== */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 2rem;
        background: var(--bg-section);
        border-radius: var(--border-radius);
        border-top: 2px solid var(--border-color);
        margin-top: 2rem;
    }

    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.875rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-modern i {
        font-size: 1.25rem;
    }

    .btn-primary.btn-modern {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
    }

    .btn-primary.btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(79, 70, 229, 0.4);
    }

    .btn-secondary.btn-modern {
        background: var(--bg-input);
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-secondary.btn-modern:hover {
        background: var(--bg-hover);
        border-color: var(--text-secondary);
    }

    /* ========== Responsive Design ========== */
    @media (max-width: 768px) {
        .modern-form {
            padding: 1.5rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .permissions-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-modern {
            width: 100%;
            justify-content: center;
        }
    }

    /* ========== تحسينات إضافية ========== */
    .g-4 {
        gap: 1.5rem;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--danger-color);
    }

    .is-invalid {
        border-color: var(--danger-color) !important;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-section {
        animation: fadeInUp 0.5s ease-out;
    }

    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    document.querySelectorAll('.btn-select-all').forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            const categoryCard = this.closest('.permission-category-card');
            const checkboxes = categoryCard.querySelectorAll('input[type="checkbox"]');
            
            // Check if all are selected
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            // Toggle all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            
            // Update button text
            this.innerHTML = allChecked ? 
                '<i class="icon-check-square"></i> {{ __("admin.select_all") }}' : 
                '<i class="icon-square"></i> {{ __("admin.deselect_all") }}';
        });
    });
    
    // Update select all button state when individual checkboxes change
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryCard = this.closest('.permission-category-card');
            const checkboxes = categoryCard.querySelectorAll('input[type="checkbox"]');
            const selectAllBtn = categoryCard.querySelector('.btn-select-all');
            
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            const someChecked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (allChecked) {
                selectAllBtn.innerHTML = '<i class="icon-square"></i> {{ __("admin.deselect_all") }}';
            } else if (someChecked) {
                selectAllBtn.innerHTML = '<i class="icon-check-square"></i> {{ __("admin.select_all") }}';
            } else {
                selectAllBtn.innerHTML = '<i class="icon-check-square"></i> {{ __("admin.select_all") }}';
            }
        });
    });
});
</script>
@endpush