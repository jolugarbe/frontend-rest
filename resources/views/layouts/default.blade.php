<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="blank, starter">

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

    <!-- Datatables -->
    <link rel="stylesheet" href="{{URL::to('js/plugins/datatables/datatables.css')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{URL::to('vendor/sweetalert2/sweetalert2.css')}}">

    <!-- Bootstrap DateTimePicker -->
    <link rel="stylesheet" href="{{URL::to('js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Bootstrap SelectPicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

    <style>

        .sidebar-header{
            background-color: transparent; !important;
        }

    </style>
    @yield('styles')

</head>

<body>

<!-- Preloader -->
<div class="preloader">
    <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>


<!-- Sidebar -->
<aside id="menu-left" class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg">
    <header class="sidebar-header">
        <a class="logo-icon" href="{{URL::to('home')}}"><img src="{{URL::to('images/theme/logo-icon-light.png')}}" alt="logo icon"></a>
        <span class="logo">
          <a href="{{URL::to('home')}}"><img src="{{URL::to('images/theme/logo-light.png')}}" alt="logo"></a>
        </span>
        <span class="sidebar-toggle-fold"></span>
    </header>

    <nav class="sidebar-navigation">
        <ul class="menu">

            <li class="menu-category">Mi Perfil</li>

            <li class="menu-item active">
                <a class="menu-link" href="{{URL::to('/home')}}">
                    <span class="icon fa fa-home"></span>
                    <span class="title">Panel de Control</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{URL::to('user/profile')}}">
                    <span class="icon fa fa-user"></span>
                    <span class="title">Mi Perfil</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-cube"></span>
                    <span class="title">Mis Residuos</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">
                    <li class="menu-item">
                        <a class="menu-link" href="{{URL::to('waste/user/published')}}">
                            <span class="dot"></span>
                            <span class="title">Publicaciones</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{URL::to('waste/user/transfers')}}">
                            <span class="dot"></span>
                            <span class="title">Cesiones</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{URL::to('waste/user/requests')}}">
                            <span class="dot"></span>
                            <span class="title">Solicitudes</span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="menu-category">Bolsa Residuos</li>


            <li class="menu-item">
                <a class="menu-link" href="{{URL::to('waste/available')}}">
                    <span class="icon ti-layout"></span>
                    <span class="title">Disponibles</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="{{URL::to('waste/demand')}}">
                    <span class="icon ti-layout"></span>
                    <span class="title">Demandados</span>
                </a>
            </li>

            <li class="menu-category">Sesión</li>


            <li class="menu-item">
                <a class="menu-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <span class="icon fa fa-window-close"></span>
                    <span class="title">Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout_user') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </nav>

</aside>
<!-- END Sidebar -->


<!-- Topbar -->
<header id="top-bar" class="topbar">
    <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
        <a class="topbar-btn d-none d-md-block" href="#" data-provide="fullscreen tooltip" title="" data-original-title="Fullscreen">
            <i class="material-icons fullscreen-default">fullscreen</i>
            <i class="material-icons fullscreen-active">fullscreen_exit</i>
        </a>
        @yield('title')
    </div>

    <div class="topbar-right">
        @yield('breadcrumb')
    </div>
</header>
<!-- END Topbar -->


<!-- Main container -->
<main class="main-container">
    <div class="main-content">

        @include('site.includes.notifications')

        @yield('content')


    </div><!--/.main-content -->


    <!-- Footer -->
    <footer class="site-footer">
        <div class="row">
            <div class="col-md-6 text-center text-md-left d-flex align-items-center">
                <a href="http://www.dipusevilla.es/" target="_blank"><img class="img-responsive" style="height: 65px; width: 65px" src="{{URL::to('images/diputacion-sevilla.png')}}" alt="logo"></a>
                <a class="ml-10" href="http://www.dipusevilla.es/" target="_blank"><strong>Cofinanciado por la Diputación de Sevilla.</strong></a>
                {{--<p class="text-center text-md-left">Copyright © 2018 <a target="_blank" href="http://centrocafa.com/">CAFA</a>. Todos los derechos reservados.</p>--}}
            </div>

            <div class="col-md-6">
                <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="#">Condiciones de uso</a>--}}
                    {{--</li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('preguntas-frecuentes')}}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('politica-privacidad')}}">Política de privacidad</a>
                    </li>
                </ul>
                {{--<p class="text-center text-sm-center text-md-right">Copyright © 2018 <a target="_blank" href="http://centrocafa.com/">CAFA</a>. Todos los derechos reservados.</p>--}}
            </div>
        </div>
    </footer>
    <!-- END Footer -->

</main>
<!-- END Main container -->



<!-- Global quickview -->
<div id="qv-global" class="quickview" data-url="assets/data/quickview-global.html">
    <div class="spinner-linear">
        <div class="line"></div>
    </div>
</div>
<!-- END Global quickview -->



<!-- Scripts -->
<script src="{{URL::to('js/core.min.js')}}"></script>
<script src="{{URL::to('js/app.min.js')}}"></script>
<script src="{{URL::to('js/script.min.js')}}"></script>

<!-- DataTables -->
<script src="{{URL::to('js/plugins/datatables/datatables.js')}}"></script>

<!-- SweetAlert2 -->
<script src="{{URL::to('vendor/sweetalert2/sweetalert2.js')}}"></script>

<!-- jQuery Validate -->
<script src="{{URL::to('js/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{URL::to('js/plugins/jquery-validate/additional-methods.min.js')}}"></script>
<!-- Additional method for validate CIF/NIF with jQueryValidator -->
<script src="{{URL::to('js/plugins/jquery-validate/my-additional-methods.js')}}"></script>
<!-- Spanish messages for jQueryValidator -->
<script src="{{URL::to('js/plugins/jquery-validate/localization/messages_es.js')}}"></script>
<!-- End jQuery Validate -->

<!-- DateTimePicker -->
<script src="{{URL::to('js/plugins/datetimepicker/js/moment.min.js')}}"></script>
<script src="{{URL::to('js/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::to('js/plugins/datetimepicker/js/moment-es.js')}}"></script>


<script>

    // jQuery Validate Default Settings
    jQuery.validator.setDefaults({
        debug: false,
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback').appendTo(element.parent());
        }
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

</script>
@yield('scripts')

</body>
</html>
