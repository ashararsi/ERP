@extends('admin.layout.main')
@section('title')
    POS Orders
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">POS Orders List</h3>
                    <a href="{{ route('admin.pos.create') }}" class="btn btn-primary btn-sm">Create New Order</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered" id="pos-orders-table">
                        <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
@endsection

@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#pos-orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pos.getdata') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"}
                },
                columns: [
                    {data: 'order_number', name: 'order_number'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'customer', name: 'customer'},
                    {data: 'items_count', name: 'items_count'},
                    {data: 'net_total', name: 'net_total' },
                    {data: 'status', name: 'status',
                        render: function(data, type, row) {
                            var statusClass = '';
                            if (data === 'completed') statusClass = 'status-completed';
                            else if (data === 'cancelled') statusClass = 'status-cancelled';
                            else statusClass = 'status-pending';

                            return '<span class="' + statusClass + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'POS Orders Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'POS Orders Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'POS Orders Data',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ],
                order: [[0, 'desc']] // Sort by order number descending by default
            });

            // Delete button handler
            $(document).on('click', '.delete-btn', function() {
                var orderId = $(this).data('id');
                if (confirm('Are you sure you want to delete this order?')) {
                    $.ajax({
                        url: '/admin/pos/' + orderId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#pos-orders-table').DataTable().ajax.reload();
                                alert('Order deleted successfully');
                            } else {
                                alert('Error deleting order');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
