@extends('layouts.default-admin')

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
        <li class="breadcrumb-item" style="display: inline"><a href="#">Residuos</a></li>
        <li class="breadcrumb-item active" style="display: inline"><a href="{{URL::to('admin/waste/transfers-requests/list')}}">Solicitudes</a></li>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="f_name">Nombre</label>
                                    <input class="form-control filters" id="f_name" name="f_name" type="text">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="f_waste_type">{{__('Tipo de residuo')}}</label>
                                    <select class="form-control show-tick filters" id="f_waste_type" name="f_waste_type" data-width="100%"  data-dropup-auto="false">
                                        <option value="">Todos</option>
                                        @foreach($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="f_request_name">Empresa Solicitante</label>
                                    <input class="form-control filters" id="f_request_name" name="f_request_name" type="text">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="f_creator_name">Empresa Cedente</label>
                                    <input class="form-control filters" id="f_creator_name" name="f_creator_name" type="text">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8">
                                <label for="f_cer_code">{{__('Código CER')}}</label>
                                <select data-provide="selectpicker"  data-lang="es_ES" data-size="8" class="form-control filters" data-live-search="true" id="f_cer_code" name="f_cer_code" required>
                                    <option value="">Todos</option>
                                    @foreach($cer_subgroups as $subgroup)

                                        <optgroup class="bg-primary text-white" label="{{$subgroup['code'].' - '.$subgroup['name']}}">

                                            @foreach($cer_codes as $code)

                                                @if($code['cer_subgroup_id'] == $subgroup['id'])
                                                    <option class="bg-white text-black-50" value="{{$code['id']}}" @if(isset($waste) && $waste['cer_code_id'] == $code['id']) selected="selected" @endif>{{$code['code'].' - '.$code['name']}}</option>
                                                @endif

                                            @endforeach

                                        </optgroup>

                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_create_date_start">Solicitados desde:</label>
                                    <input class="form-control filters" id="f_create_date_start" name="f_create_date_start" type="text">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_create_date_end">Solicitados hasta:</label>
                                    <input class="form-control filters" id="f_create_date_end" name="f_create_date_end" type="text">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Solicitudes de Residuos')}}</h4>
                <div class="card-body">
                    <table id="waste_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre')}}</th>
                            <th>{{__('Tipo')}}</th>
{{--                            <th>{{__('Cantidad')}}</th>--}}
                            <th>{{__('Código CER')}}</th>
                            <th>{{__('Empresa Cedente')}}</th>
                            <th>{{__('Empresa Solicitante')}}</th>
                            <th>{{__('Fecha de Solicitud')}}</th>
                            <th>{{__('Estado')}}</th>
                            <th>{{__('Acciones')}}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal modal-center fade" id="modal-center" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="spinner_form" style="height: 200px; width: 100%; text-align: center">
                    <h5 style="position: fixed; top: 30%; left: 50%; transform: translate(-50%, -50%);">Procesando...</h5>
                    <div class="spinner-ball" style="position: fixed; top: 50%; left: 50%; margin-left: -25px;"></div>
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

        var transfer_table;
        $(document).ready(function () {

            transfer_table = $('#waste_list').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{URL::to('admin/waste/transfers-data')}}",
                    "type": "POST",
                    data: function(d){
                        d._token = "{{csrf_token()}}";
                        d.f_name = $('#f_name').val();
                        d.f_waste_type = $('#f_waste_type').val();
                        d.f_cer_code = $('#f_cer_code').val();
                        d.f_create_date_start = $('#f_create_date_start').val();
                        d.f_create_date_end = $('#f_create_date_end').val();
                        d.f_request_name = $('#f_request_name').val();
                        d.f_creator_name = $('#f_creator_name').val();
                    }
                },
                columns: [
                    { "data": "name", "responsivePriority": 1, "targets": 0 },
                    { "data": "type", "visible": false},
//                    { "data": "quantity", "responsivePriority": 5 },
                    { "data": "cer_code", "responsivePriority": 4 },
                    { "data": "creator_name", "responsivePriority": 7 },
                    { "data": "request_name", "responsivePriority": 6 },
                    { "data": "request_date", "responsivePriority": 5 },
                    { "data": "status", "responsivePriority": 3 },
                    { "data": "action", "orderable": false, "responsivePriority": 2, "targets": -1 },
                ],
                order: [2, 'asc'],
                rowGroup: {
                    // Group by type
                    dataSrc: 'type'
                },
                "searching": false,
                "drawCallback": function( settings ) {

                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    });

                    $('.delete-transfer').click(function () {
                        var transfer_id = $(this).data('transfer_id');
                        swal({
                            title: 'Eliminar',
                            text: "¿Estás seguro de eliminar esta solicitud?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-primary',
                            cancelButtonClass: 'btn btn-secondary',
                            buttonsStyling: false,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.value) {
                            $('#modal-center').modal('show');
                            $.ajax({
                                data: {"transfer_id" : transfer_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('admin/transfer/delete')}}",
                                success: function(data) {
                                    $('#modal-center').modal('hide');
                                    if(data.result == "success"){
                                        swal({
                                            position: 'center',
                                            type: 'success',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else if(data.result == "warning"){
                                        swal({
                                            position: 'center',
                                            type: 'warning',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }else{
                                        swal({
                                            position: 'center',
                                            type: 'error',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                    transfer_table.draw();

                                },
                                error: function() {
                                    $('#modal-center').modal('hide');
                                    swal({
                                        position: 'center',
                                        type: 'error',
                                        title: 'Se ha producido un error al intentar eliminar la solicitud.',
                                        showConfirmButton: false,
                                        timer: 3500
                                    });

                                    transfer_table.draw();

                                }
                            });


                        }
                    });
                    });
                }
            });

            $('#f_create_date_start, #f_create_date_end').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

            // Apply the filter
            $(".filters").on( 'keyup change dp.change', function () {
                delay(function(){
                    transfer_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
