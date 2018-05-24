@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')
                <div class="card">
                    <div class="card-header">{{Lang::get('Registrar empresa')}}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{URL::to('register-user')}}">
                            @csrf

                            <div class="row">
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
                                    <label for="email">{{ Lang::get('Email') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

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

                            <div class="row">
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')

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
                    $(".loader").fadeIn("slow");
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

@endsection
