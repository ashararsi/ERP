@extends('admin.layout.main')

@section('title', 'Add Payment')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="text-22 text-midnight text-bold mb-4">Add Payment</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderModal">
                        View Invoice
                    </button>
                </div>
                
                
                <form method="POST" action="{{ route('admin.payments.store') }}">
                    @csrf

                    <input type="hidden" name="sales_order_id" value="{{ $sale->id }}">

                    <div class="mb-3">
                        <label>Customer</label>
                        <input type="text" class="form-control" value="{{ $sale->customer->name ?? 'N/A' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Total Bill</label>
                        <input type="text" class="form-control" value="{{ number_format($sale->net_total, 2) }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Total Paid</label>
                        <input type="text" class="form-control" 
                            value="{{ number_format($sale->payments->sum('amount'), 2) }}" 
                            disabled>

                            {{-- <input type="text" class="form-control" 
                            value="0" 
                            disabled> --}}
                    </div>

                    <div class="mb-3">
                        <label>Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="fullPaymentCheck">
                        <label class="form-check-label" for="fullPaymentCheck">Pay Full Amount</label>
                    </div>

                    <div class="mb-3">
                        <label>New Payment Amount</label>
                        <input type="number" name="amount" id="amount" step="0.01" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Remaining Balance</label>
                        <input type="text" id="remaining" class="form-control" disabled>
                    </div>

                    <button type="submit" class="btn btn-success">Submit Payment</button>
                    <a href="{{ route('admin.pos.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>S#</th>
                          <th>Item Code</th>
                          <th>Name</th>
                          <th>Batch#</th>
                          <th>QTY</th>
                          <th>R/Unit</th>
                          <th>Gross Price</th>
                          <th>T.Disc</th>
                          <th>S.Disc</th>
                          <th>S.D</th>
                          <th>T.P</th>
                          <th>Excl. S.Tax</th>
                          <th>GST @18%</th>
                          <th>Incl. S.Tax</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($sale->items as $key => $item)
                          <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $item->product->product_code ?? '-' }}</td>
                              <td>{{ $item->product->name ?? '-' }}</td>
                              <td>{{ $item->batch->batch_code ?? '-' }}</td>
                              <td>{{ $item->quantity }}</td>
                              <td>{{ $item->rate }}</td>
                              <td>{{ $item->amount }}</td>
                              <td>{{ $item->trade_discount }}</td>
                              <td>{{ $item->special_discount }}</td>
                              <td>{{ $item->scheme_discount }}</td>
                              <td>{{ number_format($item->tp_amount, 2) }}</td>
                              <td>{{ number_format($item->tp_amount * $item->quantity, 2) }}</td>
                              <td>{{ $item->tax_amount }}</td>
                              <td>{{ number_format($item->includedAmt, 2) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                      <tr>
                          <th colspan="4" class="text-end">Totals</th>
                          <th>{{ number_format($sale->items->sum('quantity'), 2) }}</th>
                          <th>-</th>
                          <th>{{ number_format($sale->items->sum('amount'), 2) }}</th>
                          <th>{{ number_format($sale->items->sum('trade_discount'), 2) }}</th>
                          <th>{{ number_format($sale->items->sum('special_discount'), 2) }}</th>
                          <th>{{ number_format($sale->items->sum('scheme_discount'), 2) }}</th>
                          <th>-</th>
                          <th>{{ number_format($sale->items->sum(fn($i) => $i->tp_amount * $i->quantity), 2) }}</th>
                          <th>{{ number_format($sale->items->sum('tax_amount'), 2) }}</th>
                          <th>{{ number_format($sale->items->sum('includedAmt'), 2) }}</th>
                      </tr>
                  </tfoot>
              </table>
      
              <div class="mt-4 row">
                  <div class="col-md-6">
                      <strong>Rep Person:</strong> {{ $sale->customer->spo->name ?? '-' }}
                  </div>
                  <div class="col-md-6">
                      <table class="table">
                          <tr><td>Total:</td><td class="text-end">{{ number_format($sale->total_cal_amount, 2) }}</td></tr>
                          <tr><td>Further Sales Amount:</td><td class="text-end">{{ number_format($sale->further_sale_tax, 2) }}</td></tr>
                          <tr><td>Total Incl. Tax:</td><td class="text-end">{{ number_format($sale->all_included_tax, 2) }}</td></tr>
                          <tr><td>Advance Tax:</td><td class="text-end">{{ number_format($sale->advance_tax, 2) }}</td></tr>
                          <tr><th>Net Total:</th><th class="text-end">{{ number_format($sale->net_total, 2) }}</th></tr>
                      </table>
                  </div>
              </div>
      
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInput = document.getElementById('amount');
        const remainingInput = document.getElementById('remaining');
        const fullPaymentCheck = document.getElementById('fullPaymentCheck');

        const total = parseFloat({{ $sale->net_total }});
        const paid = parseFloat({{ $sale->payments->sum('amount') }});
        const maxAmount = total - paid;

        function updateRemaining() {
            let newPayment = parseFloat(amountInput.value) || 0;

            if (newPayment > maxAmount) {
                alert(`Entered amount exceeds remaining balance. Maximum allowed is ${maxAmount.toFixed(2)}`);
                newPayment = maxAmount;
                amountInput.value = maxAmount.toFixed(2);
            }

            const remaining = total - paid - newPayment;
            remainingInput.value = remaining.toFixed(2);
        }

        amountInput.addEventListener('input', function () {
            if (fullPaymentCheck.checked) {
                fullPaymentCheck.checked = false;
            }
            updateRemaining();
        });

        fullPaymentCheck.addEventListener('change', function () {
            if (this.checked) {
                amountInput.value = maxAmount.toFixed(2);
                remainingInput.value = '0.00';
            } else {
                amountInput.value = '';
                remainingInput.value = maxAmount.toFixed(2);
            }
        });

        remainingInput.value = maxAmount.toFixed(2);
    });
</script>

@endsection
