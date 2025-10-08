@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('admin.dashboard') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $totalProducts ?? 0 }}</h4>
                                <p>{{ __('admin.products') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $totalOrders ?? 0 }}</h4>
                                <p>{{ __('admin.orders') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $totalUsers ?? 0 }}</h4>
                                <p>{{ __('admin.users') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa fa-dollar"></i>
                            </div>
                            <div class="stat-content">
                                <h4>${{ number_format($totalRevenue ?? 0, 2) }}</h4>
                                <p>{{ __('admin.revenue') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('admin.recent_orders') }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('admin.order_number') }}</th>
                                <th>{{ __('admin.customer_name') }}</th>
                                <th>{{ __('admin.order_date') }}</th>
                                <th>{{ __('admin.order_total') }}</th>
                                <th>{{ __('admin.order_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : 'info') }}">
                                        {{ __('admin.' . $order->status) }}
                                    </span>
                                </td>
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
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('admin.top_products') }}</h3>
            </div>
            <div class="card-body">
                @forelse($topProducts ?? [] as $product)
                <div class="product-item">
                    <div class="product-info">
                        <h6>{{ $product->name }}</h6>
                        <p class="text-muted">{{ $product->sales_count }} {{ __('admin.sales') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-muted">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.stat-icon {
    font-size: 2rem;
    color: #3498db;
    margin-right: 1rem;
}

.stat-content h4 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: bold;
}

.stat-content p {
    margin: 0;
    color: #666;
}

.product-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.product-item:last-child {
    border-bottom: none;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
}

.badge-warning {
    background-color: #f39c12;
    color: white;
}

.badge-success {
    background-color: #27ae60;
    color: white;
}

.badge-info {
    background-color: #3498db;
    color: white;
}
</style>
@endpush
