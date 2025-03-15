@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
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
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Edit Groups</h4>
                    <a href="{{ route('admin.groups.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

                </div><!-- end card header -->

                <div class="card-body">

                    {!! Form::model($group, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.groups.update', $group->id]]) !!}

                    <div class="box-body">
                        <div class="form-group col-md-6 @if($errors->has('bene_bank_code')) has-error @endif"
                             style="float:left;">
                            {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                            'Enter Group Name','maxlength'=>'50']) !!}
                            @if($errors->has('name'))
                                <span class="help-block">
                            {{ $errors->first('bene_bank_code') }}
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 @if($errors->has('bank_name')) has-error @endif"
                             style="float:left;">
                            {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}

                            <select class="form-control groups" name="parent_id" required>
                                <option>Select Parent Groups</option>
                                {!! $groups !!}

                            </select>
                        </div>


                    </div>

                    <!-- /.box-body -->
                    <button id="btn" class="btn btn-success col-md-12">Update Group</button>

                    {!! Form::close() !!}
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
@stop
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.groups').select2();
        });
    </script>
@endsection
