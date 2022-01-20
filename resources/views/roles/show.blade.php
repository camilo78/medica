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
                        <h2>Rol {{ $role->name }}</h2>
                        <p class="mb-md-0">Información del rol</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home"></i>&nbsp;/</a>
                        <a href="{{route('roles.index')}}">&nbsp;Roles&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">{{$role->name}}&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @can('user-edit')
                        <a class="btn btn-info mr-3 mt-2 mt-xl-0" href="{{ route('roles.edit',$role->id) }}"> <i
                                class="mdi mdi-account-edit"></i> Editar Rol</a>
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $role->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions->chunk(4) as $items)
                                        <div class="row">
                                            @foreach($items as $v)
                                                <div class="col-md-3">
                                                    <p class="list-group-item mb-4">{{ $v->name }}</P>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
