@extends('layouts.default-web')

@section('styles')

    @endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <h4 class="card-title text-center"><strong>Bolsa de Residuos Reutilizables y Reciclables</strong></h4>

                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-sm-6 text-center">
                            <button data-toggle="modal" data-target="#modal-ios" class="btn btn-dark w-100 mb-2" href="#"><i class="fa fa-apple"></i> {{__('Añadir a iOS')}}</button>
                        </div>
                        <div class="col-12 col-sm-6 text-center">
                            <button data-toggle="modal" data-target="#modal-android" class="btn btn-vimeo w-100 mb-2" href="#"><i class="fa fa-android"></i> {{__('Añadir a Android')}}</button>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 style="font-weight: bold">{{__('MANUAL DE USO DE LA APLICACIÓN')}}</h2>

                            <a target="_blank" href="{{asset('images/add-home-screen/MANUAL_DE_USO_APLICACION_RESIDUOS.pdf')}}" class="btn btn-w-md btn-multiline btn-info text-white"><i class="ti-download fs-20"></i><br>{{__('DESCARGAR')}}</a>
                        </div>
                    </div>

                    <div class="modal modal-top fade" id="modal-ios" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #465161;">
                                    <h5 class="modal-title text-white"><i class="fa fa-apple"></i>{{__('   Añadir a iOS')}}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h5 class="btn-bold mb-4">{{__('Paso 1: Pulsa el botón "Compartir."')}}</h5>
                                            <img src="{{asset('images/add-home-screen/ios-1.png')}}" class="w-50 mb-4">
                                            <hr>
                                        {{--</div>--}}
                                        {{--<div class="col-4">--}}
                                            <h5 class="btn-bold mb-4 mt-4">{{__('Paso 2: Pulsa el botón "Añadir a pantalla de inicio."')}}</h5>
                                            <img src="{{asset('images/add-home-screen/ios-2.png')}}" class="w-50 mb-4">
                                            <hr>
                                        {{--</div>--}}
                                        {{--<div class="col-4">--}}
                                            <h5 class="btn-bold mb-4 mt-42">{{__('Paso 3: Visualiza el resultado y pulsa añadir para tener acceso directo como aplicación.')}}</h5>
                                            <img src="{{asset('images/add-home-screen/ios-3.png')}}" class="w-50 mb-4">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">{{__('Cerrar')}}</button>
                                    {{--<button type="button" class="btn btn-bold btn-pure btn-primary">Save changes</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-top fade" id="modal-android" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #aad450">
                                    <h5 class="modal-title text-white"><i class="fa fa-android"></i>{{__('   Añadir a Android')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span class="text-white" aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h5 class="btn-bold mb-4">{{__('Paso 1: Pulsa el botón superior derecho del menú adicional (tres puntos) y a continuación "Añadir a pantalla de inicio."')}}</h5>
                                            <img src="{{asset('images/add-home-screen/droid-1.png')}}" class="w-50 mb-4">
                                            <hr>
                                            {{--</div>--}}
                                            {{--<div class="col-4">--}}
                                            <h5 class="btn-bold mb-4 mt-4">{{__('Paso 2: Puedes cambiar el nombre que aparecerá junto al icono o dejar el que viene por defecto. Pulsa añadir."')}}</h5>
                                            <img src="{{asset('images/add-home-screen/droid-2.png')}}" class="w-50 mb-4">
                                            <hr>
                                            {{--</div>--}}
                                            {{--<div class="col-4">--}}
                                            <h5 class="btn-bold mb-4 mt-4">{{__('Paso 3: Por último, mantén pulsado sobre el icono para posicionarlo en la zona del escritorio que desees o pulsa añadir para finalizar.')}}</h5>
                                            <img src="{{asset('images/add-home-screen/droid-3.png')}}" class="w-50 mb-4">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">{{__('Cerrar')}}</button>
                                    {{--<button type="button" class="btn btn-bold btn-pure btn-primary">Save changes</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @endsection


@section('scripts')
    @endsection