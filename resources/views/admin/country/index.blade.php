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
                            <table class="table table-bordered" id="data-table">
                                <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Country Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

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

@section('css')

@endsection
@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.city.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Enable buttons at the top
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Roles Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1] // Export only ID and Name
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Roles Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Roles Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    }
                ]
            });
        });

    </script>
@endsection


