<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="blank, starter">

    <title>Bolsa de Residuos &mdash; CAFA</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    {{--<link href="{{URL::to('css/core.min.css')}}" rel="stylesheet">--}}
    {{--<link href="{{URL::to('css/app.min.css')}}" rel="stylesheet">--}}
    {{--<link href="{{URL::to('css/style.min.css')}}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{URL::to('images/theme/apple-touch-icon.png')}}">
    <link rel="icon" href="{{URL::to('images/theme/favicon.png')}}">

    <style>
        .form-control, .panel, .panel-heading{
            border-radius: 0 !important;
        }

        /*.panel-heading{*/
            /*background-color: #926dde !important;*/
            /*border-color: #926dde !important;*/
        /*}*/

        .form-control {
            border-color: #e3fcff !important;
        }

        label {
            font-size: 13px !important;
        }

    </style>
</head>

<body>

<!-- Main container -->
<main class="main-container">
    <div class="main-content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h2 class="panel-title"><strong>@if(isset($is_request)) DOCUMENTO DE SOLICITUD DE RESIDUO @elseif(isset($is_transfer)) DOCUMENTO DE CESIÓN DE RESIDUO @endif</strong></h2>
                    </div>
                </div>
            </div>
        </div>


        @if(isset($is_request))
            @include('site.waste.includes.request-user-pdf')
            <div style="margin-top: 50px;"></div>
            @include('site.waste.includes.transfer-user-pdf')
            <div style="page-break-after: always"></div>
            @include('site.waste.includes.waste-transfer-request-pdf')

        @elseif(isset($is_transfer))
            @include('site.waste.includes.transfer-user-pdf')
            <div style="margin-top: 50px;"></div>
            @include('site.waste.includes.request-user-pdf')
            <div style="page-break-after: always"></div>
            @include('site.waste.includes.waste-transfer-request-pdf')
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="panel @if($status_transfer_id == 1) panel-warning @elseif($status_transfer_id == 4) panel-success @else panel-danger @endif">
                    <div class="panel-heading text-center">
                        <h2 class="panel-title">Este trámite se encuentra en el estado: <strong>{{$status_transfer_name}}</strong></h2>
                    </div>
                </div>
            </div>
        </div>

    </div><!--/.main-content -->

</main>
<!-- END Main container -->

<!-- Scripts -->
{{--<script src="{{URL::to('js/core.min.js')}}"></script>--}}
{{--<script src="{{URL::to('js/app.min.js')}}"></script>--}}
{{--<script src="{{URL::to('js/script.min.js')}}"></script>--}}

</body>
</html>