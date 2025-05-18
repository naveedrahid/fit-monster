<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="app-brand-link text-decoration-none">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ asset('admin/img/logo.jpg') }}"  class="img-fluid" alt="" style="height: 70px;object-fit: cover;width: 240px;">
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
        <li class="menu-item {{ request()->is('backend') ? 'active open' : '' }}">
            <a href="{{ route('backend.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <!-- Roles & Permissions -->
        @if (auth()->user()->can('view role') || auth()->user()->can('view permission') || auth()->user()->can('view user'))
            <li
                class="menu-item {{ request()->is('backend/roles*') || request()->is('backend/permissions*') || request()->is('backend/users*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock"></i>
                    <div class="text-truncate">Roles & Permissions</div>
                </a>
                <ul class="menu-sub">
                    @can('view role')
                        <li class="menu-item {{ request()->is('backend/roles*') ? 'active' : '' }}">
                            <a href="{{ route('backend.roles.index') }}" class="menu-link">
                                <div class="text-truncate">Roles</div>
                            </a>
                        </li>
                    @endcan

                    @can('view permission')
                        <li class="menu-item {{ request()->is('backend/permissions*') ? 'active' : '' }}">
                            <a href="{{ route('backend.permissions.index') }}" class="menu-link">
                                <div class="text-truncate">Permissions</div>
                            </a>
                        </li>
                    @endcan

                    @can('view user')
                        <li class="menu-item {{ request()->is('backend/users*') ? 'active' : '' }}">
                            <a href="{{ route('backend.users.index') }}" class="menu-link">
                                <div class="text-truncate">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @can('view shift')
            <li class="menu-item {{ request()->is('backend/shifts*') ? 'active open' : '' }}">
                <a href="{{ route('backend.shifts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-smile"></i>
                    <div class="text-truncate">{{ __('Shifts') }}</div>
                </a>
            </li>
        @endcan
</aside>
