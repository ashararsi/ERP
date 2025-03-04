@extends('admin.layout.main')
@section('title')
    Company create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Company </h3>
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
                        <form method="post" action="{!! route('admin.companies.store') !!}"
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ntn" class="form-label">NTN</label>
                                    <input type="text" class="form-control" id="ntn" name="ntn">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gst" class="form-label">GST</label>
                                    <input type="text" class="form-control" id="gst" name="gst">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gst_type" class="form-label">GST Type</label>
                                    <select class="form-control" id="gst_type" name="gst_type">
                                        <option value="">Select GST Type</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="vat" class="form-label">VAT</label>
                                    <input type="text" class="form-control" id="vat" name="vat">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" class="form-control" id="fax" name="fax">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Company</button>
                                    <a href="{!! route('admin.units.index') !!}"
                                       class=" btn btn-sm btn-danger">Cancel </a>
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
            // Add new row
            $("#addRow").click(function () {
                var newRow = `<div class="batch-detail row g-3 mt-2">
                <div class="col-md-3">
                    <input type="text" name="raw_material[]" class="form-control" placeholder="Raw Material" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="actual_quantity[]" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="operator_initials[]" class="form-control" placeholder="Operator Initials">
                </div>
                <div class="col-md-2">
                    <input type="text" name="qa_initials[]" class="form-control" placeholder="QA Initials">
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button type="button" class="btn btn-danger removeRow">X</button>
                </div>
            </div>`;
                $("#batchDetailsContainer").append(newRow);
            });

            // Remove row
            $(document).on("click", ".removeRow", function () {
                $(this).closest(".batch-detail").remove();
            });

            // Submit form
            $("#batchForm").submit(function (e) {
                e.preventDefault();
                alert("Form submitted successfully!");
            });
        });
    </script>
@endsection
