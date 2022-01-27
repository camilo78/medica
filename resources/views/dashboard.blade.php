@extends('layouts.app')
@section('styles')
@stop
@section('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- Custom js for this page-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/r-2.2.7/datatables.min.js"></script>

    <!-- End custom js for this page-->
@stop
@section('title')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2>{{__('Estadísticas')}}</h2>
                        <p class="mb-md-0">{{__('Información importante sobre tu clínica')}}</p>
                    </div>
                    <div class="d-flex mb-sm-2 mb-md-0">
                        <p class="text-muted mb-0 hover-cursor"><i class="mdi mdi-home text-muted hover-cursor"></i>/&nbsp;</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                        <i class="mdi mdi-download text-muted"></i>
                    </button>
                    <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                        <i class="mdi mdi-clock-outline text-muted"></i>
                    </button>
                    <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                        <i class="mdi mdi-plus text-muted"></i>
                    </button>
                    <button class="btn btn-primary mt-2 mt-xl-0">{{__('Generate report')}}</button>
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
                    <p class="card-title">Recent Purchases</p>
                    <div class="table-responsive">
                        <table id="recent-purchases-listing" class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status report</th>
                                <th>Office</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Gross amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Jeremy Ortega</td>
                                <td>Levelled up</td>
                                <td>Catalinaborough</td>
                                <td>$790</td>
                                <td>06 Jan 2018</td>
                                <td>$2274253</td>
                            </tr>
                            <tr>
                                <td>Alvin Fisher</td>
                                <td>Ui design completed</td>
                                <td>East Mayra</td>
                                <td>$23230</td>
                                <td>18 Jul 2018</td>
                                <td>$83127</td>
                            </tr>
                            <tr>
                                <td>Emily Cunningham</td>
                                <td>support</td>
                                <td>Makennaton</td>
                                <td>$939</td>
                                <td>16 Jul 2018</td>
                                <td>$29177</td>
                            </tr>
                            <tr>
                                <td>Minnie Farmer</td>
                                <td>support</td>
                                <td>Agustinaborough</td>
                                <td>$30</td>
                                <td>30 Apr 2018</td>
                                <td>$44617</td>
                            </tr>
                            <tr>
                                <td>Betty Hunt</td>
                                <td>Ui design not completed</td>
                                <td>Lake Sandrafort</td>
                                <td>$571</td>
                                <td>25 Jun 2018</td>
                                <td>$78952</td>
                            </tr>
                            <tr>
                                <td>Myrtie Lambert</td>
                                <td>Ui design completed</td>
                                <td>Cassinbury</td>
                                <td>$36</td>
                                <td>05 Nov 2018</td>
                                <td>$36422</td>
                            </tr>
                            <tr>
                                <td>Jacob Kennedy</td>
                                <td>New project</td>
                                <td>Cletaborough</td>
                                <td>$314</td>
                                <td>12 Jul 2018</td>
                                <td>$34167</td>
                            </tr>
                            <tr>
                                <td>Ernest Wade</td>
                                <td>Levelled up</td>
                                <td>West Fidelmouth</td>
                                <td>$484</td>
                                <td>08 Sep 2018</td>
                                <td>$50862</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
