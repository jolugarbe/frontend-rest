@extends('layouts.default')

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
        <li class="breadcrumb-item active" style="display: inline"><a href="{{URL::to('user/profile')}}">Mi Perfil</a></li>
        {{--<li class="breadcrumb-item active" style="display: inline"><a href="#">Cesión</a></li>--}}
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{Lang::get('Mi perfil')}}</h4>
            </div>

            <div class="card-body">
                <form id="update-form" method="POST" action="{{URL::to('user/update')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-light fw-400">Datos de la Empresa</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ Lang::get('Nombre') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($user) ? $user['name'] : null) }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="activity">Sector/Actividad</label>
                            <select class="form-control show-tick" id="activity" name="activity" required data-width="100%" data-dropup-auto="false">
                                <option value="">Seleccione un sector</option>
                                @foreach($activities as $activity)
                                    <optgroup label="Grupo {{$activity['group']}}">
                                        <option @if(isset($user) && $user['activity_id'] == $activity['id']) selected="selected" @endif value="{{$activity['id']}}">{{$activity['name']}}</option>
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
                            <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name', isset($user) ? $user['business_name'] : null) }}" required>
                            @if ($errors->has('business_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('business_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cif">{{ Lang::get('CIF/NIF') }}</label>
                            <input id="cif" type="text" class="form-control{{ $errors->has('cif') ? ' is-invalid' : '' }}" name="cif" value="{{ old('cif', isset($user) ? $user['cif'] : null) }}" required>
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
                            <input id="contact_person" type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ old('contact_person', isset($user) ? $user['contact_person'] : null) }}" required>
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
                            <input id="telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone', isset($user) ? $user['telephone'] : null) }}" required>
                            @if ($errors->has('telephone'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">{{ Lang::get('Email') }} <small>(Se utiliza para acceder a la plataforma)</small></label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($user) ? $user['email'] : null) }}" required>
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
                            <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line', isset($address) ? $address['address_line'] : null) }}" required>
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
                            <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code', isset($address) ? $address['postal_code'] : null) }}" required>
                            @if ($errors->has('postal_code'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label for="province">Provincia</label>
                            <select class="form-control show-tick" id="province" name="province" required data-dropup-auto="false">
                                <option value="">Seleccione provincia</option>
                                @foreach($provinces as $province)
                                    <option @if(isset($province_id) && $province_id == $province['id']) selected="selected" @endif value="{{$province['id']}}">{{$province['name']}}</option>
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
                            <select class="form-control show-tick" id="locality" name="locality" required data-dropup-auto="false">
                                <option value="">Seleccione localidad</option>
                                @foreach($localities as $locality)
                                    <option @if(isset($address) && $address['locality_id'] == $locality['id']) selected="selected" @endif value="{{$locality['id']}}">{{$locality['name']}}</option>
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
                            <select class="form-control show-tick" id="carbon_footprint" name="carbon_footprint" required data-dropup-auto="false">
                                <option @if(isset($user) && $user['carbon_footprint'] == 0) selected="selected" @endif value="0">NO</option>
                                <option @if(isset($user) && $user['carbon_footprint'] == 1) selected="selected" @endif value="1">SÍ</option>
                            </select>
                            @if ($errors->has('carbon_footprint'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('carbon_footprint') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="carbon_inscription">{{ Lang::get('Fecha de inscripción') }}</label>
                            <input id="carbon_inscription" type="text" class="form-control{{ $errors->has('carbon_inscription') ? ' is-invalid' : '' }}" name="carbon_inscription" value="{{ old('carbon_inscription', isset($user) && $user['carbon_inscription'] ? \Carbon\Carbon::createFromFormat('Y-m-d', $user['carbon_inscription'])->format('d/m/Y') : null) }}" @if(isset($user) && $user['carbon_footprint'] == 0) disabled @endif>
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
                                <input id="not_address_line" type="text" class="form-control{{ $errors->has('not_address_line') ? ' is-invalid' : '' }}" name="not_address_line" value="{{ old('not_address_line', isset($not_address) ? $not_address['address_line'] : null) }}" required>
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
                                <input id="not_postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('not_postal_code') ? ' is-invalid' : '' }}" name="not_postal_code" value="{{ old('not_postal_code', isset($not_address) ? $not_address['postal_code'] : null) }}" required>
                                @if ($errors->has('not_postal_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_postal_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="not_province">Provincia</label>
                                <select class="form-control show-tick" id="not_province" name="not_province" required data-dropup-auto="false">
                                    <option value="">Seleccione provincia</option>
                                    @foreach($provinces as $province)
                                        <option @if(isset($not_province_id) && $not_province_id == $province['id']) selected="selected" @endif value="{{$province['id']}}">{{$province['name']}}</option>
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
                                <select class="form-control show-tick" id="not_locality" name="not_locality" required data-dropup-auto="false">
                                    <option value="">Seleccione localidad</option>
                                    @foreach($localities as $locality)
                                        <option @if(isset($not_address) && $not_address['locality_id'] == $locality['id']) selected="selected" @endif value="{{$locality['id']}}">{{$locality['name']}}</option>
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
                                <input id="not_contact_person" type="text" class="form-control{{ $errors->has('not_contact_person') ? ' is-invalid' : '' }}" name="not_contact_person" value="{{ old('not_contact_person', isset($notification) ? $notification['contact_person'] : null) }}" required>
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
                                <input id="not_telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('not_telephone') ? ' is-invalid' : '' }}" name="not_telephone" value="{{ old('not_telephone', isset($notification) ? $notification['telephone'] : null) }}" required>
                                @if ($errors->has('not_telephone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_telephone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="not_email">{{ Lang::get('Email') }}</label>
                                <input id="not_email" type="email" class="form-control{{ $errors->has('not_email') ? ' is-invalid' : '' }}" name="not_email" value="{{ old('not_email', isset($notification) ? $notification['email'] : null) }}" required>
                                @if ($errors->has('not_email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right btn-submit">
                                {{__('Actualizar')}}
                            </button>
                        </div>
                    </div>
                </form>
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
            var localities = @json($localities);

            var urlRegisterUser = "{{URL::to('user/update')}}";

            $('#update-form').validate({
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
                    $('.btn-submit').prop('disabled', true);
                    $(".preloader").fadeIn("slow");
                    form.submit();

                }
            });

            $('#province').on('change changed.bs.select', function () {

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

            $('#not_province').on('change changed.bs.select', function () {

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
                    $('#carbon_inscription').prop('disabled', true).removeClass('is-invalid').removeClass('invalid-feedback');
                }
            });

            $('#carbon_inscription').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

        });

    </script>

@endsection
