@extends('admin.layout.main')

@section('title')
    Vendors
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100 mt-4">
            <h3 class="text-22 text-center text-bold w-100 mb-4">Vendors</h3>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-12 text-end">
                <a href="{!! route('admin.vendor.create') !!}" class="btn btn-primary btn-sm">Add New Vendor</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-12">
                        <table class="table table-striped table-hover" id="vendor-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>CNIC</th>
                                <th>NTN</th>
                                <th>Sales Tax No</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th width="150px">Action</th>
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
            $('#vendor-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.vendor.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'vendor_name', name: 'vendor_name'},
                    {data: 'cnic', name: 'cnic'},
                    {data: 'ntn', name: 'ntn'},
                    {data: 'salestaxno', name: 'salestaxno'},
                    {data: 'email', name: 'email'},
                    {data: 'contact', name: 'contact'},
                    {data: 'category', name: 'category'},
                    {data: 'type', name: 'type'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Vendor Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Vendor Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Vendor Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });
        });
    </script>
@endsection
