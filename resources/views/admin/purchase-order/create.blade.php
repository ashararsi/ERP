@extends('admin.layout.main')
@section('title')
    Purchase Order Create
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Purchase Order </h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.purchaseorders.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po_number">PO Number</label>
                                        <input type="text" readonly id="po_number" class="form-control"
                                               >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select class="form-control" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($data['Supplier'] as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_date">Order Date</label>
                                        <input type="date" required class="form-control" id="order_date"
                                               name="order_date">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <input type="date" required class="form-control" id="delivery_date"
                                               name="delivery_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount</label>
                                        <input type="number" step="0.01" required class="form-control" id="total_amount"
                                               name="total_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes"></textarea>
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
                                <div class="row item-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Raw Material</label>
                                            <select class="form-control" name="items[raw_material_id][]" required>
                                                <option value="">Select Material</option>
                                                @foreach($data['RawMaterials'] as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control quantity" name="items[quantity][]"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Unit </label>

                                            <select class="form-control" name="items[unit_id][]" required>
                                                <option value="">Select Units</option>
                                                @foreach($data['units'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                            <input type="text" class="form-control subtotal" name="items[subtotal][]"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-item mt-4"><span
                                                class="fa fa-trash-alt"></span></button>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-4">

                                <div class="col-md-3 ">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <a href="{!! route('admin.units.index') !!}"
                                           class=" btn btn-sm btn-danger">Cancel </a>
                                    </div>
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
    <script>
        let itemIndex = 1;

        document.getElementById('add_more').addEventListener('click', function () {
            let newRow = `
        <div class="row mt-3 item-row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Raw Material</label>
                    <select class="form-control" name="items[raw_material_id][]" required>
                        <option value="">Select Material</option>
                        @foreach($data['RawMaterials'] as $material)
            <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control quantity" name="items[quantity][]" required>
                </div>
            </div>
              <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Unit </label>

                                            <select class="form-control" name="items[unit_id][]" required>
                                                <option value="">Select Units</option>
                                                @foreach($data['units'] as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
            </select>
        </div>
    </div>
<div class="col-md-2">
<div class="form-group">
<label>Unit Price</label>
<input type="number" class="form-control unit-price" step="0.01" name="items[unit_price][]" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Subtotal</label>
                    <input type="text" class="form-control subtotal" name="items[subtotal][]" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-item mt-4"><span class="fa fa-trash-alt"></span></button>
            </div>
        </div>`;

            document.getElementById('purchase_order_items').insertAdjacentHTML('beforeend', newRow);
            itemIndex++;
        });

        document.getElementById('purchase_order_items').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });

        document.getElementById('purchase_order_items').addEventListener('input', function (e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                let row = e.target.closest('.item-row');
                let quantity = row.querySelector('.quantity').value || 0;
                let unitPrice = row.querySelector('.unit-price').value || 0;
                let subtotal = row.querySelector('.subtotal');

                subtotal.value = (quantity * unitPrice).toFixed(2);
            }
        });
    </script>

@endsection
