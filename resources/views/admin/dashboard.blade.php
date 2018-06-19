@extends('layouts.default-admin')

@section('styles')
    {{--<style>--}}
        {{--#waste_list th, #waste_list td {--}}
            {{--text-align: center;--}}
            {{--vertical-align: middle;--}}
        {{--}--}}

        {{--.group-start td{--}}
            {{--text-align: left !important;--}}
            {{--background-color: #f7fafc !important;--}}
        {{--}--}}
    {{--</style>--}}
@endsection

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('CAFA | BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES')}}</h4>--}}
@endsection

@section('breadcrumb')
    {{--<ol class="breadcrumb d-none d-md-block">--}}
        {{--<li class="breadcrumb-item" style="display: inline"><a href="#">Mis Residuos</a></li>--}}
        {{--<li class="breadcrumb-item active" style="display: inline"><a href="{{URL::to('waste/user/transfers')}}">Cesiones</a></li>--}}
    {{--</ol>--}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header bg-primary">
                    <h4 class="card-title text-white bold">Panel de Control</h4>
                    {{--<a class="btn btn-purple" href="{{URL::to('waste/create')}}">Publicar residuo</a>--}}
                </header>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Usuarios</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_users}}</h1>
                                    <a href="{{URL::to('waste/user/published')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Solicitudes</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_transfers}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('waste/user/transfers')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Residuos Disponibles</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_offers}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('waste/user/requests')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Residuos Demandados</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_demand}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('waste/user/requests')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection