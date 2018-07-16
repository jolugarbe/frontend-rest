@extends('layouts.default-admin')

@section('styles')

    <style>
        #users_list th, #users_list td {
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

        <div class="col-md-12 mb-4">
            <a class="btn btn-purple float-right" href="{{URL::to('admin/users/create')}}">Crear usuario</a>
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
                                    <label for="f_business_name">Nombre comercial</label>
                                    <input class="form-control filters" id="f_business_name" name="f_business_name" type="text">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="f_activity">{{__('Actividad')}}</label>
                                    <select class="form-control show-tick filters"  id="f_activity" name="f_activity" data-width="100%"  data-dropup-auto="false">
                                        <option value="">Todas</option>
                                        @foreach($activities as $activity)
                                            <option value="{{$activity['id']}}">GRUPO {{$activity['group'].' - '.$activity['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_cif">CIF / NIF</label>
                                    <input class="form-control filters" id="f_cif" name="f_cif" type="text">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_register_from">Registrados desde</label>
                                    <input class="form-control filters" id="f_register_from" name="f_register_from" type="text">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="f_register_until">Registrados hasta</label>
                                    <input class="form-control filters" id="f_register_until" name="f_register_until" type="text">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <h5 class="col-md-12">Huella de Carbono</h5>

                            <div class="form-group col-md-4">
                                <label for="f_carbon_footprint">{{__('Registrado')}}</label>
                                <select class="form-control filters" id="f_carbon_footprint" name="f_carbon_footprint" required>
                                    <option value="all">Todos</option>
                                    <option value="1">{{__('SÍ')}}</option>
                                    <option value="0">{{__('NO')}}</option>
                                </select>
                                @if ($errors->has('f_carbon_footprint'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('f_carbon_footprint') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_carbon_from">Inscritos desde</label>
                                    <input class="form-control filters" id="f_carbon_from" name="f_carbon_from" type="text">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="f_carbon_until">Inscritos hasta</label>
                                    <input class="form-control filters" id="f_carbon_until" name="f_carbon_until" type="text">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Usuarios registrados')}}</h4>
                <div class="card-body">
                    <table id="users_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre Comercial')}}</th>
                            <th>{{__('Actividad')}}</th>
                            <th>{{__('CIF')}}</th>
                            <th>{{__('Fecha de Registro')}}</th>
                            <th>{{__('Huella de Carbono')}}</th>
                            <th>{{__('Fecha de Inscripción')}}</th>
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

        var users_table;

        $(document).ready(function () {

            users_table  = $('#users_list').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{URL::to('admin/users/list-data')}}",
                    "type": "POST",
                    data: function(d){
                        d._token = "{{csrf_token()}}";
                        d.f_business_name = $('#f_business_name').val();
                        d.f_activity = $('#f_activity').val();
                        d.f_cif = $('#f_cif').val();
                        d.f_register_from = $('#f_register_from').val();
                        d.f_register_until = $('#f_register_until').val();
                        d.f_carbon_footprint = $('#f_carbon_footprint').val();
                        d.f_carbon_from = $('#f_carbon_from').val();
                        d.f_carbon_until = $('#f_carbon_until').val();
                    }
                },
                columns: [
                    { "data": "business_name", "responsivePriority": 1, "targets": 0 },
                    { "data": "activity", "responsivePriority": 7, "visible" : false},
                    { "data": "cif", "responsivePriority": 3},
                    { "data": "register_date", "responsivePriority": 4 },
                    { "data": "carbon_footprint", "responsivePriority": 6 },
                    { "data": "carbon_inscription", "responsivePriority": 5 },
                    { "data": "action", "orderable": false, "responsivePriority": 2, "targets": -1 },
                ],
                order: [1, 'asc'],
                rowGroup: {
                    // Group by type
                    dataSrc: 'activity'
                },
                "searching": false,
                "drawCallback": function( settings ) {

                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    });

                    $('.delete-user').click(function (e) {
                        e.preventDefault();
                        var user_id = $(this).data('user_id');
                        swal({
                            title: 'Eliminar',
                            text: "¿Estás seguro de eliminar este usuario?",
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
                                data: {"user_id" : user_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('admin/users/delete')}}",
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

                                    users_table.draw();

                                },
                                error: function() {
                                    swal({
                                        position: 'center',
                                        type: 'error',
                                        title: 'Se ha producido un error al eliminar el usuario.',
                                        showConfirmButton: false,
                                        timer: 3500
                                    });

                                    users_table.draw();

                                }
                            });

                        }
                    });
                    });
                }

            });

            $('#f_register_from, #f_register_until, #f_carbon_from, #f_carbon_until').datetimepicker({
                locale: 'es',
                format: 'DD/MM/YYYY'
            });

            // Apply the filter
            $(".filters").on( 'keyup change dp.change', function () {
                delay(function(){
                    users_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
