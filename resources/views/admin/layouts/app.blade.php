<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
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
        
        .swal-confirm:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
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
        
        .swal-cancel:hover {
            background: #545b62 !important;
            transform: translateY(-2px) !important;
        }
        
        .swal2-popup {
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        }
        
        .swal2-icon {
            margin: 20px auto 15px !important;
        }
        
        .swal2-icon.swal2-success {
            border-color: #28a745 !important;
            color: #28a745 !important;
        }
        
        .swal2-icon.swal2-error {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
        }
        
        .swal2-icon.swal2-warning {
            border-color: #ffc107 !important;
            color: #ffc107 !important;
        }
        
        /* Header Controls Styles */
        .header-grid {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .language-toggle, .theme-toggle {
            display: flex;
            align-items: center;
        }
        
        .theme-toggle-btn {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #495057;
            text-decoration: none;
        }
        
        .theme-toggle-btn:hover {
            background: #e9ecef;
            border-color: #007bff;
            color: #007bff;
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .theme-toggle-btn i {
            font-size: 16px;
        }
        
        .current-lang {
            font-weight: 500;
        }
        
        /* Dark Theme Styles */
        .dark-theme {
            background: #1a1a1a;
            color: #ffffff;
        }
        
        .dark-theme .wg-box {
            background: #2d2d2d;
            border-color: #404040;
        }
        
        .dark-theme .body-title {
            color: #ffffff;
        }
        
        .dark-theme .text-tiny {
            color: #cccccc;
        }
        
        .dark-theme input, .dark-theme textarea, .dark-theme select {
            background: #404040;
            border-color: #555555;
            color: #ffffff;
        }
        
        .dark-theme input:focus, .dark-theme textarea:focus, .dark-theme select:focus {
            background: #404040;
            border-color: #007bff;
            color: #ffffff;
        }
        
        .dark-theme .table {
            background: #2d2d2d;
            color: #ffffff;
        }
        
        .dark-theme .table th {
            background: #404040;
            color: #ffffff;
            border-color: #555555;
        }
        
        .dark-theme .table td {
            border-color: #555555;
        }
        
        .dark-theme .section-menu-left {
            background: #2d2d2d;
        }
        
        .dark-theme .menu-item a {
            color: #cccccc;
        }
        
        .dark-theme .menu-item.active a {
            background: #007bff;
            color: #ffffff;
        }
        
        /* Dark Theme Header Controls */
        .dark-theme .theme-toggle-btn {
            background: #404040;
            border-color: #555555;
            color: #ffffff;
        }
        
        .dark-theme .theme-toggle-btn:hover {
            background: #555555;
            border-color: #007bff;
            color: #007bff;
        }
        
        /* Dark Theme Upload Areas */
        .dark-theme .up-load {
            background: #404040;
            border-color: #555555;
            color: #ffffff;
        }
        
        .dark-theme .up-load:hover {
            background: #555555;
            border-color: #007bff;
        }
        
        .dark-theme .up-load .body-text {
            color: #ffffff;
        }
        
        .dark-theme .up-load .tf-color {
            color: #007bff;
        }
        
        /* Global Zebra Striping for Tables */
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
        /* وضوح النص داخل خلايا الجداول */
        .table th,
        .table td {
            color: #212529;
            vertical-align: middle;
        }
        .dark-theme .table th,
        .dark-theme .table td {
            color: #e9ecef;
        }

        /* شارات وضوح أعلى */
        .badge { font-weight: 600; padding: 6px 10px; font-size: 12px; border-radius: 6px; }
        .badge-info { background-color: #0dcaf0; color: #052c3a; }
        .badge-success { background-color: #198754; color: #eafff3; }
        .badge-warning { background-color: #ffc107; color: #3a2f00; }
        .badge-secondary { background-color: #6c757d; color: #ffffff; }
        
        /* Global Enhanced Pagination Styles */
        .pagination-wrapper {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .pagination-info {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
            background: #f8f9fa;
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 6px;
            align-items: center;
            background: #fff;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
        }
        
        .pagination .page-item {
            margin: 0;
        }
        
        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 8px 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: #fff;
            color: #495057;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
            position: relative;
        }
        
        .pagination .page-link:hover {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: #fff;
            font-weight: 700;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            border-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background: #f8f9fa;
            border-color: #e9ecef;
            color: #adb5bd;
        }
        
        /* Override Bootstrap pagination styles */
        .pagination-wrapper .pagination {
            display: flex !important;
            list-style: none !important;
            padding: 8px !important;
            margin: 0 !important;
            gap: 6px !important;
            align-items: center !important;
            background: #fff !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            border: 2px solid #e9ecef !important;
        }
        
        .pagination-wrapper .pagination li {
            margin: 0 !important;
        }
        
        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 42px !important;
            height: 42px !important;
            padding: 8px 12px !important;
            border: 2px solid #e9ecef !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: #495057 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .pagination-wrapper .pagination li a:hover {
            background: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3) !important;
        }
        
        .pagination-wrapper .pagination li.active a,
        .pagination-wrapper .pagination li.active span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
            font-weight: 700 !important;
            transform: scale(1.05) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4) !important;
        }
        
        .pagination-wrapper .pagination li.disabled a,
        .pagination-wrapper .pagination li.disabled span {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }
        
        .pagination-wrapper .pagination li.disabled a:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
        }
        
        /* Special styling for Previous/Next buttons */
        .pagination-wrapper .pagination li:first-child a,
        .pagination-wrapper .pagination li:last-child a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
            font-weight: 700 !important;
            min-width: 100px !important;
            padding: 10px 20px !important;
        }
        
        .pagination-wrapper .pagination li:first-child a:hover,
        .pagination-wrapper .pagination li:last-child a:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
            border-color: #5a67d8 !important;
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5) !important;
        }
        
        .pagination-wrapper .pagination li:first-child.disabled a,
        .pagination-wrapper .pagination li:last-child.disabled a {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            opacity: 0.6 !important;
        }
        
        .pagination-wrapper .pagination li:first-child.disabled a:hover,
        .pagination-wrapper .pagination li:last-child.disabled a:hover {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Dark Theme Pagination */
        .dark-theme .pagination-info {
            background: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        
        .dark-theme .pagination {
            background: #2d3748;
            border-color: #4a5568;
        }
        
        .dark-theme .pagination .page-link {
            background: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        
        .dark-theme .pagination .page-link:hover {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        
        .dark-theme .pagination .page-item.disabled .page-link {
            background: #4a5568;
            border-color: #718096;
            color: #a0aec0;
        }
        
        .dark-theme .pagination .page-item.disabled .page-link:hover {
            background: #4a5568;
            border-color: #718096;
            color: #a0aec0;
        }
        
        /* Dark Theme Override Bootstrap pagination */
        .dark-theme .pagination-wrapper .pagination {
            background: #2d3748 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li a,
        .dark-theme .pagination-wrapper .pagination li span {
            background: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li a:hover {
            background: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li.disabled a,
        .dark-theme .pagination-wrapper .pagination li.disabled span {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li.disabled a:hover {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        /* Dark Theme Special styling for Previous/Next buttons */
        .dark-theme .pagination-wrapper .pagination li:first-child a,
        .dark-theme .pagination-wrapper .pagination li:last-child a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li:first-child a:hover,
        .dark-theme .pagination-wrapper .pagination li:last-child a:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
            border-color: #5a67d8 !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li:first-child.disabled a,
        .dark-theme .pagination-wrapper .pagination li:last-child.disabled a {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        .dark-theme .pagination-wrapper .pagination li:first-child.disabled a:hover,
        .dark-theme .pagination-wrapper .pagination li:last-child.disabled a:hover {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        /* Dark Theme Force pagination styling - Override everything */
        .dark-theme .pagination-wrapper nav ul.pagination {
            background: #2d3748 !important;
            border-color: #4a5568 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li a,
        .dark-theme .pagination-wrapper nav ul.pagination li span {
            background: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li a:hover {
            background: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li.disabled a,
        .dark-theme .pagination-wrapper nav ul.pagination li.disabled span {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li.disabled a:hover {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li:first-child a,
        .dark-theme .pagination-wrapper nav ul.pagination li:last-child a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li:first-child a:hover,
        .dark-theme .pagination-wrapper nav ul.pagination li:last-child a:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
            border-color: #5a67d8 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li:first-child.disabled a,
        .dark-theme .pagination-wrapper nav ul.pagination li:last-child.disabled a {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        .dark-theme .pagination-wrapper nav ul.pagination li:first-child.disabled a:hover,
        .dark-theme .pagination-wrapper nav ul.pagination li:last-child.disabled a:hover {
            background: #4a5568 !important;
            border-color: #718096 !important;
            color: #a0aec0 !important;
        }
        
        /* Responsive Pagination */
        @media (max-width: 768px) {
            .pagination-wrapper {
                flex-direction: column;
                gap: 15px;
            }
            
            .pagination {
                padding: 6px;
                gap: 4px;
            }
            
            .pagination .page-link {
                min-width: 38px;
                height: 38px;
                padding: 6px 10px;
                font-size: 13px;
            }
            
            .pagination-info {
                font-size: 14px;
                padding: 10px 15px;
            }
            
            .pagination-wrapper .pagination li:first-child a,
            .pagination-wrapper .pagination li:last-child a {
                min-width: 80px !important;
                padding: 8px 15px !important;
                font-size: 12px !important;
            }
        }
        
        /* Force pagination styling - Override everything */
        .pagination-wrapper nav ul.pagination {
            display: flex !important;
            list-style: none !important;
            padding: 8px !important;
            margin: 0 !important;
            gap: 6px !important;
            align-items: center !important;
            background: #fff !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            border: 2px solid #e9ecef !important;
        }
        
        .pagination-wrapper nav ul.pagination li {
            margin: 0 !important;
        }
        
        .pagination-wrapper nav ul.pagination li a,
        .pagination-wrapper nav ul.pagination li span {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 42px !important;
            height: 42px !important;
            padding: 8px 12px !important;
            border: 2px solid #e9ecef !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: #495057 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .pagination-wrapper nav ul.pagination li a:hover {
            background: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3) !important;
        }
        
        .pagination-wrapper nav ul.pagination li.active a,
        .pagination-wrapper nav ul.pagination li.active span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
            font-weight: 700 !important;
            transform: scale(1.05) !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4) !important;
        }
        
        .pagination-wrapper nav ul.pagination li.disabled a,
        .pagination-wrapper nav ul.pagination li.disabled span {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }
        
        .pagination-wrapper nav ul.pagination li.disabled a:hover {
            transform: none !important;
            box-shadow: none !important;
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
        }
        
        /* Special styling for Previous/Next buttons in nav */
        .pagination-wrapper nav ul.pagination li:first-child a,
        .pagination-wrapper nav ul.pagination li:last-child a {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
            font-weight: 700 !important;
            min-width: 100px !important;
            padding: 10px 20px !important;
        }
        
        .pagination-wrapper nav ul.pagination li:first-child a:hover,
        .pagination-wrapper nav ul.pagination li:last-child a:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
            border-color: #5a67d8 !important;
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5) !important;
        }
        
        .pagination-wrapper nav ul.pagination li:first-child.disabled a,
        .pagination-wrapper nav ul.pagination li:last-child.disabled a {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            opacity: 0.6 !important;
        }
        
        .pagination-wrapper nav ul.pagination li:first-child.disabled a:hover,
        .pagination-wrapper nav ul.pagination li:last-child.disabled a:hover {
            background: #f8f9fa !important;
            border-color: #e9ecef !important;
            color: #adb5bd !important;
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Global Fieldset Layout Fix */
        fieldset {
            display: block !important;
            width: 100% !important;
            margin-bottom: 25px !important;
            border: none !important;
            padding: 0 !important;
        }
        
        fieldset .body-title {
            display: block !important;
            margin-bottom: 10px !important;
            font-weight: 600 !important;
            color: #333 !important;
            font-size: 16px !important;
        }
        
        fieldset input,
        fieldset textarea {
            display: block !important;
            width: 100% !important;
            padding: 14px 16px !important;
            border: 2px solid #ced4da !important; /* أوضح */
            border-radius: 10px !important;
            font-size: 16px !important;
            margin-bottom: 10px !important;
            transition: all 0.3s ease !important;
            background: #ffffff !important; /* أبيض صريح */
            color: #212529 !important;
        }
        
        fieldset input:focus,
        fieldset textarea:focus {
            border-color: #0d6efd !important; /* أزرق بوتستراب */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
            outline: none !important;
            transform: translateY(-2px) !important;
        }
        
        fieldset .text-tiny {
            display: block !important;
            font-size: 13px !important;
            color: #6c757d !important;
            margin-top: 8px !important;
            margin-bottom: 8px !important;
            line-height: 1.4 !important;
        }
        
        fieldset .tf-color-1 {
            display: block !important;
            font-size: 13px !important;
            color: #dc3545 !important;
            margin-top: 8px !important;
            margin-bottom: 8px !important;
            line-height: 1.4 !important;
            font-weight: 500 !important;
        }
        
        /* Dark theme for fieldsets */
        .dark-theme fieldset .body-title {
            color: #e2e8f0 !important;
        }
        
        .dark-theme fieldset input,
        .dark-theme fieldset textarea {
            background: #2b2f36 !important;
            border-color: #495057 !important;
            color: #e9ecef !important;
        }
        
        .dark-theme fieldset input:focus,
        .dark-theme fieldset textarea:focus {
            border-color: #0d6efd !important;
            background: #2b2f36 !important;
        }
        
        .dark-theme fieldset input::placeholder,
        .dark-theme fieldset textarea::placeholder {
            color: #9aa0a6 !important;
        }
        
        .dark-theme fieldset .text-tiny {
            color: #adb5bd !important;
        }
        
        .dark-theme fieldset .tf-color-1 {
            color: #ff6b6b !important;
        }

        /* تحسين select */
        .select select {
            width: 100% !important;
            padding: 12px 14px !important;
            border: 2px solid #ced4da !important;
            border-radius: 10px !important;
            background: #fff !important;
            color: #212529 !important;
        }
        .select select:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25) !important;
            outline: none !important;
        }

        /* أزرار الإجراءات في الجداول (أيقونات) */
        .list-icon-function {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .list-icon-function .item {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f1f3f5;
            border: 1px solid #e9ecef;
            transition: all .2s ease;
            cursor: pointer;
        }
        .list-icon-function .item i { font-size: 18px; }
        .list-icon-function .item.eye { color: #0d6efd; }
        .list-icon-function .item.edit { color: #fd7e14; }
        .list-icon-function .item.delete, .list-icon-function .item.text-danger { color: #dc3545; }
        .list-icon-function .item:hover { transform: translateY(-2px); background: #e9ecef; }

        /* نسخة الوضع الداكن */
        .dark-theme .list-icon-function .item {
            background: #343a40;
            border-color: #495057;
        }
        .dark-theme .list-icon-function .item:hover { background: #3f474f; }
        
        /* Global Sweet Alert Custom Styling */
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
        
        /* Dark Theme Form Elements */
        .dark-theme .wg-box {
            background: #2d2d2d;
            border-color: #404040;
        }
        
        .dark-theme .body-title {
            color: #ffffff;
        }
        
        .dark-theme .text-tiny {
            color: #cccccc;
        }
        
        /* Dark Theme Buttons */
        .dark-theme .tf-button {
            background: #007bff;
            color: #ffffff;
        }
        
        .dark-theme .tf-button:hover {
            background: #0056b3;
        }

        /* Sidebar/Header logo styling as circular avatar */
        #logo_header,
        #logo_header_mobile {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            background: #ffffff;
            padding: 2px;
            border: 2px solid #e9ecef;
            margin-left: 8px; /* إبعاد الشعار قليلًا عن حافة اليسار */
        }

        .dark-theme #logo_header,
        .dark-theme #logo_header_mobile {
            border-color: #495057;
            background: #2b2f36;
        }
        
        /* Dark Theme Sidebar */
        .dark-theme .section-menu-left {
            background: #2d2d2d;
            border-right: 1px solid #404040;
        }
        
        .dark-theme .menu-item a {
            color: #cccccc;
        }
        
        .dark-theme .menu-item:hover a {
            background: #404040;
            color: #ffffff;
        }
        
        /* Dark Theme Header */
        .dark-theme .header {
            background: #2d2d2d;
            border-bottom: 1px solid #404040;
        }
        
        .dark-theme .header-item {
            color: #ffffff;
        }
        
        /* Dark Theme Breadcrumbs */
        .dark-theme .breadcrumbs a {
            color: #cccccc;
        }
        
        .dark-theme .breadcrumbs .text-tiny {
            color: #cccccc;
        }
        
        /* Header Notifications Styles */
        .message-item.unread {
            background-color: #f8f9fa;
            border-left: 3px solid #007bff;
        }
        
        .dark-theme .message-item.unread {
            background-color: #2d3748;
            border-left-color: #4299e1;
        }
        
        .message-item {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .message-item:hover {
            background-color: #f8f9fa;
        }
        
        .dark-theme .message-item:hover {
            background-color: #4a5568;
        }
        
        .message-item .image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
        }
        
        .dark-theme .message-item .image {
            background: #4a5568;
        }
        
        .message-item .image i {
            font-size: 18px;
            color: #6c757d;
        }
        
        .dark-theme .message-item .image i {
            color: #a0aec0;
        }
        
        .message-item .body-title-2 {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }
        
        .dark-theme .message-item .body-title-2 {
            color: #e2e8f0;
        }
        
        .message-item .text-tiny {
            color: #718096;
            font-size: 12px;
        }
        
        .dark-theme .message-item .text-tiny {
            color: #a0aec0;
        }
        
        .message-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .message-item .flex-grow {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.dashboard') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" src="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}"
                                data-light="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}" data-dark="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('admin.dashboard') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">{{ __('admin.dashboard') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                @if(auth()->user()->hasPermission('view_products') || auth()->user()->hasPermission('create_products'))
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">{{ __('admin.products') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        @if(auth()->user()->hasPermission('create_products'))
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.create') }}" class="">
                                                <div class="text">{{ __('admin.add_product') }}</div>
                                            </a>
                                        </li>
                                        @endif
                                        @if(auth()->user()->hasPermission('view_products'))
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.index') }}" class="">
                                                <div class="text">{{ __('admin.products') }}</div>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">{{ __('admin.categories') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.categories.create') }}" class="">
                                                <div class="text">{{ __('admin.add_category') }}</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.categories.index') }}" class="">
                                                <div class="text">{{ __('admin.all_categories') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">{{ __('admin.orders') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.orders.index') }}" class="">
                                                <div class="text">{{ __('admin.orders') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-tag"></i></div>
                                        <div class="text">{{ __('admin.coupons') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.coupons.create') }}" class="">
                                                <div class="text">{{ __('admin.add_coupon') }}</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.coupons.index') }}" class="">
                                                <div class="text">{{ __('admin.all_coupons') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @if(auth()->user()->hasPermission('view_users') || auth()->user()->hasPermission('create_users'))
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">{{ __('admin.users') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        @if(auth()->user()->hasPermission('view_users'))
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.users.index') }}" class="">
                                                <div class="text">{{ __('admin.all_users') }}</div>
                                            </a>
                                        </li>
                                        @endif
                                        @if(auth()->user()->hasPermission('create_users'))
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.users.create') }}" class="">
                                                <div class="text">{{ __('admin.create_user') }}</div>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                                <li class="menu-item">
                                    <a href="{{ route('admin.reviews.index') }}" class="">
                                        <div class="icon"><i class="icon-star"></i></div>
                                        <div class="text">{{ __('admin.reviews') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.notifications') }}" class="">
                                        <div class="icon"><i class="icon-bell"></i></div>
                                        <div class="text">{{ __('admin.notifications') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-bar-chart-2"></i></div>
                                        <div class="text">{{ __('admin.statistics') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.statistics.products') }}" class="">
                                                <div class="text">{{ __('admin.products_tab') }}</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.statistics.users') }}" class="">
                                                <div class="text">{{ __('admin.users_tab') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.settings') }}" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">{{ __('admin.settings') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section-content-right">
                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="{{ route('admin.dashboard') }}">
                                    <img class="" id="logo_header_mobile" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" src="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}"
                                        data-light="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}" data-dark="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}"
                                        data-width="154px" data-height="52px" data-retina="{{ \App\Models\Setting::get('site_logo') ? asset(\App\Models\Setting::get('site_logo')) : asset('assets/admin/images/logo/logo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>

                                <div class="flex-grow"></div>
                            </div>
                            <div class="header-grid">
                                <!-- Language Toggle -->
                                <div class="language-toggle">
                                    <a href="{{ route('locale', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" class="theme-toggle-btn" id="language-toggle" title="تغيير اللغة">
                                        <i class="icon-globe"></i>
                                        <span class="current-lang">{{ app()->getLocale() == 'ar' ? 'عربي' : 'English' }}</span>
                                    </a>
                                </div>
                                
                                <!-- Theme Toggle -->
                                <div class="theme-toggle">
                                    <button class="theme-toggle-btn" id="theme-toggle" title="تغيير المظهر">
                                        <i class="icon-sun" id="theme-icon"></i>
                                    </button>
                                </div>
                                
                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny" id="notification-count">0</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2" id="notifications-dropdown">
                                            <li>
                                                <h6>{{ __('admin.notifications') }}</h6>
                                            </li>
                                            <li id="notifications-list">
                                                <div class="text-center py-3">
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="{{ route('admin.notifications') }}" class="tf-button w-full">{{ __('admin.view_all') }}</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    @if(Auth::user()->avatar)
                                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" onerror="this.src='{{ asset('assets/admin/images/avatar/user-1.png') }}'">
                                                    @else
                                                        <img src="{{ asset('assets/admin/images/avatar/user-1.png') }}" alt="{{ Auth::user()->name }}">
                                                    @endif
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</span>
                                                    <span class="text-tiny">{{ Auth::user()->name }}</span>
                                                </span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li>
                                                <a href="{{ route('admin.profile') }}" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">{{ __('admin.profile') }}</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.settings') }}" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-settings"></i>
                                                    </div>
                                                    <div class="body-title-2">{{ __('admin.settings') }}</div>
                                                </a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.logout') }}">
                                                    @csrf
                                                    <button type="submit" class="user-item w-full">
                                                        <div class="icon">
                                                            <i class="icon-logout"></i>
                                                        </div>
                                                        <div class="body-title-2">{{ __('admin.logout') }}</div>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                @if(session('success'))
                                    <script>
                                        window.successMessage = '{{ session('success') }}';
                                    </script>
                                @endif

                                @if(session('error'))
                                    <script>
                                        window.errorMessage = '{{ session('error') }}';
                                    </script>
                                @endif

                                @if($errors->any())
                                    <script>
                                        window.errorMessage = '@foreach($errors->all() as $error){{ $error }}@endforeach';
                                    </script>
                                @endif

                                @yield('content')
                            </div>
                        </div>

                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2025 <a href="https://www.linkedin.com/in/mohamed-emad-eldeen-abdulsattar-607699262/" target="_blank">Eng : Mohamed Emad</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/sweetalert-simple.js') }}"></script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    
    <script>
    $(document).ready(function() {

        
        // Language Toggle with Sweet Alert
        $(document).on('click', '#language-toggle', function(e) {
            e.preventDefault();
            
            const currentLang = '{{ app()->getLocale() }}';
            const newLang = currentLang === 'ar' ? 'en' : 'ar';
            const langText = newLang === 'ar' ? 'العربية' : 'English';
            
            // Show Sweet Alert first
            Swal.fire({
                icon: 'success',
                title: newLang === 'ar' ? 'تم تغيير اللغة بنجاح!' : 'Language Changed Successfully!',
                text: newLang === 'ar' ? `تم تغيير اللغة إلى ${langText}` : `Language changed to ${langText}`,
                confirmButtonText: newLang === 'ar' ? 'موافق' : 'OK',
                timer: 2000,
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
                // Redirect to change language
                window.location.href = $(this).attr('href');
            });
        });
        
        // Theme Toggle
        $(document).on('click', '#theme-toggle', function(e) {
            e.preventDefault();
            
            const body = $('body');
            const themeIcon = $('#theme-icon');
            
            if (body.hasClass('dark-theme')) {
                // Switch to light theme
                body.removeClass('dark-theme');
                themeIcon.removeClass('icon-moon').addClass('icon-sun');
                localStorage.setItem('theme', 'light');
            } else {
                // Switch to dark theme
                body.addClass('dark-theme');
                themeIcon.removeClass('icon-sun').addClass('icon-moon');
                localStorage.setItem('theme', 'dark');
            }
        });
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            $('body').addClass('dark-theme');
            $('#theme-icon').removeClass('icon-sun').addClass('icon-moon');
        }
        
        // Load header notifications
        loadHeaderNotifications();
        
        // Refresh notifications every 30 seconds
        setInterval(loadHeaderNotifications, 30000);
    });
    
    // Function to load header notifications
    function loadHeaderNotifications() {
        $.ajax({
            url: '{{ route("admin.notifications.header") }}',
            method: 'GET',
            success: function(response) {
                console.log('Notifications loaded:', response);
                updateNotificationCount(response.unread_count);
                updateNotificationsList(response.notifications);
            },
            error: function(xhr, status, error) {
                console.log('Error loading notifications:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    }
    
    // Function to update notification count
    function updateNotificationCount(count) {
        $('#notification-count').text(count);
        if (count > 0) {
            $('#notification-count').addClass('badge bg-danger');
        } else {
            $('#notification-count').removeClass('badge bg-danger');
        }
    }
    
    // Function to update notifications list
    function updateNotificationsList(notifications) {
        const list = $('#notifications-list');
        
        if (notifications.length === 0) {
            list.html('<div class="text-center py-3 text-muted">لا توجد إشعارات</div>');
            return;
        }
        
        let html = '';
        notifications.forEach(function(notification) {
            const iconClass = getNotificationIcon(notification.type);
            const timeAgo = getTimeAgo(notification.created_at);
            const isUnread = !notification.is_read ? 'unread' : '';
            
            // Use Arabic text directly since we're in Arabic interface
            const title = notification.title || 'إشعار';
            const message = notification.message || 'لا يوجد رسالة';
            
            html += `
                <div class="message-item ${isUnread}" data-id="${notification.id}">
                    <div class="image">
                        <i class="${iconClass}"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="body-title-2">${title}</div>
                        <div class="text-tiny">${message}</div>
                        <div class="text-tiny text-muted">${timeAgo}</div>
                    </div>
                </div>
            `;
        });
        
        list.html(html);
        
        // Add click handlers for notifications
        $('.message-item').on('click', function() {
            const notificationId = $(this).data('id');
            markNotificationAsRead(notificationId);
        });
    }
    
    // Function to mark notification as read
    function markNotificationAsRead(notificationId) {
        $.ajax({
            url: `/admin/notifications/${notificationId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Remove unread class and refresh notifications
                $(`.message-item[data-id="${notificationId}"]`).removeClass('unread');
                loadHeaderNotifications();
            },
            error: function() {
                console.log('Error marking notification as read');
            }
        });
    }
    
    
    // Function to get notification icon based on type
    function getNotificationIcon(type) {
        switch(type) {
            case 'warning':
                return 'icon-alert-triangle';
            case 'error':
                return 'icon-x-circle';
            case 'success':
                return 'icon-check-circle';
            default:
                return 'icon-info';
        }
    }
    
    // Function to get time ago
    function getTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) {
            return 'الآن';
        } else if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `منذ ${minutes} دقيقة`;
        } else if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `منذ ${hours} ساعة`;
        } else {
            const days = Math.floor(diffInSeconds / 86400);
            return `منذ ${days} يوم`;
        }
    }
    </script>
    
    @stack('scripts')
    
    <style>
        /* تحسينات عامة للواجهة */
        body {
            font-size: 18px !important;
            line-height: 1.6 !important;
        }
        
        /* تحسين الخط في الجداول */
        .table {
            font-size: 18px !important;
        }
        
        .table th, .table td {
            font-size: 18px !important;
            padding: 15px 12px !important;
            vertical-align: middle !important;
        }
        
        .table th {
            font-weight: 700 !important;
            background-color: #f8f9fa !important;
            color: #495057 !important;
        }
        
        /* تحسين الأزرار */
        .btn {
            font-size: 18px !important;
            font-weight: 700 !important;
            padding: 12px 24px !important;
            border-radius: 8px !important;
        }
        
        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }
        
        .btn-primary:hover {
            background-color: #0056b3 !important;
            border-color: #0056b3 !important;
            transform: translateY(-1px) !important;
        }
        
        /* تحسين النماذج */
        .form-control {
            font-size: 18px !important;
            padding: 16px 20px !important;
            border-radius: 8px !important;
            border: 2px solid #e9ecef !important;
        }
        
        .form-control:focus {
            border-color: #007bff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }
        
        .form-label {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #495057 !important;
            margin-bottom: 12px !important;
        }
        
        /* تحسين العناوين */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700 !important;
            color: #2c3e50 !important;
        }
        
        h3 {
            font-size: 24px !important;
        }
        
        /* تحسين البطاقات */
        .wg-box {
            border-radius: 8px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
            border: 1px solid #e9ecef !important;
        }
        
        /* تحسين الشارات */
        .badge {
            font-size: 14px !important;
            padding: 8px 12px !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
        }
        
        /* تحسين الأيقونات */
        .list-icon-function .item {
            font-size: 18px !important;
            padding: 10px !important;
            margin: 0 4px !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
        }
        
        .list-icon-function .item:hover {
            transform: translateY(-2px) !important;
        }
        
        /* تحسين البحث */
        .search-input {
            font-size: 16px !important;
            padding: 12px 16px !important;
        }
        
        /* تحسين الـ breadcrumbs */
        .breadcrumbs {
            font-size: 16px !important;
        }
        
        .breadcrumbs .text-tiny {
            font-size: 16px !important;
            font-weight: 500 !important;
        }
        
        /* تحسين الـ pagination */
        .pagination {
            font-size: 16px !important;
        }
        
        .pagination .page-link {
            padding: 10px 16px !important;
            font-size: 16px !important;
        }
        
        /* تحسين الـ checkboxes */
        .form-check-input {
            width: 22px !important;
            height: 22px !important;
            margin-right: 12px !important;
            margin-top: 2px !important;
            vertical-align: top !important;
            border: 2px solid #007bff !important;
            border-radius: 4px !important;
            background-color: white !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        .form-check-input:checked {
            background-color: #007bff !important;
            border-color: #007bff !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e") !important;
            background-size: 16px 16px !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }
        
        .form-check-input:hover {
            border-color: #0056b3 !important;
            transform: scale(1.05) !important;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
            border-color: #007bff !important;
        }
        
        /* دعم الوضع الليلي للـ checkboxes */
        [data-theme="dark"] .form-check-input {
            background-color: #4a5568 !important;
            border-color: #718096 !important;
        }
        
        [data-theme="dark"] .form-check-input:checked {
            background-color: #63b3ed !important;
            border-color: #63b3ed !important;
        }
        
        [data-theme="dark"] .form-check {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-check:hover {
            background-color: #4a5568 !important;
            border-color: #63b3ed !important;
        }
        
        [data-theme="dark"] .form-check-label {
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-text {
            color: #a0aec0 !important;
        }
        
        /* دعم الوضع الليلي للحقول الأخرى */
        [data-theme="dark"] .form-control {
            background-color: #4a5568 !important;
            border-color: #718096 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-control:focus {
            background-color: #4a5568 !important;
            border-color: #63b3ed !important;
            color: #e2e8f0 !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 179, 237, 0.25) !important;
        }
        
        [data-theme="dark"] .form-select {
            background-color: #4a5568 !important;
            border-color: #718096 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-select:focus {
            background-color: #4a5568 !important;
            border-color: #63b3ed !important;
            color: #e2e8f0 !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 179, 237, 0.25) !important;
        }
        
        [data-theme="dark"] .wg-box {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .permissions-container {
            background-color: #1a202c !important;
            border-color: #4a5568 !important;
        }
        
        [data-theme="dark"] .category-title {
            color: #e2e8f0 !important;
            border-color: #4a5568 !important;
        }
        
        /* إصلاح شامل للوضع الليلي */
        [data-theme="dark"] body {
            background-color: #1a202c !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .main-content {
            background-color: #1a202c !important;
        }
        
        [data-theme="dark"] .wg-box {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #4a5568 !important;
            border-color: #718096 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #4a5568 !important;
            border-color: #63b3ed !important;
            color: #e2e8f0 !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 179, 237, 0.25) !important;
        }
        
        [data-theme="dark"] .form-check {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-check:hover {
            background-color: #4a5568 !important;
            border-color: #63b3ed !important;
        }
        
        [data-theme="dark"] .permissions-container {
            background-color: #1a202c !important;
            border-color: #4a5568 !important;
        }
        
        [data-theme="dark"] .form-label {
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .form-text {
            color: #a0aec0 !important;
        }
        
        [data-theme="dark"] .invalid-feedback {
            color: #fc8181 !important;
        }
        
        [data-theme="dark"] .text-danger {
            color: #fc8181 !important;
        }
        
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6 {
            color: #e2e8f0 !important;
        }
        
        [data-theme="dark"] .breadcrumbs .text-tiny {
            color: #a0aec0 !important;
        }
        
        [data-theme="dark"] .breadcrumbs a {
            color: #63b3ed !important;
        }
        
        [data-theme="dark"] .breadcrumbs a:hover {
            color: #90cdf4 !important;
        }
    </style>
</body>

</html>