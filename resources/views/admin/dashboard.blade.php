@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))

@section('content')
<div class="tf-section-2 mb-30">
    <div class="flex gap20 flex-wrap-mobile">
        <div class="w-half">
            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-shopping-bag"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.total_orders') }}</div>
                            <h4>{{ $statistics['total_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-dollar-sign"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.total_amount') }}</div>
                            <h4>{{ number_format($statistics['total_revenue'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-shopping-bag"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.pending_orders') }}</div>
                            <h4>{{ $statistics['pending_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-dollar-sign"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.pending_orders_amount') }}</div>
                            <h4>{{ number_format($statistics['pending_revenue'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-half">
            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-shopping-bag"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.delivered_orders') }}</div>
                            <h4>{{ $statistics['delivered_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-dollar-sign"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.delivered_orders_amount') }}</div>
                            <h4>{{ number_format($statistics['delivered_revenue'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default mb-20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-shopping-bag"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.cancelled_orders') }}</div>
                            <h4>{{ $statistics['cancelled_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-chart-default">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap14">
                        <div class="image ic-bg">
                            <i class="icon-dollar-sign"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="body-text mb-2">{{ __('admin.cancelled_orders_amount') }}</div>
                            <h4>{{ number_format($statistics['cancelled_revenue'] ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wg-box">
        <div class="flex items-center justify-between">
            <h5>{{ __('admin.total_sales') }}</h5>
            <div class="flex items-center gap-3">
                <!-- Chart Type Buttons -->
                <div class="chart-type-buttons">
                    <button class="chart-type-btn active" data-type="line" title="{{ __('admin.line_chart') }}">
                        <i class="icon-trending-up"></i>
                    </button>
                    <button class="chart-type-btn" data-type="bar" title="{{ __('admin.bar_chart') }}">
                        <i class="icon-bar-chart"></i>
                    </button>
                    <button class="chart-type-btn" data-type="area" title="{{ __('admin.area_chart') }}">
                        <i class="icon-layers"></i>
                    </button>
                    <button class="chart-type-btn" data-type="pie" title="{{ __('admin.pie_chart') }}">
                        <i class="icon-pie-chart"></i>
                    </button>
                </div>
                
                <!-- Download Chart Button -->
                <button class="btn btn-outline-success chart-type-btn" id="download-stats-chart-btn" title="{{ __('admin.download_chart') }}">
                    <i class="icon-download"></i>
                </button>
                
                <!-- Period Filter Dropdown -->
                <div class="dropdown default">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="javascript:void(0);" class="sales-filter" data-period="this_month">{{ __('admin.this_month') }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="sales-filter" data-period="last_month">{{ __('admin.last_month') }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="sales-filter" data-period="last_3_months">{{ __('admin.last_3_months') }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="sales-filter" data-period="last_6_months">{{ __('admin.last_6_months') }}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="sales-filter" data-period="this_year">{{ __('admin.this_year') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap40">
            <div>
                <div class="mb-2">
                    <div class="text-tiny">{{ __('admin.current_month_sales') }}</div>
                </div>
                <div class="flex items-center gap10">
                    <h4 id="current-sales">${{ number_format($currentMonthSales ?? 0, 2) }}</h4>
                    <div class="box-icon-trending {{ ($salesComparison ?? 0) >= 0 ? 'up' : 'down' }}">
                        <i class="icon-trending-{{ ($salesComparison ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                        <div class="body-title number">{{ abs($salesComparison ?? 0) }}%</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="mb-2">
                    <div class="text-tiny">{{ __('admin.last_month_sales') }}</div>
                </div>
                <div class="flex items-center gap10">
                    <h4 id="last-sales">${{ number_format($lastMonthSales ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div id="line-chart-8"></div>
    </div>
</div>

<div class="tf-section mb-30">
    <div class="wg-box">
        <div class="flex items-center justify-between">
            <h5>{{ __('admin.recent_orders') }}</h5>
            <div class="dropdown default">
                <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders.index') }}">
                    <span class="view-all">{{ __('admin.view_all') }}</span>
                </a>
            </div>
        </div>
        <div class="wg-table table-all-user">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 80px">{{ __('admin.order_number') }}</th>
                            <th>{{ __('admin.customer_name') }}</th>
                            <th class="text-center">{{ __('admin.customer_phone') }}</th>
                            <th class="text-center">{{ __('admin.subtotal') }}</th>
                            <th class="text-center">{{ __('admin.tax') }}</th>
                            <th class="text-center">{{ __('admin.total') }}</th>
                            <th class="text-center">{{ __('admin.order_status') }}</th>
                            <th class="text-center">{{ __('admin.order_date') }}</th>
                            <th class="text-center">{{ __('admin.total_items') }}</th>
                            <th class="text-center">{{ __('admin.delivered_on') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->user->name ?? __('admin.unknown_user') }}</td>
                                    <td class="text-center">{{ $order->user->phone ?? __('admin.not_specified') }}</td>
                                    <td class="text-center">${{ number_format($order->subtotal ?? $order->total, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->tax ?? 0, 2) }}</td>
                                    <td class="text-center">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @switch($order->status)
                                                @case('pending')
                                                    <i class="icon-clock" style="color: #ffc107; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ __('admin.pending') }}</span>
                                                    @break
                                                @case('processing')
                                                    <i class="icon-settings" style="color: #007bff; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ __('admin.processing') }}</span>
                                                    @break
                                                @case('shipped')
                                                    <i class="icon-truck" style="color: #17a2b8; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ __('admin.shipped') }}</span>
                                                    @break
                                                @case('delivered')
                                                    <i class="icon-check-circle" style="color: #28a745; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ __('admin.delivered') }}</span>
                                                    @break
                                                @case('cancelled')
                                                    <i class="icon-x-circle" style="color: #dc3545; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ __('admin.cancelled') }}</span>
                                                    @break
                                                @default
                                                    <i class="icon-help-circle" style="color: #6c757d; font-size: 16px;"></i> 
                                                    <span class="status-text">{{ $order->status }}</span>
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-center">{{ $order->items->count() ?? 0 }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'delivered')
                                            {{ $order->updated_at->format('Y-m-d') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center py-20">
                                    <div class="text-center">
                                        <i class="icon-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-10">{{ __('admin.no_orders_yet') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Status Badge Styling for Dashboard */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge i {
        font-size: 10px;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .status-processing {
        background: #cce5ff;
        color: #004085;
        border: 1px solid #99d6ff;
    }
    
    .status-shipped {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
    
    .status-delivered {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    /* Dark Theme Status Badges */
    .dark-theme .status-pending {
        background: #3d2914;
        color: #ffc107;
        border-color: #ffc107;
    }
    
    .dark-theme .status-processing {
        background: #1a2332;
        color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .dark-theme .status-shipped {
        background: #1a2f2f;
        color: #20c997;
        border-color: #20c997;
    }
    
    .dark-theme .status-delivered {
        background: #1e3a1e;
        color: #28a745;
        border-color: #28a745;
    }
    
    .dark-theme .status-cancelled {
        background: #3a1e1e;
        color: #dc3545;
        border-color: #dc3545;
    }
    
    /* Dashboard Cards Styling */
    .wg-chart-default {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .wg-chart-default:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    
    .wg-chart-default .image.ic-bg {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #6c757d;
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid #e9ecef;
    }
    
    .wg-chart-default .flex.flex-col {
        flex: 1;
        min-width: 0;
    }
    
    .wg-chart-default .body-text {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    
    .wg-chart-default h4 {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        line-height: 1.2;
    }
    
    /* Dark Theme Dashboard Cards */
    .dark-theme .wg-chart-default {
        background: #2d3748;
        border-color: #4a5568;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    .dark-theme .wg-chart-default:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }
    
    .dark-theme .wg-chart-default .body-text {
        color: #a0aec0;
    }
    
    .dark-theme .wg-chart-default h4 {
        color: #e2e8f0;
    }
    
    .dark-theme .wg-chart-default .image.ic-bg {
        background: #4a5568;
        color: #a0aec0;
        border-color: #718096;
    }
    
    /* Responsive Dashboard Cards */
    @media (max-width: 768px) {
        .wg-chart-default {
            padding: 15px;
        }
        
        .wg-chart-default .image.ic-bg {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .wg-chart-default h4 {
            font-size: 20px;
        }
        
        .wg-chart-default .body-text {
            font-size: 12px;
        }
    }
    
    /* Chart Type Buttons */
    .chart-type-buttons {
        display: flex;
        gap: 4px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #e9ecef;
    }
    
    .chart-type-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #6c757d;
        font-size: 16px;
    }
    
    .chart-type-btn:hover {
        background: #e9ecef;
        color: #495057;
    }
    
    .chart-type-btn.active {
        background: #007bff;
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }
    
    .chart-type-btn i {
        font-size: 14px;
    }
    
    /* Dark Theme Chart Type Buttons */
    .dark-theme .chart-type-buttons {
        background: #4a5568;
        border-color: #718096;
    }
    
    .dark-theme .chart-type-btn {
        color: #a0aec0;
    }
    
    .dark-theme .chart-type-btn:hover {
        background: #718096;
        color: #e2e8f0;
    }
    
    .dark-theme .chart-type-btn.active {
        background: #007bff;
        color: #ffffff;
    }
    
    /* Dark Theme Chart Styling */
    .dark-theme #line-chart-8 .apexcharts-canvas {
        background: #2d3748 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-tooltip {
        background: #2d3748 !important;
        border: 1px solid #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-tooltip-title {
        background: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-legend {
        color: #e2e8f0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-xaxis-label,
    .dark-theme #line-chart-8 .apexcharts-yaxis-label {
        fill: #a0aec0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-grid-line {
        stroke: #4a5568 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-toolbar {
        color: #e2e8f0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-menu {
        background: #2d3748 !important;
        border: 1px solid #4a5568 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-menu-item {
        color: #e2e8f0 !important;
    }
    
    .dark-theme #line-chart-8 .apexcharts-menu-item:hover {
        background: #4a5568 !important;
    }
    
    /* Table Status Styling */
    .status-text {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
    }
    
    .flex.items-center.justify-center.gap-2 {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    /* Dark Theme Table Status */
    .dark-theme .status-text {
        color: #e2e8f0;
    }
    
    /* Table Styling */
    .wg-table {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .wg-table .table {
        margin-bottom: 0;
    }
    
    .wg-table .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        color: #495057;
        padding: 15px 12px;
        font-size: 14px;
    }
    
    .wg-table .table tbody td {
        padding: 12px;
        border-bottom: 1px solid #e9ecef;
        font-size: 14px;
        color: #495057;
    }
    
    .wg-table .table tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Dark Theme Table */
    .dark-theme .wg-table {
        background: #2d3748;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    .dark-theme .wg-table .table thead th {
        background: #4a5568;
        border-bottom-color: #718096;
        color: #e2e8f0;
    }
    
    .dark-theme .wg-table .table tbody td {
        border-bottom-color: #4a5568;
        color: #e2e8f0;
    }
    
    .dark-theme .wg-table .table tbody tr:hover {
        background: #4a5568;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    (function ($) {
        var tfLineChart = (function () {
            var chartBar = function () {
                // Ensure we have valid data for the chart
                var revenueData = @json($salesData['revenue'] ?? array_fill(0, 12, 0));
                var pendingData = @json($salesData['pending'] ?? array_fill(0, 12, 0));
                var deliveredData = @json($salesData['delivered'] ?? array_fill(0, 12, 0));
                
                // Validate data arrays
                if (!Array.isArray(revenueData) || revenueData.length === 0) {
                    revenueData = [0,0,0,0,0,0,0,0,0,0,0,0];
                }
                if (!Array.isArray(pendingData) || pendingData.length === 0) {
                    pendingData = [0,0,0,0,0,0,0,0,0,0,0,0];
                }
                if (!Array.isArray(deliveredData) || deliveredData.length === 0) {
                    deliveredData = [0,0,0,0,0,0,0,0,0,0,0,0];
                }
                
                // Ensure all arrays have 12 elements
                while (revenueData.length < 12) revenueData.push(0);
                while (pendingData.length < 12) pendingData.push(0);
                while (deliveredData.length < 12) deliveredData.push(0);
                
                var options = {
                    series: [{
                        name: '{{ __('admin.current_month_sales') }}',
                        data: revenueData
                    }, {
                        name: '{{ __('admin.last_month_sales') }}',
                        data: pendingData
                    }, {
                        name: '{{ __('admin.comparison_with_last_month') }}',
                        data: deliveredData
                    }],
                    chart: {
                        type: 'line',
                        height: 400,
                        toolbar: {
                            show: false
                        },
                        background: $('body').hasClass('dark-theme') ? '#2d3748' : '#ffffff',
                        foreColor: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                        lineCap: 'round'
                    },
                    xaxis: {
                        categories: ['{{ __('admin.jan') }}', '{{ __('admin.feb') }}', '{{ __('admin.mar') }}', '{{ __('admin.apr') }}', '{{ __('admin.may') }}', '{{ __('admin.jun') }}', '{{ __('admin.jul') }}', '{{ __('admin.aug') }}', '{{ __('admin.sep') }}', '{{ __('admin.oct') }}', '{{ __('admin.nov') }}', '{{ __('admin.dec') }}'],
                        title: {
                            text: '{{ __('admin.months') }}',
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold',
                                color: '#333333'
                            }
                        },
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: '600',
                                colors: '#666666'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: '{{ __('admin.sales_amount') }} ($)',
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold',
                                color: '#333333'
                            }
                        },
                        labels: {
                            formatter: function (val) {
                                return '$' + val.toFixed(1) + 'K';
                            },
                            style: {
                                fontSize: '12px',
                                fontWeight: '600',
                                colors: '#666666'
                            }
                        },
                        min: 0
                    },
                    colors: ['#667eea', '#f093fb', '#4facfe'],
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right'
                    },
                    grid: {
                        borderColor: $('body').hasClass('dark-theme') ? '#4a5568' : '#e0e0e0',
                        strokeDashArray: 3,
                        row: {
                            colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                            opacity: 0.3
                        },
                        column: {
                            colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                            opacity: 0.3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        shared: true,
                        intersect: false,
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return '$' + val.toFixed(2) + 'K';
                            }
                        },
                        marker: {
                            show: true
                        }
                    },
                    markers: {
                        size: 6,
                        strokeWidth: 2,
                        strokeColors: '#ffffff',
                        hover: {
                            size: 8
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.3,
                            gradientToColors: ['#667eea', '#f093fb', '#4facfe'],
                            inverseColors: false,
                            opacityFrom: 0.7,
                            opacityTo: 0.1,
                            stops: [0, 100]
                        }
                    }
                };

                try {
                    // Check if chart container exists
                    const chartContainer = document.querySelector("#line-chart-8");
                    if (!chartContainer) {
                        console.error('Chart container not found');
                        return;
                    }
                    
                    // Create and render chart
                    window.salesChart = new ApexCharts(chartContainer, options);
                    window.salesChart.render();
                    
                // Store current chart type and data
                window.currentChartType = 'line';
                window.originalChartData = {
                    revenue: revenueData,
                    pending: pendingData,
                    delivered: deliveredData
                };
                    
                    console.log('Chart created successfully');
                } catch (error) {
                    console.error('Error creating chart:', error);
                    // Show error message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ في الرسم البياني',
                            text: 'حدث خطأ أثناء إنشاء الرسم البياني: ' + error.message,
                            confirmButtonText: 'موافق'
                        });
                    }
                }
            };

            return {
                init: function () {
                    chartBar();
                }
            };
        })();

        $(document).ready(function () {
            // Check if ApexCharts is loaded
            if (typeof ApexCharts !== 'undefined') {
                tfLineChart.init();
                initChartButtons();
            } else {
                console.error('ApexCharts is not loaded');
                // Load ApexCharts dynamically if not loaded
                $.getScript('https://cdn.jsdelivr.net/npm/apexcharts', function() {
                    tfLineChart.init();
                    initChartButtons();
                });
            }
            
            // Initialize chart buttons after a short delay to ensure chart is ready
            setTimeout(function() {
                initChartButtons();
            }, 1000);
            
            // Also try to initialize after chart is created
            setTimeout(function() {
                initChartButtons();
            }, 3000);
            
            // Function to initialize chart buttons
            function initChartButtons() {

                // Remove existing event handlers
                $('.chart-type-btn').off('click');
                
                // Add new event handlers
                $('.chart-type-btn').on('click', function(e) {
                    e.preventDefault();
                    const chartType = $(this).data('type');
                    
                    // Skip download button and invalid types
                    if (chartType === 'download' || !chartType || chartType === 'undefined') {
                        return;
                    }
                    
                    // Update active button
                    $('.chart-type-btn').removeClass('active');
                    $(this).addClass('active');
                    
                    // Update chart type
                    updateChartType(chartType);
                });
                
            }
            
            // Function to get chart instance
            function getChartInstance() {
                // Try window.salesChart first
                if (window.salesChart) {
                    return window.salesChart;
                }
                
                // Try to get from element
                const chartElement = document.querySelector("#line-chart-8");
                if (chartElement && chartElement._apexChart) {
                    return chartElement._apexChart;
                }
                
                // Try to find chart by looking for ApexCharts instances in all elements
                const allElements = document.querySelectorAll('*');
                for (let element of allElements) {
                    if (element._apexChart) {
                        return element._apexChart;
                    }
                }
                
                // Try to find chart in global scope
                if (window.ApexCharts) {
                    try {
                        const charts = window.ApexCharts.getCharts();
                        if (charts && charts.length > 0) {
                            return charts[0];
                        }
                    } catch (e) {
                    }
                }
                
                // Try to find chart by looking for it in the element
                if (chartElement) {
                    const chartContainer = chartElement.querySelector('.apexcharts-canvas');
                    if (chartContainer) {
                        // Try to get chart instance from canvas
                        const chartInstance = chartContainer._apexChart || chartContainer.chart;
                        if (chartInstance) {
                            return chartInstance;
                        }
                    }
                }
                
                return null;
            }
            
            // Handle theme change for chart
            $(document).on('themeChanged', function() {
                if (window.salesChart) {
                    // Update chart theme
                    const isDark = $('body').hasClass('dark-theme');
                    window.salesChart.updateOptions({
                        theme: {
                            mode: isDark ? 'dark' : 'light'
                        },
                        chart: {
                            background: isDark ? '#2d3748' : '#ffffff',
                            foreColor: isDark ? '#e2e8f0' : '#333333'
                        },
                        grid: {
                            borderColor: isDark ? '#4a5568' : '#e0e0e0'
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: isDark ? '#a0aec0' : '#666666'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: isDark ? '#a0aec0' : '#666666'
                                }
                            }
                        }
                    });
                }
            });
            
            // Function to update chart type
            function updateChartType(type) {
                try {
                    // Get chart instance
                    const chartInstance = getChartInstance();
                    
                    if (!chartInstance) {
                        console.error('Sales chart not found');
                        
                        // Try to find chart manually
                        const chartElement = document.querySelector("#line-chart-8");
                        if (chartElement) {
                            // Try to access chart through different methods
                            if (chartElement._apexChart) {
                                updateChartWithInstance(chartElement._apexChart, type);
                                return;
                            }
                            
                            // Try to find chart in global scope
                            if (window.ApexCharts) {
                                
                                // Try to get chart from ApexCharts registry
                                try {
                                    const charts = window.ApexCharts.getCharts();
                                    if (charts && charts.length > 0) {
                                        updateChartWithInstance(charts[0], type);
                                        return;
                                    }
                                } catch (e) {
                                    console.error('Error getting charts from registry:', e);
                                }
                                
                                // Try to find chart by looking for it in the element
                                const chartContainer = chartElement.querySelector('.apexcharts-canvas');
                                if (chartContainer) {
                                    // Try to get chart instance from canvas
                                    const chartInstance = chartContainer._apexChart || chartContainer.chart;
                                    if (chartInstance) {
                                        updateChartWithInstance(chartInstance, type);
                                        return;
                                    }
                                }
                            }
                        }
                        
                        // If still no chart found, recreate it
                        console.log('No chart instance found, recreating chart');
                        if (window.originalChartData) {
                            // Recreate chart with stored data
                            const chartElement = document.querySelector("#line-chart-8");
                            if (chartElement) {
                                chartElement.innerHTML = '';
                                
                                const { revenue, pending, delivered } = window.originalChartData;
                                const options = {
                                    series: [{
                                        name: '{{ __('admin.current_month_sales') }}',
                                        data: revenue
                                    }, {
                                        name: '{{ __('admin.last_month_sales') }}',
                                        data: pending
                                    }, {
                                        name: '{{ __('admin.comparison_with_last_month') }}',
                                        data: delivered
                                    }],
                                    chart: {
                                        type: type,
                                        height: 400,
                                        toolbar: { show: false },
                                        background: $('body').hasClass('dark-theme') ? '#2d3748' : '#ffffff',
                                        foreColor: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333'
                                    },
                                    colors: ['#667eea', '#f093fb', '#4facfe'],
                                    legend: { show: true, position: 'top', horizontalAlign: 'right' },
                                    dataLabels: { enabled: false }
                                };
                                
                                window.salesChart = new ApexCharts(chartElement, options);
                                window.salesChart.render();
                                window.currentChartType = type;
                                console.log('Chart recreated successfully');
                            }
                        }
                        return;
                    }
                    
                    updateChartWithInstance(chartInstance, type);
                } catch (error) {
                    console.error('Error in updateChartType:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ في تحديث الرسم البياني',
                            text: 'حدث خطأ أثناء تحديث نوع الرسم البياني: ' + error.message,
                            confirmButtonText: 'موافق'
                        });
                    }
                }
            }
            
            // Helper function to update chart with instance
            function updateChartWithInstance(chartInstance, type) {
                try {
                    console.log('Updating chart with type:', type);
                    
                    // Get original data from the chart
                    const originalOptions = chartInstance.w.globals.initialConfig;
                    const months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 
                                  'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                    
                    // Get the original series data safely
                    let originalSeries = [];
                    
                    // First try to get data from stored original data
                    if (window.originalChartData) {
                        const { revenue, pending, delivered } = window.originalChartData;
                        originalSeries = [{
                            name: '{{ __('admin.current_month_sales') }}',
                            data: revenue
                        }, {
                            name: '{{ __('admin.last_month_sales') }}',
                            data: pending
                        }, {
                            name: '{{ __('admin.comparison_with_last_month') }}',
                            data: delivered
                        }];
                    } else if (originalOptions && originalOptions.series && Array.isArray(originalOptions.series)) {
                        originalSeries = originalOptions.series;
                    } else {
                        // Fallback to default data - use the same data as initial chart
                        var revenueData = @json($salesData['revenue'] ?? array_fill(0, 12, 0));
                        var pendingData = @json($salesData['pending'] ?? array_fill(0, 12, 0));
                        var deliveredData = @json($salesData['delivered'] ?? array_fill(0, 12, 0));
                        
                        // Validate data arrays
                        if (!Array.isArray(revenueData) || revenueData.length === 0) {
                            revenueData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        }
                        if (!Array.isArray(pendingData) || pendingData.length === 0) {
                            pendingData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        }
                        if (!Array.isArray(deliveredData) || deliveredData.length === 0) {
                            deliveredData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        }
                        
                        // Ensure all arrays have 12 elements
                        while (revenueData.length < 12) revenueData.push(0);
                        while (pendingData.length < 12) pendingData.push(0);
                        while (deliveredData.length < 12) deliveredData.push(0);
                        
                        originalSeries = [{
                            name: '{{ __('admin.current_month_sales') }}',
                            data: revenueData
                        }, {
                            name: '{{ __('admin.last_month_sales') }}',
                            data: pendingData
                        }, {
                            name: '{{ __('admin.comparison_with_last_month') }}',
                            data: deliveredData
                        }];
                    }
                    
                    // Ensure series data is valid
                    if (!originalSeries || !Array.isArray(originalSeries) || originalSeries.length === 0) {
                        // Create default series if none exist
                        originalSeries = [{
                            name: '{{ __('admin.current_month_sales') }}',
                            data: [0,0,0,0,0,0,0,0,0,0,0,0]
                        }, {
                            name: '{{ __('admin.last_month_sales') }}',
                            data: [0,0,0,0,0,0,0,0,0,0,0,0]
                        }, {
                            name: '{{ __('admin.comparison_with_last_month') }}',
                            data: [0,0,0,0,0,0,0,0,0,0,0,0]
                        }];
                    }
                    
                    // Ensure series data is properly formatted
                    const formattedSeries = originalSeries.map(series => ({
                        name: series.name,
                        data: Array.isArray(series.data) ? series.data.map(val => parseFloat(val) || 0) : [0,0,0,0,0,0,0,0,0,0,0,0]
                    }));
                    
                    // Create new options based on type
                    let newOptions = {
                        chart: {
                            type: type,
                            height: 400,
                            toolbar: {
                                show: false
                            },
                            background: $('body').hasClass('dark-theme') ? '#2d3748' : '#ffffff',
                            foreColor: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333',
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            }
                        },
                        series: formattedSeries,
                        colors: ['#667eea', '#f093fb', '#4facfe'],
                        legend: {
                            show: true,
                            position: 'top',
                            horizontalAlign: 'right'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        grid: {
                            borderColor: $('body').hasClass('dark-theme') ? '#4a5568' : '#e0e0e0',
                            strokeDashArray: 3,
                            row: {
                                colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                                opacity: 0.3
                            },
                            column: {
                                colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                                opacity: 0.3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            shared: true,
                            intersect: false,
                            style: {
                                fontSize: '12px'
                            },
                            y: {
                                formatter: function (val) {
                                    return '$' + val.toFixed(2) + 'K';
                                }
                            },
                            marker: {
                                show: true
                            }
                        }
                    };
                    
                    // Type-specific configurations
                    if (type === 'line') {
                        newOptions.stroke = {
                            curve: 'smooth',
                            width: 3,
                            lineCap: 'round'
                        };
                        newOptions.markers = {
                            size: 6,
                            strokeWidth: 2,
                            strokeColors: '#ffffff',
                            hover: {
                                size: 8
                            }
                        };
                        newOptions.fill = {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.3,
                                gradientToColors: ['#667eea', '#f093fb', '#4facfe'],
                                inverseColors: false,
                                opacityFrom: 0.7,
                                opacityTo: 0.1,
                                stops: [0, 100]
                            }
                        };
                        newOptions.xaxis = {
                            categories: months,
                            title: {
                                text: '{{ __('admin.months') }}',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            }
                        };
                        newOptions.yaxis = {
                            title: {
                                text: '{{ __('admin.sales_amount') }} ($)',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                formatter: function (val) {
                                    return '$' + val.toFixed(1) + 'K';
                                },
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            },
                            min: 0
                        };
                    } else if (type === 'bar') {
                        newOptions.plotOptions = {
                            bar: {
                                borderRadius: 6,
                                columnWidth: '45%',
                                distributed: false
                            }
                        };
                        newOptions.xaxis = {
                            categories: months,
                            title: {
                                text: '{{ __('admin.months') }}',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            }
                        };
                        newOptions.yaxis = {
                            title: {
                                text: '{{ __('admin.sales_amount') }} ($)',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                formatter: function (val) {
                                    return '$' + val.toFixed(1) + 'K';
                                },
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            },
                            min: 0
                        };
                    } else if (type === 'area') {
                        newOptions.stroke = {
                            curve: 'smooth',
                            width: 2
                        };
                        newOptions.fill = {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.3,
                                gradientToColors: ['#667eea', '#f093fb', '#4facfe'],
                                inverseColors: false,
                                opacityFrom: 0.7,
                                opacityTo: 0.1,
                                stops: [0, 100]
                            }
                        };
                        newOptions.xaxis = {
                            categories: months,
                            title: {
                                text: '{{ __('admin.months') }}',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            }
                        };
                        newOptions.yaxis = {
                            title: {
                                text: '{{ __('admin.sales_amount') }} ($)',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#333333'
                                }
                            },
                            labels: {
                                formatter: function (val) {
                                    return '$' + val.toFixed(1) + 'K';
                                },
                                style: {
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    colors: '#666666'
                                }
                            },
                            min: 0
                        };
                    } else if (type === 'pie') {
                        // For pie chart, use only the first series (revenue)
                        const revenueData = originalSeries[0] && originalSeries[0].data ? originalSeries[0].data : [0,0,0,0,0,0,0,0,0,0,0,0];
                        const pieData = [];
                        const pieLabels = [];
                        
                        if (Array.isArray(revenueData)) {
                            revenueData.forEach((value, index) => {
                                if (value > 0) {
                                    pieData.push(parseFloat(value) || 0);
                                    pieLabels.push(months[index]);
                                }
                            });
                        }
                        
                        // If no data, create default
                        if (pieData.length === 0) {
                            pieData.push(1);
                            pieLabels.push('لا توجد بيانات');
                        }
                        
                        newOptions.series = pieData;
                        newOptions.labels = pieLabels;
                        newOptions.legend = {
                            position: 'bottom',
                            horizontalAlign: 'center'
                        };
                        newOptions.plotOptions = {
                            pie: {
                                donut: {
                                    size: '70%'
                                }
                            }
                        };
                        newOptions.dataLabels = {
                            enabled: true,
                            formatter: function (val, opts) {
                                return val.toFixed(1) + "%";
                            },
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                                colors: $('body').hasClass('dark-theme') ? ['#ffffff'] : ['#000000']
                            }
                        };
                        // Remove xaxis and yaxis for pie chart
                        delete newOptions.xaxis;
                        delete newOptions.yaxis;
                    }
                    
                    // Destroy and recreate chart
                    try {
                        chartInstance.destroy();
                    } catch (e) {
                        console.log('Chart already destroyed or not found');
                    }
                    
                    // Clear the chart container
                    const chartElement = document.querySelector("#line-chart-8");
                    if (chartElement) {
                        chartElement.innerHTML = '';
                        
                        // Add a small delay to ensure the container is cleared
                        setTimeout(() => {
                            // Create new chart with updated options
                            window.salesChart = new ApexCharts(chartElement, newOptions);
                            window.salesChart.render();
                            
                            // Store current chart type
                            window.currentChartType = type;
                            
                            // Update stored data if it's not already stored
                            if (!window.originalChartData) {
                                window.originalChartData = {
                                    revenue: formattedSeries[0].data,
                                    pending: formattedSeries[1].data,
                                    delivered: formattedSeries[2].data
                                };
                            }
                            
                            console.log('Chart updated successfully');
                        }, 100);
                        return;
                    }
                    
                } catch (error) {
                    console.error('Error updating chart:', error);
                }
            }
            
            // Handle chart download - separate event handler
            $(document).on('click', '#download-stats-chart-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Download button clicked');
                downloadChart();
            });
            
            function downloadChart() {
                try {
                    console.log('downloadChart function called');
                    console.log('window.salesChart:', window.salesChart);
                    
                    if (window.salesChart) {
                        // Get current chart type
                        const currentType = window.currentChartType || 'line';
                        const fileName = `sales-chart-${currentType}-${new Date().toISOString().split('T')[0]}.png`;
                        
                        console.log('Downloading chart with type:', currentType);
                        console.log('Chart instance:', window.salesChart);
                        
                        // Wait a bit to ensure chart is fully rendered
                        setTimeout(() => {
                            try {
                                // Download the chart
                                window.salesChart.dataURI({
                                    scale: 2,
                                    width: 1200,
                                    height: 600,
                                    type: 'png'
                                }).then((uri) => {
                                    console.log('Download URI received:', typeof uri, uri);
                                    
                                    // Handle both string and object responses
                                    let dataUri = uri;
                                    if (typeof uri === 'object' && uri.imgURI) {
                                        dataUri = uri.imgURI;
                                    } else if (typeof uri === 'object' && uri.uri) {
                                        dataUri = uri.uri;
                                    }
                                    
                                    // Ensure we have a string
                                    if (typeof dataUri !== 'string') {
                                        throw new Error('Invalid data URI format');
                                    }
                                    
                                    // Create a blob from the data URI
                                    const byteString = atob(dataUri.split(',')[1]);
                                    const mimeString = dataUri.split(',')[0].split(':')[1].split(';')[0];
                                    const ab = new ArrayBuffer(byteString.length);
                                    const ia = new Uint8Array(ab);
                                    for (let i = 0; i < byteString.length; i++) {
                                        ia[i] = byteString.charCodeAt(i);
                                    }
                                    const blob = new Blob([ab], { type: mimeString });
                                    
                                    // Create download link
                                    const link = document.createElement('a');
                                    link.href = URL.createObjectURL(blob);
                                    link.download = fileName;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                    
                                    // Clean up the URL object
                                    URL.revokeObjectURL(link.href);
                                    
                                    console.log('Chart downloaded successfully');
                                    
                                    // Show success message
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'تم التحميل بنجاح',
                                            text: 'تم تحميل الرسم البياني بنجاح',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    }
                                }).catch((error) => {
                                    console.error('Error downloading chart:', error);
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'خطأ في التحميل',
                                            text: 'خطأ في تحميل الرسم البياني: ' + error.message,
                                            confirmButtonText: 'موافق'
                                        });
                                    }
                                });
                            } catch (error) {
                                console.error('Error in download timeout:', error);
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ في التحميل',
                                        text: 'خطأ في تحميل الرسم البياني',
                                        confirmButtonText: 'موافق'
                                    });
                                }
                            }
                        }, 500); // Wait 500ms for chart to be fully rendered
                    } else {
                        console.error('Chart instance not found');
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'تحذير',
                                text: 'الرسم البياني غير موجود',
                                confirmButtonText: 'موافق'
                            });
                        }
                    }
                } catch (error) {
                    console.error('Error in downloadChart:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ في التحميل',
                            text: 'خطأ في تحميل الرسم البياني: ' + error.message,
                            confirmButtonText: 'موافق'
                        });
                    }
                }
            }
            
            // Handle sales filter
            $('.sales-filter').on('click', function(e) {
                e.preventDefault();
                const period = $(this).data('period');
                
                // Update button text
                $('.dropdown-toggle').html('<span class="icon-more"><i class="icon-more-horizontal"></i></span>');
                
                // Make AJAX request to get filtered data
                $.ajax({
                    url: '/admin/sales-data',
                    method: 'GET',
                    data: { period: period },
                    success: function(response) {
                        // Update sales data
                        $('#current-sales').text('$' + response.current_sales.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                        $('#last-sales').text('$' + response.last_sales.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                        
                        // Update trend indicator
                        const trendClass = response.comparison >= 0 ? 'up' : 'down';
                        const trendIcon = response.comparison >= 0 ? 'up' : 'down';
                        $('.box-icon-trending').removeClass('up down').addClass(trendClass);
                        $('.box-icon-trending i').removeClass('icon-trending-up icon-trending-down').addClass('icon-trending-' + trendIcon);
                        $('.box-icon-trending .body-title').text(Math.abs(response.comparison) + '%');
                        
                        // Update chart
                        updateChart(response.chart_data);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('admin.error') }}!',
                            text: '{{ __('admin.error_loading_data') }}',
                            confirmButtonText: '{{ __('admin.confirm') }}'
                        });
                    }
                });
            });
        });
        
        function updateChart(chartData) {
            // Check if ApexCharts is available
            if (typeof ApexCharts === 'undefined') {
                return;
            }
            
            // Destroy existing chart
            if (window.salesChart) {
                window.salesChart.destroy();
            }
            
            // Create new chart with updated data
            var options = {
                series: [{
                    name: '{{ __('admin.current_month_sales') }}',
                    data: chartData.revenue
                }, {
                    name: '{{ __('admin.last_month_sales') }}',
                    data: chartData.pending
                }, {
                    name: '{{ __('admin.comparison_with_last_month') }}',
                    data: chartData.delivered
                }],
                chart: {
                    type: 'line',
                    height: 400,
                    toolbar: {
                        show: false
                    },
                    background: $('body').hasClass('dark-theme') ? '#2d3748' : '#ffffff',
                    foreColor: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    lineCap: 'round'
                },
                xaxis: {
                    categories: chartData.categories,
                    title: {
                        text: '{{ __('admin.months') }}',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#333333'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontWeight: '600',
                            colors: $('body').hasClass('dark-theme') ? '#a0aec0' : '#666666'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('admin.sales_amount') }} ($)',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#333333'
                        }
                    },
                    labels: {
                        formatter: function (val) {
                            return '$' + val.toFixed(1) + 'K';
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: '600',
                            colors: $('body').hasClass('dark-theme') ? '#a0aec0' : '#666666'
                        }
                    },
                    min: 0
                },
                colors: ['#667eea', '#f093fb', '#4facfe'],
                legend: {
                    show: false
                },
                grid: {
                    borderColor: $('body').hasClass('dark-theme') ? '#4a5568' : '#e0e0e0',
                    strokeDashArray: 3,
                    row: {
                        colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                        opacity: 0.3
                    },
                    column: {
                        colors: $('body').hasClass('dark-theme') ? ['#2d3748', 'transparent'] : ['#f8f9fa', 'transparent'],
                        opacity: 0.3
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return '$' + val.toFixed(2) + 'K';
                        }
                    },
                    marker: {
                        show: true
                    }
                },
                markers: {
                    size: 6,
                    strokeWidth: 2,
                    strokeColors: '#ffffff',
                    hover: {
                        size: 8
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.3,
                        gradientToColors: ['#667eea', '#f093fb', '#4facfe'],
                        inverseColors: false,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                }
            };
            
            window.salesChart = new ApexCharts(document.querySelector("#line-chart-8"), options);
            window.salesChart.render();
        }
    })(jQuery);
    
    // Re-render charts when theme changes
    $(document).on('themeChanged', function() {
        setTimeout(function() {
            if (window.statsChart) {
                window.statsChart.render();
            }
        }, 100);
    });
</script>
@endpush