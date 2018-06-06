<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <header class="card-header">
                <h4 class="card-title">{{__('Empresa solicitante')}}</h4>
                <ul class="card-controls">
                    <li><a class="card-btn-slide" href="#"></a></li>
                </ul>
            </header>
            <div class="card-content">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-light fw-400">Datos de la Empresa</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">{{ Lang::get('Nombre') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($request_user) ? $request_user['name'] : null) }}" required readonly="readonly">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="business_name">{{ Lang::get('Razón social') }}</label>
                                <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name', isset($request_user) ? $request_user['business_name'] : null) }}" required readonly="readonly">
                                @if ($errors->has('business_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('business_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="activity">Sector/Actividad</label>
                                <input id="activity" type="text" class="form-control{{ $errors->has('activity') ? ' is-invalid' : '' }}" name="activity" value="{{ old('activity', isset($request_activity) ? $request_activity : null) }}" required readonly="readonly">
                                @if ($errors->has('activity'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('activity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="cif">{{ Lang::get('CIF/NIF') }}</label>
                                <input id="cif" type="text" class="form-control{{ $errors->has('cif') ? ' is-invalid' : '' }}" name="cif" value="{{ old('cif', isset($request_user) ? $request_user['cif'] : null) }}" required readonly="readonly">
                                @if ($errors->has('cif'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('cif') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telephone">{{ Lang::get('Teléfono') }}</label>
                                <input id="telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone', isset($request_user) ? $request_user['telephone'] : null) }}" required readonly="readonly">
                                @if ($errors->has('telephone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="email">{{ Lang::get('Email') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($request_user) ? $request_user['email'] : null) }}" required readonly="readonly">
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
                                <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line', isset($request_address) ? $request_address['address_line'] : null) }}" required readonly="readonly">
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
                                <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code', isset($request_address) ? $request_address['postal_code'] : null) }}" required readonly="readonly">
                                @if ($errors->has('postal_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="province">Provincia</label>
                                <input id="province" type="text" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ old('province', isset($request_province) ? $request_province : null) }}" required readonly="readonly">
                                @if ($errors->has('province'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="locality">Localidad</label>
                                <input id="locality" type="text" class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}" name="locality" value="{{ old('locality', isset($request_locality) ? $request_locality : null) }}" required readonly="readonly">
                                @if ($errors->has('locality'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('locality') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        {{--<div class="row">--}}
                        {{--<div class="form-group col-md-12">--}}
                        {{--<label for="contact_person">{{ Lang::get('Persona de contacto') }}</label>--}}
                        {{--<input id="contact_person" type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ old('contact_person', isset($request_user) ? $request_user['contact_person'] : null) }}" required readonly="readonly">--}}
                        {{--@if ($errors->has('contact_person'))--}}
                        {{--<span class="invalid-feedback">--}}
                        {{--<strong>{{ $errors->first('contact_person') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                        {{--</div>--}}
                        {{--</div>--}}



                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-light fw-400">Huella de Carbono</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="carbon_footprint">Inscrita en el Registro de Huella de Carbono</label>
                                <input id="carbon_footprint" type="text" class="form-control{{ $errors->has('carbon_footprint') ? ' is-invalid' : '' }}" name="carbon_footprint" value="{{ old('carbon_footprint', isset($request_user) ? $request_user['carbon_footprint'] == 1 ? "SÍ" : "NO" : null) }}" required readonly="readonly">
                                @if ($errors->has('carbon_footprint'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('carbon_footprint') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="carbon_inscription">{{ Lang::get('Fecha de inscripción') }}</label>
                                <input id="carbon_inscription" type="text" class="form-control{{ $errors->has('carbon_inscription') ? ' is-invalid' : '' }}" name="carbon_inscription" value="{{ old('carbon_inscription', isset($request_user) ? $request_user['carbon_inscription'] ? \Carbon\Carbon::createFromFormat('Y-m-d',$request_user['carbon_inscription'])->format('d/m/Y') : "" : null) }}" required readonly="readonly">
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
        </div>
    </div>
</div>