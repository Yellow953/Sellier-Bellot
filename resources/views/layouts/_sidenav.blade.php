<div class="d-flex">
    <!-- Sidebar -->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" id="sidebar">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="#">
                        <img class="brand-logo" alt="logo" src="{{ asset('assets/images/logo.png') }}" />
                        <h3 class="brand-text">Sellier & Bellot</h3>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ request()->routeIs('home*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('home') }}">
                        <i class="la la-dashboard"></i>
                        <span class="menu-title  {{ request()->routeIs('home*') ? 'text-white' : '' }}"
                            data-i18n="">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('users*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('users') }}">
                        <i class="la la-user"></i>
                        <span class="menu-title {{ request()->routeIs('users*') ? 'text-white' : '' }}"
                            data-i18n="">Users</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('customers*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('customers') }}">
                        <i class="la la-group"></i>
                        <span class="menu-title {{ request()->routeIs('customers*') ? 'text-white' : '' }}"
                            data-i18n="">Customers</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('transactions*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('transactions') }}">
                        <i class="la la-exchange"></i>
                        <span class="menu-title {{ request()->routeIs('transactions*') ? 'text-white' : '' }}"
                            data-i18n="">Transactions</span>
                    </a>
                </li>
                @if (auth()->user()->role == 'admin')
                <li class="nav-item {{ request()->routeIs('guns*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('guns') }}">
                        <i class="la la-crosshairs"></i>
                        <span class="menu-title  {{ request()->routeIs('guns*') ? 'text-white' : '' }}"
                            data-i18n="">Guns</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('corridors*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('corridors') }}">
                        <i class="la la-bullseye"></i>
                        <span class="menu-title  {{ request()->routeIs('corridors*') ? 'text-white' : '' }}"
                            data-i18n="">Corridors</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('calibers*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('calibers') }}">
                        <i class="la la-send-o"></i>
                        <span class="menu-title {{ request()->routeIs('calibers*') ? 'text-white' : '' }}"
                            data-i18n="">Calibers</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('logs*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('logs') }}">
                        <i class="la la-credit-card"></i>
                        <span class="menu-title {{ request()->routeIs('logs*') ? 'text-white' : '' }}"
                            data-i18n="">Logs</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('backup*') ? 'bg-dark' : '' }}">
                    <a class="nav-link px-custom" href="{{ route('backup') }}">
                        <i class="la la-server"></i>
                        <span class="menu-title {{ request()->routeIs('backup*') ? 'text-white' : '' }}"
                            data-i18n="">Backup</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="navigation-background"></div>
    </div>
</div>