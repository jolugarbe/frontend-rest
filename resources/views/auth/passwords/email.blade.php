<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="register, signup">

    <title>Recuperar contraseña &mdash; CAFA</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{URL::to('css/core.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/app.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/style.min.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{URL::to('images/theme/apple-touch-icon.png')}}">
    <link rel="icon" href="{{URL::to('images/theme/favicon.png')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{URL::to('vendor/sweetalert2/sweetalert2.css')}}">

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

<div class="row">
    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <div class="mt-20">
            @include('site.includes.notifications')
        </div>
        <div class="card card-shadowed mt-25">
            <header class="card-header">
                <h4 class="card-title"><strong>BOLSA DE RESIDUOS</strong></h4>
                <a class="btn btn-purple" href="#">Volver</a>
            </header>
        </div>
        <div class="card card-shadowed mt-25 px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h4 class="card-title">{{Lang::get('Recuperar Contraseña')}}</h4>

            <div class="card-body">
                <form id="reset-form" method="POST" action="{{URL::to('user/email-reset')}}">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="email">{{ Lang::get('Email') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-12 text-center mb-0">

                            <button type="submit" class="btn btn-primary w-full">
                                {{ Lang::get('Recuperar')  }}
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <footer class="col-12 align-self-end text-center fs-13">
        <p class="mb-0"><small>Copyright © 2018 <a href="#">CAFA</a>. Todos los derechos reservados.</small></p>
    </footer>
</div>

<!-- Scripts -->
<script src="{{URL::to('js/core.min.js')}}"></script>
<script src="{{URL::to('js/app.min.js')}}"></script>
<script src="{{URL::to('js/script.min.js')}}"></script>

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

<script>

    $(document).ready(function () {

        var urlResetPass = "{{URL::to('user/email-reset')}}";

        $('#reset-form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });

</script>

</body>
</html>