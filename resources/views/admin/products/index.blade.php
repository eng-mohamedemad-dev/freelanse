@extends('admin.layouts.app')

@section('title', __('admin.products'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('admin.products') }}</h3>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{ __('admin.add_product') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="search-input" class="form-control" placeholder="{{ __('admin.search') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="category-filter">
                            <option value="">{{ __('admin.all_categories') }}</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="status-filter">
                            <option value="">{{ __('admin.all_status') }}</option>
                            <option value="active">{{ __('admin.active') }}</option>
                            <option value="inactive">{{ __('admin.inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary" id="filter-btn">
                            <i class="fa fa-filter"></i> {{ __('admin.filter') }}
                        </button>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <form id="bulk-action-form" method="POST" action="{{ route('admin.products.bulk-action') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="bulk_action" class="form-select">
                                <option value="">{{ __('admin.bulk_actions') }}</option>
                                <option value="activate">{{ __('admin.activate') }}</option>
                                <option value="deactivate">{{ __('admin.deactivate') }}</option>
                                <option value="delete">{{ __('admin.delete') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-check"></i> {{ __('admin.apply') }}
                            </button>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>{{ __('admin.product_image') }}</th>
                                    <th>{{ __('admin.product_name') }}</th>
                                    <th>{{ __('admin.product_price') }}</th>
                                    <th>{{ __('admin.product_category') }}</th>
                                    <th>{{ __('admin.product_status') }}</th>
                                    <th>{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products ?? [] as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="{{ $product->id }}">
                                    </td>
                                    <td>
                                        <img src="{{ $product->image ?? asset('assets/admin/images/placeholder.jpg') }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                            {{ __('admin.' . $product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-bs-toggle="tooltip" 
                                               title="{{ __('admin.view') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-sm btn-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="{{ __('admin.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $product->id }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="{{ __('admin.delete') }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('admin.confirm_delete') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('admin.delete_confirmation_message') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    {{ __('admin.cancel') }}
                                                </button>
                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('admin.delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('admin.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(isset($products) && $products->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('search-input');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('input[name="selected_items[]"]');
    
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk action form
    const bulkForm = document.getElementById('bulk-action-form');
    bulkForm.addEventListener('submit', function(e) {
        const selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
        if (selectedItems.length === 0) {
            e.preventDefault();
            alert('{{ __("admin.please_select_items") }}');
            return false;
        }
    });
});
</script>
@endpush
