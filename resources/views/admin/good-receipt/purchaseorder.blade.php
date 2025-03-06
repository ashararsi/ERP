<div id="purchase_order_items">
    @foreach($p->items as $item)
        <div class="row item-row">
            <div class="col-md-2">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label>Quantity</label>
                    <input disabled type="number" class="form-control quantity"
                           value="{!! $item->quantity !!}" name="items[quantity][]"
                           required>
                </div>
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label>Unit Price</label>
                    <input disabled type="number" class="form-control unit-price" value="{!! $item->unit_price !!}"
                           step="0.01"
                           name="items[unit_price][]" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Subtotal</label>
                    <input disabled type="text" class="form-control subtotal"
                           value="{!! $item->subtotal !!}" name="items[subtotal][]"
                           readonly>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>status </label>

                    <select class="form-control" name="items[{!! $item->id !!}]" required>
                        <option value="">Select Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">pending</option>
                        <option value="cancel">cancel</option>

                    </select>
                </div>
            </div>

        </div>
    @endforeach
</div>
