<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.1;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 9px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px 5px;
            text-align: left;
            vertical-align: top;
        }

        thead {
            background-color: #f9f9f9;
        }

        thead th {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #ccc;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .grand-total {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
            font-size: 10px;
        }

        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: right;
            font-size: 8px;
            padding: 5px 10px;
            border-top: 1px solid #eee;
            color: #777;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .address-cell {
            word-wrap: break-word;
            max-width: 150px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Lasani Pharma (Pvt.) Ltd.</h2>
        <h2>Recovery Sheet</h2>
        <p class="no-wrap">Date: {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}</p>
        <p class="no-wrap">Sales Person: {{ $salesPerson->name }} ({{ $salesPerson->phone ?? 'N/A' }})</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name and Address</th>
                    <th>Bill #</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Rem.</th>
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
                    <td class="address-cell">{{ $customer->name }} <br> {{ $customer->address ?? '-' }}</td>
                    <td class="no-wrap">{{ $order->order_number }}</td>
                    <td class="no-wrap">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td class="no-wrap">{{ number_format($order->net_total, 2) }}</td>
                    <td class="no-wrap"> {{ number_format($paid, 2) }}</td>                   
                    <td class="no-wrap">{{ number_format($pending, 2) }}</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Grand Total Pending:</td>
                    <td style="font-weight: bold;">{{ number_format($grandTotal, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="print-footer">
        <span class="no-wrap">Printing Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span> |
        <span class="no-wrap">Printed By: {{ auth()->user()->name ?? 'System' }}</span>
    </div>

</body>

</html>