@extends('admin.layout.main')

@section('title')
    Packing Material Details
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Packing Material Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Name:</strong>
                            <p>{{ $packingMaterial->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Category:</strong>
                            <p>{{ $packingMaterial->category->name ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Unit:</strong>
                            <p>{{ $packingMaterial->unit->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.packing-materials.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        {{-- <a href="{{ route('admin.packing-materials.edit', $packingMaterial->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
