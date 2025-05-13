@extends('admin.layout.main')

@section('title')
    Area Edit
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Edit Area</h3>
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

                        <form method="post" action="{{ route('admin.areas.update', $area->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Name -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Area Name</label>
                                        <input type="text" required class="form-control" name="name" value="{{ old('name', $area->name) }}">
                                    </div>
                                </div>

                                <!-- Company -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company_id">Company</label>
                                        <select name="company_id" class="form-control" required>
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}" {{ old('company_id', $area->company_id) == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        <a href="{{ route('admin.areas.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
