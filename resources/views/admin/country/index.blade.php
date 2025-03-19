@extends('admin.layout.main')

@section('title')
    Country List
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="text-22 text-midnight text-bold mb-4">Country List</h3>
                        <a href="{{ route('admin.country.create') }}" class="btn btn-primary btn-sm">Add New Country</a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Country Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($countries as $country)
                                    <tr>
                                        <td>{{ $country->id }}</td>
                                        <td>{{ $country->name }}</td>
                                        <td>
                                                <span class="badge {{ $country->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $country->status ? 'Active' : 'Inactive' }}
                                                </span>
                                        </td>
                                        <td>{{ $country->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.country.edit', $country->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('admin.country.destroy', $country->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
{{--                        {{ $countries->links() }} --}}
                        <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $(".delete-btn").click(function (e) {
                e.preventDefault();
                if (confirm("Are you sure you want to delete this country?")) {
                    $(this).closest("form").submit();
                }
            });
        });
    </script>
@endsection
