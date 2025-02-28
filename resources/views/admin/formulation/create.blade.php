@extends('admin.layout.main')
@section('title')
    Formulation create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Formulation </h3>
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
                        <form method="post" action="{!! route('admin.formulations.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="batchName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="batchName" name="batch_name" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    {{--                                    <input type="date" class="form-control" id="batchDate" name="batch_date" required>--}}
                                    <textarea class="form-control" name="description" id="description" cols="30"
                                              rows="10"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3"><h4 class="mt-4"> Material Details</h4></div>
                                <div class="col-md-6 mb-3"><h4 class="mt-4"> Process Details</h4></div>
                            </div>

                            <div class="row">
                                <div id="formulaDetailsContainer" class="formula-detail col-md-6 ">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" name="raw_material_id[]" required>
                                                <option value="">Select Raw Material</option>
                                                @foreach($raw as $rawMaterial)
                                                    <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" name="raw_material_id[]" required>
                                                <option value="">Unit</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" step="0.01" name="standard_quantity[]"
                                                   class="form-control"
                                                   placeholder="Standard Quantity" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger removeRow">X</button>
                                        </div>
                                    </div>

                                </div>


                            <div class="process-detail  col-md-6 " id="processDetailsContainer">

                                <div class="row">
                                    <div class="col-md-5">
                                        <select class="form-control" name="process[]" required>
                                            <option value="">Select  Process</option>
                                            @foreach($process as $p)
                                                <option value="{{$p->id}}">{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text"   name="remarks[]"
                                               class="form-control"
                                               placeholder="Remarks" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger removeRow">X</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary mt-3" id="addRow">Add More</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary mt-3" id="addprocessRow">Add More</button>
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
            // Add new row
            $("#addRow").click(function () {
                var newRow = `

                <div class=" row mt-3">
                                    <div class="col-md-5">
                                        <select class="form-control" name="raw_material_id[]" required>
                                            <option value="">Select Raw Material</option>
                                            @foreach($raw as $rawMaterial)
                <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                                            @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="number" step="0.01" name="standard_quantity[]" class="form-control"
                       placeholder="Standard Quantity" required>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger removeRow">X</button>
            </div>

        </div>
        `;
                $("#formulaDetailsContainer").append(newRow);
            });
            $("#addprocessRow").click(function () {
                var newRow = `

                <div class=" row mt-3">
                                    <div class="col-md-5">
                                        <select class="form-control" name="process[]" required>
                                            <option value="">Select  Process</option>
                                            @foreach($process as $p)
                <option value="{{$p->id}}">{{$p->name}}</option>
                                            @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="text"  name="remarks[]" class="form-control"
                       placeholder="remarks" required>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger removeRow">X</button>
            </div>

        </div>
        `;
                $("#processDetailsContainer").append(newRow);
            });

            // Remove row
            $(document).on("click", ".removeRow", function () {
                $(this).closest(".formula-detail").remove();
            });

            // Submit form
            // $("#batchForm").submit(function (e) {
            //     e.preventDefault();
            //     alert("Form submitted successfully!");
            // });
        });
    </script>
@endsection
