<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ asset('assets/fonts/SolaimanLipi.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        li,
        span,
        div {
            font-family: 'SolaimanLipi', sans-serif;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        {{-- Sidebar --}}
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light">NGO Admin</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">

                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>ড্যাশবোর্ড</p>
                            </a>
                        </li>

                        {{-- Home Sliders --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.home-sliders.index') }}"
                                class="nav-link {{ request()->routeIs('admin.home-sliders.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-images"></i>
                                <p>হোম স্লাইডার</p>
                            </a>
                        </li>

                        {{-- Menus & Submenus --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.menus.index') }}"
                                class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>মেনু ম্যানেজমেন্ট</p>
                            </a>
                        </li>

                        {{-- General Settings --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.general-settings.edit') }}"
                                class="nav-link {{ request()->routeIs('admin.general-settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>সাধারণ সেটিংস</p>
                            </a>
                        </li>

                        {{-- Team Members --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.team-members.index') }}"
                                class="nav-link {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>টিম মেম্বার</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.job-circulars.index') }}"
                                class="nav-link {{ request()->routeIs('admin.job-circulars.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>জব সার্কুলার</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.job-applications.index') }}"
                                class="nav-link {{ request()->routeIs('admin.job-applications.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-check"></i>
                                <p>জব আবেদন</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.gallery-events.index') }}"
                                class="nav-link {{ request()->routeIs('admin.gallery-events.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-images"></i>
                                <p>গ্যালারি ইভেন্টস</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.gallery-images.index') }}"
                                class="nav-link {{ request()->routeIs('admin.gallery-images.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-images"></i>
                                <p>গ্যালারি</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.notices.index') }}"
                                class="nav-link {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>নোটিশ বোর্ড</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.contact-messages.index') }}"
                                class="nav-link {{ request()->routeIs('contact-messages.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>যোগাযোগ বার্তা</p>
                            </a>
                        </li>




                    </ul>
                </nav>
            </div>

        </aside>

        {{-- Content --}}
        <div class="content-wrapper p-3">
            @yield('content')
        </div>

        <footer class="main-footer text-center">
            <strong>© {{ date('Y') }} NGO</strong>
        </footer>
    </div>

    {{-- AdminLTE JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @stack('scripts')

</body>

</html>
