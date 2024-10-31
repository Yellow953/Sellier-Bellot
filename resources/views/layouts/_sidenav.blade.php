<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('home') }}"><img class="brand-logo"
                        alt="logo" src="{{ asset('assets/images/logo.png') }}" />
                    <h3 class="brand-text">Sellier & Bellot</h3>
                </a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a href="{{ route('home') }}"><i class="la la-dashboard"></i><span class="menu-title"
                        data-i18n="">Dashboard</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('users') }}"><i class="la la-user"></i><span class="menu-title"
                        data-i18n="">Users</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('customers') }}"><i class="la la-group"></i><span class="menu-title"
                        data-i18n="">Customers</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('guns') }}"><i class="la la-crosshairs"></i><span class="menu-title"
                        data-i18n="">Guns</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('corridors') }}"><i class="la la-bullseye"></i><span
                        class="menu-title" data-i18n="">Corridors</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('calibers') }}"><i class="la la-send-o"></i><span class="menu-title"
                        data-i18n="">Calibers</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('transactions') }}"><i class="la la-exchange"></i><span
                        class="menu-title" data-i18n="">Transactions</span></a>
            </li>
            <li class="nav-item"><a href="{{ route('logs') }}"><i class="la la-credit-card"></i><span class="menu-title"
                        data-i18n="">Logs</span></a>
            </li>
        </ul>
    </div>
    <div class="navigation-background"></div>
</div>