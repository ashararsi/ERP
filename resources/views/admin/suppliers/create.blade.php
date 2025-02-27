@extends('admin.layout.main')
@section('title')
    Raw Material  Create
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Unit </h3>
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
                        <form method="post" action="{!! route('admin.units.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label for="name">Name</label>
                                        </div>
                                        <input type="text" required id="name" class="form-control" value=" "
                                               name="name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label for="conversion_factor">Conversion Factor</label>
                                        </div>
                                        <input type="number" step="0.01" required class="form-control"
                                               id="conversion_factor" name="conversion_factor">

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Parent</label>
                                        </div>
                                        <select class="form-control" name="parent_id">
                                            <option value="0">Main</option>
                                            @foreach($units as $unit)
                                                <option value="{!! $unit->id !!}">{!! $unit->name !!}</option>
                                            @endforeach
                                        </select>

                                    </div>
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

@endsection
