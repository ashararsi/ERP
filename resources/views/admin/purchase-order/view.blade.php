@extends('admin.layout.main')
@section('title')
    Purchase Order Details
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Purchase Order Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>PO Number:</strong> {{ $p->po_number }}</div>
                        <div class="col-md-4"><strong>Supplier:</strong> {{ $p->supplier->name ?? '-' }}</div>
                        <div class="col-md-4"><strong>Order Date:</strong> {{ $p->order_date }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Delivery Date:</strong> {{ $p->delivery_date }}</div>
                        <div class="col-md-4"><strong>Status:</strong> {{ ucfirst($p->status) }}</div>
                        <div class="col-md-4"><strong>Total Amount:</strong> {{ number_format($p->total_amount, 2) }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12"><strong>Notes:</strong><br>{{ $p->notes ?? '-' }}</div>
                    </div>

                    <hr>
                    <h4 class="mb-3">Purchase Order Items</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Raw Material</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($p->items as $item)
                                    <tr>
                                        <td>{{ $item->rawMaterial->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit->name ?? '-' }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mt-4">
                        {{-- <a href="{{ route('admin.purchaseorders.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                        <a href="{{ route('admin.purchaseorders.index') }}" class="btn btn-sm btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
