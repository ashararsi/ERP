@extends('admin.layout.main')
@section('content')
    <br/>
    <br/>
    <br/>
    <div class="container-fluid mt-4">
        <h2 class="text-center mb-4 ">Pharmaceutical Sales Order</h2>
        <form id="salesOrderForm" action="{!!   route('admin.pos.store') !!}" method="POST">
            @csrf
            <!-- Customer Information Section -->
            <div class="form-section">
                <h4 class="mb-3">Customer Information</h4>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="sOrdNo" class="form-label required-field">Order Number</label>
                        <input type="text" class="form-control" id="sOrdNo" name="sOrdNo" value="32017" required
                               readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="sOrdDate" class="form-label required-field">Order Date</label>
                        <input type="date" class="form-control" id="sOrdDate" name="sOrdDate"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="customerCode" class="form-label required-field">Customer Code</label>
                        <div class="input-group">
                            <select name="customer_id" class="form-control" id="customerCode" required>
                                <option value="">Select Customer</option>
                                @foreach($data['customers'] as $item)
                                    <option value="{!! $item->id !!}"> {{ $item->customer_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="customer_anme" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="name" value="">
                    </div>
                   
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="customerPO" class="form-label">Customer PO No</label>
                        <input type="text" class="form-control" id="customerPO" name="customerPO" value="">
                    </div>
                    <div class="col-md-4">
                        <label for="customerPODate" class="form-label">Customer PO Date</label>
                        <input type="date" class="form-control" id="customerPODate" name="customerPODate" value="">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label required-field">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="" required>
                    </div>
                </div> 
                <div class="row mt-3"> 
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="ntn" class="form-label">NTN</label>
                        <input type="text" class="form-control" id="ntn" name="ntn" value="">
                    </div>

                    <div class="col-md-4">
                        <label for="ntn" class="form-label">STN</label>
                        <input type="text" class="form-control" id="stn" name="stn" value="">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="spo" class="form-label">SPO</label>
                        <input type="text" class="form-control" id="spo" name="spo" value="" readonly>
                    </div>
                    
                </div>

                <input type="hidden" id="customerHasNTN" value="0">
                <input type="hidden" id="customerHasSTN" value="0">

            </div>
            <br/>
            <!-- Payment and Sales Information -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="paymentTerms" class="form-label required-field">Payment Terms</label>
                        <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                            <option value="" disabled selected>Select Payment Terms</option>
                            <option value="1">Cash on Delivery</option>
                            <option value="2">7 Days Credit</option>
                            <option value="3">15 Days Credit</option>
                            <option value="4">30 Days Credit</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="salesRep" class="form-label required-field">Sales Representative</label>
                        <select class="form-select" id="salesRep" name="salesRep" required>
                            <option value="" disabled selected>Select Sales Rep</option>
                            @foreach($users['operator_initials'] as $item)
                                <option value="{!! $item->id !!}">{!! $item->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="deliveryDate" class="form-label required-field">Expected Delivery Date</label>
                        <input value="{{ date('Y-m-d') }}" type="date" class="form-control" id="deliveryDate"
                               name="deliveryDate" required>
                    </div>
                </div>
            </div>
            <br/>
            <br/>
            <br/>

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
                            <th width="30%">Product Description</th>
                            <th width="8%">Batch</th>
                            <th width="7%">Expiry</th>
                            <th width="4%">Qty</th>
                            <th width="4%">Rate</th>
                            <th width="6%">Amount</th>
                            <th width="7%">Disc %</th>
                            <th width="8%">Disc Amt</th>
                            <th width="7%">Tax %</th>
                            <th width="8%">T.disc</th>
                            <th width="8%">S.disc</th>
                            <th width="8%">SS.disc</th>

                            <th width="8%">Tax Amt</th>
                            <th width="8%">Net Amount</th>
                            <th width="2%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Product rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="total-section">
                <div class="row">
                    <div class="col-md-3">
                        <label for="subTotal" class="form-label">Sub Total</label>
                        <input type="text" class="form-control" id="subTotal" name="subTotal" value="0.00" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="totalDiscount" class="form-label">Total Discount</label>
                        <input type="text" class="form-control" id="totalDiscount" name="totalDiscount" value="0.00"
                               readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="salesTax" class="form-label">Sales Tax</label>
                        <input type="text" class="form-control" id="salesTax" name="salesTax" value="0.00" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="advanceTax" class="form-label">Advance Tax</label>
                        <input type="text" class="form-control" id="advanceTax" name="advanceTax" value="0.00" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Further Sales Tax</label>
                        <input type="number" id="furtherSalesTax" class="form-control" name="furtherSalesTax" value="0.00" readonly>
                    </div>
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="advanceTax" class="form-label">T</label>
                        <input type="text" class="form-control" id="advanceTax" name="advanceTax" value="0.00" readonly>
                    </div>
                </div> --}}
                <div class="row mt-3">
                    
                    <div class="col-md-3 offset-md-6">
                        <label for="totalTax" class="form-label">Total Tax</label>
                        <input type="text" class="form-control" id="totalTax" name="totalTax" value="0.00" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="netTotal" class="form-label fw-bold">Net Total</label>
                        <input type="text" class="form-control fw-bold" id="netTotal" name="netTotal" value="0.00"
                               readonly>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="form-section mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <label for="notes" class="form-label">Special Instructions</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
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
                        <i class="bi bi-check-circle"></i> Save
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
        $(document).ready(function () {
            let rowCounter = 1;

            // Add new product row
            $('#addProductBtn').click(function () {
                addProductRow();
            });

            // Add first row by default
            addProductRow();

            // Function to add a new product row
            function addProductRow() {
                const rowId = rowCounter++;
                const newRow = `
                <tr class="medicine-input" data-row-id="${rowId}">
                    <td>
                        <select class="form-select product-select" id="product_${rowId}" name="product[]" required>
                            <option value="">Select Product</option>
                            @foreach($products as $item)
                <option data-price="{{ $item->price }}" value="{{ $item->id }}">
                                    {{ $item->product_code }} -        {{ $item->name }} - @if($item->packing) {{ $item->packing->display_name }} @endif
               @if($item->packing && $item->packing->units)
    -( unit {{ $item->packing->units->name }} )
@endif

                </option>
@endforeach
                </select>
            </td>
            <td>
                <select class="form-select batch-select" id="batch_${rowId}" name="batch[]" required>
                            <option value="">Select Batch</option>
                            @foreach($Batches as $item)
                <option value="{{ $item->id }}" data-expiry="{{ $item->expiry_date }}">
                                     {{ $item->batch_code }}
                </option>
@endforeach
                </select>
            </td>
            <td><input type="date" id="expiry_${rowId}" class="form-control expiry" name="expiry[]" required></td>
                    <td><input type="number" id="qty_${rowId}" class="form-control qty" name="qty[]" min="1" value="1" required></td>
                    <td><input type="number" id="rate_${rowId}" class="form-control rate" name="rate[]" step="0.01" min="0" required></td>
                    <td><input type="number" id="amount_${rowId}" class="form-control amount" name="amount[]" value="0.00" readonly></td>
                    <td><input type="number" id="discPercent_${rowId}" class="form-control disc-percent" name="discPercent[]" min="0" max="100" step="0.01" value="0"></td>
                    <td><input type="number" id="discAmt_${rowId}" class="form-control disc-amt" name="discAmt[]" value="0.00" readonly></td>
                    <td><input type="number" id="taxPercent_${rowId}" class="form-control tax-percent" name="taxPercent[]" min="0" step="0.01" value="0" required></td>
                    <td><input type="number" id="tDisc_${rowId}" class="form-control t-disc-amt" name="trade_discount[]"min="0" step="0.01" value="0"readonly ></td>
                    <td><input type="number" id="sDisc_${rowId}" class="form-control s-disc-amt" name="special_discount[]"min="0" step="0.01" value="0" readonly ></td>
                    <td><input type="number" id="sSDisc_${rowId}" class="form-control ss-disc-amt" name="scheme_discount[]"min="0" step="0.01" value="0" readonly></td>
                    <td><input type="number" id="taxAmt_${rowId}" class="form-control tax-amt" name="taxAmt[]" value="0.00" readonly></td>
                    <td><input type="number" id="netAmt_${rowId}" class="form-control net-amt" name="netAmt[]" value="0.00" readonly></td>
                    <td><input type="hidden" id="tPAmt_${rowId}" class="tp-amt" name="tpAmt[]" value="0.00"></td>
                    <td><input type="hidden" id="incSal_${rowId}" class="tp-amt" name="includedAmt[]" value="0.00"></td>

                    <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>
                </tr>`;

                $('#productsTable tbody').append(newRow);
                $('#productsTable tbody tr:last .product-select').select2({
                    placeholder: "Search for a product...",
                    width: '100%',
                    theme: 'bootstrap-5',
                    dropdownParent: $('#productsTable')
                });
            }

            // Remove row on trash button click
            $('#productsTable').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // Product selection change - populate rate
            $('#productsTable').on('change', '.product-select', function () {
                const selectedOption = $(this).find('option:selected');
                const price = selectedOption.data('price') || 0;
                const rowId = $(this).closest('tr').data('row-id');
                $(`#rate_${rowId}`).val(price);
                calculateRowTotal(rowId);
            });

            // Batch selection change - populate expiry date
            $('#productsTable').on('change', '.batch-select', function () {
                const selectedOption = $(this).find('option:selected');
                const expiryDate = selectedOption.data('expiry');
                const rowId = $(this).closest('tr').data('row-id');
                if (expiryDate) {
                    $(`#expiry_${rowId}`).val(expiryDate);
                }
            });

            // Calculate row total when quantity, rate, discount or tax changes
            $('#productsTable').on('input', '.qty, .rate, .disc-percent, .tax-percent .t-disc-amt', function () {
                const rowId = $(this).closest('tr').data('row-id');
                calculateRowTotal(rowId);
            });

            // Function to calculate row totals
            function calculateRowTotal(rowId) {
                const qty = parseFloat($(`#qty_${rowId}`).val()) || 0;
                const rate = parseFloat($(`#rate_${rowId}`).val()) || 0;
                const discPercent = parseFloat($(`#discPercent_${rowId}`).val()) || 0;
                // const taxPercent = parseFloat($(`#taxPercent_${rowId}`).val()) || 0;
                let taxPercent = parseFloat($(`#taxPercent_${rowId}`).val());
                if (isNaN(taxPercent) || taxPercent === 0) {
                     taxPercent = 18;
                    $(`#taxPercent_${rowId}`).val(18);
                }
                // Calculate amount
                const amount = qty * rate;
                $(`#amount_${rowId}`).val(amount);

                // Calculate discount amount
                const discAmt = amount * (discPercent / 100);
                $(`#discAmt_${rowId}`).val(discAmt);

                // Calculate taxable amount (after discount)
                const taxableAmt = amount - discAmt;

                // Calculate tax amount
                const taxAmt = taxableAmt * (taxPercent / 100);
                $(`#taxAmt_${rowId}`).val(taxAmt);

                // Calculate net amount
                const netAmt = taxableAmt + taxAmt;
                $(`#netAmt_${rowId}`).val(netAmt);

                const Tdisc = amount * 0.15;
                $(`#tDisc_${rowId}`).val(Tdisc.toFixed(2));

                const Sdisc = amount * 0.03965;
                $(`#sDisc_${rowId}`).val(Sdisc.toFixed(2));

                // Calculate S.sd (9% of amount)
                const Ssd = amount * 0.09;
                $(`#sSDisc_${rowId}`).val(Ssd.toFixed(2));

                const extraDisc = Tdisc + Sdisc + Ssd;
                console.log("net amb",netAmt);
                console.log("extra amb",extraDisc);

                const tp = amount - extraDisc;
                
                $(`#netAmt_${rowId}`).val(tp.toFixed(2));
                console.log(tp,"tp");
                console.log(qty,"qty");
                const tradePrice = tp/qty;
                console.log(tradePrice,"tradeProce");
                $(`#tPAmt_${rowId}`).val(tradePrice.toFixed(2));

                const excl =  tradePrice * qty;

                const incl = excl + taxAmt;
                $(`#incSal_${rowId}`).val(incl.toFixed(2));

                

                // Update totals
                calculateTotals();
            }

            // Function to calculate all totals
            function calculateTotals() {
                let subTotal = 0;
                let totalDiscount = 0;
                let totalTax = 0;
                let netTotal = 0;
                // Calculate row by row
                $('#productsTable tbody tr').each(function () {
                    const rowId = $(this).data('row-id');
                    subTotal += parseFloat($(`#amount_${rowId}`).val()) || 0;
                    totalDiscount += parseFloat($(`#discAmt_${rowId}`).val()) || 0;
                    totalTax += parseFloat($(`#taxAmt_${rowId}`).val()) || 0;
                    netTotal += parseFloat($(`#netAmt_${rowId}`).val()) || 0;
                });

                const hasNTN = $('#customerHasNTN').val() === '1';
                 const hasSTN = $('#customerHasSTN').val() === '1';

                let furtherSalesTaxRate = 0;
                let advanceTaxRate = 0;

                if (hasNTN && hasSTN) {
                    furtherSalesTaxRate = 0;
                    advanceTaxRate = 0.005;
                } else if (hasNTN && !hasSTN) {
                    furtherSalesTaxRate = 0.04;
                    advanceTaxRate = 0.005;
                } else if (!hasNTN && !hasSTN) {
                    furtherSalesTaxRate = 0.04;
                    advanceTaxRate = 0.025;
                }

                const furtherSalesTax = subTotal * furtherSalesTaxRate;
                const advanceTax = subTotal * advanceTaxRate;

                const finalNetTotal = netTotal + furtherSalesTax + advanceTax;

                
                // Update summary fields
                $('#subTotal').val(subTotal);
                $('#totalDiscount').val(totalDiscount);
                $('#totalTax').val(totalTax);
                $('#salesTax').val(totalTax);
                $('#furtherSalesTax').val(furtherSalesTax.toFixed(2));
                $('#advanceTax').val(advanceTax.toFixed(2));
                $('#netTotal').val(finalNetTotal.toFixed(2));
            }

            // Reset form button
            $('#resetFormBtn').click(function () {
                if (confirm('Are you sure you want to clear the form?')) {
                    $('#productsTable tbody').empty();
                    rowCounter = 1;
                    addProductRow();
                    $('input[type="text"], input[type="number"], input[type="date"], textarea').val('');
                    $('select').prop('selectedIndex', 0);
                    $('#subTotal, #totalDiscount, #salesTax, #advanceTax, #totalTax, #netTotal,#furtherSalesTax').val('0.00');
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
