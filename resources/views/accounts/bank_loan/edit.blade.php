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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Edit Bank Loan</h4>
                <a href="{{ route('admin.loan-type.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
            {!! Form::model($bank_loans, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.bank-loan.update', $bank_loans->id]]) !!}
        <div class="box-body" >
            <div class="form-group col-md-3 @if($errors->has('bank_id')) has-error @endif" style = "float:left;">
                {!! Form::label('bank_id', 'Bank Name*', ['class' => 'control-label']) !!}
              
                {!! Form::select('bank_id', $bank,old('bank'), ['class' => 'form-control select2']) !!}
                @if($errors->has('bank_id'))
                    <span class="help-block">
                        {{ $errors->first('bank_id') }}
                    </span>
                @endif
            </div>    

            <div class="form-group col-md-3 @if($errors->has('bank_id')) has-error @endif" style = "float:left;">
                {!! Form::label('company_id', 'Company Name*', ['class' => 'control-label']) !!}
              
                {!! Form::select('company_id', $company,old('company'), ['class' => 'form-control select2']) !!}
                @if($errors->has('company_id'))
                    <span class="help-block">
                        {{ $errors->first('company_id') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-3 @if($errors->has('bank_id')) has-error @endif" style = "float:left;">
                {!! Form::label('loan_installment_id', 'Loan Installement*', ['class' => 'control-label']) !!}
              
                {!! Form::select('loan_installment_id', $loan_installment,old('loan_installment'), ['class' => 'form-control select2',  'id' => 'loan_installment_id']) !!}
                @if($errors->has('loan_installment_id'))
                    <span class="help-block">
                        {{ $errors->first('loan_installment_id') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-3 @if($errors->has('bank_id')) has-error @endif" style = "float:left;">
                {!! Form::label('loan_type_id', 'Loan Type*', ['class' => 'control-label']) !!}
              
                {!! Form::select('loan_type_id', $loan_type,old('loan_type'), ['class' => 'form-control select2']) !!}
                @if($errors->has('loan_type_id'))
                    <span class="help-block">
                        {{ $errors->first('loan_type_id') }}
                    </span>
                @endif
            </div>     
            <div class="form-group col-md-3 @if($errors->has('amount')) has-error @endif" style = "float:left;">
                {!! Form::label('amount', 'Amount*', ['class' => 'control-label']) !!}
                <input type="number"  id="amount" name="amount" class="form-control" value="{{ $bank_loans->amount}}" required maxlength="50">
            </div>
            <div class="form-group col-md-3 @if($errors->has('kabis')) has-error @endif" style = "float:left;">
                {!! Form::label('kabis', 'Kabis*', ['class' => 'control-label']) !!}
                <input type="number" id="kabis" name="kabis" class="form-control" value="{{ $bank_loans->kabis}}"  required >
            </div>
            <div class="form-group col-md-3 @if($errors->has('bank_intrest')) has-error @endif" style = "float:left;">
                {!! Form::label('bank_intrest', 'Bank Intrest*', ['class' => 'control-label']) !!}
                <input type="number" id="bank_intrest" name="bank_intrest" class="form-control" value="{{ $bank_loans->bank_intrest}}" required >
            </div>
            <div class="form-group col-md-3 @if($errors->has('bank_intrest')) has-error @endif" style = "float:left;">
                {!! Form::label('insurance', 'Insurance Amount*', ['class' => 'control-label']) !!}
                <input type="number" id="insurance" name="insurance" class="form-control" value="{{ $bank_loans->insurance_amount}}" required  >
            </div>
             <input type="hidden" name="deduction_each_month" class="form-control" id="deduction_each_month" value="{{ $bank_loans->deduction_each_month}}"  required readonly="readonly" >
        
            
      
        </div>
        <!-- /.box-body -->

        <div class="box-footer" style = "padding-top:110px;">
            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn','style' => 'width:100%;']) !!}
        </div>
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