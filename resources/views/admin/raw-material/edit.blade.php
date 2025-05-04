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
                        <form method="post" action="{!! route('admin.raw-material.update',$raw->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Name</label>
                                        </div>
                                        <input  type="text" required class="form-control" value="{!! $raw->name !!}" name="name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Unit</label>
                                        </div>
                                        <select required name="unit" class="form-control">
                                            <option value="">Select Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ $raw->unit == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                    
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Quantity</label>
                                        </div>
                                        <input   type="text" required class="form-control" value="{!! $raw->quantity !!}" name="quantity">
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Supplier</label>
                                        </div>
                                        <select name="supplier" class="form-control" required>
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $raw->supplier == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Cost</label>
                                        </div>
                                        <input    type="number" step="0.01"  required class="form-control" value="{!! $raw->cost !!}" name="cost">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Expiry Date</label>
                                        </div>
                                        <input type="date" required class="form-control" value="{!! $raw->expiry_date !!}" name="expiry_date">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.raw-material.index') !!}"
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
