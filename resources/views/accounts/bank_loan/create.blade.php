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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Bank Loan</h4>
                <a href="{{ route('admin.loan-type.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => ['admin.bank-loan.store'],
                'id' => 'validation-form']) !!}
                <div class="box-body">
                    <div class="form-group col-md-3 @if($errors->has('bank')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Select Bank*', ['class' => 'control-label']) !!}
                        <select  name='bank_id' class="form-control input-sm " required >
                        <option value ="null">Select Bank</option>
                      
                            @foreach($banks as $key=> $branch)
                            <option value ="{{$branch->id}}">{{$branch->bank_name}}</option>
                            @endforeach
                      
                 
                    </select>
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('company')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Select Company*', ['class' => 'control-label']) !!}
                        <select  name='company_id' class="form-control input-sm " required >
                        <option value ="null">Select Company</option>
                      
                            @foreach($company as $key=> $branch)
                            <option value ="{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                      
                 
                    </select>
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('company')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Select Loan Type*', ['class' => 'control-label']) !!}
                        <select  name='loan_type_id' class="form-control input-sm " required >
                        <option value ="null">Select Loan Type</option>
                      
                            @foreach($loan_type as $key=> $branch)
                            <option value ="{{$branch->loan_id}}">{{$branch->loan_type}}</option>
                            @endforeach
                      
                 
                    </select>
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('company')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Select Loan Plan*', ['class' => 'control-label']) !!}
                        <select  name='loan_installment_id' id = "loan_installment_id" class="form-control input-sm " required >
                        <option value ="null">Select Loan Plan</option>
                      
                            @foreach($loan_plan as $key=> $branch)
                            <option value ="{{$branch->loan_plan_id}}">{{$branch->loan_installment}}</option>
                            @endforeach
                      
                 
                    </select>
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('amount')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Amount*', ['class' => 'control-label']) !!}
                        {!! Form::number('amount', old('amount'), ['id' => 'amount' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Amount','maxlength'=>'50']) !!}
                        @if($errors->has('amount'))
                        <span class="help-block">
                            {{ $errors->first('amount') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('kabis')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Kabis*', ['class' => 'control-label']) !!}
                        {!! Form::text('kabis', old('kabis'), ['id' => 'kabis' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Kabis','maxlength'=>'50']) !!}
                        @if($errors->has('kabis'))
                        <span class="help-block">
                            {{ $errors->first('kabis') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('bank_interest')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Bank Interest*', ['class' => 'control-label']) !!}
                        {!! Form::number('bank_intrest', old('bank_interest'), ['id' => 'bank_intrest' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Bank Interest','maxlength'=>'50']) !!}
                        @if($errors->has('bank_interest'))
                        <span class="help-block">
                            {{ $errors->first('bank_interest') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 @if($errors->has('insurance_amount')) has-error @endif" style="float:left;">
                        {!! Form::label('name', 'Insurance Amount*', ['class' => 'control-label']) !!}
                        {!! Form::number('insurance_amount', old('insurance_amount'), ['id' => 'name' ,'class' => 'form-control', 'placeholder' =>
                        'Enter Insurance Amount','maxlength'=>'50']) !!}
                        @if($errors->has('insurance_amount'))
                        <span class="help-block">
                            {{ $errors->first('insurance_amount') }}
                        </span>
                        @endif
                    </div>
                    
                 

                </div>
                <input type="hidden" name="deduction_each_month" class="form-control" id="deduction_each_month" value="" required readonly="readonly" >
          

                <!-- /.box-body -->
                <button id="btn" class="btn btn-success col-md-12">Add New Bank Loan</button>

                {!! Form::close() !!}
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        $('#bank_intrest').change(function(){

           

            var bank_intrest = $(this).val();
            var kabis = $('#kabis').val();
            var amount = $('#amount').val();
            var loan_installment_id = $('#loan_installment_id').val();
            $.ajax({
                  url: '{{url('admin/get_calculation')}}',
                data : {bank_intrest:bank_intrest,kabis:kabis,amount:amount,loan_installment_id:loan_installment_id},
                type : 'post',
                 headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
            }).done(function(data){
                 $('#deduction_each_month').val(data);
            })
        })
    })
</script>
@stop

@section('javascript')

@endsection