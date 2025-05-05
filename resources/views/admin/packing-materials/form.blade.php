@extends('admin.layout.main')

@section('title')
    {{ isset($packingMaterial) ? 'Edit' : 'Create' }} Packing Material
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">{{ isset($packingMaterial) ? 'Edit' : 'Create' }} Packing Material</h3>
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

                    <form method="POST" action="{{ isset($packingMaterial) ? route('admin.packing-materials.update', $packingMaterial->id) : route('admin.packing-materials.store') }}">
                        @csrf
                        @if(isset($packingMaterial)) @method('PUT') @endif
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Material Name</label>
                                    <input type="text" required class="form-control" name="name" value="{{ old('name', $packingMaterial->name ?? '') }}">
                                </div>
                            </div>
                        
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select required name="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id', $packingMaterial->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="unit_id">Unit</label>
                                    <select required name="unit_id" class="form-control">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (old('unit_id', $packingMaterial->unit_id ?? '') == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Additional Fields -->
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{{ route('admin.packing-materials.index') }}" class="btn btn-sm btn-danger">Cancel</a>
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
