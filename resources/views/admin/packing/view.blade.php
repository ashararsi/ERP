@extends('admin.layout.main')

@section('title')
    Packing Details
@endsection

@section('css')

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">View Packing</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Packing Type -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Packing Type</label>
                                </div>
                                <p>{{ ucfirst($packing->packing_type) }}</p>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Quantity</label>
                                </div>
                                <p>{{ $packing->quantity }}</p>
                            </div>
                        </div>

                        <!-- Unit -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Unit</label>
                                </div>
                                <p>{{ $packing->units ? $packing->units->name : 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Display Name -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Display Name</label>
                                </div>
                                <p>{{ $packing->display_name ?: 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Packing Image</label>
                                </div>
                                @if($packing->image)
                                    <img src="{{ asset('storage/' . $packing->image) }}" alt="Packing Image" class="img-fluid" style="max-width: 200px;">
                                @else
                                    <p>No image available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Status</label>
                                </div>
                                <p>{{ $packing->is_active == 1 ? 'Active' : 'Inactive' }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Description</label>
                                </div>
                                <p>{{ $packing->description ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right mt-4">
                        <a href="{{ route('admin.packing.index') }}" class="btn btn-sm btn-primary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
