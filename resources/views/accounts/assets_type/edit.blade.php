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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Edit Assets Types</h4>
                <a href="{{ route('admin.assets-types.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
              
                {!! Form::model($assets, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.assets-types.update', $assets->id]]) !!}
        
                <div class="box-body">
                    <div class="form-group col-md-12 @if($errors->has('name')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Bene Bank Code','maxlength'=>'50']) !!}
                        @if($errors->has('name'))
                        <span class="help-block">
                            {{ $errors->first('name') }}
                        </span>
                        @endif
                    </div>
                    
                    
                 

                </div>

                <!-- /.box-body -->
                <button id="btn" class="btn btn-success col-md-12">Update Assets Type</button>

                {!! Form::close() !!}
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop

@section('javascript')

@endsection