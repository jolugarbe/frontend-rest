<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>@if(isset($is_request)){{__('RESIDUO SOLICITADO')}} @elseif(isset($is_transfer)) {{__('RESIDUO CEDIDO')}} @endif</strong></h3>
            </div>
            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color: darkslategrey">Datos básicos</h4>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ Lang::get('Nombre') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($waste) ? $waste['name'] : null) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="waste_type">{{__('Tipo de residuo')}}</label>
                            <input id="waste_type" type="text" class="form-control{{ $errors->has('waste_type') ? ' is-invalid' : '' }}" name="waste_type" value="{{ old('waste_type', isset($type) ? $type : null) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="description">{{__('Descripción')}}</label>
                            <textarea class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="description" name="description" rows="3">{{ old('description', isset($waste) ? $waste['description'] : null) }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="quantity">{{ __('Cantidad') }}</label>
                            <input id="quantity" type="number" min="1" step="0.1" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity', isset($waste) ? $waste['quantity'] : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="measured_unit">{{ __('Unidad de medida') }}</label>
                            <input id="measured_unit" type="text" class="form-control{{ $errors->has('measured_unit') ? ' is-invalid' : '' }}" name="measured_unit" value="{{ old('measured_unit', isset($waste) ? $waste['measured_unit'] : null) }}" placeholder="{{__('m2, Kg, Tm...')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="frequency">{{__('Frecuencia')}}</label>
                            <input id="frequency" type="text" class="form-control{{ $errors->has('frequency') ? ' is-invalid' : '' }}" name="frequency" value="{{ old('frequency', isset($frequency) ? $frequency : null) }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="cer_code">{{ __('Código CER') }}</label>
                            <input id="cer_code" type="text" class="form-control{{ $errors->has('cer_code') ? ' is-invalid' : '' }}" name="cer_code" value="{{ old('cer_code', isset($cer_code) ? $cer_code['code'].' - '.$cer_code['name'] : null) }}">
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color: darkslategrey">Datos adicionales</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="composition">{{ __('Composición') }}</label>
                                    <input id="composition" type="text" class="form-control{{ $errors->has('composition') ? ' is-invalid' : '' }}" name="composition" value="{{ old('composition', isset($waste) ? $waste['composition'] : null) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="dangerous">{{__('Peligroso')}}</label>
                                    <input id="dangerous" type="text" class="form-control{{ $errors->has('dangerous') ? ' is-invalid' : '' }}" name="dangerous" value="{{ old('dangerous', isset($waste) ? $waste['dangerous'] == 1 ? "SÍ" : "NO" : null) }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="production">{{ __('Producción') }}</label>
                                    <input id="production" type="text" class="form-control{{ $errors->has('production') ? ' is-invalid' : '' }}" name="production" value="{{ old('production', isset($waste) ? $waste['production'] : null) }}">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="handling">{{__('Manipulación')}}</label>
                                    <textarea class="form-control {{ $errors->has('handling') ? ' is-invalid' : '' }}" id="handling" name="handling" rows="4">{{ old('handling', isset($waste) ? $waste['handling'] : null) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="packaging">{{ __('Embalaje') }}</label>
                            <input id="packaging" type="text" class="form-control{{ $errors->has('packaging') ? ' is-invalid' : '' }}" name="packaging" value="{{ old('packaging', isset($waste) ? $waste['packaging'] : null) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="transport">{{ __('Transporte') }}</label>
                            <input id="transport" type="text" class="form-control{{ $errors->has('transport') ? ' is-invalid' : '' }}" name="transport" value="{{ old('transport', isset($waste) ? $waste['transport'] : null) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="presentation">{{ __('Presentación') }}</label>
                            <input id="presentation" type="text" class="form-control{{ $errors->has('presentation') ? ' is-invalid' : '' }}" name="presentation" value="{{ old('presentation', isset($waste) ? $waste['presentation'] : null) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="generation_date">{{ __('Fecha de generación') }}</label>
                            <input id="generation_date" type="text" class="form-control{{ $errors->has('generation_date') ? ' is-invalid' : '' }}" name="generation_date" value="{{ old('generation_date', isset($waste) ? \Carbon\Carbon::createFromFormat('Y-m-d', $waste['generation_date'])->format('d/m/Y') : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="pickup_date">{{ __('Fecha de recogida') }}</label>
                            <input id="pickup_date" type="text" class="form-control{{ $errors->has('pickup_date') ? ' is-invalid' : '' }}" name="pickup_date" value="{{ old('pickup_date', isset($waste) ? \Carbon\Carbon::createFromFormat('Y-m-d', $waste['pickup_date'])->format('d/m/Y') : null) }}">
                        </div>
                    </div>

                    <hr>



                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color: darkslategrey">Ubicación</h4>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address_line">{{ Lang::get('Dirección') }}</label>
                            <input id="address_line" type="text" class="form-control{{ $errors->has('address_line') ? ' is-invalid' : '' }}" name="address_line" value="{{ old('address_line', isset($address) ? $address['address_line'] : null) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="postal_code">{{ Lang::get('Código postal') }}</label>
                            <input id="postal_code" type="number" minlength="5" maxlength="5" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code', isset($address) ? $address['postal_code'] : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="province">Provincia</label>
                            <input id="province" type="text" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ old('province', isset($province) ? $province : null) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="locality">Localidad</label>
                            <input id="locality" type="text" class="form-control{{ $errors->has('locality') ? ' is-invalid' : '' }}" name="locality" value="{{ old('locality', isset($locality) ? $locality : null) }}">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>