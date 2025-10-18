<!-- Sidebar -->
<div class="admin-sidebar">
    <div class="p-4">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/admin/images/logo/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
        </div>
        
        <!-- Navigation Menu -->
        <nav class="mt-4">
            <ul class="list-unstyled">
                <!-- Dashboard -->
                <li class="menu-item {{ request()->routeIs('admin.dashboard*') || request()->routeIs('admin') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-home"></i></div>
                            <div class="text">{{ __('admin.dashboard') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Products -->
                <li class="menu-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-box"></i></div>
                            <div class="text">{{ __('admin.products') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Categories -->
                <li class="menu-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-grid"></i></div>
                            <div class="text">{{ __('admin.categories') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Orders -->
                <li class="menu-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-shopping-cart"></i></div>
                            <div class="text">{{ __('admin.orders') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Users -->
                <li class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-users"></i></div>
                            <div class="text">{{ __('admin.users') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Coupons -->
                <li class="menu-item {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupons.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-ticket"></i></div>
                            <div class="text">{{ __('admin.coupons') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Reviews -->
                <li class="menu-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reviews.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-star"></i></div>
                            <div class="text">{{ __('admin.reviews') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Statistics -->
                <li class="menu-item {{ request()->routeIs('admin.statistics*') ? 'active' : '' }}">
                    <a href="{{ route('admin.statistics.products') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-bar-chart"></i></div>
                            <div class="text">{{ __('admin.statistics') }}</div>
                        </div>
                    </a>
                </li>


                <!-- Settings -->
                <li class="menu-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-settings"></i></div>
                            <div class="text">{{ __('admin.settings') }}</div>
                        </div>
                    </a>
                </li>

                <!-- Profile -->
                <li class="menu-item {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile') }}">
                        <div class="d-flex align-items-center">
                            <div class="icon me-3"><i class="icon-user"></i></div>
                            <div class="text">{{ __('admin.profile') }}</div>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
