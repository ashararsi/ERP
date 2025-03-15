@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('breadcrumbs')

@section('content')
<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
    <!--div-->
    <div class="card">
        <div class="card-body">
            <div class="main-content-label mg-b-12">
                <h3 style="float:left;">Update Bank Payment Voucher</h3>
                <a href="{{ route('admin.entries.index') }}" style="float:right; " class="btn btn-success pull-right">Back</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($VoucherData, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.entries.update', $VoucherData['id']]]) !!}
            <div class="box-body">
                @include('accounts.entries.voucher.bank_voucher.bank_payment.fields')
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end m-3']) !!}
            </div>
            {!! Form::close() !!}
            @include('accounts.entries.voucher.bank_voucher.bank_payment.intrument_entries_template')
        </div>
        @stop

        @push('after-scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="https://ivyacademic.org/public/theme/assets/plugins/select2/js/select2.min.js"></script>
        <script src="{{ url('js/voucher/journal_voucher/create_modify.js') }}" type="text/javascript"></script>
        
        @endpush
        <script>
            
            function dr_validation(id) {
                var id = '#entry_item-dr_amount-' + id;
                //console.log(id);
                //var value = $(id).val();
                $(id).keyup(function(event) {

                    // skip for arrow keys
                    if (event.which >= 37 && event.which <= 40) return;


                });
                //alert(value);
            }

            function cr_validation(id) {
                var id = '#entry_item-cr_amount-' + id;
                console.log(id);
                var value = $(id).val();
                // alert(value);
            }

        </script>