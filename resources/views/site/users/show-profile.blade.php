@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')
                <div class="card">
                    <div class="card-header">{{__('Ver empresa')}}</div>

                    <div class="card-body">
                        <form id="show-form" method="POST">
                            @csrf

                            @if(isset($user))
                                <input type="hidden" name="waste_id" value="{{$user['id']}}">
                            @endif
                            @if(isset($address))
                                <input type="hidden" name="address_id" value="{{$address['id']}}">
                            @endif

                            @if(isset($notification))
                                <input type="hidden" name="notification_id" value="{{$notification['id']}}">
                            @endif

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ Lang::get('Nombre') }}</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($user) ? $user['name'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="activity">Sector/Actividad</label>
                                    <input id="activity" type="text" class="form-control{{ $errors->has('activity') ? ' is-invalid' : '' }}" name="activity" value="{{ old('activity', isset($activity) ? $activity : null) }}" required readonly="readonly">
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
                                    <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name', isset($user) ? $user['business_name'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('business_name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('business_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cif">{{ Lang::get('CIF/NIF') }}</label>
                                    <input id="cif" type="text" class="form-control{{ $errors->has('cif') ? ' is-invalid' : '' }}" name="cif" value="{{ old('cif', isset($user) ? $user['cif'] : null) }}" required readonly="readonly">
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
                                    <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line', isset($address) ? $address['address_line'] : null) }}" required readonly="readonly">
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
                                    <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code', isset($address) ? $address['postal_code'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('postal_code'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="province">Provincia</label>
                                    <input id="province" type="text" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ old('province', isset($province) ? $province : null) }}" required readonly="readonly">
                                    @if ($errors->has('province'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="locality">Localidad</label>
                                    <input id="locality" type="text" class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}" name="locality" value="{{ old('locality', isset($locality) ? $locality : null) }}" required readonly="readonly">
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
                                    <input id="contact_person" type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ old('contact_person', isset($user) ? $user['contact_person'] : null) }}" required readonly="readonly">
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
                                    <input id="telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone', isset($user) ? $user['telephone'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('telephone'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">{{ Lang::get('Email') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($user) ? $user['email'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="carbon_footprint">Inscrita en el Registro de Huella de Carbono</label>
                                    <input id="carbon_footprint" type="text" class="form-control{{ $errors->has('carbon_footprint') ? ' is-invalid' : '' }}" name="carbon_footprint" value="{{ old('carbon_footprint', isset($user) ? $user['carbon_footprint'] == 1 ? "SÍ" : "NO" : null) }}" required readonly="readonly">
                                    @if ($errors->has('carbon_footprint'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('carbon_footprint') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="carbon_inscription">{{ Lang::get('Fecha de inscripción') }}</label>
                                    <input id="carbon_inscription" type="text" class="form-control{{ $errors->has('carbon_inscription') ? ' is-invalid' : '' }}" name="carbon_inscription" value="{{ old('carbon_inscription', isset($user) ? $user['carbon_inscription'] ? \Carbon\Carbon::createFromFormat('Y-m-d',$user['carbon_inscription'])->format('d/m/Y') : "" : null) }}" required readonly="readonly">
                                    @if ($errors->has('carbon_inscription'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carbon_inscription') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">{{__('Datos a efecto de notificación')}}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{isset($waste) ? URL::to('user/update') : URL::to('user/create')}}">
                            @csrf

                            @if(isset($user))
                                <input type="hidden" name="waste_id" value="{{$user['id']}}">
                            @endif
                            @if(isset($address))
                                <input type="hidden" name="address_id" value="{{$address['id']}}">
                            @endif

                            @if(isset($notification))
                                <input type="hidden" name="notification_id" value="{{$notification['id']}}">
                            @endif

                            <fieldset id="form_notification_data">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="not_address_line">{{ Lang::get('Domicilio') }}</label>
                                        <input id="not_address_line" type="text" class="form-control{{ $errors->has('not_address_line') ? ' is-invalid' : '' }}" name="not_address_line" value="{{ old('not_address_line', isset($not_address) ? $not_address['address_line'] : null) }}" required readonly="readonly">
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
                                        <input id="not_postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('not_postal_code') ? ' is-invalid' : '' }}" name="not_postal_code" value="{{ old('not_postal_code', isset($not_address) ? $not_address['postal_code'] : null) }}" required readonly="readonly">
                                        @if ($errors->has('not_postal_code'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_postal_code') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="not_province">Provincia</label>
                                        <input id="not_province" type="text" class="form-control{{ $errors->has('not_province') ? ' is-invalid' : '' }}" name="not_province" value="{{ old('not_province', isset($not_province) ? $not_province : null) }}" required readonly="readonly">
                                        @if ($errors->has('not_province'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_province') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="not_locality">Localidad</label>
                                        <input id="not_locality" type="text" class="form-control{{ $errors->has('not_locality') ? ' is-invalid' : '' }}" name="not_locality" value="{{ old('not_locality', isset($not_locality) ? $not_locality : null) }}" required readonly="readonly">
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
                                        <input id="not_contact_person" type="text" class="form-control{{ $errors->has('not_contact_person') ? ' is-invalid' : '' }}" name="not_contact_person" value="{{ old('not_contact_person', isset($notification) ? $notification['contact_person'] : null) }}" required readonly="readonly">
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
                                        <input id="not_telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('not_telephone') ? ' is-invalid' : '' }}" name="not_telephone" value="{{ old('not_telephone', isset($notification) ? $notification['telephone'] : null) }}" required readonly="readonly">
                                        @if ($errors->has('not_telephone'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_telephone') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="not_email">{{ Lang::get('Email') }}</label>
                                        <input id="not_email" type="email" class="form-control{{ $errors->has('not_email') ? ' is-invalid' : '' }}" name="not_email" value="{{ old('not_email', isset($notification) ? $notification['email'] : null) }}" required readonly="readonly">
                                        @if ($errors->has('not_email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('not_email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

    </script>

@endsection
