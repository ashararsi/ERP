@extends('admin.layout.main')
@section('title')
    Branch create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Branch </h3>
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
                        <form method="post" action="{!! route('admin.branches.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_id" class="form-label">Company ID</label>
                                    <select id="company_id" class="form-control" name="company_id">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branch_code" class="form-label">Branch Code</label>
                                    <input type="text" class="form-control" id="branch_code" name="branch_code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cell" class="form-label">Cell</label>
                                    <input type="text" class="form-control" id="cell" name="cell">
                                </div>
{{--                                <div class="col-md-6 mb-3">--}}
{{--                                    <label for="city_id" class="form-label">City</label>--}}
{{--                                    <select class="form-control" id="city_id" name="city_id">--}}
{{--                                        <option value="">Select City</option>--}}
{{--                                        --}}{{-- Add dynamic city options here --}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <div class="col-md-6 mb-3">
                                    <label for="country_id" class="form-label">Country</label>
                                    <select class="form-control" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        <option value="1">Pakistan</option>
                                        {{-- Add dynamic country options here --}}
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
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
                                    <button type="submit" class="btn btn-primary">Save  Branch</button>
                                    <a href="{!! route('admin.branches.index') !!}"
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
