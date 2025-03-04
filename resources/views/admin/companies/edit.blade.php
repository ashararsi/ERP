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
                        <form method="post" action="{!! route('admin.units.update',$unit->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label for="name">Name</label>
                                        </div>
                                        <input type="text" required id="name" class="form-control" value="{!! $unit->name !!}"
                                               name="name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label for="conversion_factor">Conversion Factor</label>
                                        </div>
                                        <input type="number" value="{!!  $unit->conversion_factor !!}" step="0.01" required class="form-control"
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
                                            @foreach($units as $unit_a)
                                                <option @if($unit->parent_id==$unit_a->id) selected @endif value="{!! $unit_a->id !!}">{!! $unit_a->name !!}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.units.index') !!}"
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
