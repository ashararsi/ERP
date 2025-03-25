<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmaceutical Invoice - Lasani Pharma</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            border: 1px solid #e0e0e0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .company-logo {
            max-width: 180px;
            height: auto;
        }
        .invoice-title {
            color: #0066cc;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .invoice-meta {
            text-align: right;
        }
        .invoice-number {
            font-weight: bold;
            color: #0066cc;
        }
        .client-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f5f9ff;
            border-radius: 5px;
        }
        .client-address {
            line-height: 1.6;
        }
        .rep-info {
            text-align: right;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table th {
            background-color: #0066cc;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 500;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-section {
            background-color: #f5f9ff;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #0066cc;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
        .pharma-stamp {
            float: right;
            margin-top: 20px;
            text-align: center;
            font-style: italic;
        }
        .batch-expiry {
            font-size: 12px;
            color: #666;
        }
        .regulatory-info {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="invoice-container">

    <!-- Header Section -->
    <div class="header">
        <div>
            <!-- Replace with actual logo image -->
            <div style="font-size: 24px; font-weight: bold; color: #0066cc;">LASANI PHARMA</div>
            <p style="margin: 5px 0; color: #555;">Manawan, Lahore, Pakistan</p>
            <p style="margin: 5px 0; color: #555;">Phone: 047-37188887 | NTN: 123456789</p>
            <p style="margin: 5px 0; color: #555;">STRN: 987654321 | License #: PHARM-12345</p>
        </div>
        <div class="invoice-meta">
            <h1 class="invoice-title">TAX INVOICE</h1>
            <p><strong>Date:</strong> March 11, 2025</p>
            <p><strong>Invoice #:</strong> <span class="invoice-number">250900242</span></p>
            <p><strong>Order #:</strong> 24-10486</p>
        </div>
    </div>

    <!-- Client Information -->
    <div class="client-info">
        <div class="client-address">
            <h3 style="margin: 0 0 10px 0; color: #0066cc;">BILL TO:</h3>
            <strong>AHSAAN MEDICAL STORE</strong><br>
            Mitha Tawana, Lahore<br>
            <strong>NTN:</strong> 1122334455<br>
            <strong>STRN:</strong> 5544332211<br>
            <strong>Contact:</strong> 0300-1234567
        </div>
        <div class="rep-info">
            <h3 style="margin: 0 0 10px 0; color: #0066cc;">SALES REP:</h3>
            Muhammad Imran<br>
            0346-5503099<br><br>

            <strong>Payment Terms:</strong> 15 Days<br>
            <strong>Due Date:</strong> March 26, 2025
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Item Code</th>
            <th>Description</th>
            <th>Batch/Expiry</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>029</td>
            <td>
                LASANI JOSHANDA MULATHI 150gm<br>
                <span class="regulatory-info">Registration #: DRAP-2025-123 | MFG: 01/2025</span>
            </td>
            <td>
                <span class="batch-expiry">B: 029.016</span><br>
                <span class="batch-expiry">E: 12/2026</span>
            </td>
            <td>2</td>
            <td>750.00</td>
            <td>1,500.00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>045</td>
            <td>
                LASANI MARHAM 15gm<br>
                <span class="regulatory-info">Registration #: DRAP-2025-456 | MFG: 02/2025</span>
            </td>
            <td>
                <span class="batch-expiry">B: 045.112</span><br>
                <span class="batch-expiry">E: 06/2027</span>
            </td>
            <td>5</td>
            <td>150.00</td>
            <td>750.00</td>
        </tr>
        </tbody>
    </table>

    <!-- Totals Section -->
    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>2,250.00</span>
        </div>
        <div class="total-row">
            <span>Trade Discount (10%):</span>
            <span>-225.00</span>
        </div>
        <div class="total-row">
            <span>Taxable Amount:</span>
            <span>2,025.00</span>
        </div>
        <div class="total-row">
            <span>Sales Tax (17%):</span>
            <span>344.25</span>
        </div>
        <div class="total-row">
            <span>Further Tax (4%):</span>
            <span>81.00</span>
        </div>
        <div class="total-row grand-total">
            <span>Total Amount:</span>
            <span>2,450.25</span>
        </div>
        <div class="total-row">
            <span>Advance Tax (2.5%):</span>
            <span>61.26</span>
        </div>
        <div class="total-row grand-total">
            <span>Net Payable:</span>
            <span>2,511.51</span>
        </div>
    </div>

    <!-- Payment Information -->
    <div style="margin-top: 20px; font-size: 14px;">
        <strong>Payment Instructions:</strong> Please make payment via bank transfer to:<br>
        Lasani Pharma Pvt Ltd, Bank: Allied Bank Limited, Account #: 123456789,<br>
        IBAN: PK36ABPL0000000123456789
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice and does not require a signature.</p>
        <p>For any queries, please contact accounts@lasanipharma.com or call 047-37188887</p>

        <div class="pharma-stamp">
            [Company Stamp Area]<br>
            Authorized Signature
        </div>
        <div style="clear: both;"></div>
    </div>

</div>

</body>
</html>
