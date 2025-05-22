@extends('admin.layout.main')
@section('content')
    <br/>
    <br/>
    <br/>
    <div class="container-fluid mt-4">
        <h2 class="text-center mb-4 ">Pharmaceutical Sales Order</h2>
        <form id="salesOrderForm" action="{!! route('admin.pos.update', $sale->id) !!}" method="POST">
            @csrf
            @method('PUT')
        
            <!-- Customer Information Section -->
            <div class="form-section">
                <h4 class="mb-3">Customer Information</h4>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="sOrdNo" class="form-label required-field">Order Number</label>
                        <input type="text" class="form-control" id="sOrdNo" name="sOrdNo" required
                            value="{{ old('sOrdNo', $sale->order_number) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="sOrdDate" class="form-label required-field">Order Date</label>
                        <input type="date" class="form-control" id="sOrdDate" name="sOrdDate" required
                            value="{{ old('sOrdDate', $sale->order_date) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="customerCode" class="form-label required-field">Customer Code</label>
                        <div class="input-group">
                            <select name="customer_id" class="form-control" id="customerCode" required>
                                <option value="">Select Customer</option>
                                @foreach($data['customers'] as $item)
                                    <option value="{{ $item->id }}" 
                                        {{ (old('customer_id', $sale->customer_id) == $item->id) ? 'selected' : '' }}>
                                        {{ $item->customer_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="name"
                            value="{{ old('name', $sale->customer_name) }}">
                    </div>
                </div>
        
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="customerPO" class="form-label">Customer PO No</label>
                        <input type="text" class="form-control" id="customerPO" name="customerPO"
                            value="{{ old('customerPO', $sale->customer_po_no) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="customerPODate" class="form-label">Customer PO Date</label>
                        <input type="date" class="form-control" id="customerPODate" name="customerPODate"
                        value="{{ old('customerPODate', optional($sale->customer)->po_date ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label required-field">City</label>
                        <input type="text" class="form-control" id="city" name="city" required
                            value="{{ old('city', $sale->city) }}">
                    </div>
                </div> 
        
                <div class="row mt-3"> 
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $sale->email) }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="ntn" class="form-label">NTN</label>
                        <input type="text" class="form-control" id="ntn" name="ntn"
                            value="{{ old('ntn', $sale->ntn) }}">
                    </div>
        
                    <div class="col-md-4">
                        <label for="stn" class="form-label">STN</label>
                        <input type="text" class="form-control" id="stn" name="stn"
                            value="{{ old('stn', $sale->stn) }}">
                    </div>
                </div>
        
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="spo" class="form-label">SPO</label>
                        <input type="text" class="form-control" id="spo" name="spo" readonly
                            value="{{ old('spo', $sale->spo) }}">
                    </div>
                </div>
        
                <input type="hidden" id="customerHasNTN" value="{{ $sale->ntn ? 1 : 0 }}">
                <input type="hidden" id="customerHasSTN" value="{{ $sale->stn ? 1 : 0 }}">
            </div>
        
            <!-- Payment and Sales Information -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="paymentTerms" class="form-label required-field">Payment Terms</label>
                        <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                            <option value="" disabled>Select Payment Terms</option>
                            <option value="1" {{ old('paymentTerms', $sale->payment_terms) == 1 ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="2" {{ old('paymentTerms', $sale->payment_terms) == 2 ? 'selected' : '' }}>7 Days Credit</option>
                            <option value="3" {{ old('paymentTerms', $sale->payment_terms) == 3 ? 'selected' : '' }}>15 Days Credit</option>
                            <option value="4" {{ old('paymentTerms', $sale->payment_terms) == 4 ? 'selected' : '' }}>30 Days Credit</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="salesRep" class="form-label required-field">Sales Representative</label>
                        <select class="form-select" id="salesRep" name="salesRep" required>
                            <option value="" disabled>Select Sales Rep</option>
                            @foreach($users['operator_initials'] as $item)
                                <option value="{{ $item->id }}" 
                                    {{ (old('salesRep', $sale->sales_rep_id) == $item->id) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="deliveryDate" class="form-label required-field">Expected Delivery Date</label>
                        <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" required
                            value="{{ old('deliveryDate', $sale->expected_delivery_date) }}">
                    </div>
                </div>
            </div>
        
            <!-- Order Details Section -->
            <!-- Order Details Section -->
            <div class="form-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4>Order Details</h4>
                  <button type="button" class="btn btn-sm btn-success" id="addProductBtn">
                    <i class="bi bi-plus-circle"></i> Add Product
                  </button>
                </div>
              
                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="productsTable">
                    <thead class="table-primary">
                      <tr>
                        <th width="20%">Product Description</th>
                        <th width="10%">Batch</th>
                        <th width="10%">Expiry</th>
                        <th width="5%">Qty</th>
                        <th width="5%">Rate</th>
                        <th width="7%">Amount</th>
                      </tr>
                    </thead>
                    <tbody id="mainRowsBody">
                      <!-- Main product rows go here -->
                    </tbody>
              
                    <thead class="table-secondary">
                      <tr>
                        <th width="10%">Disc %</th>
                        <th width="10%">Disc Amt</th>
                        <th width="10%">Tax %</th>
                        <th width="10%">T.disc</th>
                        <th width="10%">S.disc</th>
                        <th width="10%">SS.disc</th>
                        <th width="10%">Tax Amt</th>
                        <th width="10%">Net Amount</th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tbody id="detailRowsBody">
                      <!-- Detail rows go here -->
                    </tbody>
                  </table>
                </div>
              </div>

        
            <!-- Totals Section -->
            <div class="total-section">
                <div class="row">
                    <div class="col-md-3">
                        <label for="subTotal" class="form-label">Sub Total</label>
                        <input type="text" class="form-control" id="subTotal" name="subTotal" readonly
                            value="{{ old('subTotal', $sale->sub_total) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="totalDiscount" class="form-label">Total Discount</label>
                        <input type="text" class="form-control" id="totalDiscount" name="totalDiscount" readonly
                            value="{{ old('totalDiscount', $sale->total_discount) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="salesTax" class="form-label">Sales Tax</label>
                        <input type="text" class="form-control" id="salesTax" name="salesTax" readonly
                            value="{{ old('salesTax', $sale->sales_tax) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="advanceTax" class="form-label">Advance Tax</label>
                        <input type="text" class="form-control" id="advanceTax" name="advanceTax" readonly
                            value="{{ old('advanceTax', $sale->advance_tax) }}">
                    </div>
        
                    <div class="col-md-3">
                        <label>Further Sales Tax</label>
                        <input type="number" id="furtherSalesTax" class="form-control" name="furtherSalesTax" readonly
                            value="{{ old('furtherSalesTax', $sale->further_sales_tax) }}">
                    </div>
        
                    <div class="col-md-3">
                        <label>All Included Tax</label>
                        <input type="number" id="all_included_tax" class="form-control" name="all_included_tax" readonly
                            value="{{ old('all_included_tax', $sale->all_included_tax) }}">
                    </div>
        
                    <input type="hidden" id="total_amount" name="total_cal_amount"
                        value="{{ old('total_cal_amount', $sale->total_cal_amount) }}">
                </div>
        
                <div class="row mt-3">
                    <div class="col-md-3 offset-md-6">
                        <label for="totalTax" class="form-label">Total Tax</label>
                        <input type="text" class="form-control" id="totalTax" name="totalTax" readonly
                            value="{{ old('totalTax', $sale->total_tax) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="netTotal" class="form-label fw-bold">Net Total</label>
                        <input type="text" class="form-control fw-bold" id="netTotal" name="netTotal" readonly
                            value="{{ old('netTotal', $sale->net_total) }}">
                    </div>
        
                    <input type="hidden" name="further_sales_tax_rate" id="furtherSalesTaxRate" 
                        value="{{ old('further_sales_tax_rate', $sale->further_sales_tax_rate) }}">
                    <input type="hidden" name="advance_tax_rate" id="advanceTaxRate"
                        value="{{ old('advance_tax_rate', $sale->advance_tax_rate) }}">
                </div>
            </div>
        
            <!-- Notes Section -->
            <div class="form-section mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <label for="notes" class="form-label">Special Instructions</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $sale->notes) }}</textarea>
                    </div>
                </div>
            </div>
        
            <!-- Action Buttons -->
            <div class="mt-4 d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> Preview
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-danger me-2" id="resetFormBtn">
                        <i class="bi bi-trash"></i> Clear
                    </button>
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Approve
                    </button>
                </div>
            </div>
        </form>
        
    </div>
    <br/>
    <br/>
    <br/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
    <script>
           const existingProducts = @json($saleItems);
    </script> 
  <script>
        $(document).ready(function () {
            let rowCounter = 1;

$('#addProductBtn').click(function () {
    addProductRow();
});

if (existingProducts.length > 0) {
    existingProducts.forEach(productData => {
        addProductRow(productData);
    });
} else {
    addProductRow();
}

function addProductRow(data = null) {
    const rowId = rowCounter++;

    // Generate product options with selected if matches data.productId
    let productOptions = `<option value="">Select Product</option>`;
    @foreach($products as $item)
        productOptions += `<option data-price="{{ $item->price }}" value="{{ $item->id }}" ${data && data.productId == {{ $item->id }} ? 'selected' : ''}>
            {{ $item->product_code }} - {{ $item->name }}
            @if($item->packing) - {{ $item->packing->display_name }} @endif
            @if($item->packing && $item->packing->units)
                (unit {{ $item->packing->units->name }})
            @endif
        </option>`;
    @endforeach

    // Generate batch options with selected if matches data.batchId
    let batchOptions = `<option value="">Select Batch</option>`;
    @foreach($Batches as $item)
        batchOptions += `<option value="{{ $item->id }}" data-expiry="{{ $item->expiry_date }}" ${data && data.batchId == {{ $item->id }} ? 'selected' : ''}>
            {{ $item->batch_code }}
        </option>`;
    @endforeach

    const mainRow = `
        <tr class="product-main-row" data-row-id="${rowId}">
            <td>
                <select class="form-select product-select" id="product_${rowId}" name="product[]" required>
                    ${productOptions}
                </select>
            </td>
            <td>
                <select class="form-select batch-select" id="batch_${rowId}" name="batch[]" required>
                    ${batchOptions}
                </select>
            </td>
            <td><input type="date" id="expiry_${rowId}" class="form-control expiry" name="expiry[]" required value="${data ? data.expiry : ''}"></td>
            <td><input type="number" id="qty_${rowId}" class="form-control qty" name="qty[]" min="1" value="${data ? data.qty : 1}" required></td>
            <td><input type="number" id="rate_${rowId}" class="form-control rate" name="rate[]" step="0.01" min="0" value="${data ? data.rate : ''}" required></td>
            <td><input type="number" id="amount_${rowId}" class="form-control amount" name="amount[]" value="0.00" readonly></td>
        </tr>
    `;

    const detailRow = `
        <tr class="product-detail-row" data-row-id="${rowId}">
            <td><input type="number" id="discPercent_${rowId}" class="form-control disc-percent" name="discPercent[]" min="0" max="100" step="0.01" value="${data ? data.discPercent : 0}"></td>
            <td><input type="number" id="discAmt_${rowId}" class="form-control disc-amt" name="discAmt[]" value="0.00" readonly></td>
            <td><input type="number" id="taxPercent_${rowId}" class="form-control tax-percent" name="taxPercent[]" min="0" step="0.01" value="${data ? data.taxPercent : 18}" required></td>
            <td><input type="number" id="tDisc_${rowId}" class="form-control t-disc-amt" name="trade_discount[]" value="${data ? data.tradeDiscount : 0.00}" readonly></td>
            <td><input type="number" id="sDisc_${rowId}" class="form-control s-disc-amt" name="special_discount[]" value="${data ? data.specialDiscount : 0.00}" readonly></td>
            <td><input type="number" id="sSDisc_${rowId}" class="form-control ss-disc-amt" name="scheme_discount[]" value="${data ? data.schemeDiscount : 0.00}" readonly></td>
            <td><input type="number" id="taxAmt_${rowId}" class="form-control tax-amt" name="taxAmt[]" value="${data ? data.taxAmt : 0.00}" readonly></td>
            <td><input type="number" id="netAmt_${rowId}" class="form-control net-amt" name="netAmt[]" value="${data ? data.netAmt : 0.00}" readonly></td>
            <td>
                <input type="hidden" id="tPAmt_${rowId}" class="tp-amt" name="tpAmt[]" value="${data ? data.tpAmt : 0.00}">
                <input type="hidden" id="excSal_${rowId}" name="exlcudedAmt[]" value="${data ? data.excludedAmt : 0.00}">
                <input type="hidden" id="incSal_${rowId}" name="includedAmt[]" value="${data ? data.includedAmt : 0.00}">
                <button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `;

    $('#mainRowsBody').append(mainRow);
    $('#detailRowsBody').append(detailRow);

    // Initialize select2 on the product select dropdown
    $(`#product_${rowId}`).select2({
        placeholder: "Search for a product...",
        width: '100%',
        theme: 'bootstrap-5',
        dropdownParent: $('#productsTable')
    });

    calculateRowTotal(rowId);
}

// Remove row handler
$('#productsTable').on('click', '.remove-row', function () {
    const rowId = $(this).closest('tr').data('row-id');
    $(`.product-main-row[data-row-id="${rowId}"]`).remove();
    $(`.product-detail-row[data-row-id="${rowId}"]`).remove();
    calculateTotals();
});

// Update rate on product select change
$('#productsTable').on('change', '.product-select', function () {
    const selectedOption = $(this).find('option:selected');
    const price = selectedOption.data('price') || 0;
    const rowId = $(this).closest('tr').data('row-id');
    $(`#rate_${rowId}`).val(price);
    calculateRowTotal(rowId);
});

// Set expiry date on batch select change
$('#productsTable').on('change', '.batch-select', function () {
    const expiryDate = $(this).find('option:selected').data('expiry');
    const rowId = $(this).closest('tr').data('row-id');
    if (expiryDate) {
        $(`#expiry_${rowId}`).val(expiryDate);
    }
});

// Recalculate totals on qty, rate, discount or tax input change
$('#productsTable').on('input', '.qty, .rate, .disc-percent, .tax-percent', function () {
    const rowId = $(this).closest('tr').data('row-id');
    calculateRowTotal(rowId);
});

            function calculateRowTotal(rowId) {
            const qty = parseFloat($(`#qty_${rowId}`).val()) || 0;
            const rate = parseFloat($(`#rate_${rowId}`).val()) || 0;
            const discPercent = parseFloat($(`#discPercent_${rowId}`).val()) || 0;
            let taxPercent = parseFloat($(`#taxPercent_${rowId}`).val()) || 18;
            $(`#taxPercent_${rowId}`).val(taxPercent);

            const amount = qty * rate;
            $(`#amount_${rowId}`).val(amount.toFixed(2));

            const discAmt = amount * (discPercent / 100);
            $(`#discAmt_${rowId}`).val(discAmt.toFixed(2));

            const Tdisc = amount * 0.15;
            $(`#tDisc_${rowId}`).val(Tdisc.toFixed(2));

            const Sdisc = amount * 0.03965;
            $(`#sDisc_${rowId}`).val(Sdisc.toFixed(2));

            const Ssd = amount * 0.09;
            $(`#sSDisc_${rowId}`).val(Ssd.toFixed(2));

            const extraDisc = Tdisc + Sdisc + Ssd;
            const tp = amount - extraDisc;
            $(`#netAmt_${rowId}`).val(tp.toFixed(2));

            const tradePrice = tp/qty;
                            $(`#tPAmt_${rowId}`).val(tradePrice.toFixed(2));

                            const excl = tradePrice * qty;
                            $(`#excSal_${rowId}`).val(excl.toFixed(2));
                            
                            const taxAmt = excl * (taxPercent / 100);
                            $(`#taxAmt_${rowId}`).val(taxAmt.toFixed(2));

                            const incl = excl + taxAmt;
                            $(`#incSal_${rowId}`).val(incl.toFixed(2));

            calculateTotals();
            }

            function calculateTotals() {
            let subTotal = 0, totalDiscount = 0, totalTax = 0, netTotal = 0, excludedSaleAmount = 0, includedSaleAmount = 0;

            $('#productsTable .product-main-row').each(function () {
                const rowId = $(this).data('row-id');
                subTotal += parseFloat($(`#amount_${rowId}`).val()) || 0;
                totalDiscount += parseFloat($(`#discAmt_${rowId}`).val()) || 0;
                totalTax += parseFloat($(`#taxAmt_${rowId}`).val()) || 0;
                netTotal += parseFloat($(`#netAmt_${rowId}`).val()) || 0;
                excludedSaleAmount += parseFloat($(`#excSal_${rowId}`).val()) || 0;
                includedSaleAmount += parseFloat($(`#incSal_${rowId}`).val()) || 0;
            });

            const hasNTN = $('#customerHasNTN').val() === '1';
            const hasSTN = $('#customerHasSTN').val() === '1';

            let furtherSalesTaxRate = 0, advanceTaxRate = 0;

            if (hasNTN && hasSTN) {
                advanceTaxRate = 0.005;
            } else if (hasNTN && !hasSTN) {
                furtherSalesTaxRate = 0.04;
                advanceTaxRate = 0.005;
            } else {
                furtherSalesTaxRate = 0.04;
                advanceTaxRate = 0.025;
            }

            $('#furtherSalesTaxRate').val((furtherSalesTaxRate * 100).toFixed(2));
            $('#advanceTaxRate').val((advanceTaxRate * 100).toFixed(2));  
            
            const furtherSalesTax = excludedSaleAmount * furtherSalesTaxRate;
            const totalIncludedTax = furtherSalesTax + includedSaleAmount;
            const totalAdvanceNet = totalIncludedTax * advanceTaxRate;
            const totalAmount = totalIncludedTax + totalAdvanceNet;

            $('#subTotal').val(subTotal.toFixed(2));
            $('#totalDiscount').val(totalDiscount.toFixed(2));
            $('#salesTax').val(totalTax.toFixed(2));
            $('#totalTax').val(totalTax.toFixed(2));
            $('#furtherSalesTax').val(furtherSalesTax.toFixed(2));
            $('#advanceTax').val(totalAdvanceNet.toFixed(2));
            $('#netTotal').val(totalAmount.toFixed(2));
            $('#total_amount').val(includedSaleAmount.toFixed(2));
            $('#all_included_tax').val(totalIncludedTax.toFixed(2));
            }

            $('#resetFormBtn').click(function () {
            if (confirm('Are you sure you want to clear the form?')) {
                $('#mainRowsBody, #detailRowsBody').empty();
                rowCounter = 1;
                addProductRow();
                $('input[type="text"], input[type="number"], input[type="date"], textarea').val('');
                $('select').prop('selectedIndex', 0);
                $('#subTotal, #totalDiscount, #salesTax, #advanceTax, #totalTax, #netTotal, #furtherSalesTax').val('0.00');
            }
            });
            // Form submission
            $('#salesOrderForm').submit(function (e) {
                e.preventDefault();

                // Validate form
                let isValid = true;
                $('select[required], input[required]').each(function () {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    alert('Please fill all required fields');
                    return;
                }

                // Check if at least one product is added
                if ($('#productsTable tbody tr').length === 0) {
                    alert('Please add at least one product');
                    return;
                }

                // Show confirmation alert
                // alert('Form is valid and ready for submission!');

                // Small delay to allow user to read the alert before submitting
                setTimeout(() => {
                    // Submit the form normally (non-AJAX)
                    e.target.submit();
                }, 300);
            });

        });
    </script>

<script>
    $(document).ready(function () {
        const selectedCustomerId = $('#customerCode').val();
    if (selectedCustomerId) {
        $('#customerCode').trigger('change');
    }
    $('#customerCode').on('change', function () {
        const customerId = $(this).val();

        if (!customerId) return;

        $.ajax({
            url: `{{ route('admin.fetch.customers_data') }}?customer_id=${customerId}`,
            type: 'GET',
            success: function (data) {
                $('#city').val(data.city_name || '');
                $('#email').val(data.email || '');
                $('#ntn').val(data.ntn || '');
                $('#customer_code').val(data.customer_code || '');
                $('#stn').val(data.stn || '');
                $('#customer_name').val(data.name || '');
                $('#spo').val(data.spo_name || '');

                $('#customerHasNTN').val(data.ntn ? 1 : 0);
                $('#customerHasSTN').val(data.stn ? 1 : 0);

            },
            error: function () {
                alert('Failed to fetch customer data.');
            }
        });
    });
});

</script>
@endsection
