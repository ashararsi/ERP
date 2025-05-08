@extends('admin.layout.main')
@section('title')
    Raw Material View
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Raw Material Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong>
                            <p>{{ $raw->name }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Unit:</strong>
                            <p>{{ $units->where('id', $raw->unit)->first()?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Quantity:</strong>
                            <p>{{ $raw->quantity }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Supplier:</strong>
                            <p>{{ $suppliers->where('id', $raw->supplier)->first()?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Cost:</strong>
                            <p>{{ number_format($raw->cost, 2) }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Expiry Date:</strong>
                            <p>{{ \Carbon\Carbon::parse($raw->expiry_date)->format('d-m-Y') }}</p>
                        </div>

                        <div class="text-right mt-4">
                            {{-- <a href="{{ route('admin.raw-material.edit', $raw->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                            <a href="{{ route('admin.raw-material.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
