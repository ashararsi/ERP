<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            color: #000;
            background-color: #fff;
        }

        .invoice-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            box-sizing: border-box;
            padding-bottom: 120px; /* Space for footer */
        }

        .header-section {
            text-align: center;
            margin-bottom: 8px;
            position: relative;
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px 0;
        }

        .address-phone {
            font-size: 0.75rem;
            line-height: 1.25;
            color: #4b5563;
            margin-bottom: 2px;
        }

        .delivery-order-title {
            margin-top: 10px;
            font-size: 1.25rem;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 5px;
        }

        .user-logo-container {
            position: absolute;
            top: 10px;
            right: 15px;
        }

        .user-logo-container img {
            width: 70px;
            height: auto;
        }

        .customer-details-section {
            font-size: 0.75rem;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .customer-details-section table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        .customer-details-section td {
            padding: 1px 4px;
            white-space: nowrap;
            vertical-align: top;
        }

        .label {
            font-weight: 600;
            color: #374151;
        }

        .data-cell {
            border-bottom: 1px dotted #000;
            width: 100%;
        }

        .small {
            width: 1%;
            white-space: nowrap;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            font-weight: normal;
            color: #222;
        }

        .table th {
            background-color: transparent;
            color: #222;
        }

        .table th:nth-child(1), .table td:nth-child(1) { width: 4%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 8%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 20%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 8%; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 5%; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 7%; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 8%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 6%; }
        .table th:nth-child(9), .table td:nth-child(9) { width: 6%; }

        .pdf-footer {
            position: fixed;
            bottom: 20px;
            left: 30px;
            right: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header-section">
            <div class="user-logo-container">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="logo">
            </div>
            <h2 class="company-name">Lasani Pharma (Pvt.) Ltd. - HO</h2>
            <div class="address-phone">Manawan Post Office Batapur, Lahore-Pakistan</div>
            <div class="address-phone">042-37188887-37188888 &nbsp;&nbsp;&nbsp;&nbsp; 0300-0724101</div>
            <h3 class="delivery-order-title">Delivery Order</h3>
        </div>

        <div class="customer-details-section">
            <table>
                <tr>
                    <td class="label">Customer Code:</td>
                    <td>{{ $sale->customer->customer_code ?? '103850' }}</td>
                    <td class="label small">Order #:</td>
                    <td>{{ $sale->order_number ?? '24-10486' }}</td>
                </tr>
                <tr>
                    <td class="label">Customer Name:</td>
                    <td>
                        {{ $sale->customer ? trim(preg_replace('/\s+/', ' ', $sale->customer->name)) : 'AHSAAN MEDICAL STORE.' }}
                    </td>
                   
                </tr>
                <tr>
                    <td class="label">Address:</td>
                    <td>
                        {{ $sale->customer->address ?? 'Mitha Tawana' }}
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding-top: 8px;">Sales Representative:</td>
                    <td colspan="3" style="padding-left: 4px; padding-top: 8px;">
                        {{ $sale->customer->salesPerson->name ?? 'Sulman Mushtaq' }}
                        @if(isset($sale->customer->salesPerson->phone))
                            ({{ $sale->customer->salesPerson->phone }})
                        @else
                            {{ 'N/A' }}
                        @endif
                    </td>
                </tr>
                
                
            </table>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>S#</th>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Batch#</th>
                    <th>QTY</th>
                    <th>Bonus</th>
                    <th>Available Quantity</th>
                    <th>Ct.</th>
                    <th>Pcs</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->product_code ?? '' }}</td>
                    <td>{{ $item->product->name ?? '' }}</td>
                    <td>{{ $item->batch->batch_code ?? '' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->bonus ?? '' }}</td>
                    <td>{{ $item->available_quantity ?? '' }}</td>
                    <td>{{ $item->cartons ?? '' }}</td>
                    <td>{{ $item->pieces ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align: right;">Totals</th>
                    <th>{{ number_format($sale->items->sum('quantity')) }}</th>
                    <th>-</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 40px;">
            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="text-align: left;">
                        <strong>Packed By:</strong> _______________________
                    </td>
                    <td style="text-align: center;">
                        <strong>Checked By:</strong> _______________________
                    </td>
                    <td style="text-align: right;">
                        <strong>Approved By:</strong> _______________________
                    </td>
                </tr>
            </table>
        </div>

        <div class="pdf-footer">
            <div style="margin-top: 8px; font-size: 12px; text-align: right;">
                <div style="border-top: 1px solid #999; margin-bottom: 4px;"></div>
                <strong>Printed By:</strong> {{ strtoupper(auth()->user()->name ?? 'System') }} |
                <strong>Printing Date:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
        </div>
    </div>
</body>
</html>
