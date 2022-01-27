@extends('layouts.app')
@section('styles')
<style>
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before{
        margin-top: 10px !important;
    }
    table{
        font-size: 12px;
    }
    th{
        vertical-align: middle; text-align: center;
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
                searching:  false,
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
                        <h3>{{ $user->name1 .' '.$user->name2.' '.$user->surname1}}</h3>
                        <p class="mb-md-0">Información del usuario</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home"></i>&nbsp;/</a>
                        <a class="mb-0" href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0">{{ $user->name1 .' '.$user->name2.' '.$user->surname1}}&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @role('Admin')
                    <form action="{{ route('impersonate.start', compact('user')) }}" method="POST" style="margin:0px">
                        @csrf

                    <button type="submit" id="delete" class="btn btn-warning btn-icon mr-3 mt-2 mt-xl-0" data-toggle="tooltip" data-placement="top" title="Entrar como este usuario">
                            <i class="fas fa-user-clock"></i>
                        </button>
                        </form>
                    @endrole
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
                                        <p class="text-muted font-13"><strong>Nombre Completo:</strong> <span class="m-l-15">{{ $user->name1 .' '.$user->name2.' '.$user->surname1 .' '.$user->surname2}}</span></p>
                                        <p class="text-muted font-13"><strong>Rol:</strong> <span class="m-l-15">{{$user->getRoleNames()->first()}}</span></p>
                                        </p>
                                        @if(is_null($user->setting))
                                        <p class="text-muted font-13"><strong>
                                        Clínca:</strong> <span class="m-l-15 text-warning">Sin clínica</span> <span class="badge badge-pill badge-warning">
                                            @if(Auth::user()->getRoleNames()->first() == 'Médico')<a href="{{route('users.edit',$user->id)}}">Agregar</a>@else Agregar @endif
                                        </span>
                                        </p>
                                        @else
                                        <p class="text-muted font-13"><strong>
                                        Clínca:</strong> <span class="m-l-15">{{$user->setting->name}}</span></p>
                                        @endif
                                        <p class="text-muted font-13"><strong>
                                        Teléfonos:</strong><span class="m-l-15"><a href="tel:{{$user->phone1}}"> {{$user->phone1}}</a></span></p>
                                        @if(is_null($user->email))
                                        <p class="text-muted font-13"><strong>Email:</strong> <span class="m-l-15 text-warning">Sin Email</span> <span class="badge badge-pill badge-warning"><a href="{{route('users.edit',$user->id)}}">Agregar</a></span></p>
                                        @else
                                        <p class="text-muted font-13"><strong>Email:</strong> <span class="m-l-15"><a href = "mailto: {{$user->email}}"> {{$user->email}}</a></span></p>
                                        @endif
                                        <p class="text-muted font-13"><strong>Pais:</strong> <span class="m-l-15">{{ $user->country['name'].' '.$user->country['emoji'] }}</span></p>
                                        <p class="text-muted font-13"><strong>Departamento:</strong> <span class="m-l-15">{{ str_replace('Department','',$user->state['name']) }}</span></p>
                                        <p class="text-muted font-13"><strong>Ciudad:</strong> <span class="m-l-15">{{ $user->city['name'] }}</span></p>
                                        <p class="text-muted font-13"><strong>Dirección:</strong> <span class="m-l-5">{{$user->address}}</span></p>
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
                                <tr>
                                    <th>Acción</th>
                                    <th>Sujeto</th>
                                    <th>Fecha</th>
                                    <th class="none">Propiedades</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activities as $activity)
                                    <tr>
                                        <td>{{__($activity->description)}}</td>
                                           <td>
                                            @if($activity->subject_id ==! null)
                                            <a href="{{route('users.show',$activity->subject_id)}}">{{$users->where('id' , $activity->subject_id)->first()->name1.' '.$users->where('id' , $activity->subject_id)->first()->surname1}}
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{ucfirst($activity->created_at->locale('es')->isoFormat('ddd D \d\e MMM  \a \l\a\s  H:m')) }}</td>
                                        <td>
                                            <br>

                                            @foreach($activity->properties as $key => $values)
                                                <b>{{$key}}</b><br>
                                                @foreach($values as $k => $value)
                                                    {{__($k) .' = '.$value}}<br>
                                                @endforeach
                                                    <hr>
                                            @endforeach

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                            <div class="col-xl-4 small">
                                Mostrando registros del {{$activities->firstItem()}} al {{$activities->lastItem()}} de un total de {{ $activities->total()}} registros
                            </div>
                            <div class="col-xl-8 d-flex justify-content-end">
                                {{ $activities->onEachSide(1)->links() }}
                            </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
