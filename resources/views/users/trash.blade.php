@extends('layouts.app')
@section('styles')

@stop
@section('js')
    <!-- Custom js for this page-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/r-2.2.7/datatables.min.js"></script>

    <script>

        $(function () {
            var f = new Date();
            var table = $('#data').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: {
                    buttons: [
                        {
                            text: '<i class="mdi mdi-account-group"></i> Regresar a Usuarios',
                            className: ' btn-sm btn-inverse-info',
                            action: function ( e, dt, node, config ) {
                                window.location.href = '{{route('users.index')}}';
                            }
                        }
                    ],
                },
                processing: true,
                responsive: true,
                stateSave: true,
                serverSide: true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "columnDefs": [
                    { className: "text-center", "targets": [ 5 ] }
                ],
                ajax: "{{ route('users.trash') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'role', name: 'role'},
                        @can('user-restore')
                    {data: 'choose', name: 'choose', orderable: false, searchable: false},
                    @endcan
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
                    title: 'Debes selecionar uno o varios usuarios para restaurarlos'
                })
            } else {
                $.confirm({
                    title: '!Confirme esta acción!',
                    content: 'Pulsa (Si) para restaurar el o los usuarios selecionados y (No) si no quieres completar esta acción',
                    type: 'orange',
                    icon: 'fas fa-fw fa-exclamation-circle',
                    theme: 'bootstrap',
                    backgroundDismiss: 'no',
                    escapeKey: 'no',
                    buttons: {
                        si: {
                            btnClass: 'btn-warning',
                            action: function () {
                                var strIds = idsArr.join(",");
                                $.ajax({
                                    url: "{{ route('users.restore') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    type: 'POST',
                                    data: 'ids=' + strIds,
                                    success: function (data) {
                                        $('#data').DataTable().ajax.reload(null, false);
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Usuarios Restaurados'
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
                        <h2>{{__('Usuarios Eliminados')}}</h2>
                        <p class="mb-md-0">{{__('Seleccione y restaure usuarios eleminados')}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <a href="{{route('home')}}"><i class="mdi mdi-home hover-cursor"></i>&nbsp;/</a>
                        <a href="{{route('users.index')}}">&nbsp;Usuarios&nbsp;/&nbsp;</a>
                        <p class="text-muted mb-0 hover-cursor"> Papelera</p>

                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    @can('user-restore')
                        <button type="button" id="delete" class="btn btn-warning btn-icon mr-3 mt-2 mt-xl-0 ">
                            <i class="mdi mdi-delete-restore"></i><span style="font-size: 8px">Restaurar</span>
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
                                <th class="text-center" width="50px">N°</th>
                                <th width="50px">Nombre</th>
                                <th width="50px">Email</th>
                                <th width="50px">Teléfono</th>
                                <th width="50px">Rol</th>
                                @can('user-restore')
                                    <th class="text-center" width="50px"><i class="mdi mdi-checkbox-marked-outline"></i></th>
                                @endcan
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
