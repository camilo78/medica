@extends('layouts.app')
@section('styles')

@stop
@section('js')

@stop
@section('title')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5 mr-4">
                        <h2>Configuración</h2>
                        <p class="mb-md-0">Configure información para: {{$setting->name}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('settings.index')}}">&nbsp;Clínica&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">{{$setting->name}}/</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @can('user-edit')
                        <a class="btn btn-info mr-3 mt-2 mt-xl-0" href="{{route('settings.update', $setting->id)}}"> <i
                                    class="mdi mdi-account-edit"></i> Editar Clínica</a>
                    @endcan
                    <a class="btn btn-primary mt-2 mt-xl-0" href="{{URL::previous()}}"><i
                                class="mdi mdi-step-backward"></i> Atras</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 imgUp">
                            <img class="img-thumbnail img-fluid" src="
                                @if($setting->image == null)
                            {{asset('images/sin_imagen.jpg')}}
                            @else
                            {{asset('storage/'.$setting->image)}}
                            @endif" alt="profile"/>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium">Nombre de la Clínica:</label>
                                        <p>{{$setting->name}}</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium">Teléfono(s):</label>
                                        <p>{{$setting->phone}}</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium">Sitio Web:</label>
                                        <p>{{$setting->web}}</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium">Dirección:</label>
                                        <p>{{$setting->address}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
