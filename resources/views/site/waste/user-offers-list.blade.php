@extends('layouts.default')

@section('styles')
    <style>
        #waste_list th, #waste_list td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection

@section('title')
    {{--<h4 class="d-none d-md-block">{{__('CAFA | BOLSA DE RESIDUOS REUTILIZABLES Y RECICLABLES')}}</h4>--}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb d-none d-md-block">
    <li class="breadcrumb-item"><a href="#">Mis Residuos</a></li>
    <li class="breadcrumb-item active"><a href="{{URL::to('waste/user/published')}}">Publicados</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title">{{__('Mis Residuos')}}</h4>
                <div class="card-body">
                    <table id="waste_list" class="table table-striped table-bordered dataTable responsive w-100" role="grid" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{__('Nombre')}}</th>
                            <th>{{__('Cantidad')}}</th>
                            <th>{{__('Composición')}}</th>
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
                    }
                },
                columns: [
                    { "data": "name" },
                    { "data": "quantity" },
                    { "data": "composition" },
                    { "data": "t_ad_id" },
                    { "data": "action" },
                ],
                "drawCallback": function( settings ) {
                    $('.delete-waste').click(function (e) {
                        e.preventDefault();
                        var waste_id = $(this).data('waste_id');
                        swal({
                            title: 'Eliminar',
                            text: "¿Estás seguro de eliminar este residuo?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.value) {
                            $('.loader').fadeIn('slow');
                            $.ajax({
                                data: {"waste_id" : waste_id, "_token" : "{{csrf_token()}}" },
                                type: "POST",
                                dataType: "json",
                                url: "{{URL::to('waste/delete')}}",
                                success: function(data) {
                                    $('.loader').fadeOut('slow');
                                    if(data.result == "success"){
                                        swal({
                                            position: 'center',
                                            type: 'success',
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

                                    offer_table.draw();

                                },
                                error: function() {
                                    $('.loader').fadeOut('slow');
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

        });

    </script>

@endsection
