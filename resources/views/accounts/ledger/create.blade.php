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
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Ledger</h4>
                    <a href="{{ route('admin.ledger.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

                </div><!-- end card header -->

                <div class="card-body">
                    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => ['admin.ledger-store'],
                    'id' => 'validation-form']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif"
                                 style="float:left;">
                                {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                                {!! Form::text('name', old('name'), ['class' => 'form-control','id' => 'ledger_name', 'placeholder' => '','maxlength'=>250]) !!}
                                <ul id="results" class="list-group"></ul>
                                @if($errors->has('name'))
                                    <span class="help-block">
            {{ $errors->first('name') }}
        </span>
                                @endif
                            </div>
                            {{--<div class="col-md-6 form-group" style = "float:left;">
                               {!! Form::label('company_id', 'Company Name ', ['class' => 'control-label']) !!}
                               {!! Form::select('company_id', $company->prepend('Select Company', ''),old('company_id'), ['class' => 'form-control','required' => 'required',]) !!}
                               <span id="company_id_handler"></span>
                               @if($errors->has('company_id'))
                                       <span class="help-block">
                                               {{ $errors->first('company_id') }}
                                       </span>
                               @endif
                           </div>
                           <div class="col-md-6 form-group" style = "float:left;">
                               {!! Form::label('city_id', 'City Name ', ['class' => 'control-label']) !!}
                               {!! Form::select('city_id', $city->prepend('Select City', ''),old('city_id'), ['class' => 'form-control','required' => 'required']) !!}
                               <span id="city_id_handler"></span>
                               @if($errors->has('city_id'))
                                       <span class="help-block">
                                               {{ $errors->first('city_id') }}
                                       </span>
                               @endif
                           </div> --}}

                            <div class="col-md-6 form-group @if($errors->has('branch_id')) has-error @endif"
                                 style="float:left;">

                                {!! Form::label('branch', 'Branches', ['class' => 'control-label', 'id' => 'branch_selector']) !!}
                                <select name='branch_id'
                                        class="form-control input-sm select2"
                                        id="branch_id">
                                    <option value="">Select Branches</option>
                                    @foreach($branches as $key=>$value)
                                        @if(Auth::user()->roles[0]->name=="administrator" || Auth::user()->isAbleTo('Branch_'.$key))
                                            <option value="{!! $key !!}">{!! $value !!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class=" col-md-4 form-group @if($errors->has('balance_type')) has-error @endif"
                                 style="float:left;">
                                {!! Form::label('balance_type', 'Balance Type', ['class' => 'control-label']) !!}
                                <select name="balance_type" class="form-control" required>
                                    <option value="">Select Balance Type</option>
                                    <option value="d">Debit</option>
                                    <option value="c">Credit</option>
                                </select>
                                @if($errors->has('balance_type'))
                                    <span class="help-block">
            {{ $errors->first('balance_type') }}
        </span>
                                @endif
                            </div>

                            <div class=" col-md-4 form-group @if($errors->has('opening_balance')) has-error @endif"
                                 style="float:left;">
                                {!! Form::label('opening_balance', 'Opening Balance', ['class' => 'control-label']) !!}
                                {!! Form::text('opening_balance', old('opening_balance'), ['class' => 'form-control' , 'pattern'=> '[0-9]+','maxlength'=>10]) !!}
                                @if($errors->has('opening_balance'))
                                    <span class="help-block">
            {{ $errors->first('opening_balance') }}
        </span>
                                @endif
                            </div>
                            <div class=" col-md-4 form-group @if($errors->has('closing_balance')) has-error @endif"
                                 style="float:left;">
                                {!! Form::label('closing_balance', 'Closing Balance', ['class' => 'control-label']) !!}
                                {!! Form::number('closing_balance', old('closing_balance'), ['readonly' => true, 'class' => 'form-control']) !!}
                                @if($errors->has('closing_balance'))
                                    <span class="help-block">
            {{ $errors->first('closing_balance') }}
        </span>
                                @endif
                            </div>
                            <div class="col-xs-12 form-group">
                                {!! Form::label('parent_id', 'Parent Group', ['class' => 'control-label']) !!}
                                <select name="group_id" id="group_id" class="form-control groups" style="width: 100%;">
                                    <option value=""> Select a Parent Group</option>
                                    {!! $groups !!}
                                </select>
                                <span id="parent_id_handler"></span>
                                @if($errors->has('parent_id'))
                                    <span class="help-block">
                        {{ $errors->first('parent_id') }}
                </span>
                                @endif
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <button id="btn" class="btn btn-success col-md-12" style="margin-top:20px;">Add New Ledger
                        </button>

                        {!! Form::close() !!}
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.groups').select2();

            $('#ledger_name').on('input', function () {
                let query = $(this).val();
                // if (query.length >= 3) {
                $.ajax({
                    url: "{{ route('admin.ledger.already_created') }}",
                    method: "GET",
                    data: {query: query},
                    success: function (data) {
                        console.log(data);
                        $('#results').html(data);
                    }
                });
                // }
            });

        });
    </script>
@endsection
