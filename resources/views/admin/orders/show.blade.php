@extends('admin.layouts.app')

@section('title', __('admin.order_details'))
@section('page-title', __('admin.order_details'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.order_details') }} {{ $order->id }}</h3>
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
            <a href="{{ route('admin.orders.index') }}">
                <div class="text-tiny">{{ __('admin.orders') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ __('admin.order_details') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 mb-20">
        <h4>{{ __('admin.order_information') }}</h4>
        <div class="order-actions">
            @if($order->status === 'pending')
                <a href="#" class="action-btn approve approve-order" 
                   data-order-id="{{ $order->id }}" 
                   data-order-number="{{ $order->id }}"
                   title="{{ __('admin.approve') }}">
                    <i class="icon-check"></i>
                </a>
                <a href="#" class="action-btn reject reject-order" 
                   data-order-id="{{ $order->id }}" 
                   data-order-number="{{ $order->id }}"
                   title="{{ __('admin.reject') }}">
                    <i class="icon-x"></i>
                </a>
            @elseif($order->status === 'processing')
                <a href="#" class="action-btn approve approve-order" 
                   data-order-id="{{ $order->id }}" 
                   data-order-number="{{ $order->id }}"
                   title="{{ __('admin.mark_as_delivered') }}">
                    <i class="icon-check"></i>
                </a>
            @endif
            <a href="#" class="action-btn delete delete-order" 
               data-order-id="{{ $order->id }}" 
               data-order-number="{{ $order->id }}"
               title="{{ __('admin.delete') }}">
                <i class="icon-trash"></i>
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="order-info">
                <h5>{{ __('admin.customer_information') }}</h5>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>{{ __('admin.customer_name') }}:</strong></td>
                        <td>{{ $order->customer_name ?? $order->user->name ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.user_email') }}:</strong></td>
                        <td>{{ $order->customer_email ?? $order->user->email ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.customer_phone') }}:</strong></td>
                        <td>{{ $order->customer_phone ?? $order->user->phone ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.whatsapp_number') }}:</strong></td>
                        <td>{{ $order->whatsapp_number ?? __('admin.no_data') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="order-details">
                <h5>{{ __('admin.order_details') }}</h5>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>{{ __('admin.order_number') }}:</strong></td>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.order_date') }}:</strong></td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.order_status') }}:</strong></td>
                        <td>
                            <span class="order-status {{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')
                                        {{ __('admin.pending') }}
                                        @break
                                    @case('processing')
                                        {{ __('admin.processing') }}
                                        @break
                                    @case('shipped')
                                        {{ __('admin.shipped') }}
                                        @break
                                    @case('delivered')
                                        {{ __('admin.delivered') }}
                                        @break
                                    @case('cancelled')
                                        {{ __('admin.cancelled') }}
                                        @break
                                    @default
                                        {{ $order->status }}
                                @endswitch
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.payment_method') }}:</strong></td>
                        <td>{{ $order->payment_method ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.payment_status') }}:</strong></td>
                        <td>{{ $order->payment_status ?? __('admin.no_data') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row mt-20">
        <div class="col-md-12">
            <h5>{{ __('admin.order_items') }}</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.product') }}</th>
                            <th>{{ __('admin.quantity') }}</th>
                            <th>{{ __('admin.price') }}</th>
                            <th>{{ __('admin.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name ?? __('admin.no_data') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('admin.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row mt-20">
        <div class="col-md-6">
            <h5>{{ __('admin.billing_address') }}</h5>
            <table class="table table-bordered">
                @php
                    $billingAddress = is_string($order->billing_address) ? json_decode($order->billing_address, true) : $order->billing_address;
                @endphp
                @if($billingAddress)
                    <tr>
                        <td><strong>{{ __('admin.street') }}:</strong></td>
                        <td>{{ $billingAddress['street'] ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.city') }}:</strong></td>
                        <td>{{ $billingAddress['city'] ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.state') }}:</strong></td>
                        <td>{{ $billingAddress['state'] ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.zip_code') }}:</strong></td>
                        <td>{{ $billingAddress['zip'] ?? __('admin.no_data') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('admin.country') }}:</strong></td>
                        <td>{{ $billingAddress['country'] ?? __('admin.no_data') }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center">{{ __('admin.no_data') }}</td>
                    </tr>
                @endif
            </table>
        </div>
        
        <div class="col-md-6">
            <h5>{{ __('admin.financial_summary') }}</h5>
            <table class="table table-bordered">
                <tr>
                    <td><strong>{{ __('admin.subtotal') }}:</strong></td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('admin.tax') }}:</strong></td>
                    <td>${{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('admin.shipping_fees') }}:</strong></td>
                    <td>${{ number_format($order->shipping_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>{{ __('admin.discount') }}:</strong></td>
                    <td>${{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>{{ __('admin.total') }}:</strong></td>
                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
    
    
    <div class="row mt-20">
        <div class="col-md-12">
            <a href="{{ route('admin.orders.index') }}" class="tf-button style-1">
                <i class="icon-arrow-left"></i> {{ __('admin.back_to_orders') }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .order-info, .order-details {
        margin-bottom: 20px;
    }
    
    .order-info h5, .order-details h5 {
        color: #333;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .order-actions {
        display: flex;
        gap: 10px;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .action-btn i {
        font-size: 16px;
    }
    
    .action-btn.approve {
        background: #28a745;
        color: white;
    }
    
    .action-btn.reject {
        background: #ffc107;
        color: #212529;
    }
    
    .action-btn.delete {
        background: #dc3545;
        color: white;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .action-btn.approve:hover {
        background: #218838;
    }
    
    .action-btn.reject:hover {
        background: #e0a800;
    }
    
    .action-btn.delete:hover {
        background: #c82333;
    }
    
    .total-row {
        background: #f8f9fa;
        font-weight: 600;
    }
    
    
    /* Dark Theme Styles */
    .dark-theme .order-info h5, .dark-theme .order-details h5 {
        color: #ffffff;
    }
    
    .dark-theme .total-row {
        background: #404040;
        color: #ffffff;
    }
    
    /* Zebra Striping for Tables */
    .table tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }
    
    .table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
    
    .dark-theme .table tbody tr:nth-child(odd) {
        background-color: #404040;
    }
    
    .dark-theme .table tbody tr:nth-child(even) {
        background-color: #505050;
    }
    
    .dark-theme .table tbody tr:nth-child(odd) td {
        color: #ffffff;
    }
    
    .dark-theme .table tbody tr:nth-child(even) td {
        color: #ffffff;
    }
    
    /* Sweet Alert Custom Styling */
    .swal2-popup {
        line-height: 1.4 !important;
    }
    
    .swal2-title {
        line-height: 1.3 !important;
        margin-bottom: 10px !important;
    }
    
    .swal2-content {
        line-height: 1.4 !important;
        margin-top: 10px !important;
        margin-bottom: 20px !important;
    }
    
    .swal2-html-container {
        line-height: 1.4 !important;
        margin: 10px 0 !important;
    }
    
    .swal2-actions {
        margin-top: 20px !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Handle approve order
    $('.approve-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.approve_confirmation') }}',
            text: `{{ __('admin.approve_confirmation') }} "${orderNumber}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm',
                cancelButton: 'swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/orders/${orderId}/mark-completed`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_approved_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('admin.error') }}!',
                            text: '{{ __('admin.error') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        });
                    }
                });
            }
        });
    });
    
    // Handle reject order
    $('.reject-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.reject_confirmation') }}',
            text: `{{ __('admin.reject_confirmation') }} "${orderNumber}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm',
                cancelButton: 'swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/orders/${orderId}/mark-cancelled`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_rejected_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('admin.error') }}!',
                            text: '{{ __('admin.error') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        });
                    }
                });
            }
        });
    });
    
    // Handle delete order
    $('.delete-order').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');
        const orderNumber = $(this).data('order-number');
        
        Swal.fire({
            title: '{{ __('admin.delete_confirmation') }}',
            text: `{{ __('admin.delete_confirmation') }} "${orderNumber}"?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide',
                title: 'swal-title',
                content: 'swal-content',
                confirmButton: 'swal-confirm',
                cancelButton: 'swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/orders/${orderId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('admin.success') }}!',
                            text: '{{ __('admin.order_deleted_successfully') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            timer: 3000,
                            timerProgressBar: true,
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        }).then(() => {
                            window.location.href = '{{ route("admin.orders.index") }}';
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('admin.error') }}!',
                            text: '{{ __('admin.error') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}',
                            width: '500px',
                            padding: '2rem',
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title',
                                content: 'swal-content',
                                confirmButton: 'swal-confirm'
                            }
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
