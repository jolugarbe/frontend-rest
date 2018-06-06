<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="register, signup">

    <title>Registrar Empresa &mdash; CAFA</title>

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
                <h4 class="card-title"><strong>BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES</strong></h4>
                <a class="btn btn-purple" href="#">Volver</a>
            </header>
        </div>
        <div class="card card-shadowed mt-25">
            <div class="card-header">
                <h4 class="card-title">{{Lang::get('Registrar Empresa')}}</h4>
            </div>

            <div class="card-body">
                <form id="register-form" method="POST" action="{{URL::to('register-user')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-light fw-400">Datos de la Empresa</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ Lang::get('Nombre') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="activity">Sector/Actividad</label>
                            <select class="form-control" id="activity" name="activity" required>
                                <option value="">Seleccione un sector</option>
                                @foreach($activities['activities'] as $activity)
                                    <optgroup label="Grupo {{$activity['group']}}">
                                        <option value="{{$activity['id']}}">{{$activity['name']}}</option>
                                    </optgroup>
                                @endforeach
                            </select>
                            @if ($errors->has('activity'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('activity') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="business_name">{{ Lang::get('Razón social') }}</label>
                            <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name') }}" required>
                            @if ($errors->has('business_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('business_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cif">{{ Lang::get('CIF/NIF') }}</label>
                            <input id="cif" type="text" class="form-control{{ $errors->has('cif') ? ' is-invalid' : '' }}" name="cif" value="{{ old('cif') }}" required>
                            @if ($errors->has('cif'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('cif') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="contact_person">{{ Lang::get('Persona de contacto') }}</label>
                            <input id="contact_person" type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ old('contact_person') }}" required>
                            @if ($errors->has('contact_person'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact_person') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="telephone">{{ Lang::get('Teléfono') }}</label>
                            <input id="telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone') }}" required>
                            @if ($errors->has('telephone'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">{{ Lang::get('Email') }} <small>(Se utiliza para acceder a la plataforma)</small></label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-light fw-400">Dirección</h5>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="address_line">{{ Lang::get('Domicilio') }}</label>
                            <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line') }}" required>
                            @if ($errors->has('address_line'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_line') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="postal_code">{{ Lang::get('Código postal') }}</label>
                            <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code') }}" required>
                            @if ($errors->has('postal_code'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="province">Provincia</label>
                            <select class="form-control" id="province" name="province" required>
                                <option value="">Seleccione provincia</option>
                                @foreach($provinces['provinces'] as $province)
                                    <option value="{{$province['id']}}">{{$province['name']}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('province'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="locality">Localidad</label>
                            <select class="form-control" data-live-search="true" id="locality" name="locality" required>
                                <option value="">Seleccione localidad</option>
                                @foreach($localities['localities'] as $locality)
                                    <option value="{{$locality['id']}}">{{$locality['name']}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('locality'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('locality') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-light fw-400">Huella de Carbono</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="carbon_footprint">Inscrita en el Registro de Huella de Carbono</label>
                            <select class="form-control" data-live-search="true" id="carbon_footprint" name="carbon_footprint" required>
                                <option value="0">NO</option>
                                <option value="1">SÍ</option>
                            </select>
                            @if ($errors->has('carbon_footprint'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('carbon_footprint') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="carbon_inscription">{{ Lang::get('Fecha de inscripción') }}</label>
                            <input id="carbon_inscription" type="text" class="form-control{{ $errors->has('carbon_inscription') ? ' is-invalid' : '' }}" name="carbon_inscription" value="{{ old('carbon_inscription') }}" required disabled>
                            @if ($errors->has('carbon_inscription'))
                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carbon_inscription') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="checkbox" value="1" id="notification_data" name="notification_data">
                            <label for="notification_data">
                                Datos a efecto de notificación <small>(Marcar y cumplimentar en caso de ser distintos a los introducidos)</small>
                            </label>
                        </div>
                    </div>

                    <fieldset id="form_notification_data" style="display: none" disabled>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-light fw-400">Datos a efecto de notificación</h5>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="not_address_line">{{ Lang::get('Domicilio') }}</label>
                                <input id="not_address_line" type="text" class="form-control{{ $errors->has('not_address_line') ? ' is-invalid' : '' }}" name="not_address_line" value="{{ old('not_address_line') }}" required>
                                @if ($errors->has('not_address_line'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_address_line') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="not_postal_code">{{ Lang::get('Código postal') }}</label>
                                <input id="not_postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('not_postal_code') ? ' is-invalid' : '' }}" name="not_postal_code" value="{{ old('not_postal_code') }}" required>
                                @if ($errors->has('not_postal_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_postal_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="not_province">Provincia</label>
                                <select class="form-control" id="not_province" name="not_province" required>
                                    <option value="">Seleccione provincia</option>
                                    @foreach($provinces['provinces'] as $province)
                                        <option value="{{$province['id']}}">{{$province['name']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('not_province'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_province') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="not_locality">Localidad</label>
                                <select class="form-control" data-live-search="true" id="not_locality" name="not_locality" required>
                                    <option value="">Seleccione localidad</option>
                                    @foreach($localities['localities'] as $locality)
                                        <option value="{{$locality['id']}}">{{$locality['name']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('not_locality'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_locality') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="not_contact_person">{{ Lang::get('Persona de contacto') }}</label>
                                <input id="not_contact_person" type="text" class="form-control{{ $errors->has('not_contact_person') ? ' is-invalid' : '' }}" name="not_contact_person" value="{{ old('not_contact_person') }}" required>
                                @if ($errors->has('not_contact_person'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_contact_person') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="not_telephone">{{ Lang::get('Teléfono') }}</label>
                                <input id="not_telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('not_telephone') ? ' is-invalid' : '' }}" name="not_telephone" value="{{ old('not_telephone') }}" required>
                                @if ($errors->has('not_telephone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_telephone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="not_email">{{ Lang::get('Email') }}</label>
                                <input id="not_email" type="email" class="form-control{{ $errors->has('not_email') ? ' is-invalid' : '' }}" name="not_email" value="{{ old('not_email') }}" required>
                                @if ($errors->has('not_email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                    {{--<div class="form-group row">--}}
                    {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                    {{--<div class="col-md-6">--}}
                    {{--<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>--}}

                    {{--@if ($errors->has('email'))--}}
                    {{--<span class="invalid-feedback">--}}
                    {{--<strong>{{ $errors->first('email') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group row">--}}
                    {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                    {{--<div class="col-md-6">--}}
                    {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

                    {{--@if ($errors->has('password'))--}}
                    {{--<span class="invalid-feedback">--}}
                    {{--<strong>{{ $errors->first('password') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group row">--}}
                    {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

                    {{--<div class="col-md-6">--}}
                    {{--<input id="password-confirm" type="password" class="form-control" name="confirm_password" required>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center text-muted fs-13 mt-20">¿Ya estás registrado? <a class="text-primary fw-500" href="#">Inicia sesión</a></p>
    </div>


    <footer class="col-12 align-self-end text-center fs-13">
        <p class="mb-0"><small>Copyright © 2018 <a href="#">CAFA</a>. Todos los derechos reservados.</small></p>
    </footer>
</div>

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

<script>

    function filterLocalities(province_id, id) {
        return province_id = id;
    }

    $(document).ready(function () {

        // Convert localities received from PHP to sorted array in javascript.
        var localities = @json($localities['localities']);

        var urlRegisterUser = "{{URL::to('register-user')}}";

        $('#register-form').validate({
            rules: {
                "name": {
                    required: true
                },
                "activity": {
                    required: true
                },
                "business_name": {
                    required: true
                },
                "cif": {
                    required: true,
                    identificacionES: true
                },
                "address_line": {
                    required: true
                },
                "postal_code": {
                    required: true
                },
                "province": {
                    required: true
                },
                "locality": {
                    required: true
                },
                "contact_person": {
                    required: true
                },
                "telephone": {
                    required: true
                },
                "not_address_line": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_postal_code": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_province": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_locality": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_contact_person": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_telephone": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    }
                },
                "not_email": {
                    required: function () {
                        return $('#notification_data').is(':checked');
                    },
                    email: true
                },
                "email": {
                    required: true,
                    email: true
                },
                "carbon_footprint": {
                    required: true
                },
                "carbon_inscription": {
                    required: function () {
                        return $('#carbon_footprint').val() == 1 ? true : false;
                    }
                },
//                    "password": {
//                        required: true
//                    },
//                    "confirm_password": {
//                        required: true,
//                        equalTo: '#password'
//                    }
            },
            submitHandler: function (form) {
                $(".preloader").fadeIn("slow");
                form.submit();

            }
        });

        $('#province').change(function () {

            // Get array of the localities that belong to the selected province
            var province_id = $(this).val();
            var filter = jQuery.grep(localities, function( item ) {
                return item.province_id == province_id ;
            });

            var options = "<option value=''>Seleccione localidad</option>";
            filter.forEach(function (locality) {
                options += "<option value='" +locality.id+"'>"+locality.name+"</option>";
            });

            $('#locality').empty().append(options);
        });

        $('#not_province').change(function () {

            // Get array of the localities that belong to the selected province
            var province_id = $(this).val();
            var filter = jQuery.grep(localities, function( item ) {
                return item.province_id == province_id ;
            });

            var options = "<option value=''>Seleccione localidad</option>";
            filter.forEach(function (locality) {
                options += "<option value='" +locality.id+"'>"+locality.name+"</option>";
            });

            $('#not_locality').empty().append(options);
        });

        $('#notification_data').change(function () {
            var checked = $(this).is(':checked');

            if(checked){
                $('#form_notification_data').prop('disabled', false).fadeIn('slow');
            } else {
                $('#form_notification_data').fadeOut('slow', function () {
                    $('#form_notification_data').prop('disabled', true);
                });
            }
        });

        $('#carbon_footprint').change(function () {
            var register = $(this).val();

            if(register == 1){
                $('#carbon_inscription').prop('disabled', false);
            } else{
                $('#carbon_inscription').prop('disabled', true);
            }
        });

        $('#carbon_inscription').datetimepicker({
            locale: 'es',
            format: 'DD/MM/YYYY'
        });

    });

</script>

</body>
</html>
