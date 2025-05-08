@extends('admin.layout.main')

@section('title')
    View Product
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Product Details</h3>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Name:</strong>
                                <p>{{ $product->name }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Product Code:</strong>
                                <p>{{ $product->product_code }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Unit:</strong>
                                <p>{{ $units->where('id', $product->unit_id)->first()?->name ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Quantity:</strong>
                                <p>{{ $product->quantity }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Price:</strong>
                                <p>{{ number_format($product->price, 2) }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Packing:</strong>
                                <p>{{ $packing->where('id', $product->packing_id)->first()?->display_name ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-12">
                                <strong>Description:</strong>
                                <p>{{ $product->description ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Image:</strong><br>
                                @if($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" width="150" alt="Product Image">
                                @else
                                    <p>No image available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            {{-- <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
