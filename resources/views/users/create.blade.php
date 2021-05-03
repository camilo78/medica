@extends('layouts.app')
@section('css')

@stop
@section('js')
    <script>
        $('#country').change(function () {
            var cid = $(this).val();
            if (cid) {
                $.ajax({
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    url: " {{url('/getStates')}}/" + cid, //Please see the note at the end of the post**
                    success: function (res) {
                        if (res) {
                            $('#state').empty();
                            $('#city').empty();
                            $('#state').append('<option>Select State</option>');
                            $.each(res, function (key, value) {
                                $('#state').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }

                });
            }
        });
        $('#state').change(function () {
            var sid = $(this).val();
            if (sid) {
                $.ajax({
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{url('/getCities')}}/" + sid, //Please see the note at the end of the post**
                    success: function (res) {
                        if (res) {
                            $('#city').empty();
                            $('#city').append('<option>Select City</option>');
                            $.each(res, function (key, value) {
                                $('#city').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }

                });
            }
        });
    </script>
@stop
@section('title')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5 mr-4">
                        <h2>Crear Usuario</h2>
                        <p class="mb-md-0">Crea un nuevo usuario </p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">Crear&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a class="btn btn-primary mt-2 mt-xl-0" href="{{ route('users.index')}}"><i
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
                    {!! Form::open(array('route' => 'users.store','method'=>'POST','enctype'=>'miltipart/form-data')) !!}
                    <div class="row">
                        @include('users.inputs')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
