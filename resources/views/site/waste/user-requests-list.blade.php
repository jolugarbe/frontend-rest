@extends('layouts.app')

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
                        <h2>{{__('Residuos recibidos')}}</h2>
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

        $(document).ready(function () {

            $('#waste_list').DataTable({
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
                    }
                },
                columns: [
                    { "data": "name" },
                    { "data": "quantity" },
                    { "data": "composition" },
                    { "data": "action" },
                ]

            });

        });

    </script>

@endsection
