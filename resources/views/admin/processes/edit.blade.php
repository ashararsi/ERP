@extends('admin.layout.main')
@section('title')
    Role Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.processes.update',$processes->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" value="{!! $processes->name !!}" class="form-control" id="name" name="name" required>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{!! $processes->description !!}</textarea>
                                </div>

                                <!-- Sequence Order -->
                                <div class="col-md-12 mb-3">
                                    <label for="sequence_order" class="form-label">Sequence Order</label>
                                    <input type="number" class="form-control"value="{!! $processes->sequence_order !!}" id="sequence_order" name="sequence_order" value="0">
                                </div>

                                <!-- Image -->
                                <div class="col-md-12 mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                                <!-- Duration (Minutes) -->
                                <div class="col-md-12 mb-3">
                                    <label for="duration_minutes" class="form-label">Duration (Minutes)</label>
                                    <input type="number" class="form-control" value="{!! $processes->duration_minutes !!}" id="duration_minutes" name="duration_minutes">
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-12 mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3">{!! $processes->remarks !!}"</textarea>
                                </div>

                                <!-- Requires Quality Check -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox"  @if($processes->requires_quality_check==1) checked  @endif value="1" class="form-check-input" id="requires_quality_check" name="requires_quality_check">
                                        <label class="form-check-label" for="requires_quality_check">Requires Quality Check</label>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.processes.index') !!}"
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
@endsection
