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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Loan Type</h4>
                <a href="{{ route('admin.loan-type.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => ['admin.loan-type.store'],
                'id' => 'validation-form']) !!}
                <div class="box-body">
                    <div class="form-group col-md-6 @if($errors->has('loan_type')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Loan Type*', ['class' => 'control-label']) !!}
                        {!! Form::text('loan_type', old('loan_type'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Loan Type','maxlength'=>'50']) !!}
                        @if($errors->has('loan_type'))
                        <span class="help-block">
                            {{ $errors->first('loan_type') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 @if($errors->has('description')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Description*', ['class' => 'control-label']) !!}
                        {!! Form::text('description', old('description'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Description','maxlength'=>'50']) !!}
                        @if($errors->has('description'))
                        <span class="help-block">
                            {{ $errors->first('description') }}
                        </span>
                        @endif
                    </div>
                    
                 

                </div>

                <!-- /.box-body -->
                <button id="btn" class="btn btn-success col-md-12">Add New Loan Type</button>

                {!! Form::close() !!}
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop

@section('javascript')

@endsection