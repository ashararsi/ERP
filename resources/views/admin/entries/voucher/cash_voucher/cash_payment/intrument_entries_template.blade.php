<table style="display: none;">
    <tbody id="entry_item-container">
{{--    <tr class="entry_item-######">--}}
{{--        <th width="65%" colspan="5">Account</th>--}}
{{--        <th width="55%">Narration</th>--}}
{{--        <th width="15%">Debit</th>--}}
{{--        <th width="15%">Credit</th>--}}
{{--        <th width="5%">Action</th>--}}
{{--    </tr>--}}
    <tr class="entry_item-######">
        <td colspan="5">
            <div class="form-group" style="margin-bottom: 0px !important;">
                {!! Form::hidden('entry_items[counter][######]', '######', ['id' => 'entry_item-counter-######', 'class' => 'entry_item-counter-######']) !!}
                {!! Form::select('entry_items[ledger_id][######]', array(), old('branch_id'), ['id' => 'entry_item-ledger_id-######', 'style' => 'width: 100%;', 'class' => 'form-control description-data-ajax######']) !!}
            </div>
        </td>
        <td class="d-none">
            <div class="form-group" style="margin-bottom: 0px !important;">
                {!! Form::text('entry_items[narration][######]', null, [
                'id' => 'entry_item-narration-######',
                'class' => 'form-control entry_items-narration########',
                'placeholder' => 'Narration'
                ]) !!}
            </div>
        </td>
        <td>
            <div class="form-group" style="margin-bottom: 0px !important;">
                {!! Form::text('entry_items[dr_amount][######]', null, [
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
            <div class="form-group" style="margin-bottom: 0px !important;">
                {!! Form::text('entry_items[cr_amount][######]', null, [
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
    </tbody>
</table>
