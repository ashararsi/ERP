@extends('admin.layout.main')
@section('title')
    Financial Year create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h3 class="text-22 text-midnight text-bold mb-4">Create Financial Year</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" action="{!! route('admin.financial-year.store') !!}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Financial Year Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>


                                </div>
                                <div class="row mt-4">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save Financial Year</button>
                                        <a href="{!! route('admin.financial-year.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>

    </script>
@endsection
