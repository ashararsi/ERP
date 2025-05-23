@extends('admin.layout.main')

@section('title')
    Users
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100  mt-4 ">
            <h3 class="text-22 text-center text-bold w-100 mb-4"> Users </h3>
        </div>
        <div class="row    mt-4 mb-4 ">
            <div class="col-12  " style="text-align: right">
                <a href="{!! route('admin.users.create') !!}" class="btn btn-primary btn-sm ">Create Users</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row w-100 text-center">
                    <div class="col-12">
                        <table class="table table-striped   table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>verified</th>
                                <th width="200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
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
                    url: "{{ route('admin.users.getdata') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        @if(request()->query('role'))
                        'role': "{{ request()->query('role') }}",
                        @endif
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'email_verified_at', name: 'email_verified_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Add this to enable buttons
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'User Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3] // Exclude action column
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'User Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'User Data',
                        className: 'btn btn-primary',

                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ]
            });
        });
    </script>
@endsection
