@extends('admin.layout.main')
@section('css')
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Cities List</h3>
                    <a href="{{ route('admin.city.create') }}" class="btn btn-primary btn-sm">Add New City</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="cities-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->name }}</td>
                                <td>{{ $city->country ? $city->country->name : 'N/A' }}</td>

                                <td>{{ $city->status }}</td>
                                <td>
                                    <a href="{{ route('admin.city.edit', $city->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.city.destroy', $city->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ url('public/adminlte') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('public/adminlte') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cities-table').DataTable();
        });
    </script>
@stop
