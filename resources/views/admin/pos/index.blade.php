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
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="payment_status">Payment Status</label>
                            <select id="payment_status" class="form-control">
                                <option value="">All</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sales_person_id">Select Salesperson</label>
                            <select id="sales_person_id" name="sales_person_id" class="form-select">
                                <option value="" selected disabled>Select Salesperson</option>
                                @foreach($salesPersons as $person)
                                    <option value="{{ $person->id }}">{{ $person->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="col-md-3 d-flex align-items-end gap-2 mt-2">
                            <button id="filter" class="btn btn-primary mr-2">Filter</button>
                            <button id="clear" class="btn btn-secondary">Clear</button>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="pos-orders-table">
                        <thead>
                        <tr>
                            <th>invoice #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- Payment History Modal -->
                <div class="modal fade" id="paymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="paymentHistoryLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Payment History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div><strong>Total Amount:</strong> ₹<span id="total-amount"></span></div>
                                    <div><strong>Total Payments:</strong> <span id="payment-count"></span></div>
                                </div>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Date</th>
                                            <th>Remaining After Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payment-history-body">
                                        <!-- Payments will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
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
       $(document).on('click', '.view-payments', function () {
        const saleId = $(this).data('id');
        $('#payment-history-body').html('<tr><td colspan="4">Loading...</td></tr>');
        $('#paymentHistoryModal').modal('show');

        $.get(`/admin/pos/payments/${saleId}`, function (response) {
            let rows = '';
            const payments = response.payments;

            if (payments.length === 0) {
                rows = '<tr><td colspan="4" class="text-center">No payments found</td></tr>';
            } else {
                payments.forEach((payment, index) => {
                    rows += `<tr>
                        <td>${index + 1}</td>
                        <td>₹${parseFloat(payment.amount).toFixed(2)}</td>
                        <td>${payment.payment_date}</td>
                        <td>₹${payment.remaining_after}</td>
                    </tr>`;
                });
            }

            $('#total-amount').text(response.net_total);
            $('#payment-count').text(response.count);
            $('#payment-history-body').html(rows);
        });
    });


        $(document).ready(function () {
            let table = $('#pos-orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.pos.getdata') }}",
                type: "POST",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();       
                    d.payment_status = $('#payment_status').val();
                    d.sales_person_id = $('#sales_person_id').val();                    

                }
            },
            columns: [
                {data: 'invoice_number', name: 'invoice_number'},
                {data: 'order_date', name: 'order_date'},
                {data: 'customer', name: 'customer'},
                {data: 'items_count', name: 'items_count'},
                {data: 'net_total', name: 'net_total'},
                {data: 'remaining_amount', name: 'remaining_amount'},                
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        let cls = 'status-pending';
                        if (data === 'completed') cls = 'status-completed';
                        else if (data === 'cancelled') cls = 'status-cancelled';
                        return '<span class="' + cls + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'POS Orders Data',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'POS Orders Data',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
                },
                {
                    extend: 'print',
                    title: 'POS Orders Data',
                    className: 'btn btn-primary',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
                }
            ],
            order: [[0, 'desc']]
        });

        $('#filter').on('click', function () {
            table.ajax.reload();
        });

        $('#clear').on('click', function () {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#payment_status').val('');
            $('#sales_person_id').val('');
            table.ajax.reload();
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
