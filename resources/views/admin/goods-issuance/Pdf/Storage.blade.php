<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-right: 5px;
            margin-left: 5px;
        }
        th, td {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            /*text-align: center;*/
            font-size: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <table>
        <tr>
            <td style="border: none;text-align: right">
                <div style="width: 100% !important;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}"
                         style="height: 5rem;" alt="logo">
                </div>
            </td>
            <td style="border: none;text-align: left">
                <div style="width: 100%;">
                    <div class="header">Purchase Order (PO)</div>
                </div>

            </td>
        </tr>
    </table>
    <p><strong>GRN No:</strong>  </p>
    <p><strong>Date:</strong> </p>
    <p><strong>Supplier By:</strong> </p>
    <p><strong>Status :</strong>  </p>
    <div style="width: 90%;padding: 5px ">
        <table style="width: 100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @php $total=0;
            @endphp

            </tbody>
        </table>
        <p style="text-align: right"><strong>Total
                Amount:</strong>
        </p>
    </div>
</div>
</body>
</html>
