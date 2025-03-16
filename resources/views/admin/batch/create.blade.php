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
                                    <label for="batchName" class="form-label">Formulation</label>
                                    <select class="form-control" id="formulation_id" name="formulation_id" required>
                                        <option value="">Select Formulation</option>
                                        @foreach($formulation as $formulations)
                                            <option value="{{$formulations->id}}">{{$formulations->formula_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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

                if (formulation_id) {
                    $.ajax({
                        url: '{!! route('admin.FormulationController.fetch_po_record') !!}',
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: formulation_id
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
@endsection
