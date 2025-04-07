{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Invoice</title>--}}
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            margin: 0;--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .invoice-container {--}}
{{--            width: 800px;--}}
{{--            margin: auto;--}}
{{--            border: 1px solid #000;--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .header {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            align-items: center;--}}
{{--            border-bottom: 2px solid #000;--}}
{{--            padding-bottom: 20px;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .header img {--}}
{{--            height: 5rem;--}}
{{--        }--}}

{{--        .invoice-title {--}}
{{--            text-align: center;--}}
{{--            font-size: 24px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .invoice-details, .invoice-items {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .invoice-details td, .invoice-items th, .invoice-items td {--}}
{{--            border: 1px solid #000;--}}
{{--            padding: 8px;--}}
{{--            text-align: left;--}}
{{--        }--}}

{{--        .invoice-items th {--}}
{{--            background-color: #f2f2f2;--}}
{{--        }--}}

{{--        .total-section {--}}
{{--            text-align: right;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="invoice-container">--}}
{{--    <div class="header">--}}
{{--        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="logo">--}}
{{--        <div class="invoice-title">INVOICE</div>--}}
{{--    </div>--}}
{{--    <table class="invoice-details">--}}
{{--        <tr>--}}
{{--            <td><strong>Invoice No:</strong> #123456</td>--}}
{{--            <td><strong>Date:</strong> {{ date('Y-m-d') }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td><strong>Billed To:</strong> John Doe</td>--}}
{{--            <td><strong>Due Date:</strong> 2025-04-30</td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--    <table class="invoice-items">--}}
{{--        <tr>--}}
{{--            <th>Description</th>--}}
{{--            <th>Quantity</th>--}}
{{--            <th>Unit Price</th>--}}
{{--            <th>Total</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Product 1</td>--}}
{{--            <td>2</td>--}}
{{--            <td>$50.00</td>--}}
{{--            <td>$100.00</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Product 2</td>--}}
{{--            <td>1</td>--}}
{{--            <td>$30.00</td>--}}
{{--            <td>$30.00</td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--    <div class="total-section">--}}
{{--        <p>Subtotal: $130.00</p>--}}
{{--        <p>Tax (10%): $13.00</p>--}}
{{--        <p><strong>Total: $143.00</strong></p>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-weight: bold;
        }

        .sub-header, .invoice-info, .summary {
            margin-bottom: 10px;
        }

        .sub-header, .invoice-info {
            display: flex;
            justify-content: space-between;
        }

        .invoice-info td {
            padding: 3px 6px;
        }

        .table, .totals, .footer-info {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td, .totals td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .footer-info td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .footer-note {
            text-align: right;
            font-style: italic;
        }

        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .warranty {
            font-size: 11px;
            margin-top: 10px;
        }

        .bottom-section {
            margin-top: 20px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .logo {
            float: right;
        }

        .stamp-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .stamp-icons img {
            width: 50px;
            height: auto;
        }

    </style>
</head>
<body>

<div class="header">
    <div style="position: relative; text-align: center;">
        <h2 style="margin: 0;">Lasani Pharma Private Limited</h2>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}"
             alt="logo" width="100px"
             style="position: absolute; top: 0; right: 0;">
    </div>

    <div>Manawan Post Office Batapur, Lahore-Pakistan | Phone: 042-37188887, 37188888, Mobile: 0300-0724101</div>
    <div>NTN: 1129483-3 | STRN: DRAP E No. 00873</div>
</div>

<div class="invoice-info">
    <div>
        <p><strong>Customer Code:</strong> </p>
        <p><strong>Customer Name:</strong> @if($sale->customer) {!! $sale->customer->name !!} @endif</p>
        <p><strong>Address:</strong>@if($sale->customer) {!! $sale->customer->address !!} @endif</p>
    </div>
    <div>
        <p><strong>Order #:</strong> {!! $sale->order_number !!}</p>
        <p><strong>Date:</strong> {!! $sale->order_date !!}</p>
        <p><strong>Invoice #:</strong> {!! $sale->order_date !!}</p>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th>S.#</th>
        <th>Item Code</th>
        <th>Description</th>
        <th>Batch#</th>
        <th>QTY</th>
        <th>Retail Price</th>
        <th>Gross Retail Price</th>
        <th>T.Disc</th>
{{--        <th>S.Disc</th>--}}
{{--        <th>S.S.D.</th>--}}
{{--        <th>T.P</th>--}}
{{--        <th>Excl. S.Tax</th>--}}
        <th>GST 18%</th>
        <th>Incl. S.Tax</th>
    </tr>
    </thead>
    <tbody>
  @foreach($sale->items as $key=>$item)
    <tr>
        <td>{!! $key !!}</td>
        <td>@if($item->product) {!! $item->product->name !!} @endif</td>
        <td>@if($item->product) {!! $item->product->description !!} @endif</td>
        <td>@if($item->batch) {!! $item->batch->batch_code !!} @endif</td>
        <td>{!! $item->quantity !!}</td>
        <td>{!! $item->rate !!}</td>
        <td>{!! $item->amount !!}</td>
        <td>{!! $item->discount_amount !!}</td>
        <td>{!! $item->discount_amount !!}</td>
        <td>{!! $item->tax_amount !!}</td>
{{--        <td>508.47</td>--}}
{{--        <td>1,017</td>--}}
{{--        <td>183</td>--}}
{{--        <td>1,200</td>--}}
    </tr>
  @endforeach
    </tbody>
</table>

<br>

<table class="totals">
    <tr>
        <td style="text-align: right;" colspan="13"><strong>Total:</strong></td>
        <td>{!! $sale->net_total-$sale->total_tax !!}</td>
    </tr>
    <tr>
        <td style="text-align: right;" colspan="13">Further Sales Tax @ 4.00 % Amount:</td>
        <td>{!! $sale->total_tax !!}</td>
    </tr>
    <tr>
        <td style="text-align: right;" colspan="13"><strong>Total Incl. Tax:</strong></td>
        <td>{!! $sale->net_total !!}</td>
    </tr>
    <tr>
        <td style="text-align: right;" colspan="13">Advance Tax @ 2.50 %:</td>
        <td>{{ number_format($sale->sub_total * 0.025, 2) }}</td>
    </tr>
    <tr>
        <td style="text-align: right;" colspan="13"><strong>Net Total:</strong></td>
        <td><strong>{!! $sale->net_total !!}</strong></td>
    </tr>
</table>

<br>

<div><strong>Rep Person:</strong> {!! $sale->salesRep->name !!}
{{--    ({!!  $sale->salesRep->name !!})--}}
</div>

<div class="footer-note">
{{--    <div style="font-family: 'Noto Nastaliq Urdu', serif; direction: rtl; text-align: right;">--}}
{{--        نوٹ:- تبدیلی کے ادائیگی کرنے پر کمپنی ذمہ دار نہ ہو گی۔--}}
{{--    </div>--}}

</div>

<br>

<table class="footer-info">
    <tr>
        <td><strong>Goods Name:</strong> NA</td>
        <td><strong>Place:</strong> Mianwali</td>
        <td><strong>Bilty No:</strong> NA</td>
        <td><strong>Bilty Date:</strong> 11/03/2025</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Courier/Registry Date:</strong> 08/01/2002</td>
        <td><strong>Recept No:</strong></td>
        <td><strong>Cartons:</strong> 0 | <strong>Fare Rs.:</strong> 0</td>
    </tr>
</table>

<br>

<div class="warranty">
    <p><strong>General Warranty</strong><br>
        I declare that the goods manufactured and sold by Lasani Pharma Private Limited are pure unani (Herbal) product and manufactured according to unani (Herbal) system of medicine. That the drugs here described in this invoice do not contravene in anyway the provision section 23 drap act 2012.</p>
    <p>Email: info@lasaniindustries.com</p>
</div>

<div class="signatures">
    <div><strong>Prepared By:</strong> Irsa</div>
    <div><strong>Checked By:</strong> It is system generated document. It does not require signatures</div>
</div>

{{--<div class="stamp-icons">--}}
{{--    <img src="https://i.imgur.com/qMEIEsV.png" alt="ISO Mark">--}}
{{--    <img src="https://i.imgur.com/yQ6YtOp.png" alt="GMP Certified">--}}
{{--    <img src="https://i.imgur.com/SY0GqBa.png" alt="HALAL">--}}
{{--</div>--}}

</body>
</html>
