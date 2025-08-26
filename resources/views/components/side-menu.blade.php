<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="app-brand-link text-decoration-none">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ asset('admin/img/logo.jpg') }}" class="img-fluid" alt=""
                        style="height: 70px;object-fit: cover;width: 240px;">
                </span>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('/') ? 'active open' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <!-- Roles & Permissions -->
        @if (auth()->user()->can('view role') || auth()->user()->can('view permission'))
            <li class="menu-item {{ request()->is('roles*') || request()->is('permissions*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock"></i>
                    <div class="text-truncate">Roles & Permissions</div>
                </a>
                <ul class="menu-sub">
                    @can('view role')
                        <li class="menu-item {{ request()->is('roles*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}" class="menu-link">
                                <div class="text-truncate">Roles</div>
                            </a>
                        </li>
                    @endcan

                    @can('view permission')
                        <li class="menu-item {{ request()->is('permissions*') ? 'active' : '' }}">
                            <a href="{{ route('permissions.index') }}" class="menu-link">
                                <div class="text-truncate">Permissions</div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endif

        @can(['view package', 'view addon'])
            <li class="menu-item {{ request()->is('packages*') || request()->is('addons*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class=" bx bx-lock"></i> --}}
                    <i class="menu-icon tf-icons fas fa-cubes"></i>
                    <div class="text-truncate">Packages & Addons</div>
                </a>
                <ul class="menu-sub">
                    @can('view package')
                        <li class="menu-item {{ request()->is('packages*') ? 'active' : '' }}">
                            <a href="{{ route('packages.index') }}" class="menu-link">
                                <div class="text-truncate">Packages</div>
                            </a>
                        </li>
                    @endcan

                    @can('view addon')
                        <li class="menu-item {{ request()->is('addons*') ? 'active' : '' }}">
                            <a href="{{ route('addons.index') }}" class="menu-link">
                                <div class="text-truncate">Addons</div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @can('view user')
            <li class="menu-item {{ request()->is('users*') ? 'active open' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fas fa-users"></i>
                    <div class="text-truncate">Users</div>
                </a>
            </li>
        @endcan
        @can('view shift')
            <li class="menu-item {{ request()->is('shifts*') ? 'active open' : '' }}">
                <a href="{{ route('shifts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fas fa-retweet"></i>
                    <div class="text-truncate">{{ __('Shifts') }}</div>
                </a>
            </li>
        @endcan
        @can('view payment')
            <li class="menu-item {{ request()->is('payments*') ? 'active open' : '' }}">
                <a href="{{ route('payments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fas fa-credit-card"></i>
                    <div class="text-truncate">{{ __('Payment') }}</div>
                </a>
            </li>
        @endcan
</aside>
