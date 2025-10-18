<!-- Header -->
<header class="admin-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-link text-white d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                        <i class="icon-menu" style="font-size: 1.5rem;"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <div>
                        <h1 class="h3 mb-0">@yield('page-title', __('admin.dashboard'))</h1>
                        @hasSection('page-subtitle')
                            <p class="mb-0 opacity-75">@yield('page-subtitle')</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link text-white position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="icon-bell" style="font-size: 1.2rem;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ __('admin.notifications') }}</h6></li>
                            <li><a class="dropdown-item" href="#">{{ __('admin.new_order') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ __('admin.new_review') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ __('admin.system_update') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">{{ __('admin.view_all') }}</a></li>
                        </ul>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-link text-white d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="me-2">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="icon-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-start">
                                <div class="fw-bold">{{ auth()->user()->name }}</div>
                                <small class="opacity-75">{{ __('admin.admin') }}</small>
                            </div>
                            <i class="icon-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="icon-user me-2"></i>{{ __('admin.profile') }}
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}">
                                <i class="icon-settings me-2"></i>{{ __('admin.settings') }}
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="icon-log-out me-2"></i>{{ __('admin.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

