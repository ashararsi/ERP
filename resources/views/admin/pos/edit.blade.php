@extends('admin.layout.main')
@section('content')
<br/><br/><br/>
<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">Edit Sales Order</h2>
    <form id="salesOrderForm" action="{{ route('admin.pos.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Customer Info -->
        <div class="form-section">
            <h4 class="mb-3">Customer Information</h4>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label required-field">Order Number</label>
                    <input type="text" class="form-control" name="sOrdNo" value="{{ $order->sOrdNo }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label required-field">Order Date</label>
                    <input type="date" class="form-control" name="sOrdDate" value="{{ $order->sOrdDate }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label required-field">Customer Code</label>
                    <select name="customer_id" class="form-control" required>
                        @foreach($data['customers'] as $item)
                            <option value="{{ $item->id }}" {{ $order->customer_id == $item->id ? 'selected' : '' }}>
                                {{ $item->customer_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $order->name }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-4">
                    <label class="form-label">Customer PO No</label>
                    <input type="text" class="form-control" name="customerPO" value="{{ $order->customerPO }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Customer PO Date</label>
                    <input type="date" class="form-control" name="customerPODate" value="{{ $order->customerPODate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">City</label>
                    <input type="text" class="form-control" name="city" value="{{ $order->city }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $order->email }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">NTN</label>
                    <input type="text" class="form-control" name="ntn" value="{{ $order->ntn }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">STN</label>
                    <input type="text" class="form-control" name="stn" value="{{ $order->stn }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label">SPO</label>
                    <input type="text" class="form-control" name="spo" value="{{ $order->spo }}" readonly>
                </div>
            </div>
        </div>

        <!-- Payment and Sales Info -->
        <br/>
        <div class="form-section">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label required-field">Payment Terms</label>
                    <select class="form-select" name="paymentTerms" required>
                        <option value="1" {{ $order->paymentTerms == 1 ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="2" {{ $order->paymentTerms == 2 ? 'selected' : '' }}>7 Days Credit</option>
                        <option value="3" {{ $order->paymentTerms == 3 ? 'selected' : '' }}>15 Days Credit</option>
                        <option value="4" {{ $order->paymentTerms == 4 ? 'selected' : '' }}>30 Days Credit</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">Sales Representative</label>
                    <select class="form-select" name="salesRep" required>
                        @foreach($users['operator_initials'] as $item)
                            <option value="{{ $item->id }}" {{ $order->salesRep == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">Expected Delivery Date</label>
                    <input type="date" class="form-control" name="deliveryDate" value="{{ $order->deliveryDate }}" required>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <br/>
        <div class="form-section">
            <h4>Order Details</h4>
            <table class="table table-bordered" id="productsTable">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Batch</th>
                        <th>Expiry</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="mainRowsBody">
                    @foreach($order->details as $index => $detail)
                    <tr>
                        <td>
                            <select class="form-select" name="product[]">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $detail->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="batch[]">
                                @foreach($Batches as $batch)
                                    <option value="{{ $batch->id }}"
                                        {{ $detail->batch_id == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->batch_code }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="date" class="form-control" name="expiry[]" value="{{ $detail->expiry }}"></td>
                        <td><input type="number" class="form-control" name="qty[]" value="{{ $detail->qty }}"></td>
                        <td><input type="number" class="form-control" name="rate[]" value="{{ $detail->rate }}"></td>
                        <td><input type="number" class="form-control" name="amount[]" value="{{ $detail->amount }}" readonly></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="form-label">Sub Total</label>
                <input type="text" class="form-control" name="subTotal" value="{{ $order->subTotal }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Discount</label>
                <input type="text" class="form-control" name="totalDiscount" value="{{ $order->totalDiscount }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sales Tax</label>
                <input type="text" class="form-control" name="salesTax" value="{{ $order->salesTax }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Net Total</label>
                <input type="text" class="form-control" name="netTotal" value="{{ $order->netTotal }}" readonly>
            </div>
        </div>

        <!-- Notes -->
        <div class="form-section mt-3">
            <label class="form-label">Special Instructions</label>
            <textarea class="form-control" name="notes" rows="2">{{ $order->notes }}</textarea>
        </div>

        <!-- Actions -->
        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success me-2"><i class="bi bi-check-circle"></i> Update</button>
            <a href="{{ route('admin.pos.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function calculateRowAmount(row) {
            const qty = parseFloat(row.querySelector('input[name="qty[]"]').value) || 0;
            const rate = parseFloat(row.querySelector('input[name="rate[]"]').value) || 0;
            const amountField = row.querySelector('input[name="amount[]"]');
            amountField.value = (qty * rate).toFixed(2);
        }
    
        function updateTotals() {
            let subTotal = 0;
            document.querySelectorAll('input[name="amount[]"]').forEach(field => {
                subTotal += parseFloat(field.value) || 0;
            });
    
            const totalDiscount = 0;
            const salesTax = 0;
            const netTotal = subTotal;
    
            document.querySelector('input[name="subTotal"]').value = subTotal.toFixed(2);
            document.querySelector('input[name="totalDiscount"]').value = totalDiscount.toFixed(2);
            document.querySelector('input[name="salesTax"]').value = salesTax.toFixed(2);
            document.querySelector('input[name="netTotal"]').value = netTotal.toFixed(2);
        }
    
        function attachRowEvents(row) {
            ['qty[]', 'rate[]'].forEach(name => {
                row.querySelector(`input[name="${name}"]`).addEventListener('input', () => {
                    calculateRowAmount(row);
                    updateTotals();
                });
            });
        }
    
        document.querySelectorAll('#mainRowsBody tr').forEach(row => {
            attachRowEvents(row);
            calculateRowAmount(row);
        });
    
        document.getElementById('addRowBtn')?.addEventListener('click', function () {
            const row = document.querySelector('#mainRowsBody tr').cloneNode(true);
            row.querySelectorAll('input').forEach(input => input.value = '');
            row.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            document.getElementById('mainRowsBody').appendChild(row);
            attachRowEvents(row);
        });
    
        updateTotals();
    });
    </script>
    
@endsection