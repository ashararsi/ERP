@extends('admin.layout.main')
@section('title')
    holiday  Edit
@endsection
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Edit Holiday</h3>
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
                    <form method="post" action="{!! route('admin.holidays.update', $holyday->id) !!}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label> Name</label>
                                    </div>
                                    <input type="text" required class="form-control" name="holiday_name" value="{!! $holyday->holiday_name !!}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label> Date</label>
                                    </div>
                                    <input type="date" required class="form-control" name="holiday_date" value="{!! $holyday->holiday_date !!}">
                                </div>
                            </div>
                        </div>


                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{!! route('admin.holidays.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
