@extends('admin.layout.main')
@section('title')
    Product create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create   Product </h3>
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
                        <form method="post" action="{!! route('admin.products.store') !!}"
                              enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <!-- Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" required class="form-control" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="product_code">Product Code</label>
                                        <input type="text" id="product_code" required class="form-control" name="product_code" value="{{ old('product_code') }}">
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <select required name="unit" class="form-control">
                                            <option value="">Select Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" required class="form-control" name="quantity" value="{{ old('quantity') }}">
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" required class="form-control" name="price" value="{{ old('price') }}">
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">Product Image</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="unit">Packing</label>
                                        <select required name="packing_id" class="form-control">
                                            <option value="">Select packing</option>
                                            @foreach($packing as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>



                            <div class="row mt-4">

                                <div class="col-md-3 ">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <a href="{!! route('admin.products.index') !!}"
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
