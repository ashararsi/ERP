@extends('admin.layout.main')
@section('title')
    Packing Management
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Packing List</h3>
                    <a href="{{ route('admin.packing.create') }}" class="btn btn-primary btn-sm">Add New Packing</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="data-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Packing Type</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Display Name</th>
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
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.packing.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'packing_type', name: 'packing_type'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'unit', name: 'unit'},
                    {data: 'display_name', name: 'display_name'},

                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Packing Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Packing Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Packing Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ]
            });
        });
    </script>
@endsection
