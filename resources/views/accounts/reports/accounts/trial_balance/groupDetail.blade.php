@inject('request', 'Illuminate\Http\Request')
@inject('CoreAccounts', '\App\Helpers\CoreAccounts')
@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <?php
                    $start_date = date('d-m-Y', strtotime($start_date));
                    $end_date = date('d-m-Y', strtotime($end_date));
                    ?>
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Group ({!! $group_name !!}) detail
                        from {{ $start_date }}
                        to {{ $end_date }}
                    </h4>
                </div>

                <div class="card-body">
                    <div class="panel-body pad table-responsive">
                        <table class="table table-bordered table-striped design-table" style="width:100%">
                            <thead>
                            <tr>
                                <th style="font-size: 14px;color: black;">Acc. Name</th>
                                <th style="text-align: right; font-size: 14px;color: black;">Op. Dr</th>
                                <th style="text-align: right;font-size: 14px;color: black;">Op. Cr</th>
                                <th style="text-align: right;font-size: 14px;color: black;">Debit</th>
                                <th style="text-align: right; font-size: 14px;color: black;">Credit</th>
                                <th style="text-align: right; font-size: 14px;color: black;">Cl. Dr</th>
                                <th style="text-align: right;font-size: 14px;color: black;">Cl. Cr</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! $ReportData !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js"
            type="text/javascript"></script>
    <script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"
            type="text/javascript"></script>
    <script language="JavaScript"
            src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"
            type="text/javascript"></script>
@stop
