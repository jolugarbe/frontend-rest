<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>{{__('EMPRESA SOLICITANTE')}}</strong></h3>
            </div>
            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color: darkslategrey">Datos de la Empresa</h4>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ Lang::get('Nombre') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($request_user) ? $request_user['name'] : null) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="business_name">{{ Lang::get('Razón social') }}</label>
                            <input id="business_name" type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name', isset($request_user) ? $request_user['business_name'] : null) }}">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="activity">Sector/Actividad</label>
                            <input id="activity" type="text" class="form-control{{ $errors->has('activity') ? ' is-invalid' : '' }}" name="activity" value="{{ old('activity', isset($request_activity) ? $request_activity : null) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cif">{{ Lang::get('CIF/NIF') }}</label>
                            <input id="cif" type="text" class="form-control{{ $errors->has('cif') ? ' is-invalid' : '' }}" name="cif" value="{{ old('cif', isset($request_user) ? $request_user['cif'] : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="telephone">{{ Lang::get('Teléfono') }}</label>
                            <input id="telephone" type="number" minlength="9" maxlength="9" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone', isset($request_user) ? $request_user['telephone'] : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="email">{{ Lang::get('Email') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($request_user) ? $request_user['email'] : null) }}">
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color: darkslategrey">Dirección</h4>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address_line">{{ Lang::get('Domicilio') }}</label>
                            <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line', isset($request_address) ? $request_address['address_line'] : null) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="postal_code">{{ Lang::get('Código postal') }}</label>
                            <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code', isset($request_address) ? $request_address['postal_code'] : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="province">Provincia</label>
                            <input id="province" type="text" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ old('province', isset($request_province) ? $request_province : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="locality">Localidad</label>
                            <input id="locality" type="text" class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}" name="locality" value="{{ old('locality', isset($request_locality) ? $request_locality : null) }}">
                        </div>
                    </div>

                    {{--<hr>--}}

                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<h4 style="color: darkslategrey">Huella de Carbono</h4>--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-md-6">--}}
                            {{--<label for="carbon_footprint">Inscrita en el Registro de Huella de Carbono</label>--}}
                            {{--<input id="carbon_footprint" type="text" class="form-control{{ $errors->has('carbon_footprint') ? ' is-invalid' : '' }}" name="carbon_footprint" value="{{ old('carbon_footprint', isset($request_user) ? $request_user['carbon_footprint'] == 1 ? "SÍ" : "NO" : null) }}">--}}
                        {{--</div>--}}

                        {{--<div class="form-group col-md-6">--}}
                            {{--<label for="carbon_inscription">{{ Lang::get('Fecha de inscripción') }}</label>--}}
                            {{--<input id="carbon_inscription" type="text" class="form-control{{ $errors->has('carbon_inscription') ? ' is-invalid' : '' }}" name="carbon_inscription" value="{{ old('carbon_inscription', isset($request_user) ? $request_user['carbon_inscription'] ? \Carbon\Carbon::createFromFormat('Y-m-d',$request_user['carbon_inscription'])->format('d/m/Y') : "" : null) }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </form>
            </div>
        </div>
    </div>
</div>