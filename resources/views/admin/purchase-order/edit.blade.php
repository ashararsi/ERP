@extends('admin.layout.main')
@section('title')
    purchase Orders Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.purchaseorders.update',$p->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po_number">PO Number</label>
                                        <input type="text" value="{!! $p->po_number !!}" readonly id="po_number"
                                               class="form-control"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select class="form-control" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($data['Supplier'] as $supplier)
                                                <option @if($p->supplier_id==$supplier->id)  selected
                                                        @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_date">Order Date</label>
                                        <input type="date" value="{!! $p->order_date !!}" required class="form-control"
                                               id="order_date"
                                               name="order_date">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <input value="{!! $p->delivery_date !!}" type="date" required
                                               class="form-control" id="delivery_date"
                                               name="delivery_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option @if($p->status=="pending") selected @endif value="pending">Pending
                                            </option>
                                            <option @if($p->status=="approved") selected @endif value="approved">
                                                Approved
                                            </option>
                                            <option @if($p->status=="delivered") selected @endif value="delivered">
                                                Delivered
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount</label>
                                        <input type="number" value="{!! $p->total_amount !!}" step="0.01" required
                                               class="form-control" id="total_amount"
                                               name="total_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes">{!! $p->notes !!}</textarea>
                            </div>

                            <hr>
                            <div class="row mb-4 mt-3">
                                <div class="col-md-3">
                                    <h4 class="mt-2">Purchase Order Items</h4>
                                </div>
                                <div class="col-md-3 ">
                                    <button type="button" class="btn btn-primary mt-3" id="add_more"><span
                                            class="fa fa-plus"></span></button>
                                </div>
                            </div>


                            <div id="purchase_order_items">
                                @foreach($p->items as $item)
                                    <div class="row item-row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Raw Material</label>
                                                <select class="form-control" name="items[raw_material_id][]" required>
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
                                                <input type="number" class="form-control quantity"
                                                    value="{!! $item->quantity !!}"   name="items[quantity][]"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Unit </label>

                                                <select class="form-control" name="items[unit_id][]" required>
                                                    <option  value="">Select Units</option>
                                                    @foreach($data['units'] as $u_item)
                                                        <option @if($item->unit_id == $u_item->id) selected @endif  value="{{ $u_item->id }}">{{ $u_item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Unit Price</label>
                                                <input type="number" class="form-control unit-price" step="0.01"
                                                       name="items[unit_price][]" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Subtotal</label>
                                                <input type="text" class="form-control subtotal"
                                                       name="items[subtotal][]"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-item mt-4"><span
                                                    class="fa fa-trash-alt"></span></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.purchaseorders.index') !!}"
                                       class=" btn btn-sm btn-danger">Cancel </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
@endsection
