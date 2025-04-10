@extends('admin.layout.main')
@section('title')
    Create Packing
@endsection
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Packing</h3>
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
                    <form method="post" action="{{ route('admin.packing.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Packing Type -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Packing Type</label>
                                    </div>
                                    <select name="packing_type" class="form-control" required>
                                        <option value="" disabled selected>Select Packing Type</option>
                                        <option value="bottle">Bottle</option>
                                        <option value="box">Box</option>
                                        <option value="pouch">Pouch</option>
                                        <option value="tablet">Tablet</option>
                                        <option value="cup">Cup</option>
                                        <option value="jar">Jar</option>
                                        <option value="tin">Tin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Quantity</label>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" name="quantity" required>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Unit</label>
                                    </div>
                                    <select name="unit" class="form-control" required>
                                        <option value="" disabled selected>Select Unit</option>
                                     @foreach($units as $item)
                                         <option value="{!! $item->id !!}">
                                             {!! $item->name !!}
                                         </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Display Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Display Name (Optional)</label>
                                    </div>
                                    <input type="text" class="form-control" name="display_name">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Packing Image (Optional)</label>
                                    </div>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Status</label>
                                    </div>
                                    <select name="is_active" class="form-control" required>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Description (Optional)</label>
                                    </div>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{{ route('admin.packing.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop
