<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
  <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? __('website.home') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="surfside media" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('assets/website/images/favicon.ico') }}" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.gstatic.com/">
  <link
    href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/website/css/plugins/swiper.min.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/website/css/custom.css') }}" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
    
  @stack('styles')
</head>

<body class="gradient-bg">
  <svg class="d-none">
    <symbol id="icon_nav" viewBox="0 0 25 18">
      <rect width="25" height="2" />
      <rect y="8" width="20" height="2" />
      <rect y="16" width="25" height="2" />
    </symbol>
    <symbol id="icon_facebook" viewBox="0 0 9 15">
      <path
        d="M7.62891 8.31543L8.01172 5.7998H5.57812V4.15918C5.57812 3.44824 5.90625 2.79199 7 2.79199H8.12109V0.631836C8.12109 0.631836 7.10938 0.44043 6.15234 0.44043C4.15625 0.44043 2.84375 1.6709 2.84375 3.8584V5.7998H0.601562V8.31543H2.84375V14.4404H5.57812V8.31543H7.62891Z" />
    </symbol>
    <symbol id="icon_twitter" viewBox="0 0 14 13">
      <path
        d="M12.5508 3.59668C13.0977 3.18652 13.5898 2.69434 13.9727 2.12012C13.4805 2.33887 12.9062 2.50293 12.332 2.55762C12.9336 2.20215 13.3711 1.65527 13.5898 0.97168C13.043 1.2998 12.4141 1.5459 11.7852 1.68262C11.2383 1.1084 10.5 0.780273 9.67969 0.780273C8.09375 0.780273 6.80859 2.06543 6.80859 3.65137C6.80859 3.87012 6.83594 4.08887 6.89062 4.30762C4.51172 4.1709 2.37891 3.02246 0.957031 1.2998C0.710938 1.70996 0.574219 2.20215 0.574219 2.74902C0.574219 3.7334 1.06641 4.6084 1.85938 5.12793C1.39453 5.10059 0.929688 4.99121 0.546875 4.77246V4.7998C0.546875 6.19434 1.53125 7.34277 2.84375 7.61621C2.625 7.6709 2.35156 7.72559 2.10547 7.72559C1.91406 7.72559 1.75 7.69824 1.55859 7.6709C1.91406 8.81934 2.98047 9.63965 4.23828 9.66699C3.25391 10.4326 2.02344 10.8975 0.683594 10.8975C0.4375 10.8975 0.21875 10.8701 0 10.8428C1.25781 11.6631 2.76172 12.1279 4.40234 12.1279C9.67969 12.1279 12.5508 7.78027 12.5508 3.97949C12.5508 3.84277 12.5508 3.7334 12.5508 3.59668Z" />
    </symbol>
    <symbol id="icon_instagram" viewBox="0 0 14 13">
      <path
        d="M7.125 3.2959C5.375 3.2959 3.98047 4.71777 3.98047 6.44043C3.98047 8.19043 5.375 9.58496 7.125 9.58496C8.84766 9.58496 10.2695 8.19043 10.2695 6.44043C10.2695 4.71777 8.84766 3.2959 7.125 3.2959ZM7.125 8.49121C6.00391 8.49121 5.07422 7.58887 5.07422 6.44043C5.07422 5.31934 5.97656 4.41699 7.125 4.41699C8.24609 4.41699 9.14844 5.31934 9.14844 6.44043C9.14844 7.58887 8.24609 8.49121 7.125 8.49121ZM11.1172 3.18652C11.1172 2.77637 10.7891 2.44824 10.3789 2.44824C9.96875 2.44824 9.64062 2.77637 9.64062 3.18652C9.64062 3.59668 9.96875 3.9248 10.3789 3.9248C10.7891 3.9248 11.1172 3.59668 11.1172 3.18652ZM13.1953 3.9248C13.1406 2.94043 12.9219 2.06543 12.2109 1.35449C11.5 0.643555 10.625 0.424805 9.64062 0.370117C8.62891 0.31543 5.59375 0.31543 4.58203 0.370117C3.59766 0.424805 2.75 0.643555 2.01172 1.35449C1.30078 2.06543 1.08203 2.94043 1.02734 3.9248C0.972656 4.93652 0.972656 7.97168 1.02734 8.9834C1.08203 9.96777 1.30078 10.8154 2.01172 11.5537C2.75 12.2646 3.59766 12.4834 4.58203 12.5381C5.59375 12.5928 8.62891 12.5928 9.64062 12.5381C10.625 12.4834 11.5 12.2646 12.2109 11.5537C12.9219 10.8154 13.1406 9.96777 13.1953 8.9834C13.25 7.97168 13.25 4.93652 13.1953 3.9248ZM11.8828 10.0498C11.6914 10.5967 11.2539 11.0068 10.7344 11.2256C9.91406 11.5537 8 11.4717 7.125 11.4717C6.22266 11.4717 4.30859 11.5537 3.51562 11.2256C2.96875 11.0068 2.55859 10.5967 2.33984 10.0498C2.01172 9.25684 2.09375 7.34277 2.09375 6.44043C2.09375 5.56543 2.01172 3.65137 2.33984 2.83105C2.55859 2.31152 2.96875 1.90137 3.51562 1.68262C4.30859 1.35449 6.22266 1.43652 7.125 1.43652C8 1.43652 9.91406 1.35449 10.7344 1.68262C11.2539 1.87402 11.6641 2.31152 11.8828 2.83105C12.2109 3.65137 12.1289 5.56543 12.1289 6.44043C12.1289 7.34277 12.2109 9.25684 11.8828 10.0498Z" />
    </symbol>
    <symbol id="icon_youtube" viewBox="0 0 16 11">
      <path
        d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z" />
    </symbol>
    <symbol id="icon_pinterest" viewBox="0 0 14 15">
      <path
        d="M13.5625 7.44043C13.5625 3.69434 10.5273 0.65918 6.78125 0.65918C3.03516 0.65918 0 3.69434 0 7.44043C0 10.3389 1.77734 12.7725 4.29297 13.7568C4.23828 13.2373 4.18359 12.417 4.32031 11.8154C4.45703 11.2959 5.11328 8.45215 5.11328 8.45215C5.11328 8.45215 4.92188 8.04199 4.92188 7.44043C4.92188 6.51074 5.46875 5.7998 6.15234 5.7998C6.72656 5.7998 7 6.2373 7 6.75684C7 7.33105 6.61719 8.20605 6.42578 9.02637C6.28906 9.68262 6.78125 10.2295 7.4375 10.2295C8.64062 10.2295 9.57031 8.97168 9.57031 7.13965C9.57031 5.49902 8.39453 4.37793 6.75391 4.37793C4.8125 4.37793 3.69141 5.82715 3.69141 7.30371C3.69141 7.90527 3.91016 8.53418 4.18359 8.8623C4.23828 8.91699 4.23828 8.99902 4.23828 9.05371C4.18359 9.27246 4.04688 9.7373 4.04688 9.81934C4.01953 9.95605 3.9375 9.9834 3.80078 9.92871C2.95312 9.51855 2.43359 8.28809 2.43359 7.27637C2.43359 5.14355 3.99219 3.1748 6.91797 3.1748C9.26953 3.1748 11.1016 4.87012 11.1016 7.1123C11.1016 9.43652 9.625 11.3232 7.57422 11.3232C6.89062 11.3232 6.23438 10.9678 6.01562 10.5303C6.01562 10.5303 5.6875 11.8428 5.60547 12.1436C5.44141 12.7451 5.03125 13.4834 4.75781 13.9209C5.38672 14.1396 6.07031 14.2217 6.78125 14.2217C10.5273 14.2217 13.5625 11.1865 13.5625 7.44043Z" />
    </symbol>
  </svg>

  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-inner">
        <div class="header-left">
          <div class="logo">
            <a href="{{ route('website.home') }}">
              <img src="{{ asset('assets/website/images/logo.png') }}" alt="{{ config('app.name') }}">
            </a>
          </div>
        </div>
        
        <div class="header-center">
          <div class="search-box">
            <form action="{{ route('website.search') }}" method="GET">
              <input type="text" name="q" placeholder="{{ __('website.search_products') }}" 
                     value="{{ request('q') }}">
              <button type="submit"><i class="fa fa-search"></i></button>
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
            
            @auth
              <div class="user-menu">
                <div class="dropdown">
                  <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('website.account.dashboard') }}">
                      <i class="fa fa-dashboard"></i> {{ __('website.my_account') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('website.orders.index') }}">
                      <i class="fa fa-shopping-bag"></i> {{ __('website.my_orders') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('website.wishlist.index') }}">
                      <i class="fa fa-heart"></i> {{ __('website.wishlist') }}</a></li>
                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                          <i class="fa fa-sign-out"></i> {{ __('website.logout') }}
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
            @else
              <div class="auth-buttons">
                <a href="{{ route('website.login') }}" class="btn btn-outline-light">
                  <i class="fa fa-sign-in"></i> {{ __('website.login') }}
                </a>
                <a href="{{ route('website.register') }}" class="btn btn-primary">
                  <i class="fa fa-user-plus"></i> {{ __('website.register') }}
                </a>
              </div>
            @endauth
            
            <div class="cart-icon">
              <a href="{{ route('website.cart.index') }}" class="cart-link">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-count">{{ session('cart', collect())->count() }}</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Navigation -->
  <nav class="navigation">
    <div class="container">
      <ul class="nav-list">
        <li class="nav-item {{ request()->routeIs('website.home') ? 'active' : '' }}">
          <a href="{{ route('website.home') }}">{{ __('website.home') }}</a>
        </li>
        <li class="nav-item {{ request()->routeIs('website.products.*') ? 'active' : '' }}">
          <a href="{{ route('website.products.index') }}">{{ __('website.products') }}</a>
        </li>
        <li class="nav-item {{ request()->routeIs('website.categories.*') ? 'active' : '' }}">
          <a href="{{ route('website.categories.index') }}">{{ __('website.categories') }}</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('website.contact') }}">{{ __('website.contact') }}</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('website.about') }}">{{ __('website.about') }}</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
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
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>{{ __('website.about_us') }}</h3>
          <p>{{ __('website.about_description') }}</p>
        </div>
        
        <div class="footer-section">
          <h3>{{ __('website.quick_links') }}</h3>
          <ul>
            <li><a href="{{ route('website.home') }}">{{ __('website.home') }}</a></li>
            <li><a href="{{ route('website.products.index') }}">{{ __('website.products') }}</a></li>
            <li><a href="{{ route('website.contact') }}">{{ __('website.contact') }}</a></li>
          </ul>
        </div>
        
        <div class="footer-section">
          <h3>{{ __('website.contact_info') }}</h3>
          <p>{{ __('website.contact_description') }}</p>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('website.all_rights_reserved') }}</p>
      </div>
    </div>
  </footer>

  <!-- JavaScript Files -->
  <script src="{{ asset('assets/website/js/plugins/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/website/js/plugins/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/website/js/plugins/swiper.min.js') }}"></script>
  <script src="{{ asset('assets/website/js/plugins/bootstrap-slider.min.js') }}"></script>
  <script src="{{ asset('assets/website/js/plugins/countdown.js') }}"></script>
  <script src="{{ asset('assets/website/js/theme.js') }}"></script>
  <script src="{{ asset('assets/website/js/main.js') }}"></script>
  
  @stack('scripts')
</body>
</html>