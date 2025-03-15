@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet"
    href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


@stop
@section('breadcrumbs')
@section('content')
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }

    .col-md-3 {
        padding: 10px;
    }

    .col-md-6 {
        padding: 10px;
    }

    .col-md-12 {
        padding: 10px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Bank Loan Details</h4>
                <a href="{{ route('admin.bank-loan.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
            <div class="panel-body pad table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Installment No</th>
                    <th>Markup Per Year</th>
                    <th>Markup Per Month</th>
                    <th>Insurance</th>
                    <th>Principal</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>
                    <?php
                        $i=1;
                    ?>
                @foreach($array as $arr)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>Installment No: <?php echo $i; ?></td>
         
                <td>{{$arr['markup_per_year']}}</td>
                <td>{{$arr['markup_per_month']}}</td>
                <td>{{$arr['insurance']}}</td>
           
                <td>{{$arr['principal']}}</td>
                    <td>{{$arr['total']}}</td>
                    <?php
                    $i++;
                    ?>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total: </b>{{$total}}</td>
                    <td></td>
                
                </tr>

                </tbody>
            </table>
        </div>
            
      
        </div>
        <!-- /.box-body -->


            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop
