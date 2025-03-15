<div class="row col-sm-12">

    <div class="form-group col-md-12  @error('entry_type_id') border-danger @enderror">
        {!! Form::label('entry_type_id', 'Voucher Type*', ['class' => 'control-label']) !!}
        <select name="entry_type_id" id="entry_type_id" class="form-control">
            @foreach($entry_types as $key => $value)
                <option @if($VoucherData['entry_type_id'] == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

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
        {!! Form::label('voucher_date', 'Voucher Date*', ['class' => 'control-label']) !!}
        <input readonly type="text" class="form-control daterange" name="voucher_date" id="voucher_date"
               value="{{ $VoucherData['voucher_date'] ?? null }}" required>
        @if($errors->has('voucher_date'))
            <span class="help-block">
            {{ $errors->first('voucher_date') }}
        </span>
        @endif
    </div>

    <div class="form-group col-md-4  @if($errors->has('company_id')) has-error @endif">
        {!! Form::label('company_id', 'Company*', ['class' => 'control-label']) !!}
        <select class="form-control select2" name="company_id" id="company_id" required>
            @foreach($companies as $item)
                @if($item->id == $companyId)
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

    <div class="form-group col-md-4  @if($errors->has('branch_id')) has-error @endif">
        {!! Form::label('branch_id', 'Old Branch*', ['class' => 'control-label']) !!}
        <select class="form-control select2" name="branch_id" required>
            @foreach($Branches as $item)
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
    @if(isset(auth()->user()->roles[0]))
        @php
            $company_session=  Session::get('company_session');
            if(!$company_session) {
                $company_session=0;
            }

        $branch_session=  Session::get('branch_session');
            if(!$branch_session){
                 $branch_session=0;
            }
        @endphp
        <div class="form-group col-md-4  @if($errors->has('branch_id')) has-error @endif">
            {!! Form::label('branch_id', 'New Branch*', ['class' => 'control-label']) !!}
            @if(auth()->user()->roles[0]->name=="administrator")
                <select name='branch_id_new'
                        class="form-control input-sm select2"
                        id="branch_id">
                    @php
                        $html='';
                            if( $branch_session!=0){
                           $branch= \App\Models\Branches::find($branch_session);
                             $html='<option selected value="'.$branch->id.'"> '.$branch->name.'</option>';
                            }
                    @endphp
                    {!! $html !!}
                </select>
            @else
                @php
                    $branchs=\App\Models\Branches::where('company_id',$company_session)->get();
                @endphp
                <select name='branch_id_new'
                        class="form-control input-sm select2"
                        id="branch_id">
                    @foreach($branchs as $item)
                        @if(Auth::user()->isAbleTo('Branch_'.$item->id))
                            @if($branch_session==$item->id)
                                <option selected value="{!! $item->id !!}">{!! $item->name !!}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            @endif
        </div>
    @endif

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

    <div class="form-group col-md-12  @error('narration') border-danger @enderror">
        {!! Form::label('narration', 'Narration*', ['class' => 'control-label']) !!}
        {!! Form::text('narration', $VoucherData['narration'], ['id' => 'narration', 'onkeydown' => 'FormControls.updateNarration();', 'onkeyup' => 'FormControls.updateNarration();', 'onblur' => 'FormControls.updateNarration();', 'class' => 'form-control'. ($errors->has('narration') ? " is-invalid" : null) ]) !!}

        @error('narration')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
{{--<input type="hidden" name="entry_type_id" value="{{$VoucherData['entry_type_id']}}"/>--}}
<div class="nav-tabs-custom">
    <hr>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <button onclick="FormControls.createEntryItem();" type="button" style="margin-bottom: 5px;"
                    class="btn pull-right btn-sm btn-flat btn-primary"><i class="ri-add-line align-middle me-1"></i>
                &nbsp;Add Row
            </button>

            <table class="table table-responsive" id="entry_items">
                <thead>
                <tr>
                    <th width="65%" colspan="5">Account</th>
                    <th width="15%">Debit</th>
                    <th width="15%">Credit</th>
                    <th width="5%">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($VoucherData['entry_items']['counter']))
                    @foreach ($VoucherData['entry_items']['counter'] as $key => $val)
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
                            {{--                        <td>--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [--}}
                            {{--                                'id' => "entry_item-narration-$val",--}}
                            {{--                                'class' => 'form-control entry_items-narration',--}}
                            {{--                                'style' => 'width: 150px; height: 40px;',--}}
                            {{--                                'placeholder' => 'Narration',--}}
                            {{--                                ]) !!}--}}
                            {{--                            </div>--}}
                            {{--                        </td>--}}
                            {{--                        <td>--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                {!! Form::text("entry_items[instrument_number][$val]", $VoucherData['entry_items']['instrument_number'][$val], [--}}
                            {{--                                'id' => "entry_item-instrument_number-$val",--}}
                            {{--                                'class' => 'form-control entry_items-instrument_number',--}}
                            {{--                                'placeholder' => 'Instrument',--}}
                            {{--                                ]) !!}--}}
                            {{--                            </div>--}}
                            {{--                        </td>--}}
                            <td>
                                <button onclick="FormControls.destroyEntryItem('{{$val}}');"
                                        id="entry_item-del_btn-{{$val}}" type="button"
                                        class="btn btn-danger btn-icon waves-effect waves-light"><i
                                        class="ri-delete-bin-5-line"></i></button>
                            </td>
                        </tr>
                        <tr class="entry_item-{{ $val }} last_row">
                            @if(isset($vendorDropdown) && $vendorDropdown == 1)
                                @if($voucher_type == 4 || $voucher_type == 5)
                                    <td colspan="5">
                                @else
                                    <td colspan="6">
                                        @endif
                                        <div class="form-group">
                                            {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [
                                            'id' => "entry_item-narration-$val",
                                            'class' => 'form-control entry_items-narration',
                                            'placeholder' => 'Narration',
                                            ]) !!}
                                        </div>
                                    </td>
                                    @if($voucher_type == 4 || $voucher_type == 5)
                                        <td>
                                            <div class="form-group">
                                                {!! Form::text("entry_items[instrument_number][$val]", null, [
                                                'id' => "entry_item-instrument_number-$val",
                                                'class' => 'form-control entry_items-instrument_number',
                                                'placeholder' => 'instrument',
                                                'onfocusout' => "FormControls.checkInstrumentNo($val)"
                                                ]) !!}
                                            </div>
                                        </td>
                                    @endif
                                    <td colspan="2">
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
                                    @else
                                        @if($voucher_type == 4 || $voucher_type == 5)
                                            <td colspan="6">
                                        @else
                                            <td colspan="8">
                                                @endif
                                                <div class="form-group">
                                                    {!! Form::text("entry_items[narration][$val]", $VoucherData['entry_items']['narration'][$val], [
                                                    'id' => "entry_item-narration-$val",
                                                    'class' => 'form-control entry_items-narration',
                                                    'placeholder' => 'Narration',
                                                    ]) !!}
                                                </div>
                                            </td>
                                            @if($voucher_type == 4 || $voucher_type == 5)
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
                                        @endif
                        </tr>
                    @endforeach
                    {{--                @else--}}
                    {{--                    <tr id="entry_item-1">--}}
                    {{--                        <td colspan="3">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                {!! Form::hidden('entry_items[counter][1]', '1', ['id' => "entry_item-counter-1", 'class' => 'entry_item-counter-1']) !!}--}}
                    {{--                                {!! Form::select('entry_items[ledger_id][1]', array(), old('branch_id'), ['id' => 'entry_item-ledger_id-1', 'style' => 'width: 100%;', 'class' => 'form-control description-data-ajax']) !!}--}}
                    {{--                            </div>--}}
                    {{--                        </td>--}}
                    {{--                        <td>--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                {!! Form::number('entry_items[dr_amount][1]', null, [--}}
                    {{--                                'onkeydown' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'onkeyup' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'onblur' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'id' => 'entry_item-dr_amount-1',--}}
                    {{--                                'onchange' => "dr_validation(1)",--}}
                    {{--                                'class' => 'form-control entry_items-dr_amount',--}}
                    {{--                                'placeholder' => 'Dr. Amount'--}}
                    {{--                                ]) !!}--}}
                    {{--                            </div>--}}
                    {{--                        </td>--}}
                    {{--                        <td>--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                {!! Form::text('entry_items[cr_amount][1]', null, [--}}
                    {{--                                'onkeydown' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'onkeyup' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'onblur' => 'FormControls.CalculateTotal();',--}}
                    {{--                                'id' => 'entry_item-cr_amount-1',--}}
                    {{--                                'onchange' => "cr_validation(1)",--}}
                    {{--                                'class' => 'form-control entry_items-cr_amount',--}}
                    {{--                                'placeholder' => 'Cr. Amount'--}}
                    {{--                                ]) !!}--}}
                    {{--                            </div>--}}
                    {{--                        </td>--}}
                    {{--                        --}}{{--                        <td>--}}
                    {{--                        --}}{{--                            <div class="form-group">--}}
                    {{--                        --}}{{--                                {!! Form::text('entry_items[narration][1]', null, [--}}
                    {{--                        --}}{{--                                'id' => 'entry_item-narration-1',--}}
                    {{--                        --}}{{--                                'class' => 'form-control entry_items-narration',--}}
                    {{--                        --}}{{--                                'placeholder' => 'Narration'--}}
                    {{--                        --}}{{--                                ]) !!}--}}
                    {{--                        --}}{{--                            </div>--}}
                    {{--                        --}}{{--                        </td>--}}

                    {{--                        --}}{{--                        <td>--}}
                    {{--                        --}}{{--                            <div class="form-group">--}}
                    {{--                        --}}{{--                                {!! Form::text('entry_items[instrument_number][1]', null, [--}}
                    {{--                        --}}{{--                                'id' => 'entry_item-instrument_number-1',--}}
                    {{--                        --}}{{--                                'class' => 'form-control entry_items-instrument_number',--}}
                    {{--                        --}}{{--                                'placeholder' => 'instrument'--}}
                    {{--                        --}}{{--                                ]) !!}--}}
                    {{--                        --}}{{--                            </div>--}}
                    {{--                        --}}{{--                        </td>--}}

                    {{--                        <td>--}}
                    {{--                            <button onclick="FormControls.destroyEntryItem('1');" id="entry_item-del_btn-1"--}}
                    {{--                                    type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i--}}
                    {{--                                    class="ri-delete-bin-5-line"></i></button>--}}
                    {{--                        </td>--}}
                    {{--                    </tr>--}}
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
                            {!! Form::number('dr_total', old('dr_total', $VoucherData['dr_total']), ['id' => 'dr_total', 'class' => 'form-control', 'readonly' => 'true', 'readonly' => 'true']) !!}
                            @if($errors->has('dr_total'))
                                <span class="help-block">
                                    {{ $errors->first('dr_total') }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="form-group @if($errors->has('cr_total')) has-error @endif">
                            {!! Form::number('cr_total', old('cr_total', $VoucherData['cr_total']), ['id' => 'cr_total', 'class' => 'form-control', 'readonly' => 'true', 'readonly' => 'true']) !!}
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
                </tbody>
            </table>
            <input type="hidden" id="entry_item-global_counter"
                   value="@if(count($VoucherData['entry_items']['counter'])){{ count($VoucherData['entry_items']['counter']) }}@else{{'1'}}@endif"/>
        </div>
    </div>
</div>

