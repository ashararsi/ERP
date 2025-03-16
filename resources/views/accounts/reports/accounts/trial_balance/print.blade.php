@inject('request', 'Illuminate\Http\Request')
@if($request->get('medium_type') != 'web')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">

    <style type="text/css">
        @page {
            margin: 10px 20px;
        }

        @media print {
            table {
                font-size: 12px;
            }

            .tr-root-group {
                background-color: #F3F3F3;
                color: rgba(0, 0, 0, 0.98);
                font-weight: bold;
            }

            .tr-group {
                font-weight: bold;
            }

            .bold-text {
                font-weight: bold;
            }

            .error-text {
                font-weight: bold;
                color: #FF0000;
            }

            .ok-text {
                color: #006400;
            }

            .th {
                color: black;
                font-size: 17px;
            }

        }

        table {
            border: black 1px solid;
        }

        td {
            border: black 1px solid;
        }

        th {
            border: black 1px solid;
        }

        table, td, th {
            padding: 5px;
        }
    </style>
@endif
@inject('CoreAccounts', '\App\Helpers\CoreAccounts')
<div class="panel-body pad table-responsive">
    <div class="col-md-12">
        <?php
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        ?>
        <ul>
            @if($company != null || $branch != null)
                <h2 style="text-align:center;">{{$company}}</h2>
                <h2 style="text-align:center;">{{$branch}}</h2>
            @endif
            <h5 style="text-align:center;">Trial Balance from {{ $start_date }} to {{ $end_date }}</h5>
        </ul>
    </div>
    @if($request->get('medium_type') == 'web')
        <div class="row mb-2" style="margin-top: -25px">
            <div class="col-md-6"></div>
            <div class="col-md-6" style="">
                <div class="">
                    {{--                <button onclick="FormControls.printReport('excel');" type="button"--}}
                    {{--                        style="background: #199c19; color: white;" class="btn bg-olive btn-flat"><i--}}
                    {{--                        class="fa fa-file-excel-o"></i>&nbsp;Excel--}}
                    {{--                </button>--}}
                    <!--<button onclick="FormControls.printReport('pdf');" type="button" class="btn btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>-->
                    <button onclick="FormControls.printReport('pdf');" type="button"
                            style="background: #817ba7; color: white;float: right;" class="btn btn-flat"><i
                            class="fa fa-print"></i>&nbsp;Print
                    </button>
                    <button onclick="FormControls.printReport('excel');" type="button"
                            style="background: #0ab39c; color: white;float: right;" class="btn btn-flat"><i
                            class="fa fa-print"></i>&nbsp;Excel
                    </button>
                </div>
            </div>
        </div>
    @endif

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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
<script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"
        type="text/javascript"></script>
<script language="JavaScript"
        src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"
        type="text/javascript"></script>
