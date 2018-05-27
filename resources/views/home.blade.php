@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-header bg-info text-white">Residuos</h5>
                            <div class="card-body text-center">
                                <h1 class="card-title">{{$total_waste}}</h1>
                                {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                <a href="{{URL::to('waste/user/offers')}}" class="btn btn-info col-md-12">Ofertados</a>
                                <a href="{{URL::to('waste/available')}}" class="btn btn-info col-md-12">Disponibles</a>
                                <a href="{{URL::to('waste/create')}}" class="btn btn-info col-md-12 mt-1">Crear</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-header bg-info text-white">Cesiones</h5>
                            <div class="card-body text-center">
                                <h1 class="card-title">{{$total_transfers}}</h1>
                                {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                <a href="{{URL::to('waste/user/transfers')}}" class="btn btn-info">Consultar</a>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-header bg-info text-white">Solicitudes</h5>
                            <div class="card-body text-center">
                                <h1 class="card-title">{{$total_requests}}</h1>
                                {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                <a href="{{URL::to('waste/user/requests')}}" class="btn btn-info">Consultar</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
