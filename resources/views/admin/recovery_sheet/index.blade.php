@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Generate Recovery Sheet</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.recovery.generate') }}" method="POST" target="_blank">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sales_person_id" class="form-label">Sales Person:</label>
                        <select name="sales_person_id" class="form-select" required>
                            @foreach($salesPersons as $person)
                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Generate Recovery Sheet</button>
            </form>
        </div>
    </div>
</div>
@endsection
