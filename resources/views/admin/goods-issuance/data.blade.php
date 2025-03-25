<div id="formula_items">


    @foreach($batch->batchDetails as $key=>$item)

            <?php

            $f_item = \App\Models\FormulationDetail::where('formulation_id', $batch->formulation_id)->where('raw_material_id', $item->raw_material_id)->first();
            ?>
        <hr/>
        <div class=" item-row card card-body" data-id="{{ $item->id }}">
            <div class="row">
                <input type="hidden" name="items[item_id][]" value="{!! $item->id !!}">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Raw Material</label>
                        <select disabled class="form-control" name="items[raw_material_id][]" required>
                            <option value="">Select Material</option>
                            @foreach($raw as $material)
                                <option @if($item->raw_material_id == $material->id) selected @endif
                                value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Unit </label>

                        <select disabled class="form-control" name="items[unit_id][]" required>
                            <option value="">Select Units</option>
                            @foreach($units as $u_item)
                                <option @if($f_item->unit_id == $u_item->id) selected
                                        @endif  value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Standard Quantity</label>


                        <input disabled type="number" class="form-control quantity"
                               value="{!!( $f_item->standard_quantity ) !!}" name="items[quantity][]"
                               required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Actual</label>
                        <input type="number" class="form-control quantity"
                               value="{!! $item->actual_quantity !!}" name="items[actual_quantity][]"
                               required>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label>Operator </label>
                        <select disabled class="form-control" name="items[operator_ids][]" required>
                            <option value="">Select Operator</option>
                            @foreach($users['operator_initials'] as $u_item)
                                <option @if($item->operator_initials==$u_item->id) selected
                                        @endif value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Prod In-Charge </label>
                        <select disabled class="form-control" name="items[in_charge][]" required>
                            <option value="">Select Qa</option>
                            @foreach($users['Prod'] as $u_item)
                                <option @if($item->in_charge==$u_item->id) selected
                                        @endif value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>QA </label>
                        <select disabled class="form-control" name="items[qa_initials][]" required>
                            <option value="">Select Qa</option>
                            @foreach($users['qaUsers'] as $u_item)
                                <option @if($item->in_charge==$u_item->id) selected
                                        @endif  value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
</div>
