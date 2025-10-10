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
                                        <p class="mt-10">No orders yet</p>
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
                var options = {
                    series: [{
                        name: '{{ __('admin.current_month_sales') }}',
                        data: [{{ implode(',', $salesData['revenue'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }}]
                    }, {
                        name: '{{ __('admin.last_month_sales') }}',
                        data: [{{ implode(',', $salesData['pending'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }}]
                    }, {
                        name: '{{ __('admin.comparison_with_last_month') }}',
                        data: [{{ implode(',', $salesData['delivered'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }}]
                    }],
                    chart: {
                        type: 'line',
                        height: 400,
                        toolbar: {
                            show: false
                        },
                        background: '#ffffff',
                        foreColor: '#333333',
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
                        show: false
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        strokeDashArray: 3,
                        row: {
                            colors: ['#f8f9fa', 'transparent'],
                            opacity: 0.3
                        },
                        column: {
                            colors: ['#f8f9fa', 'transparent'],
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

                var chart = new ApexCharts(document.querySelector("#line-chart-8"), options);
                chart.render();
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
            } else {
                console.error('ApexCharts is not loaded');
                // Load ApexCharts dynamically if not loaded
                $.getScript('https://cdn.jsdelivr.net/npm/apexcharts', function() {
                    tfLineChart.init();
                });
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
                console.error('ApexCharts is not available');
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
                    background: '#ffffff',
                    foreColor: '#333333',
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
                    show: false
                },
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 3,
                    row: {
                        colors: ['#f8f9fa', 'transparent'],
                        opacity: 0.3
                    },
                    column: {
                        colors: ['#f8f9fa', 'transparent'],
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
</script>
@endpush