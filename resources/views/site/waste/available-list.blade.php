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
                                    <select class="form-control show-tick filters"  id="f_waste_type" name="f_waste_type" data-width="100%"  data-dropup-auto="false">
                                        <option value="">Todos</option>
                                        @foreach($types as $type)
                                            <option value="{{$type['id']}}">{{$type['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_pickup_date">Fecha de Disponibilidad</label>
                                    <input class="form-control filters" id="f_pickup_date" name="f_pickup_date" type="text">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_generation_date">Fecha de Generación</label>
                                    <input class="form-control filters" id="f_generation_date" name="f_generation_date" type="text">
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="f_dangerous">{{__('Peligroso')}}</label>
                                <select class="form-control filters" data-live-search="true" id="f_dangerous" name="f_dangerous" required>
                                    <option value="all">Todos</option>
                                    <option value="1">{{__('SÍ')}}</option>
                                    <option value="0">{{__('NO')}}</option>
                                </select>
                                @if ($errors->has('f_dangerous'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('f_dangerous') }}</strong>
                                        </span>
                                @endif
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_creator_name">Empresa Propietaria</label>
                                    <input class="form-control filters" id="f_creator_name" name="f_creator_name" type="text">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Residuos Disponibles')}}</h4>
                <div class="card-body">
                    <table id="waste_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre')}}</th>
                            <th>{{__('Tipo de Residuo')}}</th>
                            <th>{{__('Cantidad')}}</th>
                            <th>{{__('Código CER')}}</th>
                            <th>{{__('Fecha de Generación')}}</th>
                            <th>{{__('Empresa Propietaria')}}</th>
                            <th>{{__('Fecha de Disponibilidad')}}</th>
                            <th>{{__('Peligroso')}}</th>
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

        var available_table;
        $(document).ready(function () {



            available_table  = $('#waste_list').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{URL::to('waste/available-data')}}",
                    "type": "POST",
                    data: function(d){
                        d._token = "{{csrf_token()}}";
                        d.f_name = $('#f_name').val();
                        d.f_waste_type = $('#f_waste_type').val();
                        d.f_cer_code = $('#f_cer_code').val();
                        d.f_dangerous = $('#f_dangerous').val();
                        d.f_pickup_date = $('#f_pickup_date').val();
                        d.f_creator_name = $('#f_creator_name').val();
                        d.f_generation_date = $('#f_generation_date').val();
                    }
                },
                columns: [
                    { "data": "name", "responsivePriority": 1, "targets": 0 },
                    { "data": "type", "responsivePriority": 9, "visible" : false},
                    { "data": "quantity", "responsivePriority": 3},
                    { "data": "cer_code", "responsivePriority": 4 },
                    { "data": "generation_date", "responsivePriority": 7 },
                    { "data": "creator_name", "responsivePriority": 5 },
                    { "data": "pickup_date", "responsivePriority": 6 },
                    { "data": "dangerous", "responsivePriority": 8 },
                    { "data": "action", "orderable": false, "responsivePriority": 2, "targets": -1 },
                ],
                order: [1, 'asc'],
                rowGroup: {
                    // Group by type
                    dataSrc: 'type'
                },
                "searching": false,
                "drawCallback": function( settings ) {

                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    });

                    $('.request-waste').click(function () {
                        var waste_id = $(this).data('waste_id');
                        swal({
                            title: 'Solicitar',
                            text: "¿Estás seguro de solicitar este residuo?",
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
                                data: {"waste_id" : waste_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('waste/request')}}",
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
                                    }
                                    else{
                                        swal({
                                            position: 'center',
                                            type: 'error',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3500
                                        });
                                    }

                                    available_table.draw();

                                },
                                error: function() {
                                    $('#modal-center').modal('hide');
                                    swal({
                                        position: 'center',
                                        type: 'error',
                                        title: 'Se ha producido un error al tramitar la solicitud.',
                                        showConfirmButton: false,
                                        timer: 3500
                                    });

                                    available_table.draw();

                                }
                            });


                        }
                        });
                    });
                }

            });

            $('#f_pickup_date, #f_generation_date').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

            // Apply the filter
            $(".filters").on( 'keyup change dp.change', function () {
                delay(function(){
                    available_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
