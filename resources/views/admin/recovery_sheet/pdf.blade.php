<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            margin: 0;
        }

        .header {
            display: flex;
            /* align-items: center; */
            /* margin-bottom: 15px; */
            /* padding: 10px; */
            border-bottom: 1px solid #eee;
        }

        .header img {
            height: 60px;
            width: auto;
            /* flex-shrink: 0; */
        }

        .header .title {
            /* flex-grow: 1; */
            text-align: center;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .header p {
            margin: 2px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 0 10px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        thead {
            background-color: #87CEEB;
            color: #000000;
        }

        tfoot td {
            font-weight: bold;
        }

        .print-footer {
            text-align: right;
            font-size: 9px;
            margin-top: 20px;
            color: #555;
            padding: 0 10px;
        }

        .nowrap {
            white-space: nowrap;
        }

        .address-cell {
            max-width: 300px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="Company Logo">
        <div class="title">
            <h2>Lasani Pharma (Pvt.) Ltd.</h2>
            <h2>Recovery Sheet</h2>
            <p class="nowrap">Date: {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="info-row">
        <div>Sales Person: {{ $salesPerson->name }} ({{ $salesPerson->phone ?? 'N/A' }})</div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name and Address</th>
                    <th>Bill #</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; $counter = 1; @endphp
                @foreach($customers as $customer)
                    @foreach($customer->salesOrders as $order)
                        @php
                            $paid = $order->payments->sum('amount');
                            $pending = $order->net_total - $paid;
                            $grandTotal += $pending;
                        @endphp
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="address-cell">
                                {{ $customer->name }}<br>
                                {{ $customer->address ?? '-' }}
                            </td>
                            <td class="nowrap">{{ $order->order_number }}</td>
                            <td class="nowrap">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                            <td class="nowrap">{{ number_format($order->net_total, 2) }}</td>
                            <td class="nowrap">{{ number_format($paid, 2) }}</td>
                            <td class="nowrap">{{ number_format($pending, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right;">Grand Total Pending:</td>
                    <td>{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="print-footer">
        Printing Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }} | Printed By: {{ auth()->user()->name ?? 'System' }}
    </div>
</body>

</html>
