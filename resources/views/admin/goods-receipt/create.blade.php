@extends('admin.layout.main')
@section('title')
    Goods Issuance create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Goods Receipt </h3>
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
                        <form action="{{ route('admin.goods-receipt.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Good Issuance</label>
                                        <select name="batch_id" class="form-control" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->batch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="batch_id" class="form-label">Batch</label>
                                        <select name="batch_id" class="form-control" required>
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->batch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="received_quantity" class="form-label">Received Quantity</label>
                                        <input type="number" name="received_quantity" class="form-control" step="0.01"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="wastage_quantity" class="form-label">Wastage Quantity</label>
                                        <input type="number" name="wastage_quantity" class="form-control" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="received_by" class="form-label">Received By</label>
                                        <input type="text" name="received_by" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="received_date" class="form-label">Received Date</label>
                                        <input type="date" name="received_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="qa_status" class="form-label">QA Status</label>
                                        <select name="qa_status" class="form-control" required>
                                            <option value="pending">Pending</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="pass">Pass</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea name="remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>


                            {{--                                <div class="mb-3">--}}
                            {{--                                    <label for="raw_material_id" class="form-label">Raw Material</label>--}}
                            {{--                                    <select name="raw_material_id" class="form-control" required>--}}
                            {{--                                        <option value="">Select Raw Material</option>--}}
                            {{--                                        @foreach($rawMaterials as $rawMaterial)--}}
                            {{--                                            <option value="{{ $rawMaterial->id }}">{{ $rawMaterial->name }}</option>--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}


                            <button type="submit" class="btn btn-primary">Submit</button>
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
            $('#total_qty').change(function () {
                $('#batchDetailsContainer').html('');
                var formulation_id = $('#formulation_id').val();
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
        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            let batchDateInput = document.getElementById("batchDate");

            batchDateInput.value = today; // Set default value to today
            batchDateInput.setAttribute("min", today); // Restrict selection to today and future dates
        });


        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

            let mfgDateInput = document.getElementById("mfg_date");
            let expDateInput = document.getElementById("expiry_date");

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
            mfgDateInput.addEventListener("change", function () {
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



