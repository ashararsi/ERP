@extends('admin.layout.main')

@section('title')
    View Formulation
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Formulation Details</h3>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <strong>Name:</strong> {{ $f->formula_name }}
                    </div>

                    <div class="mb-3">
                        <strong>Unit:</strong> {{ $units->where('id', $f->formula_unit_id)->first()->name ?? '-' }}
                    </div>

                    <div class="mb-3">
                        <strong>For Value:</strong> 1
                    </div>

                    <div class="mb-3">
                        <strong>Description:</strong> {{ $f->description }}
                    </div>

                    <hr>
                    <h5>Material Details</h5>
                    @if($f->formulationDetail->isNotEmpty())
                        @foreach($f->formulationDetail as $item)
                            <div class="row border p-2 mb-2">
                                <div class="col-md-2">
                                    <strong>Raw Material:</strong>
                                    {{ $raw->where('id', $item->raw_material_id)->first()->name ?? '-' }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Unit:</strong>
                                    {{ $units->where('id', $item->unit)->first()->name ?? '-' }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Quantity:</strong> {{ $item->standard_quantity }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Process:</strong>
                                    {{ $process->where('id', $item->process)->first()->name ?? '-' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Remarks:</strong> {{ $item->remarks }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No material details found.</p>
                    @endif

                    <hr>
                    <h5>Additional Process Details</h5>
                    @if($f->formulationDetail->isNotEmpty())
                        @foreach($f->formulationDetail as $proc)
                            <div class="row border p-2 mb-2">
                                <div class="col-md-3">
                                    <strong>Process:</strong> {{ $process->where('id', $proc->process_id)->first()->name ?? '-' }}
                                </div>
                                <div class="col-md-9">
                                    <strong>Remarks:</strong> {{ $proc->remarks }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No process details found.</p>
                    @endif

                    <a href="{{ route('admin.formulations.index') }}" class="btn btn-sm btn-danger mt-3">Back</a>

                </div>
            </div>
        </div>
    </div>
</div>
@stop
