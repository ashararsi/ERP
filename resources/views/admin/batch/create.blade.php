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
                                <div class="col-md-6 mb-3">
                                    <label for="batchName" class="form-label">Batch Name</label>
                                    <input type="text" class="form-control" id="batchName" name="batch_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="batchDate" class="form-label">Batch Date</label>
                                    <input type="date" class="form-control" id="batchDate" name="batch_date" required>
                                </div>
                            </div>

                            <h4 class="mt-4">Batch Details</h4>

                            <div id="batchDetailsContainer">
                                <div class="batch-detail row g-3">
                                    <div class="col-md-3">
                                        <select class="form-control">
                                            <option value="">Select Raw Material</option>
                                            @foreach($raw as $rawMaterial)
                                                <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" step="0.01" name="actual_quantity[]" class="form-control"
                                               placeholder="Quantity" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="operator_initials[]" class="form-control"
                                               placeholder="Operator Initials">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="qa_initials[]" class="form-control"
                                               placeholder="QA Initials">

                                        <select name="qa_initials[]" class="form-control">
                                            <option value="">Select Raw Material</option>
                                            @foreach($raw as $rawMaterial)
                                                <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger removeRow">X</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mt-3" id="addRow">Add More</button>
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
