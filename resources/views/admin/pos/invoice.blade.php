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
            margin: 40px;
            color: #000;
            background-color: #fff;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .header-section {
            text-align: center;
            margin-bottom: 8px; /* Space below header text */
        }

        .header-section .company-name {
            font-size: 1.5rem; /* 24px */
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px 0;
        }
        /* Removed logo style from here as it's positioned absolutely in HTML */

        .header-section .address-phone,
        .header-section .ntn-line {
            font-size: 0.75rem; /* 12px */
            line-height: 1.25;
            color: #4b5563;
            margin-bottom: 2px;
        }

        .ntn-strn-line-container {
            font-size: 0.75rem; /* 12px */
            font-weight: 600;
            color: #374151;
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            display: grid; /* Using grid for alignment */
            grid-template-columns: 1fr 1fr 1fr;
            align-items: center;
            text-align: center; /* Default for all spans */
        }
        .ntn-strn-line-container .ntn { text-align: left; }
        .ntn-strn-line-container .drap { text-align: right; }


        .website-url {
            text-align: center;
            font-weight: 500;
            color: #2563eb; /* blue-600 */
            margin-bottom: 12px;
            font-size: 0.875rem; /* 14px */
        }

        .customer-details-section {
        font-size: 0.75rem;
        margin-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 8px;
    }

    .customer-details-section table {
        width: 100%;
    }

    .customer-details-section strong {
        font-weight: 600;
        color: #374151;
    }

    .customer-details-section p {
        margin-bottom: 3px;
        line-height: 1.3;
    }

    .customer-details-section .align-right {
        text-align: right;
    }

    .customer-details-section td {
        padding: 2px 4px;
    }

    .customer-details-section td:nth-child(2n) {
        text-align: left;
    }

    .customer-details-section td:nth-child(2n+1) {
        text-align: left;
    }

    .data-cell {
        border-bottom: 1px dotted black;
    }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .invoice-info div {
            width: 48%;
        }
        .invoice-info p {
            margin: 3px 0;
            font-size: 13px;
        }
        .underline {
            text-decoration: underline;
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
        }

        /* Hide elements that are not in the PDF or for which placeholders are enough */
        .user-logo-container { /* Your logo container */
            position: absolute;
            top: 10px; /* Adjust as needed */
            right: 15px; /* Adjust as needed */
            /* display: none; /* Uncomment if you want to hide it completely as PDF has no top-right logo */
        }
        .user-logo-container img {
            width: 70px; /* Adjust size */
            height: auto;
        }
        .table th {
            background-color: #f0f0f0;
            font-weight: bold;
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
        .table th:nth-child(10), .table td:nth-child(10) { width: 6%; }
        .table th:nth-child(11), .table td:nth-child(11) { width: 6%; }
        .table th:nth-child(12), .table td:nth-child(12) { width: 8%; }
        .table th:nth-child(13), .table td:nth-child(13) { width: 6%; }
        .table th:nth-child(14), .table td:nth-child(14) { width: 8%; }
        .totals {
            font-size: 12px;
            margin-bottom: 15px;
            text-align: right;
        }
        .totals p {
            margin: 3px 0;
        }
        .footer-block {
    margin-top: 195px; /* Adjust this value as needed */
}
        .footer-container {
    margin-bottom: 10px;
}

.footer-signatures {
    margin-top: 10px;
    width: 100%;
}

.signature-table {
    width: 100%;
    font-size: 12px;
    border-collapse: collapse;
}

.signature-table td {
    padding: 10px 5px;
    vertical-align: top;
}

.footer-info {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    margin-bottom: 15px;
}

.footer-info td {
    border: 1px solid #000;
    padding: 3px 6px;
    vertical-align: top;
}

.footer-images-full {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-bottom: 15px;
}

.footer-images-full img {
    width: 600px;
    height: 120px;
    object-fit: contain;
    display: block; /* Or use 'cover' if you want it to fill the area */
}



        .rep-person {
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header-section">
            <div class="user-logo-container">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="logo">
                {{-- <img src="https://placehold.co/100x40/cccccc/333333?text=LOGO" alt="logo"> --}}
            </div>
    
            <h2 class="company-name">Lasani Pharma Private Limited</h2>
            <div class="address-phone">Manawan Post Office Batapur, Lahore-Pakistan | Phone: 042-37188887, 37188888, Mobile: 0300-0724101</div>
            <div class="ntn-strn-line-container">
                <span class="ntn">NTN: 1129483-3</span>
                <span class="strn">STRN:</span>
                <span class="drap">DRAP E No. 00873</span>
            </div>
        </div>
    
        <div class="website-url">
            www.lasaniindustries.com
        </div>
    
        <div class="customer-details-section">
            <table>
                <tr>
                    <td><strong>Customer Code:</strong></td>
                    <td class="data-cell">{!! $sale->customer->id ?? '103850' !!}</td>
                    <td><strong>Order #:</strong></td>
                    <td class="data-cell">{!! $sale->order_number ?? '24-10486' !!}</td>
                </tr>
                <tr>
                    <td><strong>Customer Name:</strong></td>
                    <td class="data-cell">@if($sale->customer) {!! trim(preg_replace('/\s+/', ' ', $sale->customer->name)) !!} @else AHSAAN MEDICAL STORE. @endif</td>
                    <td><strong>Date:</strong></td>
                    <td class="data-cell">{!! $sale->order_date ?? '11/03/2025' !!}</td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td class="data-cell">@if($sale->customer) {!! $sale->customer->address !!} @else Mitha Tawana @endif</td>
                    <td><strong>Invoice #:</strong></td>
                    <td class="data-cell">{!!  $sale->invoice_number ?? '250300242' !!}</td>
                </tr>
                 <tr>
                    <td><strong>Party NTN:</strong></td>
                    <td class="data-cell">{!! $sale->customer->ntn ?? '' !!}</td>
                     <td><strong>CNIC:</strong></td>
                     <td class="data-cell">{!! $sale->customer->cnic ?? '' !!}</td>
                </tr>
            </table>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>S#</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Batch#</th>
                    <th>QTY</th>
                    <th>R/Unit</th>
                    <th>Gross Price</th>
                    <th>T.Disc</th>
                    <th>S.Disc</th>
                    <th>S.D</th>
                    <th>T.P</th>
                    <th>Excl. S.Tax Amount</th>
                    <th>GST @18%</th>
                    <th>Incl. S.Tax Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $key => $item)
                    <tr>
                        <td>{!! $key + 1 !!}</td>
                        <td>@if($item->product) {!! $item->product->code !!} @endif</td>
                        <td>@if($item->product) {!! $item->product->description !!} @endif</td>
                        <td>@if($item->batch) {!! $item->batch->batch_code !!} @endif</td>
                        <td>{!! $item->quantity !!}</td>
                        <td>{!! $item->rate !!}</td>
                        <td>{!! $item->amount !!}</td>
                        <td>{!! $item->trade_discount !!}</td>
                        <td>{!! $item->special_discount !!}</td>
                        <td>{!! $item->scheme_discount !!}</td>
                        <td>{!! $item->trade_price !!}</td>
                        <td>{!! $item->excl_tax_amount !!}</td>
                        <td>{!! $item->tax_amount !!}</td>
                        <td>{!! $item->incl_tax_amount !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Total:</strong> {!! $sale->net_total - $sale->total_tax !!}</p>
            <p>Further Sales Tax @ 4.00 % Amount: {!! $sale->total_tax !!}</p>
            <p><strong>Total Incl. Tax:</strong> {!! $sale->net_total !!}</p>
            <p>Advance Tax @ 2.50 %: {{ number_format($sale->sub_total * 0.025, 2) }}</p>
            <p><strong>Net Total:</strong> {!! $sale->net_total !!}</p>
        </div>

        <div class="footer-block">
            <div class="rep-person">
                <strong>Rep Person:</strong> {!! $sale->salesRep->name !!}
            </div>
        
            <div class="footer-container">
                <table class="footer-info">
                    <tr>
                        <td><strong>Goods Name:</strong> NA</td>
                        <td><strong>Place:</strong> Mianwali</td>
                        <td><strong>Bilty No:</strong> NA</td>
                        <td><strong>Bilty Date:</strong> {!! $sale->order_date !!}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Courier/Registry Date:</strong> 08/01/2002</td>
                        <td><strong>Receipt No:</strong></td>
                        <td><strong>Cartons:</strong> 0 | <strong>Fare Rs.:</strong> 0</td>
                    </tr>
                </table>
            </div>

            <div class="footer-signatures">
                <table class="signature-table">
                    <tr>
                        <td><strong>Prepared By:</strong> Irsa</td>
                        <td><strong>Checked By:</strong> ______________________</td>
                    </tr>
                </table>
            </div>
        
            <div class="footer-images-full">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('footer-2.png'))) }}" alt="Footer Stamp">
            </div>
        </div>
        
        
    </div>
</body>
</html>