<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel 8 User Roles and Permissions Tutorial') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/base/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/r-2.2.7/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <style>
        a:hover {
            text-decoration: none;
        }

        .custom-select {
            width: 50px !important;
        }

        .loader-page {
            position: fixed;
            z-index: 25000;
            background: rgb(255, 255, 255);
            left: 0px;
            top: 0px;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .3s ease;
        }

        .loader-page::before {
            content: "";
            position: absolute;
            border: 2px solid rgb(50, 150, 176);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-sizing: border-box;
            border-left: 2px solid rgba(50, 150, 176, 0);
            border-top: 2px solid rgba(50, 150, 176, 0);
            animation: rotarload 1s linear infinite;
            transform: rotate(0deg);
        }

        @keyframes rotarload {
            0% {
                transform: rotate(0deg)
            }
            100% {
                transform: rotate(360deg)
            }
        }

        .loader-page::after {
            position: absolute;
            border: 2px solid rgba(50, 150, 176, .5);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-sizing: border-box;
            border-left: 2px solid rgba(50, 150, 176, 0);
            border-top: 2px solid rgba(50, 150, 176, 0);
            animation: rotarload 1s ease-out infinite;
            transform: rotate(0deg);
        }
    </style>
    @yield('styles')
</head>
<body class="sidebar-icon-only">
<div id="app" class="container-scroller">
    <div class="loader-page"></div>
    @include('partials.navbar')
    <div class="container-fluid page-body-wrapper">
        @include('partials.sidebard')
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('title')
                @include('sweetalert::alert')
                @if (session('status'))
                    <div class="alert card bg-gradient-primary border-0" role="alert">
                        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
                            <p class="mb-0 text-white font-weight-medium">{{ session('status') }}</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                {{-- @include('partials.probanner')--}}
                @yield('content')
            </div>
            <!-- content-wrapper ends -->
        @include('partials.footer')
        <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/template.js')}}"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- endinject -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@yield('js')
<script type="text/javascript">
    (function ($) {
        jQuery.isEmpty = function (obj) {
            var isEmpty = obj;
            if (typeof obj == 'undefined' || obj === null || obj === '') {
                isEmpty = '';
            }
            if (typeof obj == 'number' && isNaN(obj)) {
                isEmpty = '';
            }
            if (obj instanceof Date && isNaN(Number(obj))) {
                isEmpty = '';
            }
            return isEmpty;
        }
    })(jQuery);
    $(window).on('load', function () {
        setTimeout(function () {
            $(".loader-page").css({visibility: "hidden", opacity: "0"})
        }, 300);
    });
    var URLSHOW = '{{URL::to('users')}}/';
    $('body').on('keyup', '#search-users', function () {
        var searchQuest = $(this).val();
        if (searchQuest == '') {
            $('#dynamic').html('');
            $('#dynamic').hide();
        } else {
            $.ajax({
                method: 'POST',
                url: '{{route("users.search")}}',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    searchQuest: searchQuest,
                },
                beforeSend: function () {
                    // Show image container
                    $("#loader").show();
                },
                success: function (res) {
                    var row = '';
                    $('#dynamic').show();
                    $('#dynamic').html('');
                    $.each(res, function (index, value) {
                        if (index > 9) return false;
                        row = '<p><a href="' + URLSHOW + value.id + '">' + value.name1 + ' ' + jQuery.isEmpty(value.name2) + ' ' + value.surname1 + ' ' + jQuery.isEmpty(value.surname2) + '</a></p>';
                        $('#dynamic').append(row);
                    });
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Sin conexión.\n Verifica tu red.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Recurso no encontrado. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Error del servidor [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'El análisis JSON solicitado falló.';
                    } else if (exception === 'timeout') {
                        msg = 'Error de tiempo de espera.';
                    } else if (exception === 'abort') {
                        msg = 'Solicitud de Ajax abortada.';
                    } else {
                        msg = 'Error no detectado.\n' + jqXHR.responseText;
                    }
                    $('#dynamic').html('');
                },
            })
        }

    });

    $('body').on('keyup', '#search-users1', function () {

        var searchQuest = $(this).val();
        if (searchQuest == '') {
            $('#dynamic1').html('');
            $('#dynamic1').hide();
        } else {
            $.ajax({
                method: 'POST',
                url: '{{route("users.search")}}',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    searchQuest: searchQuest,
                },
                beforeSend: function () {
                    // Show image container
                    $("#loader1").show();
                },
                success: function (res) {
                    var row = '';
                    $('#dynamic1').show();
                    $('#dynamic1').html('');
                    $.each(res, function (index, value) {
                        if (index > 9) return false;
                        row = '<p><a href="' + URLSHOW + value.id + '">' + value.name1 + ' ' + jQuery.isEmpty(value.name2) + ' ' + value.surname1 + ' ' + jQuery.isEmpty(value.surname2) + '</a></p>';
                        $('#dynamic1').append(row);
                    });
                },
            })
        }

    });
</script>
<script src="{{ asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
</body>
</html>
