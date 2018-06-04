@extends('layouts.default')

@section('styles')
    <style>
        #waste_list th, #waste_list td {
            text-align: center;
            vertical-align: middle;
        }

        .group-start td{
            text-align: left !important;
            background-color: #f7fafc !important;
        }
    </style>
@endsection

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('CAFA | BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES')}}</h4>--}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
        <li class="breadcrumb-item" style="display: inline"><a href="#">Mis Residuos</a></li>
        <li class="breadcrumb-item active" style="display: inline"><a href="{{URL::to('waste/user/requests')}}">Solicitados</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title"><i class="fa fa-search" aria-hidden="true"></i>  {{__('Filtros de búsqueda')}}</h4>
                    <ul class="card-controls">
                        <li><a class="card-btn-slide" href="#"></a></li>
                    </ul>
                </header>

                <div class="card-content" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_name">Nombre</label>
                                    <input class="form-control filters" id="f_name" name="f_name" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_waste_type">{{__('Tipo de residuo')}}</label>
                                    <select class="show-tick filters" data-provide="selectpicker" id="f_waste_type" name="f_waste_type" data-width="100%"  data-dropup-auto="false">
                                        <option value="">Todos</option>
                                        @foreach($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_cer_code">Código CER</label>
                                    <input class="form-control filters" id="f_cer_code" name="f_cer_code" type="text">
                                </div>
                            </div>

                        </div>

                        <div class="row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_pickup_date">Fecha de Disponibilidad</label>
                                    <input class="form-control filters" id="f_pickup_date" name="f_pickup_date" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_creator_name">Empresa Propietaria</label>
                                    <input class="form-control filters" id="f_creator_name" name="f_creator_name" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_request_date">Solicitud de Cesión</label>
                                    <input class="form-control filters" id="f_request_date" name="f_request_date" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Residuos Solicitados')}}</h4>
                <div class="card-body">
                    <table id="waste_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre')}}</th>
                            <th>{{__('Cantidad')}}</th>
                            <th>{{__('Código CER')}}</th>
                            <th>{{__('Fecha de Disponibilidad')}}</th>
                            <th>{{__('Empresa Propietaria')}}</th>
                            <th>{{__('Solicitud de Cesión')}}</th>
                            <th>{{__('Acciones')}}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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

        var request_table;
        $(document).ready(function () {

            request_table = $('#waste_list').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{URL::to('waste/user/requests-data')}}",
                    "type": "POST",
                    data: function(d){
                        d._token = "{{csrf_token()}}";
                        d.f_name = $('#f_name').val();
                        d.f_waste_type = $('#f_waste_type').val();
                        d.f_cer_code = $('#f_cer_code').val();
                        d.f_pickup_date = $('#f_pickup_date').val();
                        d.f_creator_name = $('#f_creator_name').val();
                        d.f_request_date = $('#f_request_date').val();
                    }
                },
                columns: [
                    { "data": "name", "responsivePriority": 1, "targets": 0 },
                    { "data": "quantity" },
                    { "data": "cer_code" },
                    { "data": "pickup_date" },
                    { "data": "creator_name" },
                    { "data": "request_date" },
                    { "data": "action", "orderable": false, "responsivePriority": 2, "targets": -1 },
                ],
                order: [2, 'asc'],
                rowGroup: {
                    // Group by type
                    dataSrc: 'type'
                },
                "searching": false,
                "drawCallback": function( settings ) {

                }
            });

            $('#f_pickup_date, #f_request_date').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

            // Apply the filter
            $(".filters").on( 'keyup change dp.change', function () {
                delay(function(){
                    request_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
