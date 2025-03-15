@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        .form-group {
            margin-bottom: 5px;
        }
    </style>
@stop
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-12">
                    @if($VoucherData['entry_type_id']==5)
                        <h3 style="float:left;">Update Bank Payment Voucher</h3>
                    @endif
                    @if($VoucherData['entry_type_id']==3)
                        <h3 style="float:left;">Update Cash Payment Voucher</h3>
                    @endif
                    @if($VoucherData['entry_type_id']==4)
                        <h3 style="float:left;">Update Bank Receipt Voucher</h3>
                    @endif
                    @if($VoucherData['entry_type_id']==2)
                        <h3 style="float:left;">Update Cash Receipt Voucher</h3>
                    @endif
                    @if($VoucherData['entry_type_id']==1)
                        <h3 style="float:left;">Update Journal Voucher</h3>
                    @endif

                    <a href="{{ route('admin.entries.index') }}" style="float:right; "
                       class="btn btn-success pull-right">Back</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($VoucherData, ['method' => 'PUT', 'id' => 'validation-form', 'route' => ['admin.entries.update', $VoucherData['id']]]) !!}
                <div class="box-body" style="margin-top:40px;">

                    <input type="hidden" id="company_id_selected" value="{{ $VoucherData['company_id'] }}">
                    <input type="hidden" id="branch_id_selected" value="{{ $VoucherData['branch_id'] }}">

                    @include('accounts.entries.voucher.bank_voucher.bank_payment.edit_fields',['voucher_type' => $VoucherData['entry_type_id'],'companyId'=>$VoucherData['company_id'],'branchId'=>$VoucherData['branch_id'],'vendor'=>$vendor,'vendorDropdown'=>$vendorDropdown])
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @include('accounts.entries.voucher.bank_voucher.bank_payment.edit_intrument_entries_template',['voucher_type' => $VoucherData['entry_type_id'],'vendor'=>$vendor,'vendorDropdown'=>$vendorDropdown])
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
            type="text/javascript"></script>
    <script src="https://ivyacademic.org/public/theme/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('js/voucher/journal_voucher/edit.js') }}" type="text/javascript"></script>

@endpush
@section('javascript')
    <script>

        jQuery(document).ready(function () {
            $('.vendor_id_select').select2();
        });

        $('#company_id').on('change', function () {
            $('#company_id_selected').val('');
            $('#branch_id_selected').val('');
            company_change();
        });

        function dr_validation(id) {
            var id = '#entry_item-dr_amount-' + id;
            //console.log(id);
            //var value = $(id).val();
            $(id).keyup(function (event) {

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

        function company_change() {
            let company_id = $('#company_id_selected').val();
            let branch_id = $('#branch_id_selected').val();

            if (company_id == '') {
                company_id = $('#company_id').val();
            }
            if (branch_id == '') {
                branch_id = 0;
            }

            $('#branch_id').val('');

            $.ajax({
                url: '/admin/getBranchesFromSelectedCompany/' + company_id + '/' + branch_id,
                type: "GET",
                success: function (data) {
                    $('#branch_id').html(data);
                },
                error: function (error) {
                    console.log('error ' + error);
                }
            });
        }

    </script>
@endsection
