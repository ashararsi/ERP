@extends('admin.layout.main')

@section('title')
    Edit Country
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Edit Country</h3>
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

                        <form method="post" action="{{ route('admin.country.update', $country->id) }}">
                            @csrf
                            @method('PUT')  {{-- Required for updating in Laravel --}}

                            <div class="row">
                                <!-- Country Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Country Name</label>
                                    <input type="text" required id="name" class="form-control" name="name"
                                           value="{{ old('name', $country->name) }}">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" {{ $country->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $country->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit & Cancel Buttons -->
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Update Country</button>
                                    <a href="{{ route('admin.country.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            console.log("Edit country page loaded.");
        });
    </script>
@endsection
