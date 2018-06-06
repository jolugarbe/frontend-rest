@extends('layouts.default')

@section('styles')

@endsection

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('CAFA | BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES')}}</h4>--}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
        <li class="breadcrumb-item" style="display: inline"><a href="#">Residuos</a></li>
        <li class="breadcrumb-item active" style="display: inline"><a href="#">Cesión</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-shadowed">
                <header class="card-header">
                    <h4 class="card-title"><strong>@if(isset($is_request)) DOCUMENTO DE SOLICITUD DE RESIDUO @elseif(isset($is_transfer)) DOCUMENTO DE CESIÓN DE RESIDUO @endif</strong></h4>
                    <div class="card-header-actions">
                        <a class="btn btn-purple" href="#">Volver</a>
                        @if(isset($is_request))
                            <a class="btn btn-danger" href="{{URL::to('waste/user/show-request/pdf/'.$transfer_id)}}"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                        @elseif(isset($is_transfer))
                            <a class="btn btn-danger" href="{{URL::to('waste/user/show-transfer/pdf/'.$transfer_id)}}"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                        @endif
                    </div>
                </header>
            </div>
        </div>
    </div>

    @if(isset($is_request))
        @include('site.waste.includes.request-user')
        @include('site.waste.includes.waste-transfer-request')
        @include('site.waste.includes.transfer-user')
    @elseif(isset($is_transfer))
        @include('site.waste.includes.transfer-user')
        @include('site.waste.includes.waste-transfer-request')
        @include('site.waste.includes.request-user')
    @endif

@endsection

@section('scripts')

    <script>

    </script>

@endsection
