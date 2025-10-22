<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="width:70px">{{ __('admin.order_number') }}</th>
                <th class="text-center">{{ __('admin.customer_name') }}</th>
                <th class="text-center">{{ __('admin.customer_phone') }}</th>
                <th class="text-center">{{ __('admin.subtotal') }}</th>
                <th class="text-center">{{ __('admin.tax') }}</th>
                <th class="text-center">{{ __('admin.total') }}</th>
                <th class="text-center">{{ __('admin.order_status') }}</th>
                <th class="text-center">{{ __('admin.order_date') }}</th>
                <th class="text-center">{{ __('admin.total_items') }}</th>
                <th class="text-center">{{ __('admin.delivered_on') }}</th>
                <th class="text-center">{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{ $order->id }}</td>
                    <td class="text-center">{{ $order->customer_name ?? $order->user->name ?? __('admin.no_data') }}</td>
                    <td class="text-center">{{ $order->customer_phone ?? $order->user->phone ?? __('admin.no_data') }}</td>
                    <td class="text-center">${{ number_format($order->subtotal, 2) }}</td>
                    <td class="text-center">${{ number_format($order->tax_amount, 2) }}</td>
                    <td class="text-center">${{ number_format(($order->subtotal ?? 0) + ($order->tax_amount ?? 0), 2) }}</td>
                    <td class="text-center">
                        @switch($order->status)
                            @case('pending')
                                <i class="icon-clock" style="color: #ffc107;"></i> {{ __('admin.pending') }}
                                @break
                            @case('processing')
                                <i class="icon-settings" style="color: #007bff;"></i> {{ __('admin.processing') }}
                                @break
                            @case('shipped')
                                <i class="icon-truck" style="color: #17a2b8;"></i> {{ __('admin.shipped') }}
                                @break
                            @case('delivered')
                                <i class="icon-check-circle" style="color: #28a745;"></i> {{ __('admin.delivered') }}
                                @break
                            @case('cancelled')
                                <i class="icon-x-circle" style="color: #dc3545;"></i> {{ __('admin.cancelled') }}
                                @break
                            @default
                                <i class="icon-help-circle" style="color: #6c757d;"></i> {{ $order->status }}
                        @endswitch
                    </td>
                    <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                    <td class="text-center">
                        @if($order->status === 'delivered' && $order->delivered_at)
                            {{ $order->delivered_at->format('Y-m-d H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="list-icon-function">
                            <a href="{{ route('admin.orders.show', $order) }}" class="item eye" title="{{ __('admin.view') }}">
                                <i class="icon-eye"></i>
                            </a>
                            
                            @if($order->status === 'pending')
                                <a href="#" class="item approve approve-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.approve') }}">
                                    <i class="icon-check"></i>
                                </a>
                                <a href="#" class="item reject reject-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.reject') }}">
                                    <i class="icon-x"></i>
                                </a>
                                <a href="#" class="item delete delete-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.delete') }}">
                                    <i class="icon-trash"></i>
                                </a>
                            @elseif($order->status === 'processing')
                                <a href="#" class="item ship ship-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.mark_as_shipped') }}">
                                    <i class="icon-truck"></i>
                                </a>
                                <a href="#" class="item approve approve-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.mark_as_delivered') }}">
                                    <i class="icon-check"></i>
                                </a>
                                <a href="#" class="item delete delete-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.delete') }}">
                                    <i class="icon-trash"></i>
                                </a>
                            @else
                                <a href="#" class="item delete delete-order" 
                                   data-order-id="{{ $order->id }}" 
                                   data-order-number="{{ $order->id }}"
                                   title="{{ __('admin.delete') }}">
                                    <i class="icon-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center py-20">
                        <div class="text-center">
                            <i class="icon-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-10">{{ __('admin.no_records_found') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            {{ __('admin.showing_results') }} {{ $orders->firstItem() }} {{ __('admin.to') }} {{ $orders->lastItem() }} {{ __('admin.of') }} {{ $orders->total() }} {{ __('admin.order') }}
        </div>
        {{ $orders->links() }}
    </div>
@endif
