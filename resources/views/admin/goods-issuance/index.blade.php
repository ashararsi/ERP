@extends('admin.layout.main')
@section('title')
    Goods Issuance
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Goods Issuance List</h3>
                    {{--                    <a href="{{ route('admin.city.create') }}" class="btn btn-primary btn-sm">Add New City</a>--}}
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered mt-5" id="data-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th> Name</th>
                            <th>Batch Number</th>
                            <th>Quantity</th>
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
                    url: "{{ route('admin.inventory.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'product_id', name: 'product_id'},
                    {data: 'batch_number', name: 'batch_number'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'cost_price', name: 'cost_price'},
                    {data: 'selling_price', name: 'selling_price'},
                    {data: 'expiry_date', name: 'expiry_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Enable buttons at the top
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Roles Data',
                        className: 'btn btn-primary mb-4',
                        exportOptions: {
                            columns: [0, 1] // Export only ID and Name
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Roles Data',
                        className: 'btn btn-primary mb-4',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Roles Data',
                        className: 'btn btn-primary mb-4',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    }
                ]
            });
        });

    </script>
@endsection
