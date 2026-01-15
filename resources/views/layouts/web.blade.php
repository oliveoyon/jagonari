<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Jagonari')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

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

        /* Force Bangla font on header menus */
        /* Nav menu font fix and size */
        #navmenu ul li a,
        #navmenu ul li a span {
            font-family: 'SolaimanLipi', sans-serif;
            /* Bangla font */
            font-size: 1.1rem;
            /* slightly larger than default */
            font-weight: 500;
        }

        /* Dropdown arrows spacing */
        #navmenu ul li a i.toggle-dropdown {
            margin-left: 5px;
        }

        /* Optional: make topbar contact info use Bangla font too */
        .topbar .contact-info,
        .topbar .contact-info span,
        .topbar .contact-info a {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 0.95rem;
        }

        /* Optional: footer menu font */
        .footer-links h4,
        .footer-links ul li a {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 1rem;
        }
    </style>

</head>


<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center light-background">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:{{ general_setting('email1') }}">{{ general_setting('email1') }}</a></i>
                    <i
                        class="bi bi-phone d-flex align-items-center ms-4"><span>{{ general_setting('phone1') }}</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="{{ general_setting('twitter_url') }}" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="{{ general_setting('facebook_url') }}" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="{{ general_setting('linkedin_url') }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="{{ Storage::url(general_setting('logo', 'default-logo.png')) }}" alt="">

                    {{-- <h1 class="sitename">Flattern</h1> --}}
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ url('/') }}">হোম</a></li>
                        @foreach (get_menus() as $menu)
                            <li class="{{ $menu->children->count() ? 'dropdown' : '' }}">
                                <a href="{{ url($menu->slug) }}">
                                    <span>{{ $menu->title }}</span>
                                    @if ($menu->children->count())
                                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                                    @endif
                                </a>

                                @if ($menu->children->count())
                                    <ul>
                                        @foreach ($menu->children as $child)
                                            <li class="{{ $child->children->count() ? 'dropdown' : '' }}">
                                                <a href="{{ url($child->slug) }}">
                                                    <span>{{ $child->title }}</span>
                                                    @if ($child->children->count())
                                                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                                                    @endif
                                                </a>

                                                @if ($child->children->count())
                                                    <ul>
                                                        @foreach ($child->children as $grandchild)
                                                            <li>
                                                                <a
                                                                    href="{{ url($grandchild->slug) }}">{{ $grandchild->title }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach

                        <li><a href="{{ url('/jobs') }}">জব সার্কুলার</a></li>
                        <li><a href="{{ url('/contact') }}">যোগাযোগ</a></li>
                    </ul>

                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>


            </div>

        </div>

    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer dark-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">

                    {{-- Static About / Contact --}}
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                            <span class="sitename">
                                {{ general_setting('site_name', 'My Website') }}
                            </span>
                        </a>

                        <div class="footer-contact pt-3">
                            @if (general_setting('address'))
                                <p>{!! nl2br(e(general_setting('address'))) !!}</p>
                            @endif

                            @if (general_setting('phone1'))
                                <p class="mt-3">
                                    <strong>Phone:</strong>
                                    <span>{{ general_setting('phone1') }}</span>
                                </p>
                            @endif

                            @if (general_setting('email1'))
                                <p>
                                    <strong>Email:</strong>
                                    <span>{{ general_setting('email1') }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Dynamic Footer Menus (2nd, 3rd, 4th Parent Menus) --}}
                    @foreach (get_menus()->slice(1, 4) as $menu)
                        <div class="col-lg-2 col-md-3 footer-links">
                            <h4>{{ $menu->title }}</h4>

                            @if ($menu->children->count())
                                <ul>
                                    @foreach ($menu->children as $child)
                                        <li>
                                            <a href="{{ url($child->slug) }}">
                                                {{ $child->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="copyright text-center">
            <div
                class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div>
                        © {{ now()->year }}
                        <strong>
                            <span>{{ general_setting('site_name', 'My Website') }}</span>
                        </strong>.
                        All Rights Reserved
                    </div>

                    @if (general_setting('footer_text'))
                        <div class="credits">
                            {!! general_setting('footer_text') !!}
                        </div>
                    @endif
                </div>

                {{-- Social Links --}}
                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    @if (general_setting('twitter_url'))
                        <a href="{{ general_setting('twitter_url') }}"><i class="bi bi-twitter-x"></i></a>
                    @endif
                    @if (general_setting('facebook_url'))
                        <a href="{{ general_setting('facebook_url') }}"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if (general_setting('linkedin_url'))
                        <a href="{{ general_setting('linkedin_url') }}"><i class="bi bi-linkedin"></i></a>
                    @endif
                </div>

            </div>
        </div>

    </footer>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
