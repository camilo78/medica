@extends('layouts.app')
@section('styles')

@stop
@section('js')
<script type="text/javascript">
    const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              showCloseButton: true,
              timer: 5000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
        })

        var has_errors = {{ $errors->count() > 0 ? 'true' : 'false'}};
        if(has_errors){
            Toast.fire({
                title: 'Errores del Formulario',
                icon: 'error',
                html:jQuery("#ERROR_COPY").html(),
            })
        }
</script>
@stop
@section('title')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5 mr-4">
                        <h2>Crear Rol</h2>
                        <p class="mb-md-0">Crea un nuevo rol </p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('roles.index')}}">&nbsp;Roles&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">Crear&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a class="btn btn-primary mt-2 mt-xl-0" href="{{ URL::previous() }}"><i
                            class="mdi mdi-step-backward"></i> Atras</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
<div id="ERROR_COPY" style="display:none">
        @foreach ($errors->all() as $error)
            <p style="text-align:left;"><i class="fas fa-arrow-right fa-fw text-danger"></i> {{ $error }}</p>
        @endforeach
</div>
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="font-weight-medium">Name:</label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                @if ($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="font-weight-medium mb-1">Permission:</label>
                                @if ($errors->has('permission'))
                                    <small class="text-danger">{{ $errors->first('permission') }}</small>
                                @endif
                                @foreach($permission->chunk(4) as $items)
                                    <div class="row">
                                        @foreach($items as $value)
                                            <div class="col-md-3">
                                                <p class="list-group-item mb-4">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }} {{ $value->name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary  align-self-end">Guardar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
