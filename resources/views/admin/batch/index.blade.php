@extends('admin.layout.main')

@section('title')
    Batches
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100  mt-4 ">
            <h3 class="text-22 text-center text-bold w-100 mb-4">Batches</h3>
        </div>
        <div class="row    mt-4 mb-4 ">
            <div class="col-12 " style="text-align: right">
                <a href="{!! route('admin.batches.create') !!}" class="btn btn-primary btn-sm ">Create Batch</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row w-100 ">
                    <div class="col-12">
                        <table class="table table-striped   table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Product Name</th>
                                <th>Batch code</th>
                                <th>Total Qty</th>
                                <th>batch date</th>
                                <th>MFG Date</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
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

@endsection
@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.batches.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'batch_name', name: 'batch_name'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'batch_code', name: 'batch_code'},
                    {data: 'total_qty', name: 'total_qty'},
                    {data: 'batch_date', name: 'batch_date'},
                    {data: 'mfg_date', name: 'mfg_date'},
                    {data: 'expiry_date', name: 'expiry_date'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Enable buttons at the top
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Roles Data',
                        exportOptions: {
                            columns: [0, 1] // Export only ID and Name
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Roles Data',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Roles Data',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    }
                ]
            });
        });

    </script>
@endsection
