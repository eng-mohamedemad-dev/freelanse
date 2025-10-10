<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>@yield('title', 'لوحة التحكم')</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
            padding: 15px 20px !important;
            border: 2px solid #e9ecef !important;
            border-radius: 10px !important;
            font-size: 16px !important;
            margin-bottom: 10px !important;
            transition: all 0.3s ease !important;
            background: #fff !important;
            color: #333 !important;
        }
        
        fieldset input:focus,
        fieldset textarea:focus {
            border-color: #007bff !important;
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
            background: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }
        
        .dark-theme fieldset input:focus,
        .dark-theme fieldset textarea:focus {
            border-color: #007bff !important;
            background: #2d3748 !important;
        }
        
        .dark-theme fieldset input::placeholder,
        .dark-theme fieldset textarea::placeholder {
            color: #a0aec0 !important;
        }
        
        .dark-theme fieldset .text-tiny {
            color: #a0aec0 !important;
        }
        
        .dark-theme fieldset .tf-color-1 {
            color: #ff6b6b !important;
        }
        
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
                            <img class="" id="logo_header" alt="" src="{{ asset('assets/admin/images/logo/logo.png') }}"
                                data-light="{{ asset('assets/admin/images/logo/logo.png') }}" data-dark="{{ asset('assets/admin/images/logo/logo.png') }}">
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
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">{{ __('admin.products') }}</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.create') }}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products.index') }}" class="">
                                                <div class="text">{{ __('admin.products') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
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
                                <li class="menu-item">
                                    <a href="{{ route('admin.users.index') }}" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">{{ __('admin.users') }}</div>
                                    </a>
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
                                    <img class="" id="logo_header_mobile" alt="" src="{{ asset('assets/admin/images/logo/logo.png') }}"
                                        data-light="{{ asset('assets/admin/images/logo/logo.png') }}" data-dark="{{ asset('assets/admin/images/logo/logo.png') }}"
                                        data-width="154px" data-height="52px" data-retina="{{ asset('assets/admin/images/logo/logo.png') }}">
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
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">New discount codes available for customers</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">User account verification completed</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
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
                                                    <span class="body-title mb-2">{{ Auth::user()->name }}</span>
                                                    <span class="text-tiny">Admin</span>
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
                                                        <div class="body-title-2">Logout</div>
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
                            <div class="body-text">Copyright © 2024 SurfsideMedia</div>
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
        console.log('Document ready, jQuery loaded');
        console.log('Language toggle button exists:', $('#language-toggle').length > 0);
        console.log('Theme toggle button exists:', $('#theme-toggle').length > 0);
        console.log('Current locale from server:', '{{ app()->getLocale() }}');
        console.log('Language toggle href:', $('#language-toggle').attr('href'));
        
        // Language Toggle with Sweet Alert
        $(document).on('click', '#language-toggle', function(e) {
            e.preventDefault();
            console.log('Language toggle clicked');
            console.log('Button href:', $(this).attr('href'));
            
            const currentLang = '{{ app()->getLocale() }}';
            const newLang = currentLang === 'ar' ? 'en' : 'ar';
            const langText = newLang === 'ar' ? 'العربية' : 'English';
            
            console.log('Current locale:', currentLang, 'New locale:', newLang);
            
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
                console.log('Redirecting to:', $(this).attr('href'));
                window.location.href = $(this).attr('href');
            });
        });
        
        // Theme Toggle
        $(document).on('click', '#theme-toggle', function(e) {
            e.preventDefault();
            console.log('Theme toggle clicked');
            
            const body = $('body');
            const themeIcon = $('#theme-icon');
            
            if (body.hasClass('dark-theme')) {
                // Switch to light theme
                body.removeClass('dark-theme');
                themeIcon.removeClass('icon-moon').addClass('icon-sun');
                localStorage.setItem('theme', 'light');
                console.log('Switched to light theme');
            } else {
                // Switch to dark theme
                body.addClass('dark-theme');
                themeIcon.removeClass('icon-sun').addClass('icon-moon');
                localStorage.setItem('theme', 'dark');
                console.log('Switched to dark theme');
            }
        });
        
        // Load saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            $('body').addClass('dark-theme');
            $('#theme-icon').removeClass('icon-sun').addClass('icon-moon');
        }
    });
    </script>
    
    @stack('scripts')
</body>

</html>