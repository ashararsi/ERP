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
                    @endif @endif data-start_date="{{ $year->start_date }}" data-end_date="{{ $year->end_date }}"
                    value="{{ $year->id }}">{{ $year->name }}</option>
            @endforeach
        </select>
        @if($errors->has('financial_year'))
            <span class="help-block">
            {{ $errors->first('financial_year') }}
        </span>
        @endif
    </div>
    <input type="hidden" id="selected_voucher_date" value="{{ isset($VoucherData['voucher_date']) ?? null }}">
    <div class="form-group col-md-4  @if($errors->has('voucher_date')) has-error @endif">
        {!! Form::label('number', 'Voucher Date*', ['class' => 'control-label']) !!}
        <input readonly type="text" class="form-control daterange" name="voucher_date" id="voucher_date"
               value="{{ $VoucherData['voucher_date'] ?? null }}" required>
        @if($errors->has('voucher_date'))
            <span class="help-block">
                {{ $errors->first('voucher_date') }}
            </span>
        @endif
    </div>
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
    </style>
    {{--    <div class="form-group col-md-6 @if($errors->has('entry_type_id')) has-error @endif">--}}
    {{--        {!! Form::label('entry_type_id', 'Entry Type*', ['class' => 'control-label']) !!}--}}
    {{--        {!! Form::select('entry_type_id', array('4'=>'Bank Reciept Voucher'), $VoucherData['entry_type_id'], ['style' => 'width: 100%;', 'class' => 'form-control select2','required']) !!}--}}
    {{--        <span id="entry_type_id_handler"></span>--}}
    {{--        @if($errors->has('entry_type_id'))--}}
    {{--            <span class="help-block">--}}
    {{--                {{ $errors->first('entry_type_id') }}--}}
    {{--            </span>--}}
    {{--        @endif--}}
    {{--    </div>--}}
    <div class="form-group col-md-6  @if($errors->has('company_id')) has-error @endif">
        {!! Form::label('company_id', 'Companies*', ['class' => 'control-label']) !!}
        <select class="form-control select2" name="company_id" id="company_id"  >
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
        <select class="form-control select2" name="branch_id" id="branch_id"  >
            @foreach($branches as $item)
                @if($item->id == $branchId)
                    <option
                        value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
            @endforeach
        </select>
        @if($errors->has('company_id'))
            <span class="help-block">
            {{ $errors->first('company_id') }}
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
            <button onclick="FormControls.createEntryItem();" type="button" style="margin-bottom: 5px;"
                    class="btn pull-right btn-sm btn-flat btn-primary"><i class="fa fa-plus"></i>&nbsp;Add <u>R</u>ow
            </button>
            <table class="table table-condensed" id="entry_items">
                @if(count($VoucherData['entry_items']['counter']))
                    <tr>
                        <th width="65%" colspan="5">Account</th>
                        <th width="15%">Debit</th>
                        <th width="15%">Credit</th>
                        <th width="5%">Action</th>
                    </tr>
                    @foreach ($VoucherData['entry_items']['counter'] as $key => $val)
                        @if($key != '######')
                            <tr class="entry_item-{{ $val }} first_row">
                                <td colspan="5">
                                    <div class="form-group">
                                        {!! Form::hidden("entry_items[counter][$val]", $val, ['id' => "entry_item-counter-$val", 'class' => "entry_item-counter-$val"]) !!}
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
                                            class="btn btn-block btn-danger btn-sm"><i class="ri-delete-bin-5-line"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="entry_item-{{ $val }} last_row">
                                @if(isset($vendorDropdown) && $vendorDropdown == 1)
                                    <td colspan="5">
                                        <div class="form-group">
                                            {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [
                                            'id' => "entry_item-narration-$val",
                                            'class' => 'form-control entry_items-narration',
                                            'placeholder' => 'Narration',
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {!! Form::text("entry_items[instrument_number][$val]", $VoucherData['entry_items']['instrument_number'][$val], [
                                            'id' => "entry_item-instrument_number-$val",
                                            'class' => 'form-control entry_items-instrument_number',
                                            'placeholder' => 'Instrument No',
                                            'onfocusout' => "FormControls.checkInstrumentNo($val)"
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group">
                                            <select class="form-control vendor_id_select"
                                                    id="entry_item-vendor_id-{{$val}}"
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
                                @else
                                    <td colspan="6">
                                        <div class="form-group">
                                            {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [
                                            'id' => "entry_item-narration-$val",
                                            'class' => 'form-control entry_items-narration',
                                            'placeholder' => 'Narration',
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group">
                                            {!! Form::text("entry_items[instrument_number][$val]", $VoucherData['entry_items']['instrument_number'][$val], [
                                            'id' => "entry_item-instrument_number-$val",
                                            'class' => 'form-control entry_items-instrument_number',
                                            'placeholder' => 'Instrument No',
                                            'onfocusout' => "FormControls.checkInstrumentNo($val)"
                                            ]) !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <th width="65%" colspan="5">Account</th>
                        <th width="15%">Debit</th>
                        <th width="15%">Credit</th>
                        <th width="5%">Action</th>
                    </tr>
                    <tr class="entry_item-1 first_row">
                        <td colspan="5">
                            <div class="form-group">
                                {!! Form::hidden('entry_items[counter][1]', '1', ['id' => "entry_item-counter-1", 'class' => 'entry_item-counter-1']) !!}
                                {!! Form::select('entry_items[ledger_id][1]', array(), old('branch_id'), ['id' => 'entry_item-ledger_id-1', 'style' => 'width: 100%;', 'class' => 'form-control description-data-ajax']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::number('entry_items[dr_amount][1]', null, [
                                'onkeydown' => 'FormControls.CalculateTotal();',
                                'onkeyup' => 'FormControls.CalculateTotal();',
                                'onblur' => 'FormControls.CalculateTotal();',
                                'id' => 'entry_item-dr_amount-1',
                                'onchange' => "dr_validation(1)",
                                'class' => 'form-control entry_items-dr_amount',
                                'placeholder' => 'Dr. Amount'
                                ]) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::number('entry_items[cr_amount][1]', null, [
                                'onkeydown' => 'FormControls.CalculateTotal();',
                                'onkeyup' => 'FormControls.CalculateTotal();',
                                'onblur' => 'FormControls.CalculateTotal();',
                                'id' => 'entry_item-cr_amount-1',
                                'onchange' => "cr_validation(1)",
                                'class' => 'form-control entry_items-cr_amount',
                                'placeholder' => 'Cr. Amount'
                                ]) !!}
                            </div>
                        </td>
                        <td>
                            <button onclick="FormControls.destroyEntryItem('1');" id="entry_item-del_btn-1"
                                    type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i
                                    class="ri-delete-bin-5-line"></i></button>
                        </td>
                    </tr>
                    <tr class="entry_item-1 last_row">
                        @if(isset($vendorDropdown) && $vendorDropdown == 1)
                            <td colspan="5">
                                <div class="form-group">
                                    {!! Form::text('entry_items[narration][1]', null, [
                                    'id' => 'entry_item-narration-1',
                                    'class' => 'form-control entry_items-narration',
                                    'placeholder' => 'Narration'
                                    ]) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('entry_items[instrument_number][1]', null, [
                                    'id' => 'entry_item-instrument_number-1',
                                    'class' => 'form-control entry_items-instrument_number',
                                    'placeholder' => "Instrument No",
                                    'onfocusout' => "FormControls.checkInstrumentNo(1)"
                                    ]) !!}
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="form-group">
                                    <select class="form-control vendor_id_select" id="entry_item-vendor_id-1"
                                            name="entry_items[vendor_id][1]">
                                        <option value="">Select Vendor</option>
                                        @foreach($vendor as $item)
                                            <option value="{{ $item->vendor_id }}">{{ $item->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        @else
                            <td colspan="6">
                                <div class="form-group">
                                    {!! Form::text('entry_items[narration][1]', null, [
                                    'id' => 'entry_item-narration-1',
                                    'class' => 'form-control entry_items-narration',
                                    'placeholder' => 'Narration'
                                    ]) !!}
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="form-group">
                                    {!! Form::text('entry_items[instrument_number][1]', null, [
                                    'id' => 'entry_item-instrument_number-1',
                                    'class' => 'form-control entry_items-instrument_number',
                                    'placeholder' => "Instrument No",
                                    'onfocusout' => "FormControls.checkInstrumentNo(1)"
                                    ]) !!}
                                </div>
                            </td>
                        @endif
                    </tr>
                @endif
                <tr>
                    <td colspan="5" style="padding-top: 12px;">
                        <div style="display: flex;align-items: center;justify-content: space-between;">
                            <div>
                                <b>Difference</b>
                            </div>
                            <div style="width: 65%" class="form-group @if($errors->has('diff_total')) has-error @endif">
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
                    <td style="display: inline-flex">
                        <div class="form-group  @if($errors->has('dr_total')) has-error @endif">
                            {!! Form::number('dr_total', old('dr_total', $VoucherData['dr_total']), ['id' => 'dr_total', 'class' => 'form-control', 'readonly' => 'true']) !!}
                            @if($errors->has('dr_total'))
                                <span class="help-block">
                                    {{ $errors->first('dr_total') }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
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
                        <button onclick="FormControls.createEntryItem();" type="button" style="font-weight: bolder"
                                class="btn btn-primary btn-icon waves-effect waves-light">
                            <i class="ri-add-line"></i>
                        </button>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="entry_item-global_counter"
                   value="@if(count($VoucherData['entry_items']['counter'])){{ count($VoucherData['entry_items']['counter']) }}@else{{'1'}}@endif"/>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">

            {{-- <div class="form-group col-md-6 @if($errors->has('cheque_no')) has-error @endif">
                {!! Form::label('cheque_no', 'Cheque #', ['class' => 'control-label']) !!}
                {!! Form::text('cheque_no', $VoucherData['cheque_no'], ['class' => 'form-control']) !!}
                @if($errors->has('cheque_no'))
                    <span class="help-block">
                        {{ $errors->first('cheque_no') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6 @if($errors->has('cheque_date')) has-error @endif">
                {!! Form::label('cheque_date', 'Cheque Date', ['class' => 'control-label']) !!}
                {!! Form::text('cheque_date', ($VoucherData['cheque_date']) ? $VoucherData['cheque_date'] : date('Y-m-d'), ['class' => 'form-control datepicker']) !!}
                @if($errors->has('cheque_date'))
                    <span class="help-block">
                        {{ $errors->first('cheque_date') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6 @if($errors->has('invoice_no')) has-error @endif">
                {!! Form::label('invoice_no', 'Invoice #', ['class' => 'control-label']) !!}
                {!! Form::text('invoice_no', $VoucherData['invoice_no'], ['class' => 'form-control']) !!}
                @if($errors->has('invoice_no'))
                    <span class="help-block">
                        {{ $errors->first('invoice_no') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6 @if($errors->has('invoice_date')) has-error @endif">
                {!! Form::label('invoice_date', 'Invoice Date*', ['class' => 'control-label']) !!}
                {!! Form::text('invoice_date', ($VoucherData['invoice_date']) ? $VoucherData['invoice_date'] : date('Y-m-d'), ['class' => 'form-control datepicker']) !!}
                @if($errors->has('invoice_date'))
                    <span class="help-block">
                        {{ $errors->first('invoice_date') }}
                    </span>
                @endif
            </div> --}}
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
