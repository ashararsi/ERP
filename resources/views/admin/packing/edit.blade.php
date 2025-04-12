@extends('admin.layout.main')

@section('title')
    Packing Edit
@endsection
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Edit Packing</h3>
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
                    <form method="post" action="{!! route('admin.packing.update', $packing->id) !!}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Packing Type -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Packing Type</label>
                                    </div>
                                    <select name="packing_type" class="form-control" required>
                                        <option value="" disabled selected>Select Packing Type</option>
                                        <option @if($packing->packing_type=="bottle") selected @endif value="bottle">
                                            Bottle
                                        </option>
                                        <option @if($packing->packing_type=="box") selected @endif    value="box">Box
                                        </option>
                                        <option @if($packing->packing_type=="pouch") selected @endif   value="pouch">
                                            Pouch
                                        </option>
                                        <option @if($packing->packing_type=="tablet") selected @endif   value="tablet">
                                            Tablet
                                        </option>
                                        <option @if($packing->packing_type=="cup") selected @endif    value="cup">Cup
                                        </option>
                                        <option @if($packing->packing_type=="jar") selected @endif   value="jar">Jar
                                        </option>
                                        <option @if($packing->packing_type=="tin") selected @endif   value="tin">Tin
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Quantity</label>
                                    </div>
                                    <input type="number" value="{!! $packing->quantity !!}" step="0.01" class="form-control" name="quantity" required>
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
                                            <option @if($packing->unit==$item->id)  selected @endif value="{!! $item->id !!}">
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
                                    <input type="text" class="form-control" value="{!! $packing->display_name !!}" name="display_name">
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
                                        <option value="1"   @if($packing->is_active==1) selected @endif  >Active</option>
                                        <option value="0"  @if($packing->is_active==0) selected @endif>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Description (Optional)</label>
                                    </div>
                                    <textarea class="form-control" name="description" rows="3">{!! $packing->description !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{!! route('admin.packing.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
