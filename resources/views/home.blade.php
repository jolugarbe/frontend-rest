@extends('layouts.default')

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('HOME')}}</h4>--}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
        <li class="breadcrumb-item active"><a href="{{URL::to('/home')}}">Home</a></li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header bg-primary">
                    <h4 class="card-title text-white bold">Mis Residuos</h4>
                    <a class="btn btn-purple" href="{{URL::to('waste/create')}}">Publicar residuo</a>
                </header>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Publicados</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_waste}}</h1>
                                    <a href="{{URL::to('waste/user/published')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Cedidos</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_transfers}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('waste/user/transfers')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Solicitados</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_requests}}</h1>
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

    {{--<div class="row">--}}

        {{--<div class="col-md-12">--}}
            {{--<div class="card">--}}
                {{--<header class="card-header bg-primary">--}}
                    {{--<h4 class="card-title text-white bold">Bolsa de Residuos</h4>--}}
                {{--</header>--}}
                {{--<div class="card-body">--}}
                    {{----}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}
@endsection
