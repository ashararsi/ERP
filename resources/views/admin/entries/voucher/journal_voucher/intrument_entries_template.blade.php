<table style="display: none;">
    <tbody id="entry_item-container">
    <tr class="entry_item-###### first_row">
        <td colspan="5">
            <div class="form-group">
                {!! Form::hidden('entry_items[counter][######]', '######', ['id' => 'entry_item-counter-######',
                    'class' => 'entry_item-counter-######']) !!}
                {!! Form::select('entry_items[ledger_id][######]', array(), old('branch_id'),
                    ['id' => 'entry_item-ledger_id-######', 'style' => 'width: 100%;',
                    'class' => 'form-control classForNarration description-data-ajax######']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::number('entry_items[dr_amount][######]', null, [
                'onkeydown' => 'FormControls.CalculateTotal();',
                'onkeyup' => 'FormControls.CalculateTotal();',
                'onblur' => 'FormControls.CalculateTotal();',
                'id' => 'entry_item-dr_amount-######',
                'onchange' => "dr_validation(######)",
                'class' => 'form-control entry_items-dr_amount########',
                'placeholder' => 'Dr. Amount'
                ]) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::number('entry_items[cr_amount][######]', null, [
                'onkeydown' => 'FormControls.CalculateTotal();',
                'onkeyup' => 'FormControls.CalculateTotal();',
                'onblur' => 'FormControls.CalculateTotal();',
                'id' => 'entry_item-cr_amount-######',
                'onchange' => "cr_validation(######)",
                'class' => 'form-control entry_items-cr_amount########',
                'placeholder' => 'Cr. Amount'
                ]) !!}
            </div>
        </td>
        <td>
            <button id="entry_item-del_btn-######" onclick="FormControls.destroyEntryItem('######');" type="button"
                    class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i>
            </button>
        </td>
    </tr>
    <tr class="entry_item-###### last_row">
        @if(isset($vendorDropdown) && $vendorDropdown == 1)
            <td colspan="6">
                <div class="form-group">
                    {!! Form::text('entry_items[narration][######]', null, [
                    'id' => 'entry_item-narration-######',
                    'class' => ' form-control entry_items-narration########',
                    'placeholder' => 'Narration'
                    ]) !!}
                </div>
            </td>
            <td colspan="2">
                <div class="form-group">
                    <select class="form-control vendor_id_select" id="entry_item-vendor_id-######" name="entry_items[vendor_id][######]">
                        <option value="">Select Vendor</option>
                        @foreach($vendor as $item)
                            <option value="{{ $item->vendor_id }}">{{ $item->vendor_name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
        @else
            <td colspan="8">
                <div class="form-group">
                    {!! Form::text('entry_items[narration][######]', null, [
                    'id' => 'entry_item-narration-######',
                    'class' => ' form-control entry_items-narration########',
                    'placeholder' => 'Narration'
                    ]) !!}
                </div>
            </td>
        @endif
    </tr>
    </tbody>
</table>
