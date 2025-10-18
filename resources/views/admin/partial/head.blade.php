<title>@yield('title', __('admin.dashboard'))</title>
<meta charset="utf-8">
<meta name="author" content="themesflat.com">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animation.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/font/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/icon/style.css') }}">
<link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/admin/images/favicon.ico') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/custom.css') }}">

<style>
    /* SweetAlert Custom Styles */
    .swal-wide {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .swal-title {
        font-size: 24px !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 15px !important;
    }
    
    .swal-content {
        font-size: 16px !important;
        line-height: 1.5 !important;
        color: #555 !important;
    }
    
    .swal-confirm {
        font-size: 16px !important;
        font-weight: 500 !important;
        padding: 12px 24px !important;
        border-radius: 8px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        transition: all 0.3s ease !important;
    }
    
    .swal-cancel {
        font-size: 16px !important;
        font-weight: 500 !important;
        padding: 12px 24px !important;
        border-radius: 8px !important;
        background: #6c757d !important;
        border: none !important;
        transition: all 0.3s ease !important;
    }
    
    .swal-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4) !important;
    }
    
    .swal-cancel:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4) !important;
    }
    
    /* Custom Admin Styles */
    .admin-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 25px 0;
        margin-bottom: 30px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        border-bottom: 4px solid #3498db;
    }
    
    .admin-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .admin-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .admin-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .admin-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
    }
    
    .admin-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .admin-table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.01);
        transition: all 0.2s ease;
    }
    
    .admin-sidebar {
        background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        min-height: 100vh;
        box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }
    
    .admin-sidebar .menu-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 5px 10px;
    }
    
    .admin-sidebar .menu-item:hover {
        background: rgba(255,255,255,0.1);
        transform: translateX(5px);
    }
    
    .admin-sidebar .menu-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .admin-sidebar .menu-item a {
        color: white;
        text-decoration: none;
        padding: 15px 20px;
        display: block;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .admin-sidebar .menu-item a:hover {
        color: white;
        text-decoration: none;
    }
    
    .admin-content {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px;
    }
    
    .admin-stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        border-left: 5px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .admin-stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .admin-stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 10px;
    }
    
    .admin-stats-label {
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .admin-form-group {
        margin-bottom: 25px;
    }
    
    .admin-form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }
    
    .admin-form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .admin-form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .admin-alert {
        border-radius: 10px;
        border: none;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .admin-alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 5px solid #28a745;
    }
    
    .admin-alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 5px solid #dc3545;
    }
    
    .admin-alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border-left: 5px solid #ffc107;
    }
    
    .admin-alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
        border-left: 5px solid #17a2b8;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-content {
            padding: 15px;
        }
        
        .admin-stats-card {
            margin-bottom: 20px;
        }
        
        .admin-sidebar {
            min-height: auto;
        }
    }
    
    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .slide-in {
        animation: slideIn 0.5s ease-out;
    }
    
    @keyframes slideIn {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }
    
    /* Loading Spinner */
    .admin-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Custom Scrollbar */
    .admin-scroll::-webkit-scrollbar {
        width: 8px;
    }
    
    .admin-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .admin-scroll::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .admin-scroll::-webkit-scrollbar-thumb:hover {
        background: #5a6fd8;
    }
</style>

@stack('styles')
