@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <style>
        td {
            border-bottom: none !important;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }

        .first_row > td > div,
        .first_row > td > button {
            margin-top: 5px !important;
        }

        .last_row > td > div,
        .last_row > td > button {
            margin-bottom: 5px !important;
        }

        .last_row {
            border-bottom-width: 1px !important;
            border-color: darkgrey !important;
        }

        .select2-selection__rendered {
            line-height: 35px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 35px !important;
        }

        .custom-select2-container {
            width: 500px !important;
        }

    </style>
@stop
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">Create {{ $entry_template->entry_type->name }}</h3>
                    <a href="{{ route('admin.entry_templates.index') }}" style="float:right;"
                       class="btn btn-success pull-right">Back</a>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['admin.bpv-store'], 'id' => 'validation-form']) !!}
                <div class="box-body" style="margin-top:40px;">
                    {!! Form::hidden('entry_type_id', old('entry_type_id', $entry_template->entry_type_id),['id'=>'entry_type_id']) !!}

                    <div class="row">
                        <div class="form-group col-md-4  @if($errors->has('number')) has-error @endif">
                            {!! Form::label('number', 'Number*', ['class' => 'control-label']) !!}
                            {!! Form::text('number', ($VoucherData['number']) ? $VoucherData['number'] : '??????', ['class' => 'form-control', 'readonly' => 'true']) !!}
                            @if($errors->has('number'))
                                <span class="help-block">
                {{ $errors->first('number') }}
            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-4  @if($errors->has('financial_year')) has-error @endif">
                            {!! Form::label('financial_year', 'Financial Year*', ['class' => 'control-label']) !!}
                            <select class="form-control financial_year" name="financial_year" id="financial_year">
                                <option data-start_date="" data-end_date="" value="">Select</option>
                                @foreach($financial_year as $year)
                                    <option
                                        @if(isset($VoucherData['financial_year'])) @if($VoucherData['financial_year'] == $year->id) selected
                                        @endif @endif data-start_date="{{ $year->start_date }}"
                                        data-end_date="{{ $year->end_date }}"
                                        value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('financial_year'))
                                <span class="help-block">
            {{ $errors->first('financial_year') }}
        </span>
                            @endif
                        </div>
                        <input type="hidden" id="selected_voucher_date"
                               value="{{ isset($VoucherData['voucher_date']) ?? null }}">
                        <div class="form-group col-md-4  @if($errors->has('voucher_date')) has-error @endif">
                            {!! Form::label('number', 'Voucher Date*', ['class' => 'control-label']) !!}
                            <input readonly type="text" class="form-control daterange" name="voucher_date"
                                   id="voucher_date"
                                   value="{{ $VoucherData['voucher_date'] ?? null }}" required>
                            @if($errors->has('voucher_date'))
                                <span class="help-block">
                {{ $errors->first('voucher_date') }}
            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6  @if($errors->has('company_id')) has-error @endif">
                            {!! Form::label('company_id', 'Companies*', ['class' => 'control-label']) !!}
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                @foreach($companies as $item)
                                    @if($item->id == $companyId)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('company_id'))
                                <span class="help-block">
            {{ $errors->first('company_id') }}
        </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6  @if($errors->has('branch_id')) has-error @endif">
                            {!! Form::label('branch_id', 'Branches*', ['class' => 'control-label']) !!}
                            <select class="form-control select2" name="branch_id" id="branch_id" required>
                                @foreach($branches as $item)
                                    @if($item->id == $branchId)
                                        <option
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('branch_id'))
                                <span class="help-block">
            {{ $errors->first('branch_id') }}
        </span>
                            @endif
                        </div>

                        <div class="form-group col-md-12  @if($errors->has('narration')) has-error @endif">
                            {!! Form::label('narration', 'Narration*', ['class' => 'control-label']) !!}
                            {!! Form::text('narration', $VoucherData['narration'], ['id' => 'narration', 'onkeydown' => 'FormControls.updateNarration();', 'onkeyup' => 'FormControls.updateNarration();', 'onblur' => 'FormControls.updateNarration();', 'class' => 'form-control']) !!}
                            @if($errors->has('narration'))
                                <span class="help-block">
                {{ $errors->first('narration') }}
            </span>
                            @endif
                        </div>
                    </div>

                    <div class="nav-tabs-custom">
                        <hr>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <button onclick="FormControls.createEntryItem();" type="button"
                                        style="margin-bottom: 5px;"
                                        class="btn pull-right btn-sm btn-flat btn-primary"><i class="fa fa-plus"></i>&nbsp;Add
                                    <u>R</u>ow
                                </button>
                                {{--                                @dd($VoucherData)--}}
                                <table class="table table-condensed" id="entry_items">
                                    <tr>
                                        <th width="35%">Account</th>
                                        <th width="35%">Debit</th>
                                        <th width="25%">Credit</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    @foreach ($VoucherData['entry_items']['counter'] as $key => $val)
                                        @if($key != '######')
                                            <tr class="entry_item-{{ $val }} first_row">
                                                <td>
                                                    {!! Form::hidden("entry_items[counter][$val]", $val, ['id' => "entry_item-counter-$val", 'class' => "entry_item-counter-$val"]) !!}
                                                    <div class="custom-select2-container">
                                                        {!! Form::select("entry_items[ledger_id][$val]", ($VoucherData['entry_items']['ledger_id'][$val]) ? array($VoucherData['ledger_array'][$VoucherData['entry_items']['ledger_id'][$val]]->id => $VoucherData['ledger_array'][$VoucherData['entry_items']['ledger_id'][$val]]->number . ' - ' . $VoucherData['ledger_array'][$VoucherData['entry_items']['ledger_id'][$val]]->name) : array(), $VoucherData['entry_items']['ledger_id'][$val], ['id' => "entry_item-ledger_id-$val", 'style' => 'width: 100%;', 'class' => 'form-control description-data-ajax']) !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        {!! Form::number("entry_items[dr_amount][$val]", $VoucherData['entry_items']['dr_amount'][$val], [
                                                        'onkeydown' => 'FormControls.CalculateTotal();',
                                                        'onkeyup' => 'FormControls.CalculateTotal();',
                                                        'onblur' => 'FormControls.CalculateTotal();',
                                                        'id' => "entry_item-dr_amount-$val",
                                                        'onchange' => "validation($val)",
                                                        'class' => 'form-control entry_items-dr_amount',
                                                        'placeholder' => 'Dr. Amount',
                                                        ]) !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        {!! Form::number("entry_items[cr_amount][$val]", $VoucherData['entry_items']['cr_amount'][$val], [
                                                        'onkeydown' => 'FormControls.CalculateTotal();',
                                                        'onkeyup' => 'FormControls.CalculateTotal();',
                                                        'onblur' => 'FormControls.CalculateTotal();',
                                                        'id' => "entry_item-cr_amount-$val",
                                                        'class' => 'form-control entry_items-cr_amount',
                                                        'placeholder' => 'Cr. Amount',
                                                        ]) !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    <button onclick="FormControls.destroyEntryItem('{{$val}}');"
                                                            id="entry_item-del_btn-{{$val}}" type="button"
                                                            class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                            class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="entry_item-{{ $val }} last_row">
                                                <td class="narration_div">
                                                    <div class="form-group" style="width: 100% !important;">
                                                        {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [
                                                        'id' => "entry_item-narration-$val",
                                                        'class' => 'form-control entry_items-narration',
                                                        'placeholder' => 'Narration',
                                                        ]) !!}
                                                    </div>
                                                </td>
                                                <td class="instrument_div">
                                                    <div class="form-group">
                                                        {!! Form::text("entry_items[instrument_number][$val]", $VoucherData['entry_items']['instrument_number'][$val], [
                                                        'id' => "entry_item-instrument_number-$val",
                                                        'class' => 'form-control entry_items-instrument_number',
                                                        'placeholder' => 'Instrument No',
                                                        'onfocusout' => "FormControls.checkInstrumentNo($val)"
                                                        ]) !!}
                                                    </div>
                                                </td>
                                                <td class="vendor_div">
                                                    <div class="form-group">
                                                        <select class="form-control vendor_id_select"
                                                                name="entry_items[vendor_id][{{$val}}]">
                                                            <option value="">Select Vendor</option>
                                                            @foreach($vendor as $item)
                                                                <option
                                                                    @if(isset($VoucherData['entry_items']['vendor_id'][$val]))
                                                                        @if($VoucherData['entry_items']['vendor_id'][$val] == $item->vendor_id) selected
                                                                    @endif @endif value="{{ $item->vendor_id }}">{{ $item->vendor_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td style="padding-top: 12px;">
                                            <div
                                                style="display: flex;align-items: center;justify-content: space-between;">
                                                <div>
                                                    <b>Difference</b>
                                                </div>
                                                <div style="width: 65%"
                                                     class="form-group @if($errors->has('diff_total')) has-error @endif">
                                                    {!! Form::number('diff_total', old('diff_total', 0.00), ['id' => 'diff_total', 'class' => 'form-control', 'readonly' => 'true', 'readonly' => 'true']) !!}
                                                    @if($errors->has('diff_total'))
                                                        <span class="help-block">
                                        {{ $errors->first('diff_total') }}
                                    </span>
                                                    @endif
                                                </div>
                                                <div class="pull-right">
                                                    <b>Total</b>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="">
                                            <div class="form-group  @if($errors->has('dr_total')) has-error @endif">
                                                {!! Form::number('dr_total', old('dr_total', $VoucherData['cr_total']), ['id' => 'dr_total', 'class' => 'form-control', 'readonly' => 'true']) !!}
                                                @if($errors->has('dr_total'))
                                                    <span class="help-block">
                                    {{ $errors->first('dr_total') }}
                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="">
                                            <div class="form-group @if($errors->has('cr_total')) has-error @endif">
                                                {!! Form::number('cr_total', old('cr_total', $VoucherData['cr_total']), ['id' => 'cr_total', 'class' => 'form-control', 'readonly' => 'true']) !!}
                                                @if($errors->has('cr_total'))
                                                    <span class="help-block">
                                    {{ $errors->first('cr_total') }}
                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <button onclick="FormControls.createEntryItem();" type="button"
                                                    style="font-weight: bolder"
                                                    class="btn btn-primary btn-icon waves-effect waves-light">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" id="entry_item-global_counter"
                                       value="@if(count($VoucherData['entry_items']['counter'])){{ count($VoucherData['entry_items']['counter']) }}@else{{'1'}}@endif"/>
                            </div>
                            <div class="tab-pane" id="tab_2">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}

                    @include('accounts.entry_templates.include_use_entry_template',['entry_type'=>$entry_template->entry_type_id, 'vendor'=>$vendor,'vendorDropdown'=>$vendorDropdown])

                    <div class="clearfix mt-5">
                        <div class="panel-body pad table-responsive">
                            <table class="table table-bordered datatable" style="text-transform:none;">
                                <thead>
                                <tr style="text-align:center;">
                                    <th style="text-align:center;">Sr.No</th>
                                    <th style="text-align:center;">Entry Type</th>
                                    <th style="text-align:center;">Voucher Date</th>
                                    <th style="text-align:center;">Number</th>
                                    <th style="text-align:center;">Narration</th>
                                    <th style="text-align:center;">Dr.Amount</th>
                                    <th style="text-align:center;">Cr.Amount</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($entries as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->entry_type->code }}</td>
                                        <td>{{ $item->voucher_date }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->narration }}</td>
                                        <td>{{ number_format($item->dr_total) }}</td>
                                        <td>{{ number_format($item->cr_total) }}</td>
                                        <td>
                                            @if(Auth::user()->isAbleTo('print-voucher'))
                                                <a class="btn btn-warning"
                                                   href="{{ route('admin.download',$item->id) }}">PDF</a>
                                            @endif
                                            @if(Auth::user()->isAbleTo('show-voucher'))
                                                <a class="btn btn-primary" href="{{ route('admin.show',$item->id) }}">View</a>
                                            @endif
                                            @if(Auth::user()->isAbleTo('accounts-edit-voucher'))
                                                <a class="btn btn-success"
                                                   href="{!! route('admin.bpv-edit',$item->id) !!}"
                                                   style="margin-right:10px;">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
            type="text/javascript"></script>
    <script
        src="https://ivyacademic.org/public/theme/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('js/voucher/journal_voucher/create_modify.js') }}"
            type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    <script>
        function dr_validation(id) {
            var id = '#entry_item-dr_amount-' + id;
            $(id).keyup(function (event) {
                if (event.which >= 37 && event.which <= 40) return;
            });
        }

        function cr_validation(id) {
            var id = '#entry_item-cr_amount-' + id;
            console.log(id);
            var value = $(id).val();
        }

        function hideDivByEntryType() {
            var entry_type_id = $('#entry_type_id').val();

            if (entry_type_id == 1) {

                $('.instrument_div').hide();
                $('.vendor_div').show();
                $('.narration_div').attr('colspan', '2');

            } else if (entry_type_id == 2) {

                $('.instrument_div').hide();
                $('.vendor_div').hide();
                $('.narration_div').attr('colspan', '3');

            } else if (entry_type_id == 3) {

                $('.instrument_div').hide();
                $('.vendor_div').show();
                $('.narration_div').attr('colspan', '2');

            } else if (entry_type_id == 4) {

                $('.instrument_div').show();
                $('.vendor_div').hide();
                $('.narration_div').attr('colspan', '2');

            } else if (entry_type_id == 5) {

                $('.instrument_div').show();
                $('.vendor_div').show();
                $('.narration_div').attr('colspan', '1');

            }
        }

        $(document).ready(function () {
            $('.vendor_id_select').select2();

            hideDivByEntryType();
        });
    </script>
@endsection
