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

    .col-md-4 {
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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Edit Loan Plan</h4>
                <a href="{{ route('admin.loan-type.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
           
                {!! Form::model($loan, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.loan-plan.update', $loan->loan_plan_id]]) !!}
        
                <div class="box-body">
                    <div class="form-group col-md-6 @if($errors->has('loan_installment')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Loan Plan*', ['class' => 'control-label']) !!}
                        {!! Form::text('loan_installment', old('loan_installment'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Loan Installment','maxlength'=>'50']) !!}
                        @if($errors->has('loan_installment'))
                        <span class="help-block">
                            {{ $errors->first('loan_installment') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('tenure')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Tenure*', ['class' => 'control-label']) !!}
                        {!! Form::number('tenure', old('tenure'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Description','maxlength'=>'50']) !!}
                        @if($errors->has('tenure'))
                        <span class="help-block">
                            {{ $errors->first('tenure') }}
                        </span>
                        @endif
                    </div>
                    
                 

                </div>

                <!-- /.box-body -->
                <button id="btn" class="btn btn-success col-md-12">Edit Loan Plan</button>

                {!! Form::close() !!}
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop

@section('javascript')

@endsection