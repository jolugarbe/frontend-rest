@extends('layouts.default-admin')

@section('styles')

@endsection

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('CAFA | BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES')}}</h4>--}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
        <li class="breadcrumb-item" style="display: inline"><a href="#">Residuos</a></li>
        <li class="breadcrumb-item active" style="display: inline"><a href="#">Ver datos</a></li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">

                <header class="card-header">
                    <h4 class="card-title">{{__('Ver Residuo')}}</h4>
                    <ul class="card-controls">
                        <li><a class="card-btn-slide" href="#"></a></li>
                    </ul>
                </header>

                <div class="card-content">
                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{isset($waste) ? URL::to('waste/update') : URL::to('waste/create')}}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-light fw-400">Datos básicos</h5>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">{{ Lang::get('Nombre') }}</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($waste) ? $waste['name'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="waste_type">{{__('Tipo de residuo')}}</label>
                                    <input id="waste_type" type="text" class="form-control{{ $errors->has('waste_type') ? ' is-invalid' : '' }}" name="waste_type" value="{{ old('waste_type', isset($type) ? $type : null) }}" required readonly="readonly">
                                    @if ($errors->has('waste_type'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('waste_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">{{__('Descripción')}}</label>
                                    <textarea class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="description" name="description" rows="3" readonly="readonly">{{ old('description', isset($waste) ? $waste['description'] : null) }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="quantity">{{ __('Cantidad') }}</label>
                                    <input id="quantity" type="number" min="1" step="0.1" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity', isset($waste) ? $waste['quantity'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="measured_unit">{{ __('Unidad de medida') }}</label>
                                    <input id="measured_unit" type="text" class="form-control{{ $errors->has('measured_unit') ? ' is-invalid' : '' }}" name="measured_unit" value="{{ old('measured_unit', isset($waste) ? $waste['measured_unit'] : null) }}" placeholder="{{__('m2, Kg, Tm...')}}" required readonly="readonly">
                                    @if ($errors->has('measured_unit'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('measured_unit') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group col-md-4">
                                    <label for="frequency">{{__('Frecuencia')}}</label>
                                    <input id="frequency" type="text" class="form-control{{ $errors->has('frequency') ? ' is-invalid' : '' }}" name="frequency" value="{{ old('frequency', isset($frequency) ? $frequency : null) }}" required readonly="readonly">
                                    @if ($errors->has('frequency'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('frequency') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="cer_code">{{ __('Código CER') }}</label>
                                    <input id="cer_code" type="text" class="form-control{{ $errors->has('cer_code') ? ' is-invalid' : '' }}" name="cer_code" value="{{ old('cer_code', isset($cer_code) ? $cer_code['code'].' - '.$cer_code['name'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('cer_code'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cer_code') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-light fw-400">Datos adicionales</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="composition">{{ __('Composición') }}</label>
                                            <input id="composition" type="text" class="form-control{{ $errors->has('composition') ? ' is-invalid' : '' }}" name="composition" value="{{ old('composition', isset($waste) ? $waste['composition'] : null) }}" required readonly="readonly">
                                            @if ($errors->has('composition'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('composition') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="dangerous">{{__('Peligroso')}}</label>
                                            <input id="dangerous" type="text" class="form-control{{ $errors->has('dangerous') ? ' is-invalid' : '' }}" name="dangerous" value="{{ old('dangerous', isset($waste) ? $waste['dangerous'] == 1 ? "SÍ" : "NO" : null) }}" required readonly="readonly">
                                            @if ($errors->has('dangerous'))
                                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('dangerous') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="production">{{ __('Producción') }}</label>
                                            <input id="production" type="text" class="form-control{{ $errors->has('production') ? ' is-invalid' : '' }}" name="production" value="{{ old('production', isset($waste) ? $waste['production'] : null) }}" readonly="readonly">
                                            @if ($errors->has('production'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('production') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="handling">{{__('Manipulación')}}</label>
                                            <textarea class="form-control {{ $errors->has('handling') ? ' is-invalid' : '' }}" id="handling" name="handling" rows="4" required readonly="readonly">{{ old('handling', isset($waste) ? $waste['handling'] : null) }}</textarea>
                                            @if ($errors->has('handling'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('handling') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="packaging">{{ __('Embalaje') }}</label>
                                    <input id="packaging" type="text" class="form-control{{ $errors->has('packaging') ? ' is-invalid' : '' }}" name="packaging" value="{{ old('packaging', isset($waste) ? $waste['packaging'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('packaging'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('packaging') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="transport">{{ __('Transporte') }}</label>
                                    <input id="transport" type="text" class="form-control{{ $errors->has('transport') ? ' is-invalid' : '' }}" name="transport" value="{{ old('transport', isset($waste) ? $waste['transport'] : null) }}" required readonly="readonly">
                                    @if ($errors->has('transport'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('transport') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="presentation">{{ __('Presentación') }}</label>
                                    <input id="presentation" type="text" class="form-control{{ $errors->has('presentation') ? ' is-invalid' : '' }}" name="presentation" value="{{ old('presentation', isset($waste) ? $waste['presentation'] : null) }}" readonly="readonly">
                                    @if ($errors->has('presentation'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('presentation') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="generation_date">{{ __('Fecha de generación') }}</label>
                                    <input id="generation_date" type="text" class="form-control{{ $errors->has('generation_date') ? ' is-invalid' : '' }}" name="generation_date" value="{{ old('generation_date', isset($waste) ? \Carbon\Carbon::createFromFormat('Y-m-d', $waste['generation_date'])->format('d/m/Y') : null) }}" required readonly="readonly">
                                    @if ($errors->has('generation_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('generation_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="pickup_date">{{ __('Fecha de recogida') }}</label>
                                    <input id="pickup_date" type="text" class="form-control{{ $errors->has('pickup_date') ? ' is-invalid' : '' }}" name="pickup_date" value="{{ old('pickup_date', isset($waste) ? \Carbon\Carbon::createFromFormat('Y-m-d', $waste['pickup_date'])->format('d/m/Y') : null) }}" required readonly="readonly">
                                    @if ($errors->has('pickup_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('pickup_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <hr>



                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-light fw-400">Ubicación</h5>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address_line">{{ Lang::get('Dirección') }}</label>
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
