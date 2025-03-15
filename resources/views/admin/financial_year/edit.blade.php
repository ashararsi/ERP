@extends('admin.layout.main')
@section('title')
    Company Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.financial-year.update',$f->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Financial Year Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $f->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $f->start_date }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $f->end_date }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" {{ $f->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $f->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.financial-year.index') !!}"
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
