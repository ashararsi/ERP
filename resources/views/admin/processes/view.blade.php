@extends('admin.layout.main')
@section('title')
    Process View
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Process Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong>
                            <p>{{ $processes->name }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p>{{ $processes->description }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Sequence Order:</strong>
                            <p>{{ $processes->sequence_order }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Image:</strong><br>
                            @if($processes->image)
                                <img src="{{ asset('storage/' . $processes->image) }}" alt="Process Image" width="150">
                            @else
                                <p>No image uploaded.</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>Duration (Minutes):</strong>
                            <p>{{ $processes->duration_minutes }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Remarks:</strong>
                            <p>{{ $processes->remarks }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Requires Quality Check:</strong>
                            <p>{{ $processes->requires_quality_check ? 'Yes' : 'No' }}</p>
                        </div>

                        <div class="text-right mt-4">
                            {{-- <a href="{{ route('admin.processes.edit', $processes->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                            <a href="{{ route('admin.processes.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
