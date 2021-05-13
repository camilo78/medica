@extends('layouts.app')
@section('styles')
<style>
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before{
        margin-top: 10px !important;
    }
</style>
@stop
@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/r-2.2.7/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#logs').DataTable( {

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                responsive:true,
                searching: false,
                ordering: false,
                paginate: false,
                info: false,

            } );
        } );
    </script>
@stop
@section('title')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5 mr-4">
                        <h2>{{ $user->name1 .' '.$user->name2.' '.$user->surname1}}</h2>
                        <p class="mb-md-0">Información del usuario</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">{{ $user->name1 .' '.$user->name2.' '.$user->surname1}}&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @can('user-edit')
                        <a class="btn btn-info mr-3 mt-2 mt-xl-0" href="{{ route('users.edit',$user->id) }}"> <i
                                class="mdi mdi-account-edit"></i> Editar Usuario</a>
                    @endcan
                    <a class="btn btn-primary mt-2 mt-xl-0" href="{{ URL::previous() }}"><i
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
                        <div class="col-xl-4">
                            <!-- Personal-Information -->
                            <div class="card-box">
                                <h4 class="header-title mt-0">Información Personal</h4>
                                <img class="img-thumbnail img-fluid" src="
                                @if($user->avatar == null)
                                {{asset('images/sin_imagen.jpg')}}
                                @else
                                {{asset('storage/'.$user->avatar)}}
                                @endif" alt="profile"/>
                                <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                                <div class="panel-body">
                                    <hr>
                                    <div class="text-left">
                                        <p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15">{{ $user->name1 .' '.$user->name2.' '.$user->surname1 .' '.$user->surname2}}</span></p>
                                        <p class="text-muted font-13"><strong>Rol :</strong> <span class="m-l-15">{{$user->getRoleNames()->first()}}</span></p>
                                        <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15"><a href="tel:{{$user->phone1}}"> {{$user->phone1}}</a></span></p>
                                        <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><a href = "mailto: {{$user->email}}"> {{$user->email}}</a></span></p>
                                        <p class="text-muted font-13"><strong>Pais :</strong> <span class="m-l-15">{{ $user->country['name'].' '.$user->country['emoji'] }}</span></p>
                                        <p class="text-muted font-13"><strong>Estado, Departamento :</strong> <span class="m-l-15">{{ str_replace('Department','',$user->state['name']) }}</span></p>
                                        <p class="text-muted font-13"><strong>Ciudad :</strong> <span class="m-l-15">{{ $user->city['name'] }}</span></p>
                                        <p class="text-muted font-13"><strong>Dirección :<br></strong> <span class="m-l-5">{{$user->address}}</span></p>
                                    </div>
                                    <ul class="social-links list-inline mt-4 mb-0">
                                        <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Personal-Information -->

                        </div>
                        <div class="col-xl-8">
                            <h4 class="header-title mb-3 w-auto">Ultimas Actividades</h4>
                            <table class="table table-striped table-bordered table-sm" id="logs" width="100%">
                                <thead>
                                <tr >
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">#</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Descripción</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Sujeto Tipo</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Id <br> Sujeto</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Causante Tipo</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Id <br> Causante</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Fecha</th>
                                    <th style="font-size: 12px; vertical-align: middle;text-align: center">Propiedades</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activities as $activity)
                                    <tr>
                                        <td style="font-size: 12px">{{$activity->id}}</td>
                                        <td style="font-size: 12px">{{$activity->description}}</td>
                                        <td style="font-size: 12px">{{$activity->subject_type}}</td>
                                        <td style="font-size: 12px">{{$activity->subject_id}}</td>
                                        <td style="font-size: 12px">{{$activity->causer_type}}</td>
                                        <td style="font-size: 12px">{{$activity->causer_id}}</td>
                                        <td style="font-size: 12px">{{$activity->created_at}}</td>
                                        <td style="font-size: 12px" ><br>
                                            @foreach($activity->properties as $key => $values)
                                                <b>{{$key}}</b><br>
                                                @foreach($values as $k => $value)
                                                    {{$k .' = '.$value}}<br>
                                                @endforeach
                                                    <hr>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
