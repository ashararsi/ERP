@extends('admin.layout.main')
@section('content')
    <br/>
    <br/>
    <br/>
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-primary">Pharmaceutical Sales Order</h2>

        <form id="salesOrderForm">
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
                        <input type="date" class="form-control" id="sOrdDate" name="sOrdDate" value="2025-03-24"
                               required>
                    </div>
                    <div class="col-md-3">
                        <label for="customerCode" class="form-label required-field">Customer Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="customerCode" name="customerCode" value="107307"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#customerModal">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="customerName" class="form-label required-field">Customer Name</label>
                        <input type="text" class="form-control" id="customerName" name="customerName"
                               value="HAKEEM BASHEER DAWAKHANA" required>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="customerPO" class="form-label">Customer PO No</label>
                        <input type="text" class="form-control" id="customerPO" name="customerPO" value="24-52573">
                    </div>
                    <div class="col-md-4">
                        <label for="customerPODate" class="form-label">Customer PO Date</label>
                        <input type="date" class="form-control" id="customerPODate" name="customerPODate"
                               value="2025-03-24">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label required-field">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="Kasur" required>
                    </div>
                </div>
            </div>

            <!-- Payment and Sales Information -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="paymentTerms" class="form-label required-field">Payment Terms</label>
                        <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                            <option value="" disabled>Select Payment Terms</option>
                            <option value="1" selected>Cash on Delivery</option>
                            <option value="2">7 Days Credit</option>
                            <option value="3">15 Days Credit</option>
                            <option value="4">30 Days Credit</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="salesRep" class="form-label required-field">Sales Representative</label>
                        <select class="form-select" id="salesRep" name="salesRep" required>
                            <option value="" disabled>Select Sales Rep</option>
                            <option value="Pervez Akhtar (0300-4380358)" selected>Pervez Akhtar (0300-4380358)</option>
                            <option value="Other Rep">Other Representative</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="deliveryDate" class="form-label required-field">Expected Delivery Date</label>
                        <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" required>
                    </div>
                </div>
            </div>

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
                            <th width="7%">Qty</th>
                            <th width="8%">Rate</th>
                            <th width="8%">Amount</th>
                            <th width="7%">Disc %</th>
                            <th width="8%">Disc Amt</th>
                            <th width="7%">Tax %</th>
                            <th width="8%">Tax Amt</th>
                            <th width="8%">Net Amount</th>
                            <th width="2%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="medicine-input">
                            <td>
                                <select class="form-select product-select" name="product[]" required>
                                    <option value="LASANI MARHAM 15gm" selected>LASANI MARHAM 15gm</option>
                                    <option value="KESODYL 120ml">KESODYL 120ml</option>
                                    <!-- More products would be loaded dynamically -->
                                </select>
                            </td>
                            <td><input type="text" class="form-control batch" name="batch[]" value="B12345" required>
                            </td>
                            <td><input type="date" class="form-control expiry" name="expiry[]" value="2026-12-31"
                                       required></td>
                            <td><input type="number" class="form-control qty" name="qty[]" value="15" min="1" required>
                            </td>
                            <td><input type="number" class="form-control rate" name="rate[]" value="150.00" step="0.01"
                                       min="0" required></td>
                            <td><input type="number" class="form-control amount" name="amount[]" value="2250.00"
                                       readonly></td>
                            <td><input type="number" class="form-control disc-percent" name="discPercent[]" value="20"
                                       min="0" max="100" step="0.01"></td>
                            <td><input type="number" class="form-control disc-amt" name="discAmt[]" value="450.00"
                                       readonly></td>
                            <td><input type="number" class="form-control tax-percent" name="taxPercent[]" value="18"
                                       min="0" step="0.01" required></td>
                            <td><input type="number" class="form-control tax-amt" name="taxAmt[]" value="282.65"
                                       readonly></td>
                            <td><input type="number" class="form-control net-amt" name="netAmt[]" value="1853.01"
                                       readonly></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-row"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="medicine-input">
                            <td>
                                <select class="form-select product-select" name="product[]" required>
                                    <option value="LASANI MARHAM 15gm">LASANI MARHAM 15gm</option>
                                    <option value="KESODYL 120ml" selected>KESODYL 120ml</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control batch" name="batch[]" value="B54321" required>
                            </td>
                            <td><input type="date" class="form-control expiry" name="expiry[]" value="2027-06-30"
                                       required></td>
                            <td><input type="number" class="form-control qty" name="qty[]" value="10" min="1" required>
                            </td>
                            <td><input type="number" class="form-control rate" name="rate[]" value="180.00" step="0.01"
                                       min="0" required></td>
                            <td><input type="number" class="form-control amount" name="amount[]" value="1800.00"
                                       readonly></td>
                            <td><input type="number" class="form-control disc-percent" name="discPercent[]" value="20"
                                       min="0" max="100" step="0.01"></td>
                            <td><input type="number" class="form-control disc-amt" name="discAmt[]" value="360.00"
                                       readonly></td>
                            <td><input type="number" class="form-control tax-percent" name="taxPercent[]" value="18"
                                       min="0" step="0.01" required></td>
                            <td><input type="number" class="form-control tax-amt" name="taxAmt[]" value="219.67"
                                       readonly></td>
                            <td><input type="number" class="form-control net-amt" name="netAmt[]" value="1440.07"
                                       readonly></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-row"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="total-section">
                <div class="row">
                    <div class="col-md-3">
                        <label for="subTotal" class="form-label">Sub Total</label>
                        <input type="text" class="form-control" id="subTotal" name="subTotal" value="4050.00" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="totalDiscount" class="form-label">Total Discount</label>
                        <input type="text" class="form-control" id="totalDiscount" name="totalDiscount" value="810.00"
                               readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="salesTax" class="form-label">Sales Tax</label>
                        <input type="text" class="form-control" id="salesTax" name="salesTax" value="0.00" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="advanceTax" class="form-label">Advance Tax</label>
                        <input type="text" class="form-control" id="advanceTax" name="advanceTax" value="2.50" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3 offset-md-6">
                        <label for="totalTax" class="form-label">Total Tax</label>
                        <input type="text" class="form-control" id="totalTax" name="totalTax" value="502.32" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="netTotal" class="form-label fw-bold">Net Total</label>
                        <input type="text" class="form-control fw-bold" id="netTotal" name="netTotal" value="17063.96"
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
                    <button type="button" class="btn btn-danger me-2">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                    <button type="button" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Modify
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

    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Search Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by name, code, or city">
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>107307</td>
                                <td>HAKEEM BASHEER DAWAKHANA</td>
                                <td>Kasur</td>
                                <td>0300-1234567</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary select-customer">Select</button>
                                </td>
                            </tr>
                            <!-- More customer rows would be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
    <script>
        // This would contain JavaScript for dynamic calculations, adding/removing rows, etc.
        document.addEventListener('DOMContentLoaded', function () {

        });
    </script>
@endsection
