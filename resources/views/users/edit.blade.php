@extends('layouts.app')
@section('styles')
    <style>

        .btn-primary_upload {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);

        }

        .imgUp {
            margin-bottom: 15px;
        }

        .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        .imgAdd {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4bd7ef;
            color: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 30px;
            margin-top: 0px;
            cursor: pointer;
            font-size: 15px;
        }
    </style>
@stop
@section('js')
    <script>
        $(".imgAdd").click(function () {
            $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
        });
        $(document).on("click", "i.del", function () {
            $(this).parent().remove();
        });
        $(function () {
            $(document).on("change", ".uploadFile", function () {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
    </script>
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
                            $.each(res, function (key, value) {
                                $('#state').append('<option value="' + key + '">' + value.replace('Department', '') + '</option>');
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
                        <h2>Editar Usuario</h2>
                        <p class="mb-md-0">Edita la información
                            de {{ $user->name1 .' '.$user->name2.' '.$user->surname1 .' '.$user->surname2}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <a href="{{route('users.show',$user->id)}}">{{ $user->name1 .' '.$user->surname1}}
                            &nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor">Editar&nbsp;/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a class="btn btn-primary mt-2 mt-xl-0" href="{{ URL::previous()}}"><i
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
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],'enctype'=>'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-lg-3 imgUp">
                            <label class="font-weight-medium mb-3">Foto:</label>
                            <div class="imagePreview" style="
                                width: 100%;
                                height: 230px;
                                @if($user->avatar == null)
                                background: url({{asset('images/sin_imagen.jpg')}});
                            @else
                                background: url({{asset('storage/'.$user->avatar)}});
                                @endif

                                background-color: #fff;
                                background-position: center;
                                background-size: cover;
                                background-repeat: no-repeat;
                                display: inline-block;
                                box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
                                "></div>
                            <label class="btn btn-primary btn-primary_upload">
                                Buscar Imagen<input type="file" name="avatar" class="uploadFile img" value="Upload Photo"
                                             style="width: 0px;height: 0px;overflow: hidden;">
                            </label>

                        @if ($errors->has('avatar'))
                            <small class="text-danger">{{ $errors->first('avatar') }}</small>
                        @endif
                        </div><!-- col-2 -->
                    <div class="col-lg-9">
                        @include('users.inputs')
                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
