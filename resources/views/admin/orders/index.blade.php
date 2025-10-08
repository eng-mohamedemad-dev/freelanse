@extends('admin.layouts.app')

@section('title', __('admin.orders'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('admin.orders') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="status-filter">
                            <option value="">{{ __('admin.all_status') }}</option>
                            <option value="pending">{{ __('admin.pending') }}</option>
                            <option value="processing">{{ __('admin.processing') }}</option>
                            <option value="shipped">{{ __('admin.shipped') }}</option>
                            <option value="delivered">{{ __('admin.delivered') }}</option>
                            <option value="cancelled">{{ __('admin.cancelled') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="date-from" placeholder="{{ __('admin.date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="date-to" placeholder="{{ __('admin.date_to') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="search" placeholder="{{ __('admin.search') }}">
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('admin.order_number') }}</th>
                                <th>{{ __('admin.customer_name') }}</th>
                                <th>{{ __('admin.customer_phone') }}</th>
                                <th>{{ __('admin.order_date') }}</th>
                                <th>{{ __('admin.order_total') }}</th>
                                <th>{{ __('admin.order_status') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info')) }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="btn btn-sm btn-info" 
                                           data-bs-toggle="tooltip" 
                                           title="{{ __('admin.view') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        @if($order->status == 'pending')
                                        <button type="button" 
                                                class="btn btn-sm btn-success mark-completed" 
                                                data-order-id="{{ $order->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="{{ __('admin.mark_completed') }}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        @endif
                                        
                                        @if($order->status != 'cancelled' && $order->status != 'delivered')
                                        <button type="button" 
                                                class="btn btn-sm btn-danger mark-cancelled" 
                                                data-order-id="{{ $order->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="{{ __('admin.mark_cancelled') }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        @endif
                                        
                                        <a href="{{ route('admin.orders.invoice', $order) }}" 
                                           class="btn btn-sm btn-warning" 
                                           data-bs-toggle="tooltip" 
                                           title="{{ __('admin.invoice') }}">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('admin.no_data') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as completed
    document.querySelectorAll('.mark-completed').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            
            Swal.fire({
                title: '{{ __("admin.confirm") }}',
                text: '{{ __("admin.mark_completed_confirmation") }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.yes") }}',
                cancelButtonText: '{{ __("admin.no") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/orders/${orderId}/mark-completed`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '{{ __("admin.success") }}',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '{{ __("admin.error") }}',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });

    // Mark as cancelled
    document.querySelectorAll('.mark-cancelled').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            
            Swal.fire({
                title: '{{ __("admin.confirm") }}',
                text: '{{ __("admin.mark_cancelled_confirmation") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.yes") }}',
                cancelButtonText: '{{ __("admin.no") }}',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/orders/${orderId}/mark-cancelled`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '{{ __("admin.success") }}',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '{{ __("admin.error") }}',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });

    // Filter functionality
    const statusFilter = document.getElementById('status-filter');
    const dateFrom = document.getElementById('date-from');
    const dateTo = document.getElementById('date-to');
    const search = document.getElementById('search');

    function applyFilters() {
        const params = new URLSearchParams();
        
        if (statusFilter.value) params.append('status', statusFilter.value);
        if (dateFrom.value) params.append('date_from', dateFrom.value);
        if (dateTo.value) params.append('date_to', dateTo.value);
        if (search.value) params.append('search', search.value);
        
        window.location.href = '{{ route("admin.orders.index") }}?' + params.toString();
    }

    statusFilter.addEventListener('change', applyFilters);
    dateFrom.addEventListener('change', applyFilters);
    dateTo.addEventListener('change', applyFilters);
    search.addEventListener('input', debounce(applyFilters, 500));

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});
</script>
@endpush
