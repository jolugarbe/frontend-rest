@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')
                <div class="card">
                    <div class="card-header">{{Lang::get('Registrar residuo')}}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{isset($editar) ? URL::to('waste/update') : URL::to('waste/create')}}">
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
                                    <label for="waste_type">{{__('Tipo de residuo')}}</label>
                                    <select class="form-control" id="waste_type" name="waste_type" required>
                                        <option value="">Seleccione un tipo</option>
                                        @foreach($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
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
                                    <textarea class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="quantity">{{ __('Cantidad') }}</label>
                                    <input id="quantity" type="number" min="1" step="0.1" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}" required>
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="measured_unit">{{ __('Unidad de medida') }}</label>
                                    <input id="measured_unit" type="text" class="form-control{{ $errors->has('measured_unit') ? ' is-invalid' : '' }}" name="measured_unit" value="{{ old('measured_unit') }}" placeholder="{{__('m2, Kg, Tm...')}}" required>
                                    @if ($errors->has('measured_unit'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('measured_unit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="frequency">{{__('Frecuencia')}}</label>
                                    <select class="form-control" data-live-search="true" id="frequency" name="frequency" required>
                                        <option value="">Seleccione frecuencia</option>
                                        @foreach($frequencies as $frequency)
                                            <option value="{{$frequency['id']}}">{{$frequency['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('frequency'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('frequency') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="composition">{{ __('Composición') }}</label>
                                            <input id="composition" type="text" class="form-control{{ $errors->has('composition') ? ' is-invalid' : '' }}" name="composition" value="{{ old('composition') }}" required>
                                            @if ($errors->has('composition'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('composition') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="dangerous">{{__('Peligroso')}}</label>
                                            <select class="form-control" data-live-search="true" id="dangerous" name="dangerous" required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="1">{{__('SÍ')}}</option>
                                                <option value="0">{{__('NO')}}</option>
                                            </select>
                                            @if ($errors->has('dangerous'))
                                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('dangerous') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="handling">{{__('Manipulación')}}</label>
                                            <textarea class="form-control {{ $errors->has('handling') ? ' is-invalid' : '' }}" id="handling" name="handling" rows="4" required>{{ old('handling') }}</textarea>
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
                                <div class="form-group col-md-4">
                                    <label for="presentation">{{ __('Presentación') }}</label>
                                    <input id="presentation" type="text" class="form-control{{ $errors->has('presentation') ? ' is-invalid' : '' }}" name="presentation" value="{{ old('presentation') }}">
                                    @if ($errors->has('presentation'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('presentation') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="generation_date">{{ __('Fecha de generación') }}</label>
                                    <input id="generation_date" type="text" class="form-control{{ $errors->has('generation_date') ? ' is-invalid' : '' }}" name="generation_date" value="{{ old('generation_date') }}" required>
                                    @if ($errors->has('generation_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('generation_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="pickup_date">{{ __('Fecha de recogida') }}</label>
                                    <input id="pickup_date" type="text" class="form-control{{ $errors->has('pickup_date') ? ' is-invalid' : '' }}" name="pickup_date" value="{{ old('pickup_date') }}" required>
                                    @if ($errors->has('pickup_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('pickup_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="address_line">{{ Lang::get('Ubicación') }}</label>
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
                                        @foreach($provinces as $province)
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
                                        @foreach($localities as $locality)
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
                                <div class="form-group col-md-6">
                                    <label for="packaging">{{ __('Embalaje') }}</label>
                                    <input id="packaging" type="text" class="form-control{{ $errors->has('packaging') ? ' is-invalid' : '' }}" name="packaging" value="{{ old('packaging') }}" required>
                                    @if ($errors->has('packaging'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('packaging') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="transport">{{ __('Transporte') }}</label>
                                    <input id="transport" type="text" class="form-control{{ $errors->has('transport') ? ' is-invalid' : '' }}" name="transport" value="{{ old('transport') }}" required>
                                    @if ($errors->has('transport'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('transport') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="production">{{ __('Producción') }}</label>
                                    <input id="production" type="text" class="form-control{{ $errors->has('production') ? ' is-invalid' : '' }}" name="production" value="{{ old('production') }}">
                                    @if ($errors->has('production'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('production') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="cer_code">{{ __('Código CER') }}</label>
                                    <input id="cer_code" type="text" class="form-control{{ $errors->has('cer_code') ? ' is-invalid' : '' }}" name="cer_code" value="{{ old('cer_code') }}" required>
                                    @if ($errors->has('cer_code'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('cer_code') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="ad_type">{{__('Tipo de anuncio')}}</label>
                                    <select class="form-control" data-live-search="true" id="ad_type" name="ad_type" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach($ads as $ad)
                                            <option value="{{$ad['id']}}">{{__($ad['name'])}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ad_type'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('ad_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{__('Registrar')}}
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
            var localities = @json($localities);

            var urlRegisterUser = "{{URL::to('waste/create')}}";

            $('#register-form').validate({
                rules: {
                    "name": {
                        required: true
                    },
                    "waste_type": {
                        required: true
                    },
                    "quantity": {
                        required: true,
                        number: true
                    },
                    "measured_unit": {
                        required: true
                    },
                    "frequency": {
                        required: true
                    },
                    "composition": {
                        required: true
                    },
                    "dangerous": {
                        required: true
                    },
                    "handling": {
                        required: true
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
                    "generation_date": {
                        required: true
                    },
                    "pickup_date": {
                        required: true
                    },
                    "packaging": {
                        required: true
                    },
                    "transport": {
                        required: true
                    },
                    "cer_code": {
                        required: true
                    },
                    "ad_type": {
                        required: true
                    }
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

            $('#generation_date, #pickup_date').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

        });

    </script>

@endsection
