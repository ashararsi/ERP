@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Notification</h4>
                <a href="{{ route('admin.eobi-notification.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => ['admin.eobi-notification.store'],
                'id' => 'validation-form']) !!}
                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif" style="float:left;">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    <input type="text" name="name" required="required" placeholder="Enter Name" class="form-control" />
                </div>
                
                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif" style="float:left;">
                    {!! Form::label('name', 'Description*', ['class' => 'control-label']) !!}
                    <input type="text" name="description" required="required" placeholder="Enter Description" class="form-control" />
                </div>
                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif" style="float:left;">
                    {!! Form::label('name', 'Date*', ['class' => 'control-label']) !!}
                    <input type="date" name="date" value="0" placeholder="Select Date" class="form-control" required="required"/>
                </div>

                
                <div class="form-group col-md-4 @if($errors->has('name')) has-error @endif" style="float:left;">
                    {!! Form::label('name', 'Amount*', ['class' => 'control-label']) !!}
                    <input type="number" name="amount" value="0" placeholder="Enter Amount" class="form-control" required="required" />
                </div>
                <div class="form-group col-md-4 @if($errors->has('subject_fee')) has-error @endif" style="float:left">
                    {!! Form::label('name', 'Company Share', ['class' => 'control-label']) !!}
                    <input type="number" name="company_share" value="0" placeholder="Enter Company Share" class="form-control" required="required" />
                </div>

                
                <!-- /.box-body -->
                <div>
                    <button id="btn" class="btn btn-success col-md-12">Add New Notification</button>

                {!! Form::close() !!}
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>

    @stop

    @section('javascript')

    @endsection