<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{{ app()->getLocale() }}" lang="{{ app()->getLocale() }}">

<head>
    <title>{{ config('app.name', 'Laravel') }} - {{ __('admin.admin_panel') }}</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/custom.css') }}">
    
    @stack('styles')
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">
                <!-- Sidebar -->
                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.dashboard') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt="" src="{{ asset('assets/admin/images/logo/logo.png') }}"
                                data-light="{{ asset('assets/admin/images/logo/logo.png') }}" 
                                data-dark="{{ asset('assets/admin/images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.main_home') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">{{ __('admin.dashboard') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.products') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.products.index') }}">
                                        <div class="icon"><i class="icon-bag"></i></div>
                                        <div class="text">{{ __('admin.all_products') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.products.create') }}">
                                        <div class="icon"><i class="icon-plus"></i></div>
                                        <div class="text">{{ __('admin.add_product') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.categories') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.index') }}">
                                        <div class="icon"><i class="icon-category"></i></div>
                                        <div class="text">{{ __('admin.all_categories') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.create') }}">
                                        <div class="icon"><i class="icon-plus"></i></div>
                                        <div class="text">{{ __('admin.add_category') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.orders') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.orders.index') }}">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">{{ __('admin.all_orders') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.users') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.users.index') }}">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">{{ __('admin.all_users') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="center-item">
                            <div class="center-heading">{{ __('admin.settings') }}</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.settings.index') }}">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">{{ __('admin.settings') }}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="section-main">
                    <!-- Header -->
                    <div class="header">
                        <div class="header-left">
                            <div class="header-search">
                                <form action="{{ route('admin.products.index') }}" method="GET">
                                    <input type="text" name="search" placeholder="{{ __('admin.search_products') }}" 
                                           value="{{ request('search') }}">
                                    <button type="submit"><i class="icon-search"></i></button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="header-right">
                            <div class="header-actions">
                                <div class="language-switcher">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-globe"></i> {{ app()->getLocale() == 'ar' ? 'عربي' : 'English' }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" 
                                                   href="{{ route('locale', 'ar') }}">
                                                    <i class="fa fa-flag"></i> عربي
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" 
                                                   href="{{ route('locale', 'en') }}">
                                                    <i class="fa fa-flag"></i> English
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="user-menu">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="icon-user"></i> {{ Auth::user()->name }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                                                    <i class="icon-settings"></i> {{ __('admin.settings') }}
                                                </a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="icon-logout"></i> {{ __('admin.logout') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="content">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Files -->
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    
    @stack('scripts')
</body>
</html>