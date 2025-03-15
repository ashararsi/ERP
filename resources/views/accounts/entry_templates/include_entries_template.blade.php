<table style="display: none;">
    <tbody id="entry_item-container">
    <tr class="entry_item-###### first_row">
        <td colspan="5">
            <div class="form-group" style="margin-bottom: 0px !important;">
                {!! Form::hidden('entry_items[counter][######]', '######', ['id' => 'entry_item-counter-######', 'class' => 'entry_item-counter-######']) !!}
                {!! Form::select('entry_items[ledger_id][######]', array(), old('branch_id'), ['id' => 'entry_item-ledger_id-######', 'style' => 'width: 100%;', 'class' => 'form-control description-data-ajax######']) !!}
            </div>
        </td>
        <td width="5%">
            <button id="entry_item-del_btn-######" onclick="destroyEntryItem('######');" type="button"
                    class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i>
            </button>
        </td>
    </tr>
    <tr class="entry_item-###### last_row">
        <td colspan="5">
            <div
                style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">

                <div class="form-group" style="flex: 4;">
                    {!! Form::text('entry_items[narration][######]', null, [
                    'id' => 'entry_item-narration-######',
                    'class' => 'form-control entry_items-narration',
                    'placeholder' => 'Narration'
                    ]) !!}
                </div>

                <div class="form-group instrument_div" style="flex: 1;">
                    {!! Form::text('entry_items[instrument_number][######]', null, [
                    'id' => 'entry_item-instrument_number-######',
                    'class' => 'form-control entry_items-instrument_number',
                    'placeholder' => "Instrument No",
                    'onfocusout' => "checkInstrumentNo(######)"
                    ]) !!}
                </div>

                <div class="form-group vendor_div" style="flex: 1;">
                    <select class="form-control vendor_id_select"
                            id="entry_item-vendor_id-######"
                            name="entry_items[vendor_id][######]">
                        <option value="">Select Vendor</option>
                        @foreach($vendor as $item)
                            <option
                                value="{{ $item->vendor_id }}">{{ $item->vendor_name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </td>
        <td width="5%">
            <button onclick="createEntryItem();" type="button"
                    style="font-weight: bolder"
                    class="btn btn-primary btn-icon waves-effect waves-light">
                <i class="ri-add-line"></i>
            </button>
        </td>
    </tr>
    </tbody>
</table>
