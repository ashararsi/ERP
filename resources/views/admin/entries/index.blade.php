@extends('admin.layout.main')
@section('css')
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Entries</h4>


                </div><!-- end card header -->
                <div class="card-body">

                    <div class="clearfix"></div>
                    <!-- /.box-header -->
                    <div class="panel-body pad table-responsive">
                        <table class="table table-bordered datatable" style="text-transform:none;">
                            <thead>
                            <tr style="text-align:center;">
                                <th style="text-align:center;">Sr.No</th>
                                <th style="text-align:center;">Entry Type</th>
                                <th style="text-align:center;">Voucher Date</th>
                                <th style="text-align:center;">Number</th>
                                <th style="text-align:center;">Narration</th>
                                <th style="text-align:center;">Dr.Amount</th>
                                <th style="text-align:center;">Cr.Amount</th>
                                <th style="text-align:center;">Entry Items Dr.Amount</th>
                                <th style="text-align:center;">Entry Items Cr.Amount</th>
                                <th style="text-align:center;">Action</th>
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
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.entries.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'entery_type', name: 'entery_type'},
                    {data: 'voucher_date', name: 'voucher_date'},
                    {data: 'number', name: 'number'},
                    {data: 'dr_amount', name: 'dr_amount'},
                    {data: 'cr_amount', name: 'cr_amount'},
                    {data: 'items_dr_amount', name: 'items_dr_amount'},
                    {data: 'items_cr_amount', name: 'items_cr_amount'},
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

