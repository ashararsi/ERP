@extends('admin.layout.main')

@section('title')
    View Category
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Category Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Category Name:</strong>
                                <p>{{ $category->name }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Status:</strong>
                                <p>{{ ucfirst($category->status) }}</p>
                            </div>
                        </div>

                        <div class="text-right">
                            {{-- <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
