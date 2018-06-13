@extends('layouts.default-web')

@section('styles')

    <!-- Bootstrap DateTimePicker -->
    <link rel="stylesheet" href="{{URL::to('js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card px-50 py-30 w-400px mx-auto" style="max-width: 100%">
                <h4 class="card-title">{{Lang::get('Iniciar Sesión')}}</h4>

                <div class="card-body">
                    <form id="login-form" method="POST" action="{{URL::to('login-user')}}">
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

                            <div class="form-group col-md-12">
                                <label for="password">{{ Lang::get('Contraseña') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-12 text-center mb-0">

                                <button type="submit" class="btn btn-primary w-full">
                                    {{ Lang::get('Acceder')  }}
                                </button>

                                <a class="btn btn-pure btn-purple mt-1" href="{{ route('password.request') }}">
                                    {{ __('¿Has olvidado tu contraseña?') }}
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted fs-13 mt-20">¿Aún no estás registrado? <a class="text-primary fw-500" href="{{URL::to('register')}}">Regístrate</a></p>
        </div>
    </div>

@endsection

@section('scripts')

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

    <script>

        $(document).ready(function () {

            var urlLoginUser = "{{URL::to('login-user')}}";

            $('#login-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    $('.preloader').fadeIn('slow');
                    form.submit();
                }
            });

        });

    </script>

@endsection
