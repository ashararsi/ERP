@extends('admin.layout.main')

@section('title')
    Edit Product
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Edit Product</h3>
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

                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" required class="form-control" name="name" value="{{ old('name', $product->name) }}">
                                    </div>
                                </div>

                                <!-- Product Code -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="product_code">Product Code</label>
                                        <input type="text" required class="form-control" name="product_code" value="{{ old('product_code', $product->product_code) }}">
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <select required name="unit_id" class="form-control">
                                            <option value="">Select Unit</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" required class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}">
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" required class="form-control" name="price" value="{{ old('price', $product->price) }}">
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">Product Image</label>
                                        <input type="file" class="form-control" name="image">
                                        @if($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}" class="mt-2" width="100" alt="Product Image">
                                        @endif
                                    </div>
                                </div>

                                <!-- Packing -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="packing_id">Packing</label>
                                        <select required name="packing_id" class="form-control">
                                            <option value="">Select Packing</option>
                                            @foreach($packing as $item)
                                                <option value="{{ $item->id }}" {{ $product->packing_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-danger">Cancel</a>
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
