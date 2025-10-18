@extends('admin.layouts.app')

@section('title', __('admin.statistics'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.statistics') }}</h3>
    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
        <li><a href="{{ route('admin.dashboard') }}"><div class="text-tiny">{{ __('admin.dashboard') }}</div></a></li>
        <li><i class="icon-chevron-right"></i></li>
        <li><div class="text-tiny">{{ __('admin.statistics') }}</div></li>
    </ul>
</div>

<!-- Navigation Tabs -->
<div class="wg-box mb-4">
    <div class="d-flex align-items-center justify-content-between gap10 flex-wrap">
        <div class="tabs-header">
            <button class="btn btn-outline-primary tab-btn active" data-tab="products">
                <i class="icon-package"></i>
                {{ __('admin.top_products') }}
            </button>
            <button class="btn btn-outline-primary tab-btn" data-tab="users">
                <i class="icon-users"></i>
                {{ __('admin.top_users') }}
            </button>
        </div>
        <div class="wg-filter" style="min-width: 300px;">
            <input type="text" class="form-control form-control-lg" id="stats-search" placeholder="{{ __('admin.search_here') }}">
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="wg-box mb-4">
    <div class="flex items-center justify-between">
        <h5 id="chart-title">{{ isset($products) ? __('admin.top_products') : __('admin.top_users') }}</h5>
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
        </div>
    </div>
    <div id="stats-chart-apex" style="height: 350px; max-height: 350px;"></div>
</div>

<!-- Table Section -->
<div class="wg-box">
    <div class="d-flex align-items-center justify-content-between gap10 flex-wrap mb-3">
        <div class="body-title mb-0" id="table-title">{{ isset($products) ? __('admin.all_products') : __('admin.all_users') }}</div>
    </div>
    <div id="table-container">
        @if(isset($products) && $products instanceof \Illuminate\Contracts\Pagination\Paginator)
                @include('admin.statistics.partials.products_table', ['products' => $products])
        @elseif(isset($users) && $users instanceof \Illuminate\Contracts\Pagination\Paginator)
                @include('admin.statistics.partials.users_table', ['users' => $users])
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    (function ($) {
        // Store current chart type globally
        window.currentChartType = 'line';
        window.currentTab = '{{ isset($products) ? "products" : "users" }}';
        window.currentChartData = {
            labels: [],
            values: [],
            title: ''
        };

        var searchTimer;

        // Initialize chart data from PHP
        @php
            $labels = [];
            $data = [];
            if(isset($products) && $products instanceof \Illuminate\Contracts\Pagination\Paginator){
                foreach($products as $row){
                    $labels[] = optional($row->product)->name_ar ?? optional($row->product)->name_en ?? ('#'.$row->product_id);
                    $data[] = (int) $row->qty;
                }
            } elseif(isset($users) && $users instanceof \Illuminate\Contracts\Pagination\Paginator){
                foreach($users as $u){
                    $labels[] = optional(\App\Models\User::find($u->user_id))->name ?? ('#'.$u->user_id);
                    $data[] = (int) $u->purchases;
                }
            }
        @endphp

        window.currentChartData = {
            labels: @json($labels ?? []),
            values: @json($data ?? []),
            title: '{{ isset($products) ? __("admin.total_sold") : __("admin.purchases") }}'
        };

        // Base chart options template
        function getBaseChartOptions(type, labels, values, title) {
            var baseOptions = {
                chart: {
                    type: type,
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    background: $('body').hasClass('dark-theme') ? '#2d3748' : '#ffffff',
                    foreColor: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
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
                            return val ? val.toFixed(0) : '0';
                        }
                    }
                }
            };

            // Type-specific configurations
            if (type === 'pie') {
                baseOptions.series = values;
                baseOptions.labels = labels;
                baseOptions.legend.position = 'bottom';
                baseOptions.plotOptions = {
                    pie: {
                        donut: {
                            size: '70%'
                        }
                    }
                };
            } else {
                baseOptions.series = [{
                    name: title,
                    data: values
                }];
                baseOptions.xaxis = {
                    categories: labels,
                    title: {
                        text: window.currentTab === 'products' ? '{{ __("admin.products") }}' : '{{ __("admin.users") }}',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333'
                        }
                    },
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '12px',
                            fontWeight: '600',
                            colors: $('body').hasClass('dark-theme') ? '#a0aec0' : '#666666'
                        }
                    }
                };
                baseOptions.yaxis = {
                    title: {
                        text: window.currentTab === 'products' ? '{{ __("admin.total_sold") }}' : '{{ __("admin.purchases") }}',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: $('body').hasClass('dark-theme') ? '#e2e8f0' : '#333333'
                        }
                    },
                    labels: {
                        formatter: function (val) {
                            return val ? val.toFixed(0) : '0';
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: '600',
                            colors: $('body').hasClass('dark-theme') ? '#a0aec0' : '#666666'
                        }
                    },
                    min: 0
                };
                baseOptions.dataLabels = {
                    enabled: false
                };

                // Type-specific additions
                if (type === 'line') {
                    baseOptions.stroke = {
                        curve: 'smooth',
                        width: 3,
                        lineCap: 'round'
                    };
                    baseOptions.markers = {
                        size: 6,
                        strokeWidth: 2,
                        strokeColors: '#ffffff',
                        hover: {
                            size: 8
                        }
                    };
                    baseOptions.fill = {
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
                } else if (type === 'bar') {
                    baseOptions.plotOptions = {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '45%',
                            distributed: false
                        }
                    };
                } else if (type === 'area') {
                    baseOptions.stroke = {
                        curve: 'smooth',
                        width: 2
                    };
                    baseOptions.fill = {
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
                }
            }

            return baseOptions;
        }

        // Create or update chart
        function createChart(type, labels, values, title) {
            console.log('Creating chart:', { type, labels, values, title });

            // Validate data
            if (!labels || !values || labels.length === 0 || values.length === 0) {
                $('#stats-chart-apex').html('<div class="text-center p-4"><div class="text-muted"><i class="icon-bar-chart" style="font-size: 48px; color: #ccc;"></i><br><br>لا توجد بيانات للعرض</div></div>');
                return;
            }

            // Store current data
            window.currentChartData = { labels, values, title };
            window.currentChartType = type;

            // Destroy existing chart
            if (window.statsChart) {
                try {
                    window.statsChart.destroy();
                } catch (e) {
                    console.warn('Error destroying chart:', e);
                }
                window.statsChart = null;
            }

            // Clear container
            const chartElement = document.querySelector('#stats-chart-apex');
            if (chartElement) {
                chartElement.innerHTML = '';
            }

            // Create new chart
            try {
                const options = getBaseChartOptions(type, labels, values, title);
                window.statsChart = new ApexCharts(chartElement, options);
                window.statsChart.render();
                console.log('Chart created successfully');
            } catch (error) {
                console.error('Error creating chart:', error);
                $('#stats-chart-apex').html('<div class="text-center p-4"><div class="text-danger"><i class="icon-alert-circle" style="font-size: 48px; color: #dc3545;"></i><br><br>خطأ في إنشاء الرسم البياني</div></div>');
            }
        }

         // Initialize chart type buttons
         function initChartButtons() {
             console.log('Initializing chart buttons');

             $('.chart-type-btn').off('click').on('click', function(e) {
                 e.preventDefault();
                 e.stopPropagation();

                 const newType = $(this).data('type');
                 console.log('Chart type button clicked:', newType);

                 // Update active state
                 $('.chart-type-btn').removeClass('active');
                 $(this).addClass('active');

                 // Recreate chart with new type
                 createChart(
                     newType,
                     window.currentChartData.labels,
                     window.currentChartData.values,
                     window.currentChartData.title
                 );
             });
             
             // Initialize download button
             $('#download-stats-chart-btn').off('click').on('click', function(e) {
                 e.preventDefault();
                 downloadStatsChart();
             });
         }
         
         // Download stats chart
         function downloadStatsChart() {
             if (window.statsChart) {
                 try {
                     // Get current chart type
                     const currentType = window.currentChartType || 'line';
                     const currentTab = window.currentTab || 'products';
                     const fileName = `statistics-${currentTab}-${currentType}-${new Date().toISOString().split('T')[0]}.png`;
                     
                     // Download the chart
                     window.statsChart.dataURI({
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
                     }).catch((error) => {
                         console.error('Error downloading chart:', error);
                         alert('خطأ في تحميل الرسم البياني: ' + error.message);
                     });
                 } catch (error) {
                     console.error('Error downloading chart:', error);
                     alert('خطأ في تحميل الرسم البياني');
                 }
             } else {
                 alert('الرسم البياني غير موجود');
             }
         }

        // Tab switching
        function switchTab(tab) {
            console.log('Switching to tab:', tab);

            // Update active tab button
            $('.tab-btn').removeClass('active');
            $(`[data-tab="${tab}"]`).addClass('active');

            window.currentTab = tab;

            // Update titles
            const chartTitle = $('#chart-title');
            const tableTitle = $('#table-title');

            if (tab === 'products') {
                chartTitle.text('{{ __("admin.top_products") }}');
                tableTitle.text('{{ __("admin.all_products") }}');
            } else {
                chartTitle.text('{{ __("admin.top_users") }}');
                tableTitle.text('{{ __("admin.all_users") }}');
            }

            // Load data
            loadTab(tab);
        }

        // Load tab data
        function loadTab(tab) {
            const url = tab === 'products' 
                ? '{{ route('admin.statistics.products') }}' 
                : '{{ route('admin.statistics.users') }}';
            const searchValue = $('#stats-search').val() || '';
            const params = new URLSearchParams({ search: searchValue, ajax: 1 });

            // Show loading state
            $('#table-container').html('<div class="text-center p-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            $.ajax({
                url: url + '?' + params.toString(),
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    console.log('Data loaded successfully:', data);

                    // Update table
                    $('#table-container').html(data.html);
                    attachLinks();

                    // Update chart with new data
                    if (data.chartData && data.chartData.labels && data.chartData.values) {
                        createChart(
                            window.currentChartType,
                            data.chartData.labels,
                            data.chartData.values,
                            data.chartData.title
                        );
                    } else {
                        console.warn('No chart data received');
                        $('#stats-chart-apex').html('<div class="text-center p-4"><div class="text-muted"><i class="icon-bar-chart" style="font-size: 48px; color: #ccc;"></i><br><br>لا توجد بيانات للعرض</div></div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading data:', error);
                    $('#table-container').html('<div class="alert alert-danger">خطأ في تحميل البيانات. الرجاء المحاولة مرة أخرى.</div>');
                }
            });
        }

        // Attach table links
        function attachLinks() {
            $('[data-product-show]').off('click').on('click', function(e) {
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });
        }

        // Document ready
        $(document).ready(function() {
            console.log('Document ready');

            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded');
                $.getScript('https://cdn.jsdelivr.net/npm/apexcharts', function() {
                    initializeApp();
                });
            } else {
                initializeApp();
            }
        });

        function initializeApp() {
            console.log('Initializing app');

            // Create initial chart
            createChart(
                window.currentChartType,
                window.currentChartData.labels,
                window.currentChartData.values,
                window.currentChartData.title
            );

            // Initialize buttons
            initChartButtons();

            // Tab switching
            $('.tab-btn').off('click').on('click', function() {
                const tab = $(this).data('tab');
                switchTab(tab);
            });

            // Search functionality
            $('#stats-search').on('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    loadTab(window.currentTab);
                }, 300);
            });

            // Attach table links
            attachLinks();

            console.log('App initialized successfully');
        }

    })(jQuery);
