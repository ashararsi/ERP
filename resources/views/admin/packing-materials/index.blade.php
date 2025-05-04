@extends('admin.layout.main')

@section('title')
    Packing Materials
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100 mt-4">
            <h3 class="text-22 text-center text-bold w-100 mb-4">Packing Materials</h3>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-12 text-end">
                <a href="{!! route('admin.packing-materials.create') !!}" class="btn btn-primary btn-sm">Create Packing Material</a>
                <a href="{!! route('admin.packing-materials.import') !!}" class="btn btn-primary btn-sm">Import Data</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-12">
                        <table class="table table-striped table-hover" id="packing-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
            $('#packing-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.packing-materials.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Packing Materials',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Packing Materials',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Packing Materials',
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
