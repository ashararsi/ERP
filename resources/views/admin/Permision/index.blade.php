@extends('admin.layout.main')

@section('title')
    Permissions
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100  mt-4 ">
            <h3 class="text-22 text-center text-bold w-100 mb-4"> Permissions </h3>
        </div>
        <div class="row    mt-4 mb-4 ">
            {{-- <div class="col-12  " style="text-align: right">
                <a href="{!! route('admin.permissions.create') !!}" class="btn btn-primary btn-sm ">Create
                    Permission</a>
            </div> --}}
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
                                <th>Main</th>
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
                    url: "{{ route('admin.permissions.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'main', name: 'main'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Enables the export buttons at the top
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Permissions Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2] // Export only ID, Name, and Main columns
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Permissions Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Permissions Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    }
                ]
            });
        });

    </script>
@endsection
