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
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Formulation</h3>
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

                            <!-- Basic Information Section -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="formula_unit_id" class="form-label">Unit</label>
                                    <select class="form-control" name="formula_unit_id" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="for_value" class="form-label">For Value</label>
                                    <input type="text" readonly name="for_value" class="form-control" value="1">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="formula_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="formula_name" name="formula_name"
                                           required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30"
                                              rows="5"></textarea>
                                </div>
                            </div>

                            <!-- Material Details Section -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h4 class="mt-4">Material Details</h4>
                                </div>
                            </div>

                            <div id="formulaDetailsContainer">
                                <div class="row formula-detail mb-3 border p-3">
                                    <div class="col-md-2">
                                        <label>Raw Material</label>
                                        <select class="form-control" name="materials[0][raw_material_id]" required>
                                            <option value="">Select Raw Material</option>
                                            @foreach($raw as $rawMaterial)
                                                <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Unit</label>
                                        <select class="form-control" name="materials[0][unit]" required>
                                            <option value="">Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Standard Qty</label>
                                        <input type="number" step="0.01" name="materials[0][standard_quantity]"
                                               class="form-control" placeholder="Quantity" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Process</label>
                                        <select class="form-control" name="materials[0][process]" required>
                                            <option value="">Select Process</option>
                                            @foreach($process as $p)
                                                <option value="{{$p->id}}">{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Remarks</label>
                                        <input type="text" name="materials[0][remarks]" class="form-control"
                                               placeholder="Remarks" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary mt-3" id="addRow">Add More Material
                                    </button>
                                </div>
                            </div>

                            <!-- Process Details Section -->
                            <div class="row mt-4">
                                <div class="col-md-12 mb-3">
                                    <h4 class="mt-4">Process Details</h4>
                                </div>
                            </div>

                            <div id="process_detail">
                                <!-- Initial process row will be added here by JavaScript -->
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary mt-3" id="addRow_p">Add More Process
                                    </button>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{!! route('admin.formulations.index') !!}" class="btn btn-danger ml-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet"/>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        $(document).ready(function () {
            let materialCounter = 0;
            let processCounter = 0;

            // Initialize Tagify
            function initTagify() {
                $(".check_points").each(function () {
                    if ($(this).data("tagify")) {
                        $(this).data("tagify").destroy();
                    }
                    let tagify = new Tagify(this);
                    $(this).data("tagify", tagify);
                });
            }

            // Add Material Row
            $("#addRow").click(function () {
                materialCounter++;
                const newRow = `
                <div class="row formula-detail mb-3 border p-3">
                    <div class="col-md-2">
                        <label>Raw Material</label>
                        <select class="form-control" name="materials[${materialCounter}][raw_material_id]" required>
                            <option value="">Select Raw Material</option>
                            @foreach($raw as $rawMaterial)
                <option value="{{$rawMaterial->id}}">{{$rawMaterial->name}}</option>
                            @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Unit</label>
                <select class="form-control" name="materials[${materialCounter}][unit]" required>
                            <option value="">Unit</option>
                            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Standard Qty</label>
                <input type="number" step="0.01" name="materials[${materialCounter}][standard_quantity]"
                               class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <label>Process</label>
                        <select class="form-control" name="materials[${materialCounter}][process]" required>
                            <option value="">Select Process</option>
                            @foreach($process as $p)
                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Remarks</label>
                <input type="text" name="materials[${materialCounter}][remarks]" class="form-control" placeholder="Remarks" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                    </div>
                </div>`;
                $("#formulaDetailsContainer").append(newRow);
            });

            // Add Process Row
            $("#addRow_p").click(function () {
                processCounter++;
                const newRow = `
                <div class="row process_detail border p-3 mb-3" data-process-id="${processCounter}">
                    <div class="col-md-2">
                        <label>Process</label>
                        <select class="form-control" name="processes[${processCounter}][process_id]" required>
                            <option value="">Select Process</option>
                            @foreach($process as $p)
                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Process Order</label>
                <input type="number" class="form-control" name="processes[${processCounter}][order]">
                    </div>
                    <div class="col-md-2">
                        <label>Remarks</label>
                        <input type="text" name="processes[${processCounter}][remarks]" class="form-control" placeholder="Remarks" required>
                    </div>
                    <div class="col-md-2">
                        <label>Duration (mins)</label>
                        <input type="number" name="processes[${processCounter}][time]" class="form-control" placeholder="Duration" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger removeProcessRow">Remove</button>
                    </div>

                    <!-- Check Points Table -->
                    <div class="col-md-12 border p-3 mt-3">
                        <label>Check Points</label>
                        <table class="table table-bordered checkpoint_table mt-2">
                            <thead>
                                <tr>
                                    <th>Check Point</th>
                                    <th>Unit</th>
                                    <th>Standard</th>
                                    <th>Actual</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="checkpoint_body">
                                <tr>
                                    <td><input type="text" name="processes[${processCounter}][checkpoints][0][name]" class="form-control" required></td>
                                    <td>
                                        <select class="form-control" name="processes[${processCounter}][checkpoints][0][unit]" required>
                                            <option value="">Unit</option>
                                            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                </select>
            </td>
            <td><input type="number" name="processes[${processCounter}][checkpoints][0][standard]" class="form-control" required></td>
                                    <td><input type="number" name="processes[${processCounter}][checkpoints][0][actual]" class="form-control" required></td>
                                    <td><button type="button" class="btn btn-danger removeCheckpoint">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-success addCheckpoint" data-process-id="${processCounter}">+ Add Checkpoint</button>
                    </div>
                </div>`;
                $("#process_detail").append(newRow);
            });

            // Add initial process row
            $("#addRow_p").trigger("click");

            // Add Checkpoint
            $(document).on("click", ".addCheckpoint", function () {
                const processId = $(this).data("process-id");
                const checkpointCount = $(this).closest(".process_detail").find(".checkpoint_body tr").length;

                const checkpointRow = `
                <tr>
                    <td><input type="text" name="processes[${processId}][checkpoints][${checkpointCount}][name]" class="form-control" required></td>
                    <td>
                        <select class="form-control" name="processes[${processId}][checkpoints][${checkpointCount}][unit]" required>
                            <option value="">Unit</option>
                            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                </select>
            </td>
            <td><input type="number" name="processes[${processId}][checkpoints][${checkpointCount}][standard]" class="form-control" required></td>
                    <td><input type="number" name="processes[${processId}][checkpoints][${checkpointCount}][actual]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger removeCheckpoint">X</button></td>
                </tr>`;

                $(this).closest(".process_detail").find(".checkpoint_body").append(checkpointRow);
            });

            // Remove Checkpoint
            $(document).on("click", ".removeCheckpoint", function () {
                $(this).closest("tr").remove();
            });

            // Remove Material Row
            $(document).on("click", ".removeRow", function () {
                $(this).closest(".formula-detail").remove();
            });

            // Remove Process Row
            $(document).on("click", ".removeProcessRow", function () {
                $(this).closest(".process_detail").remove();
            });
        });
    </script>
@stop
