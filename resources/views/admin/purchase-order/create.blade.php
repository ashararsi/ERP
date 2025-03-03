@extends('admin.layout.main')
@section('title')
    Raw Material  Create
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Unit </h3>
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


                        <form action="{{ route('purchase_orders.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po_number">PO Number</label>
                                        <input type="text" required id="po_number" class="form-control"
                                               name="po_number">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select class="form-control" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
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
                            <h4>Purchase Order Items</h4>

                            <div id="purchase_order_items">
                                <div class="row item-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Raw Material</label>
                                            <select class="form-control" name="items[0][raw_material_id]" required>
                                                <option value="">Select Material</option>
                                                @foreach($rawMaterials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control quantity" name="items[0][quantity]"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Unit Price</label>
                                            <input type="number" class="form-control unit-price" step="0.01"
                                                   name="items[0][unit_price]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Subtotal</label>
                                            <input type="text" class="form-control subtotal" name="items[0][subtotal]"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger remove-item mt-4">Remove</button>
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

@endsection
