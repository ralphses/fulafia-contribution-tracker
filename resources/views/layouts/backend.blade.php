@php use Illuminate\Support\Facades\Auth; @endphp
    <!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <!--
      Available classes for <html> element:

      'dark'                  Enable dark mode - Default dark mode preference can be set in app.js file (always saved and retrieved in localStorage afterwards):
                                window.Codebase = new App({ darkMode: "system" }); // "on" or "off" or "system"
      'dark-custom-defined'   Dark mode is always set based on the preference in app.js file (no localStorage is used)
    -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Codebase - Bootstrap 5 Admin Template &amp; UI Framework</title>

    <meta name="description" content="Codebase - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Codebase - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description"
          content="Codebase - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/codebase/app.js'])

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/codebase/themes/corporate.scss', 'resources/js/codebase/app.js']) --}}

    <!-- Load and set dark mode preference (blocking script to prevent flashing) -->
    <script src="{{ asset('js/setTheme.js') }}"></script>
    @yield('js')
</head>

<body>
<div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
    <!-- Side Overlay-->
    <aside id="side-overlay">
        <!-- Side Header -->
        <div class="content-header">
            <!-- User Avatar -->
            <a class="img-link me-2" href="javascript:void(0)">
                <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
            </a>
            <!-- END User Avatar -->

            <!-- User Info -->
            <a class="link-fx text-body-color-dark fw-semibold fs-sm" href="javascript:void(0)">
                John Smith
            </a>
            <!-- END User Info -->

            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-danger ms-auto" data-toggle="layout"
                    data-action="side_overlay_close">
                <i class="fa fa-fw fa-times"></i>
            </button>
            <!-- END Close Side Overlay -->
        </div>
        <!-- END Side Header -->

        <!-- Side Content -->
        <div class="content-side">
            <p>
                Content..
            </p>
        </div>
        <!-- END Side Content -->
    </aside>
    <!-- END Side Overlay -->

    <nav id="sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header justify-content-lg-center">
                <!-- Logo -->
                <div>
            <span class="smini-visible fw-bold tracking-wide fs-lg">
              c<span class="text-primary">b</span>
            </span>
                    <a class="link-fx fw-bold tracking-wide mx-auto" href="/">
                        <img src="{{ asset('media/photos/logo_ful.png') }}" alt="Logo"
                             style="max-height: 50px; margin-right: 30px;">
                    </a>
                </div>
                <!-- END Logo -->

                <!-- Options -->
                <div>
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout"
                            data-action="sidebar_close">
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                    <!-- END Close Sidebar -->
                </div>
                <!-- END Options -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div class="js-sidebar-scroll">
                <!-- Side User -->

                <!-- END Side User -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <!-- Dashboard -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route("dashboard") }}">
                                <i class="nav-main-link-icon fa fa-house-user"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                            </a>
                        </li>

                        <!-- Contributions -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('contributions.recent') ? ' active' : '' }}" href="{{ route("contributions.recent") }}">
                                <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                                <span class="nav-main-link-name">Recent Contributions</span>
                            </a>
                        </li>

                        <!-- Contribution Schemes -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('contribution-schemes') ? ' active' : '' }}" href="{{ route('contributions.schemes') }}">
                                <i class="nav-main-link-icon fa fa-chart-line"></i>
                                <span class="nav-main-link-name">Contribution Schemes</span>
                            </a>
                        </li>

                        <!-- Cooperatives -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('cooperatives') ? ' active' : '' }}" href="{{ route('cooperatives') }}">
                                <i class="nav-main-link-icon fa fa-handshake"></i>
                                <span class="nav-main-link-name">Cooperatives</span>
                            </a>
                        </li>

                        <!-- My Contributions -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('my-contributions') ? ' active' : '' }}" href="{{ route('userContributions.user') }}">
                                <i class="nav-main-link-icon fa fa-wallet"></i>
                                <span class="nav-main-link-name">My Contributions</span>
                            </a>
                        </li>

                        <!-- Members Contributions -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('users-contributions') ? ' active' : '' }}" href="{{ route('userContributions.users') }}">
                                <i class="nav-main-link-icon fa fa-piggy-bank"></i>
                                <span class="nav-main-link-name">Members Contributions</span>
                            </a>
                        </li>

                        <!-- Staff -->
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('users') ? ' active' : '' }}" href="{{ route('users') }}">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">Members Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </div>

            <!-- END Sidebar Scrolling -->
        </div>
        <!-- Sidebar Content -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="space-x-1">
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- END Toggle Sidebar -->

                <!-- Open Search Section -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="header_search_on">
                    <i class="fa fa-fw fa-search"></i>
                </button>
                <!-- END Open Search Section -->

                <!-- Options -->
                <div class="dropdown d-inline-block">


                </div>
                <!-- END Options -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="space-x-1">
                <!-- User Dropdown -->
                <div class="d-inline-block">
                    <span class="d-none d-sm-inline-block fw-semibold">{{ Auth::user()->name }}</span>
                </div>

                <div class="d-inline-block">
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-alt-secondary"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt d-sm-none"></i>
                        <span class="d-none d-sm-inline-block fw-semibold">Logout</span>
                    </a>

                    <!-- Logout Form (hidden, but necessary for the POST request) -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Loader -->
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="far fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        @yield('content')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold"
                                                                               href="https://pixelcave.com"
                                                                               target="_blank">pixelcave</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="https://pixelcave.com/products/codebase" target="_blank">Codebase</a>
                    &copy; <span data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Page Container -->
</body>

</html>