</script>

<style>
.tabs-header {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.tab-btn.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.tab-btn:hover:not(.active) {
    background: #f8f9fa;
    border-color: #007bff;
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

/* Chart Container */
#stats-chart-apex {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

/* Dark Theme */
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

.dark-theme #stats-chart-apex {
    background: #2d3748;
    color: #e2e8f0;
}

/* Search Input Styling */
#stats-search {
    width: 350px;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

#stats-search:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: none;
}

/* Tab Buttons Styling */
.tab-btn {
    font-size: 16px !important;
    font-weight: 600 !important;
    padding: 12px 24px !important;
    border-radius: 8px !important;
    transition: all 0.3s ease !important;
}

.tab-btn i {
    font-size: 18px !important;
    margin-right: 8px !important;
}

.tab-btn.active {
    background: #007bff !important;
    color: #ffffff !important;
    border-color: #007bff !important;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3) !important;
}

.tab-btn:hover:not(.active) {
    background: #f8f9fa !important;
    border-color: #007bff !important;
    color: #007bff !important;
}

/* Dark Theme for Search and Tabs */
.dark-theme #stats-search {
    background: #2d3748;
    border-color: #4a5568;
    color: #e2e8f0;
}

.dark-theme #stats-search:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.dark-theme .tab-btn:hover:not(.active) {
    background: #4a5568 !important;
    border-color: #007bff !important;
    color: #007bff !important;
}

.dropdown .dropdown-menu {
    min-width: 200px;
}
</style>
@endpush
@endsection