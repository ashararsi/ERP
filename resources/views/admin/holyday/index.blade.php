@extends('admin.layout.main')

@section('title')
    Holidays
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Holydays List</h3>
                    <a href="{{ route('admin.holidays.create') }}" class="btn btn-primary btn-sm">Add New Holidays</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="data-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th> Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection
@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.holidays.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'holiday_name', name: 'holiday_name'},
                    {data: 'holiday_date', name: 'holiday_date'},

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
