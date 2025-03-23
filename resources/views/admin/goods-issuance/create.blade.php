@extends('admin.layout.main')
@section('title')
    GoodsIssuance
@stop



@section('content')
    <div class="container">
        <h2>Issue New Goods</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('goods-issuance.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="batch_id" class="form-label">Batch</label>
                <select name="batch_id" class="form-control" required>
                    <option value="">Select Batch</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->batch_number }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="raw_material_id" class="form-label">Raw Material</label>
                <input type="text" name="raw_material_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="issued_quantity" class="form-label">Quantity</label>
                <input type="number" name="issued_quantity" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="issued_by" class="form-label">Issued By</label>
                <input type="text" name="issued_by" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Issue Goods</button>
        </form>
    </div>
@endsection


@section('js')


@stop



