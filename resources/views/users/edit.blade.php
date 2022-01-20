@extends('layouts.app')
@section('styles')
    <style>
        .f_user {
            border: solid 1px #E1E1E1 !important;
        }
        input, select {
            height: 40px !important;
        }
        .tab-pane {
            border-bottom-right-radius: 7px;
            border-bottom-left-radius: 7px;
            border-left: solid 1px #dddfeb;
            border-bottom: solid 1px #dddfeb;
            border-right: solid 1px #dddfeb;
            border-top: solid 1px #dddfeb;
        }
        .nav-link-user {
            border-bottom: solid 1px #ffffff !important;
            border-left: solid 1px #dddfeb !important;
            border-top: solid 1px #dddfeb !important;
            border-right: solid 1px #dddfeb !important;
            background: white !important;
            padding-bottom: 10px !important;
            padding-top: 10px !important;
            border-top-right-radius: 7px !important;
            border-top-left-radius: 7px !important;
        }
        .active {
            background-color: #EFF5FB !important;
        }
        a.dropdown-item.active.selected {
            color: #4d83ff;
        }
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
    <script
        src="https://cdn.jsdelivr.net/gh/RobinHerbots/jquery.inputmask@5.0.0-beta.87/dist/jquery.inputmask.min.js">
    </script>
    <script>
        function calcularEdad(fecha) {
            // Si la fecha es correcta, calculamos la edad
            if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
                fecha = formatDate(fecha, "yyyy-MM-dd");
            }
            var values = fecha.split("-");
            var dia = values[2];
            var mes = values[1];
            var ano = values[0];
            // cogemos los valores actuales
            var fecha_hoy = new Date();
            var ahora_ano = fecha_hoy.getYear();
            var ahora_mes = fecha_hoy.getMonth() + 1;
            var ahora_dia = fecha_hoy.getDate();
            // realizamos el calculo
            var edad = (ahora_ano + 1900) - ano;
            if (ahora_mes < mes) {
                edad--;
            }
            if ((mes == ahora_mes) && (ahora_dia < dia)) {
                edad--;
            }
            if (edad > 1900) {
                edad -= 1900;
            }
            // calculamos los meses
            var meses = 0;
            if (ahora_mes > mes && dia > ahora_dia)
                meses = ahora_mes - mes - 1;
            else if (ahora_mes > mes)
                meses = ahora_mes - mes
            if (ahora_mes < mes && dia < ahora_dia)
                meses = 12 - (mes - ahora_mes);
            else if (ahora_mes < mes)
                meses = 12 - (mes - ahora_mes + 1);
            if (ahora_mes == mes && dia > ahora_dia)
                meses = 11;
            // calculamos los dias
            var dias = 0;
            if (ahora_dia > dia)
                dias = ahora_dia - dia;
            if (ahora_dia < dia) {
                ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
                dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
            }
            return edad + " años, " + meses + " meses y " + dias + " días";
        }
        $('#birth').focusout(function () {
            var x = $(this).val();
            age = calcularEdad(x);
            $("#age").val(age);
        });
        $('#surname1').focusout(function () {
            surname1 = $("#surname1").val();
            name1 = $("#name1").val();
            id = $("#id").val() + {{ auth()->id() }};
            if (surname1 == 0 || name1 == 0) {
            } else {
                codigo = name1.charAt(0) + surname1.charAt(0) + id.padStart(6, 0);
                $("#patient_code").val(codigo.toUpperCase());
            }
        });
        $('#name1').focusout(function () {
            surname1 = $("#surname1").val();
            name1 = $("#name1").val();
            id = $("#id").val() + {{ auth()->id() }};
            if (surname1 == 0 || name1 == 0) {
            } else {
                codigo = name1.charAt(0) + surname1.charAt(0) + id.padStart(6, 0);
                $("#patient_code").val(codigo.toUpperCase());
            }
        });
        $('#name_relation').focusout(function () {
            name_relation = $("#name_relation").val();
            if (name_relation == 0) {
                $("#kinship").attr("required", false);
            } else {
                $("#kinship").attr("required", true);
            }
        });
        $( document ).ready(function() {
            role = $('#role').val();
            if (role == 'Médico' || role == 'Asistente') {
                $(".h-medico").addClass("d-none")
            }else{
                $(".h-patient").addClass("d-none")
            }

        });
        $('#civil').on('change', function () {
            var gender = $('#gender').find(":selected").val();
            var civil = $(this).find(":selected").val();
            if (gender == 'M') {
                $("#married").addClass("d-none")
            }
        });
        $('#gender').on('change', function () {
            var gender = $(this).find(":selected").val();
            var civil = $('#civil').find(":selected").val();
            if (gender == 'M') {
                $("#married").addClass("d-none")
            }
        });
        $('#civil').on('change', function () {
            var gender = $('#gender').find(":selected").val();
            var civil = $(this).find(":selected").val();
            if (gender == 'F' && civil == 'Married') {
                $("#married").removeClass("d-none")
            }
        });
        $('#gender').on('change', function () {
            var gender = $(this).find(":selected").val();
            var civil = $('#civil').find(":selected").val();
            if (gender == 'F' && civil == 'Married') {
                $("#married").removeClass("d-none")
            }
        });
        $('#civil').on('change', function () {
            var gender = $('#gender').find(":selected").val();
            var civil = $(this).find(":selected").val();
            if (gender == 'F' && civil == 'Single') {
                $("#married").addClass("d-none")
            }
        });
        $('#gender').on('change', function () {
            var gender = $(this).find(":selected").val();
            var civil = $('#civil').find(":selected").val();
            if (gender == 'F' && civil == 'Single') {
                $("#married").addClass("d-none")
            }
        });
        // Initialize InputMask
        $(":input").inputmask();
    </script>
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
                            $('#state').append('<option>Seleccione Departamento</option>');
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
                        <h2>Editar Usuario</h2>
                        <p class="mb-md-0">Edita la información
                            de {{ $user->name1 .' '.$user->name2.' '.$user->surname1 .' '.$user->surname2}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home"></i>&nbsp;/</a>
                        <a href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <a href="{{route('users.show',$user->id)}}">{{ $user->name1 .' '.$user->surname1}}
                            &nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0">Editar&nbsp;/&nbsp;</p>
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
                        <div class="col-lg-2 imgUp">
                            <label class="font-weight-medium mb-3">Foto:</label>
                            <div class="imagePreview" style="
                                width: 100%;
                                height: 180px;
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
                                                    style="width: 0px;height: 0px !important;overflow: hidden;">
                            </label>
                            @if ($errors->has('avatar'))
                                <small class="text-danger">{{ $errors->first('avatar') }}</small>
                            @endif
                        </div><!-- col-3 -->
                        @include('users.inputs')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
@endsection
