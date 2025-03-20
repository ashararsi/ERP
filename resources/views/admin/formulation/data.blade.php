<div id="formula_items">

    @foreach($f->formulationDetail as $item)
        <hr/>
        <div class=" item-row card card-body" data-id="{{ $item->id }}">
          <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Raw Material</label>
                    <select disabled class="form-control" name="items[raw_material_id][]" required>
                        <option value="">Select Material</option>
                        @foreach($data['RawMaterials'] as $material)
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
                        @foreach($data['units'] as $u_item)
                            <option @if($item->unit_id == $u_item->id) selected
                                    @endif  value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Standard Quantity</label>
                    <input disabled type="number" class="form-control quantity"
                           value="{!!( $item->standard_quantity * $qty) !!}" name="items[quantity][]"
                           required>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label>Actual</label>
                    <input type="number" class="form-control quantity"
                           value="" name="items[actual_quantity][]"
                           required>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label>Operator </label>
                    <select class="form-control" name="items[operator_ids][]" required>
                        <option value="">Select Operator</option>
                        @foreach($users['operator_initials'] as $u_item)
                            <option value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Prod In-Charge </label>
                    <select   class="form-control" name="items[in_charge][]" required>
                        <option value="">Select Qa</option>
                        @foreach($users['Prod'] as $u_item)
                            <option value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>QA </label>
                    <select   class="form-control" name="items[in_charge][]" required>
                        <option value="">Select Qa</option>
                        @foreach($users['qaUsers'] as $u_item)
                            <option value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>

        </div>
    @endforeach
</div>
