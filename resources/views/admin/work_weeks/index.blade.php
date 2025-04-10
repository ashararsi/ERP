@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 class="text-22 text-midnight text-bold mb-0">Cities List</h3>
                    <a href="{{ route('admin.work-weeks.create') }}" class="btn btn-primary btn-sm">Add New Weeks</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="data-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                            <th>Working Days</th>
                            <th>Status</th>
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
                    url: "{{ route('admin.work-weeks.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'mon', name: 'mon'},
                    {data: 'tue', name: 'tue'},
                    {data: 'wed', name: 'wed'},
                    {data: 'thu', name: 'thu'},
                    {data: 'fri', name: 'fri'},
                    {data: 'sat', name: 'sat'},
                    {data: 'sun', name: 'sun'},
                    {data: 'working_days', name: 'working_days'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'City Work Week',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'City Work Week',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'City Work Week',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                        }
                    }
                ]
            });
        });
    </script>
@endsection
