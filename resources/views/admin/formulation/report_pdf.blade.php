<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formula Report</title>
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
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
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
                    <div class="header">Formula Report</div>
                </div>
            </td>
        </tr>
    </table>

    <h3>Formula Name: {{ $f->formula_name }}</h3>
    <p><strong>Description:</strong> {{ $f->description }}</p>

    <div style="width: 90%; padding: 5px;">
        <table style="width: 100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Raw Material</th>
                <th>Unit</th>
                <th>Standard Quantity</th>
                <th>Actual Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($f->formulationDetail as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->RawMaterial->name }}</td>
                    <td>@if($item->unit)   {{ $item->unit->name }} @endif</td>
                    <td>{{ number_format($item->standard_quantity, 2) }}</td>
                    <td>{{ number_format($item->actual_quantity ?? 0, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
