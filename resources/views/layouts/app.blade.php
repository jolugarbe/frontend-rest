<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Bootstrap SelectPicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

    <!-- Bootstrap DateTimePicker -->
    <link rel="stylesheet" href="{{URL::to('js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Datatables -->
    <link rel="stylesheet" href="{{URL::to('js/plugins/datatables/datatables.css')}}">

    <style>
        body{
            font-family: Raleway,sans-serif !important;
        }

        /**
            Loader
         */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{URL::to('images/loader/loader.gif')}}') center no-repeat #fff;
        }

    </style>

    @yield('styles')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(!Cookie::get('front_us_token'))
                            <li><a class="nav-link" href="{{ route('login') }}">{{ Lang::get('Acceder') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ Lang::get('Registrar') }}</a></li>
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Cookie::get('front_us_data')) {{Request::cookie('front_us_data', null)}} @else  Usuario @endif <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}"> {{ __('Panel de control') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ Lang::get('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout_user') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="loader"></div>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- JQUERY VALIDATE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

    <!-- Additional method for validate CIF/NIF with jQueryValidator -->
    <script src="{{URL::to('js/plugins/jquery-validate/my-additional-methods.js')}}"></script>
    <!-- Spanish messages for jQueryValidator -->
    <script src="{{URL::to('js/plugins/jquery-validate/localization/messages_es.js')}}"></script>
    <!-- END JQUERY VALIDATE -->

    <!-- BOOTSTRAP SELECTPICKER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!-- DATETIMEPICKER -->
    <script src="{{URL::to('js/plugins/datetimepicker/js/moment.min.js')}}"></script>
    <script src="{{URL::to('js/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::to('js/plugins/datetimepicker/js/moment-es.js')}}"></script>

    <!-- DATATABLES -->
    <script src="{{URL::to('js/plugins/datatables/datatables.js')}}"></script>

    <script src="{{URL::to('js/plugins/sweetalert2/sweetalert2.js')}}"></script>
    <script>

        $(window).on('load',function() {
            // Animate loader off screen
            $(".loader").fadeOut("slow");
        });

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
