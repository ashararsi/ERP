@extends('admin.layout.main')
@section('title')
    Batch create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Batch </h3>
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
                        <form method="post" action="{!! route('admin.batches.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="total_qty" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" value="1" id="total_qty" name="total_qty" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="batchName" class="form-label">Formulation</label>
                                    <select class="form-control" id="formulation_id" name="formulation_id" required>
                                        <option value="">Select Formulation</option>
                                        @foreach($formulation as $formulations)
                                            <option value="{{$formulations->id}}">{{$formulations->formula_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-md-4 mb-3">
                                    <label for="status" class="form-label">Batch Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option selected value="in_process">In Process</option>
                                        <option value="packaging">Packaging</option>
                                        <option value="completed">Completed</option>
                                        <option value="dispatched_for_warehouse">Dispatched for Warehouse</option>
                                    </select>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="batchName" class="form-label">Batch Name</label>
                                    <input type="text" class="form-control" id="batchName" name="batch_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="batchDate" class="form-label">Batch Date</label>
                                    <input type="date" class="form-control" id="batchDate" name="batch_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="batchName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="batchName" name="product_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="batchName" class="form-label">Batch NO (auto)</label>
                                    <input readonly type="text" class="form-control" id="batchName" name="batch_no" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="mfg_date" class="form-label">Mfg Date</label>
                                    <input type="date" class="form-control" id="mfg_date" name="mfg_date" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exp_date" class="form-label">Exp Date</label>
                                    <input type="date" class="form-control" id="exp_date" name="exp_date" required>
                                </div>

                            </div>
                            <h4 class="mt-4">Batch Details</h4>
                            <div id="batchDetailsContainer">
                                <div class="batch-detail row g-3">

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

        $(document).ready(function () {
            $('#formulation_id').change(function () {
                $('#batchDetailsContainer').html('');
                var formulation_id = $(this).val();
                var total_qty = $('#total_qty').val();

                if (formulation_id) {
                    $.ajax({
                        url: '{!! route('admin.FormulationController.fetch_po_record') !!}',
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: formulation_id,
                            total_qty: total_qty
                        },
                        success: function (response) {
                            $('#batchDetailsContainer').html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            let batchDateInput = document.getElementById("batchDate");

            batchDateInput.value = today; // Set default value to today
            batchDateInput.setAttribute("min", today); // Restrict selection to today and future dates
        });


        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

            let mfgDateInput = document.getElementById("mfg_date");
            let expDateInput = document.getElementById("exp_date");

            // Set Mfg Date default to today and restrict past selection
            mfgDateInput.value = today;
            mfgDateInput.setAttribute("min", today);

            // Set Exp Date default to today + 2 years
            let twoYearsLater = new Date();
            twoYearsLater.setFullYear(twoYearsLater.getFullYear() + 2);
            let twoYearsLaterFormatted = twoYearsLater.toISOString().split('T')[0];

            expDateInput.value = twoYearsLaterFormatted;
            expDateInput.setAttribute("min", today); // Exp Date cannot be before today

            // Update Exp Date when Mfg Date changes
            mfgDateInput.addEventListener("change", function() {
                let selectedMfgDate = new Date(mfgDateInput.value);
                let minExpDate = new Date(selectedMfgDate);
                minExpDate.setFullYear(minExpDate.getFullYear() + 2); // Exp Date should be at least Mfg Date + 2 years

                let minExpFormatted = minExpDate.toISOString().split('T')[0];
                expDateInput.setAttribute("min", minExpFormatted);

                // Auto-update Exp Date if it's before the new min
                if (expDateInput.value < minExpFormatted) {
                    expDateInput.value = minExpFormatted;
                }
            });
        });
    </script>
@endsection
