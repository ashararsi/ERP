<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            width: 800px;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .header img {
            height: 5rem;
        }

        .invoice-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .invoice-details, .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-details td, .invoice-items th, .invoice-items td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .invoice-items th {
            background-color: #f2f2f2;
        }

        .total-section {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <div class="header">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" alt="logo">
        <div class="invoice-title">INVOICE</div>
    </div>
    <table class="invoice-details">
        <tr>
            <td><strong>Invoice No:</strong> #123456</td>
            <td><strong>Date:</strong> {{ date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>Billed To:</strong> John Doe</td>
            <td><strong>Due Date:</strong> 2025-04-30</td>
        </tr>
    </table>
    <table class="invoice-items">
        <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>Product 1</td>
            <td>2</td>
            <td>$50.00</td>
            <td>$100.00</td>
        </tr>
        <tr>
            <td>Product 2</td>
            <td>1</td>
            <td>$30.00</td>
            <td>$30.00</td>
        </tr>
    </table>
    <div class="total-section">
        <p>Subtotal: $130.00</p>
        <p>Tax (10%): $13.00</p>
        <p><strong>Total: $143.00</strong></p>
    </div>
</div>
</body>
</html>
