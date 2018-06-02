@extends('layouts.default')

@section('styles')
<style>
    #waste_list th, #waste_list td {
        text-align: center;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')

                <div class="row">

                    <div class="col-md-12">
                        <h2>{{__('Residuos disponibles')}}</h2>
                    </div>

                    <div class="col-md-12">
                        <h4>{{__('Filtros')}}</h4>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <label for="f_name">Nombre</label>
                            <input id="f_name" type="text" name="f_name">
                        </div>

                    </div>

                    <div class="col-md-12">

                        <table id="waste_list" class="responsive w-100">
                            <thead>
                                <tr>
                                    <th>{{__('Nombre')}}</th>
                                    <th>{{__('Cantidad')}}</th>
                                    <th>{{__('Composición')}}</th>
                                    <th>{{__('Acciones')}}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>

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
                    }
                },
                columns: [
                    { "data": "name" },
                    { "data": "quantity" },
                    { "data": "composition" },
                    { "data": "action" },
                ],
                "drawCallback": function( settings ) {
                    $('.request-waste').click(function () {
                        var waste_id = $(this).data('waste_id');
                        swal({
                            title: 'Solicitar',
                            text: "¿Estás seguro de solicitar este residuo?",
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
                                url: "{{URL::to('waste/request')}}",
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

                                    available_table.draw();

                                },
                                error: function() {
                                    $('.loader').fadeOut('slow');
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

            // Apply the filter
            $("#f_name").on( 'keyup change', function () {
                delay(function(){
                    available_table.draw();
                }, 200 );
            } );

        });

    </script>

@endsection
