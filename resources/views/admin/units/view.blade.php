@extends('admin.layout.main')
@section('title')
    Unit View
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Unit Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Name:</strong>
                                <p>{{ $unit->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Conversion Factor:</strong>
                                <p>{{ $unit->conversion_factor }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Parent:</strong>
                                <p>
                                    @if($unit->parent_id == 0)
                                        Main
                                    @else
                                        {{ $unit->parent->name ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            {{-- <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                            <a href="{{ route('admin.units.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
