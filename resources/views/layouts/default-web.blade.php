<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <script src="{{URL::to('vendor/typeahead/typeahead.jquery.min.js')}}"></script>
    <script src="{{URL::to('vendor/typeahead/bloodhound.min.js')}}"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bolsa de residuos reutilizables y reciclables">
    <meta name="keywords" content="layouts, boxed">

    <title>Bolsa de Residuos &mdash; CAFA</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{URL::to('css/core.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/app.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/style.min.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{URL::to('images/theme/apple-touch-icon.png')}}">
    <link rel="icon" href="{{URL::to('images/theme/favicon.png')}}">

    @yield('styles')

</head>

<body class="  pace-done"><div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div></div>

<!-- Preloader -->
<div class="preloader" style="display: none;">
    <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>





<!-- Topbar -->
<header class="topbar topbar-expand-lg">
    <div class="container">
        <div class="topbar-left">
            <span class="topbar-btn topbar-menu-toggler"><i>☰</i></span>
            <span class="topbar-brand"><img src="{{URL::to('images/theme/full-logo-black-2.png')}}" alt="logo"></span>

            <div class="topbar-divider d-none d-xl-block"></div>

            <nav class="topbar-navigation">
                <ul class="menu">

                    <li class="menu-item">
                        <a class="menu-link" href="../index.html">
                            <span class="title">Sección 1</span>
                        </a>
                    </li>


                    <li class="menu-item active">
                        <a class="menu-link" href="#">
                            <span class="title">Sección 2</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="title">Sección 3</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="title">Sección 4</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="title">Sección 5</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

        <div class="topbar-right">
            <ul class="menu d-none d-lg-block d-xl-block">
                @if(Cookie::get('front_us_token'))
                    <li class="menu-item">
                        <a class="menu-link" href="{{ url('/home') }}">
                            <span class="title">Panel de control</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <span class="title">Cerrar sesión</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout_user') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('login') }}">
                            <span class="title">Acceder</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('register') }}">
                            <span class="title">Registrarme</span>
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="topbar-btns d-block d-lg-none">
                @if(Cookie::get('front_us_token'))
                    <li class="dropdown show">
                        <span class="topbar-btn" data-toggle="dropdown" aria-expanded="true"><i class="ti-user"></i></span>
                        <div class="dropdown-menu dropdown-menu-right show" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 65px; left: -120px;">
                            <a class="dropdown-item" href="{{ route('home') }}"><i class="ti-settings"></i> Panel de control</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> Cerrar sesión</a>
                            <form id="logout-form" action="{{ route('logout_user') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="dropdown show">
                        <span class="topbar-btn" data-toggle="dropdown" aria-expanded="true"><i class="ti-user"></i></span>
                        <div class="dropdown-menu dropdown-menu-right show" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 65px; left: -120px;">
                            <a class="dropdown-item" href="{{ route('login') }}"><i class="ti-user"></i> Acceder</a>
                            <a class="dropdown-item" href="{{ route('register') }}"><i class="ti-email"></i> Registrarme</a>
                        </div>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</header>
<!-- END Topbar -->





<!-- Main container -->
<main class="main-container">

    <div class="main-content container">

        <div>
            @include('site.includes.notifications')
        </div>

        @yield('content')

    </div><!--/.main-content -->


    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-center text-md-left">Copyright © 2018 <a target="_blank" href="http://centrocafa.com/">CAFA</a>. Todos los derechos reservados.</p>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Condiciones de uso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Política de privacidad</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->

</main>
<!-- END Main container -->



<!-- Global quickview -->
<div id="qv-global" class="quickview" data-url="../assets/data/quickview-global.html">
    <div class="spinner-linear">
        <div class="line"></div>
    </div>
</div>
<!-- END Global quickview -->



<!-- Scripts -->
<script src="{{URL::to('js/core.min.js')}}"></script>
<script src="{{URL::to('js/app.min.js')}}"></script>
<script src="{{URL::to('js/script.min.js')}}"></script>

@yield('scripts')

</body>
</html>