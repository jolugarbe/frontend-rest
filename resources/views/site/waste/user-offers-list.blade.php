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
        <li class="breadcrumb-item active" style="display: inline"><a href="{{URL::to('waste/user/published')}}">Publicaciones</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12 mb-4">
            <a class="btn btn-purple float-right" href="{{URL::to('waste/create')}}">Publicar residuo</a>
        </div>

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

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_generation_date">Fecha de Generación</label>
                                    <input class="form-control filters" id="f_generation_date" name="f_generation_date" type="text">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_dangerous">{{__('Peligrosidad')}}</label>
                                    <select class="form-control show-tick filters" id="f_dangerous" name="f_dangerous" data-width="100%"  data-dropup-auto="false">
                                        <option value="all">Todos</option>
                                        <option value="1">Peligrosos</option>
                                        <option value="0">No peligrosos</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_ad_type">{{__('Tipo de publicación')}}</label>
                                    <select class="form-control show-tick filters" id="f_ad_type" name="f_ad_type" data-width="100%"  data-dropup-auto="false">
                                        <option value="">Todos</option>
                                        @foreach($ads as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Mis Residuos')}}</h4>
                <div class="card-body">
                    <table id="waste_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre')}}</th>
                            <th>{{__('Cantidad')}}</th>
                            <th>{{__('Tipo')}}</th>
                            <th>{{__('Código CER')}}</th>
                            <th>{{__('Fecha de Generación')}}</th>
                            <th>{{__('Peligroso')}}</th>
                            <th>{{__('Tipo Publicación')}}</th>
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

        var offer_table;
        $(document).ready(function () {

            offer_table = $('#waste_list').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{URL::to('waste/user/offers-data')}}",
                    "type": "POST",
                    data: function(d){
                        d._token = "{{csrf_token()}}";
                        d.f_name = $('#f_name').val();
                        d.f_waste_type = $('#f_waste_type').val();
                        d.f_cer_code = $('#f_cer_code').val();
                        d.f_generation_date = $('#f_generation_date').val();
                        d.f_dangerous = $('#f_dangerous').val();
                        d.f_ad_type = $('#f_ad_type').val();
                    }
                },
                columns: [
                    { "data": "name", "responsivePriority": 1, "targets": 0 },
                    { "data": "quantity" },
                    { "data": "type", "visible": false },
                    { "data": "cer_code" },
                    { "data": "generation_date" },
                    { "data": "dangerous" },
                    { "data": "t_ad_id" },
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

                    $('.acquired-waste').click(function (e) {
                        e.preventDefault();
                        var waste_id = $(this).data('waste_id');
                        swal({
                            title: 'Conseguido',
                            text: "¿Estás seguro de marcar como conseguido?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-primary',
                            cancelButtonClass: 'btn btn-secondary',
                            buttonsStyling: false,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.value) {
                            $.ajax({
                                data: {"waste_id" : waste_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('waste/acquired')}}",
                                success: function(data) {
                                    if(data.result == "success"){
                                        swal({
                                            position: 'center',
                                            type: 'success',
                                            title: 'Correcto',
                                            text: data.message,
                                            showConfirmButton: false,
                                            timer: 4000
                                        });
                                    }else{
                                        swal({
                                            position: 'center',
                                            type: 'error',
                                            title: 'Error',
                                            text: data.message,
                                            showConfirmButton: false,
                                            timer: 4000
                                        });
                                    }

                                    offer_table.draw();

                                },
                                error: function() {
                                    swal({
                                        position: 'center',
                                        type: 'error',
                                        title: 'Se ha producido un error al marcar el residuo como conseguido.',
                                        showConfirmButton: false,
                                        timer: 3500
                                    });

                                    offer_table.draw();

                                }
                            });

                        }
                    });
                    });

                    $('.delete-waste').click(function (e) {
                        e.preventDefault();
                        var waste_id = $(this).data('waste_id');
                        swal({
                            title: 'Eliminar',
                            text: "¿Estás seguro de eliminar este residuo?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-primary',
                            cancelButtonClass: 'btn btn-secondary',
                            buttonsStyling: false,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.value) {
                            $.ajax({
                                data: {"waste_id" : waste_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('waste/delete')}}",
                                success: function(data) {
                                    if(data.result == "success"){
                                        swal({
                                            position: 'center',
                                            type: 'success',
                                            title: 'Correcto',
                                            text: data.message,
                                            showConfirmButton: false,
                                            timer: 4000
                                        });
                                    }else{
                                        swal({
                                            position: 'center',
                                            type: 'error',
                                            title: 'Error',
                                            text: data.message,
                                            showConfirmButton: false,
                                            timer: 4000
                                        });
                                    }

                                    offer_table.draw();

                                },
                                error: function() {
                                    swal({
                                        position: 'center',
                                        type: 'error',
                                        title: 'Se ha producido un error al eliminar el residuo.',
                                        showConfirmButton: false,
                                        timer: 3500
                                    });

                                    offer_table.draw();

                                }
                            });

                        }
                    });
                    });
                }

            });


            $('#f_generation_date').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

            // Apply the filter
            $(".filters").on( 'keyup change dp.change', function () {
                delay(function(){
                    offer_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
