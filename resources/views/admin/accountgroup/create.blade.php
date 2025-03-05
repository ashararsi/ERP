@extends('admin.layout.main')
@section('title')
    Account Group create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Account Group </h3>
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
                        <form method="post" action="{!! route('admin.account_groups.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <!-- Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="number" class="form-label">Parrent</label>
                                    <select id="parent_id" class="form-control groups select2" name="parent_id" required>
                                        <option>Select Parent Groups</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group['id']}}">({{$group['number']}}
                                                )-{{$group['name']}}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="row mt-4">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save</button>
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
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

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


        });
    </script>
    <script>

        $(document).ready(function () {
            $('#company_id').change(function () {
                var companyId = $(this).val();
                $('#branch_id').html('<option value="">Loading...</option>');

                if (companyId) {
                    $.ajax({
                        url: '/get-branches/' + companyId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            $('#branch_id').html('<option value="">Select Branch</option>');
                            $.each(response, function (index, branch) {
                                $('#branch_id').append('<option value="' + branch.id + '">' + branch.name + '</option>');
                            });
                        },
                        error: function () {
                            $('#branch_id').html('<option value="">Error loading branches</option>');
                        }
                    });
                } else {
                    $('#branch_id').html('<option value="">Select Branch</option>');
                }
            });
        });


        $(document).ready(function() {
            $('#parent_id').select2({
                placeholder: "Select Parent Groups",
                allowClear: true
            });
        });
    </script>
@endsection
