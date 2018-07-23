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
                                    <a href="{{URL::to('admin/users/list')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Solicitudes</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_transfers}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('admin/waste/transfers-requests/list')}}" class="btn btn-secondary w-full">Consultar</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="card">
                                <h4 class="card-title bg-info text-white">Residuos Disponibles</h4>
                                <div class="card-body text-center">
                                    <h1 class="card-title">{{$total_offers}}</h1>
                                    {{--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
                                    <a href="{{URL::to('admin/waste/available-list')}}" class="btn btn-secondary w-full">Consultar</a>
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

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="usersChart" style="width: 100%" height="300"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="transfersChart" style="width: 100%" height="300"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="availablesChart" style="width: 100%" height="300"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="demandsChart" style="width: 100%" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <script src="{{URL::to('vendor/chartjs/Chart.js')}}"></script>
    <script>

        var ctx = document.getElementById("usersChart").getContext('2d');
        var usersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [{
                    label: 'Usuarios registrados ' + '{{\Carbon\Carbon::now()->year}}',
                    data: {{json_encode($users_months)}},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                        'rgba(255,99,132,1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById("transfersChart").getContext('2d');
        var transfersChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [{
                    label: 'Solicitudes realizadas ' + '{{\Carbon\Carbon::now()->year}}',
                    data: {{json_encode($transfers_months)}},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx3 = document.getElementById("availablesChart").getContext('2d');
        var availablesChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [{
                    label: 'Residuos disponibles registrados ' + '{{\Carbon\Carbon::now()->year}}',
                    data: {{json_encode($waste_available_months)}},
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        var ctx4 = document.getElementById("demandsChart").getContext('2d');
        var demandsChart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [{
                    label: 'Residuos demandados registrados ' + '{{\Carbon\Carbon::now()->year}}',
                    data: {{json_encode($waste_request_months)}},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

    </script>

@endsection