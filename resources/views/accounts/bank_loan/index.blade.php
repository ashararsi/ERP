@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet"
    href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


@stop
@section('content')
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Bank Loan</h4>
                @if(Auth::user()->isAbleTo('bank-loan-create'))
                <a href="{{route('admin.bank-loan.create')}}" style="float:right;" class="btn btn-success pull-right">Add New
                 Bank Loan</a>
                 @endif

            </div><!-- end card header -->

            <div class="card-body">
                <table class="table table-bordered table-striped {{ count($loan) > 0 ? 'datatable' : '' }}">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Bank Name</th>
                            <th>Company Name</th>
                            <th>Loan Type</th>
                            <th>Loan Plan</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Mark Up</th>
                            <th>Deduction Each Month</th>
                            <th>Kabis</th>
                            <th>Bank Interest</th>
                            @if(Auth::user()->isAbleTo('bank-loan-show'))
                            <th>Details</th>
                            @endif
                            @if(Auth::user()->isAbleTo('bank-loan-edit'))
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($loan) > 0)
                        <?php
                $i=0;
                ?>
                        @foreach ($loan as $bank)
                        <?php $i++; ?>
                        <tr data-entry-id="{{ $bank->id }}">
                            <td>
                                {{$i}}
                            </td>
                            <td>{{ $bank->bank_name }}</td>
                            <td>{{ $bank->company_name }}</td>
                            <td>{{ $bank->loan_type }}</td>
                            <td>{{ $bank->loan_installment }}</td>
                            <td>{{ $bank->tenure }}</td>
                            <td>{{ $bank->amount }}</td>
                            <td>{{ $bank->markup }}</td>
                            <td>{{ $bank->deduction_each_month}}</td>
                            <td>{{ $bank->kabis}}</td>
                            <td>{{ $bank->bank_intrest}}</td>
                            @if(Auth::user()->isAbleTo('bank-loan-show'))
                            <td>
                            <div class="hstack gap-3 flex-wrap">
                                    <a href="bank-loan-details\{{$bank->id}}" class="btn btn-danger">
                                            Show</a>
                                   
                                </div>
                            </td>
                            @endif
                            @if(Auth::user()->isAbleTo('bank-loan-edit'))
                            <td>
                                <div class="hstack gap-3 flex-wrap">
                                    <a href="bank-loan\{{$bank->id}}\edit" class="link-success fs-15"><i
                                            class="ri-edit-2-line"></i></a>
                                   
                                </div>

                            </td>
                            @endif


                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop

@section('javascript')

@endsection