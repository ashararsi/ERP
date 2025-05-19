@extends('admin.layout.main')
@section('title', 'Recovery Sheet Filters')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="mb-0 text-22 text-midnight text-bold">Stored Recovery Sheet</h3>
                <a href="{{ route('admin.recovery_sheet.index') }}" class="btn btn-primary btn-sm mt-2">Generate New Sheet</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="filters-table">
                    <thead>
                        <tr>
                            <th>Serial #</th>
                            <th>Sales Person</th>
                            <th>Date Range</th>
                            <th>Cities</th>
                            <th>Areas</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
@include('admin.layout.datatable')
<script>
    $(document).ready(function () {
        $('#filters-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.recovery_sheets.data') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'serial_no', name: 'serial_no' },
                { data: 'sales_person', name: 'salesPerson.name' },
                { data: 'date_range', name: 'date_range' },
                { data: 'cities', name: 'cities' },
                { data: 'areas', name: 'areas' },
                {data: 'action', name:'action'}
            ],
            order: [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Recovery Sheet Filters',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0,1,2,3,4,5] }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Recovery Sheet Filters',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0,1,2,3,4,5] }
                },
                {
                    extend: 'print',
                    title: 'Recovery Sheet Filters',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0,1,2,3,4,5] }
                }
            ]

        });
    });
</script>
@endsection
