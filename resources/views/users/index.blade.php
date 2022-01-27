@extends('layouts.app')
@section('styles')

@stop
@section('js')
    <!-- Custom js for this page-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/r-2.2.7/datatables.min.js"></script>
     <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    <script>

        $(function () {
            var f = new Date();
            var table = $('#data').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: {
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="mdi mdi-file-excel"></i> Excel',
                            className: ' btn-sm btn-inverse-success',
                            exportOptions: {
                                 columns: [ 1, 2, 3, 4, 5, 6, ':visible' ]
                            },
                            filename: '{{(is_null(Auth::user()->setting)) ? 'Sysmed' : Auth::user()->setting->name}} Usuarios',
                            title: "{{(is_null(Auth::user()->setting)) ? 'Sysmed' : Auth::user()->setting->name}}",
                            messageTop: 'Usuarios registrados en el sistema al ' + f.getDate() + "/" + f.getMonth() + "/" + f.getFullYear(),
                            messageBottom: '{{ env('APP_NAME') }} V {{ env('VERSION') }} {{ env('DESCRIPTION') }}',
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="mdi mdi-file-pdf"></i> PDF',
                            className: 'btn-sm btn-inverse-danger',
                            exportOptions: {
                               columns: [ 1, 2, 3, 4, 5, 6, ':visible' ]
                            },
                            filename: '{{(is_null(Auth::user()->setting)) ? 'Sysmed' : Auth::user()->setting->name}} Usuarios',
                            title: "{{(is_null(Auth::user()->setting)) ? 'Sysmed' : Auth::user()->setting->name}}",
                            messageTop: 'Usuarios registrados en el sistema al ' + f.getDate() + "/" + f.getMonth() + "/" + f.getFullYear(),
                            messageBottom: '® {{ env('APP_NAME') }} V {{ env('VERSION') }} {{ env('DESCRIPTION') }}',
                            customize: function(doc) {
                              doc.content[1].margin = [ 150, 0, 100, 5 ] //left, top, right, bottom
                              doc.content[2].margin = [ 10, 0, 10, 5 ] //left, top, right, bottom
                              doc.content[3].margin = [ 440, 0, 0, 0 ] //left, top, right, bottom
                            }
                        },
                        {
                            text: '<i class="mdi mdi-delete-variant"></i> Papelera',
                            className: ' btn-sm btn-inverse-warning',
                            action: function ( e, dt, node, config ) {
                                window.location.href = '{{route('users.trash')}}';
                            }
                        },
                        {
                            extend: 'colvis',
                            className: ' btn-sm btn-inverse-primary',
                            text: '<i class="mdi mdi-eye"></i> Columnas'
                        }
                    ],
                },
                processing: true,
                responsive: true,
                stateSave: true,
                serverSide: true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                ajax: "{{ route('users.index') }}",
                columns: [
                        @can('user-delete')
                            {data: 'choose', name: 'choose', orderable: false, searchable: false},
                        @endcan
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'phone', name: 'phone'},
                        {data: 'role', name: 'role'},
                        @role('Admin')
                            {data: 'setting', name: 'setting'},
                        @endrole
                        {data: 'address', name: 'address'},
                ],
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width: '25rem',
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        // Delete record
        $('#delete').on('click', function (e) {
            var idsArr = $('[name="inputs[]"]:checked').map(function () {
                return this.value;
            }).get();
            if (idsArr.length <= 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Debes selecionar uno o varios usuarios para elimiarlos'
                })
            } else {
                $.confirm({
                    title: '!Confirme esta acción!',
                    content: 'Pulsa (Si) para eliminar el o los usuarios selecionados y (No) si no quieres completar esta acción',
                    type: 'red',
                    icon: 'fas fa-fw fa-exclamation-circle',
                    theme: 'bootstrap',
                    backgroundDismiss: 'no',
                    escapeKey: 'no',
                    buttons: {
                        si: {
                            btnClass: 'btn-red',
                            action: function () {
                                var strIds = idsArr.join(",");
                                $.ajax({
                                    url: "{{ route('users.destroy') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    type: 'DELETE',
                                    data: 'ids=' + strIds,
                                    success: function (data) {
                                        $('#data').DataTable().ajax.reload(null, false);
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Usuarios Eliminados'
                                        })
                                    },
                                    error: function (data) {
                                        alert(data.responseText);
                                    }
                                });
                            }
                        },
                        no: {
                            btnClass: 'btn-blue',
                            action: function () {

                            }
                        },
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
                        <h2>{{__('Usuarios')}}</h2>
                        <p class="mb-md-0">{{__('Cree, elimine y actualice usuarios')}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home"></i>&nbsp;/</a>
                        <p class="text-muted mb-0">&nbsp;Usuarios&nbsp;/</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @can('user-delete')
                        <button type="button" id="delete" class="btn btn-danger btn-icon mr-3 mt-2 mt-xl-0">
                            <i class="mdi mdi-delete-outline"></i><span style="font-size: 9px">Eliminar</span>
                        </button>
                    @endcan
                    @can('user-create')
                        <a class="btn btn-primary mt-2 mt-xl-0" href="{{ route('users.create') }}"><i
                                class="mdi mdi-account-plus"></i> {{__('Crear Nuevo Usuario')}}</a>
                    @endcan
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
                    <div class="table-responsive">
                        <table id="data" class="table table-striped table-hover" width="100%">
                            <thead>
                            <tr>
                                @can('user-delete')
                                <th class="text-center" width="30px">Eliminar</th>
                                @endcan
                                <th  width="30px">N.</th>
                                <th width="30px">Nombre</th>
                                <th width="30px">Email</th>
                                <th width="30px">Teléfono</th>
                                <th width="30px">Rol</th>

                                @role('Admin')
                                <th width="50px">Clínica</th>
                                @endrole
                                <th width="50px">Dirección</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
