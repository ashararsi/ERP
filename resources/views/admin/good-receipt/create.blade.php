@extends('admin.layout.main')
@section('title')
    GRN Create
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Good Receipt Note (GRN)</h3>
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
                        <form action="{{ route('admin.grns.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po_number">PO Number</label>
                                        <select class="form-control" name="purchase_order_id" id="purchase_order_id"
                                                required>
                                            <option value="">Select Order</option>
                                            @foreach($data['po'] as $po)
                                                <option value="{{ $po->id }}">{{ $po->po_number }}</option>
                                            @endforeach
                                        </select>
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
                                        <input type="date" required class="form-control" id="receipt_date"
                                               name="receipt_date"
                                               value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="pending">Pending</option>
                                            <option value="rejected">cancel</option>
                                            <option value="verified">Delivered</option>
                                        </select>
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

                            </div>


                            <div id="purchase_order_items">

                            </div>
                            <hr>

                            <div class="row mt-4">

                                <div class="col-md-3 ">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <a href="{!! route('admin.grns.index') !!}"
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

        $(document).ready(function () {
            $('#purchase_order_id').change(function () {
                var purchaseOrderId = $(this).val();

                if (purchaseOrderId) {
                    $.ajax({
                        url: '{!! route('admin.grns.fetch_po_record') !!}', // Update this with your route URL
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: purchaseOrderId
                        },
                        success: function (response) {

                            $('#purchase_order_items').html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                }
            });
        });

    </script>

@endsection
