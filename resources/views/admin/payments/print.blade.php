<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0;
            margin: 0;
            color: #333;
            background-color: #f9f9f9;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            border: 1px solid #e1e1e1;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4a6fdc;
        }
        .logo {
            max-width: 180px;
            max-height: 80px;
        }
        h1 {
            color: #4a6fdc;
            font-size: 28px;
            margin: 0;
            padding: 0;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            margin: 0;
            color: #555;
            font-size: 18px;
        }
        .invoice-title p {
            margin: 5px 0 0;
            color: #777;
        }
        table {
            width: 100%;
            line-height: 1.6;
            border-collapse: collapse;
            margin: 30px 0;
        }
        table th {
            background: #4a6fdc;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 500;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .total-row td {
            font-weight: bold;
            background: #f8f9fa;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .status-completed {
            background: #28a745;
            color: white;
        }
        .status-pending {
            background: #ffc107;
            color: #333;
        }
        .status-failed {
            background: #dc3545;
            color: white;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #777;
            font-size: 14px;
        }
        @media print {
            body {
                background: none;
            }
            .invoice-box {
                border: none;
                box-shadow: none;
                padding: 0;
                margin: 0;
                width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>Payment Invoice</h1>
                <p>Issued: {{ now()->format('M d, Y') }}</p>
            </div>
            <div class="invoice-title">
                <h2>Invoice #{{ $payment->id }}</h2>
                <p>Transaction ID: {{ $payment->transaction_id }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>User</td>
                    <td>{{ $payment->user->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Course</td>
                    <td>{{ $payment->course->title ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <span class="status status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Paid At</td>
                    <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : '-' }}</td>
                </tr>
                @if($payment->notes)
                <tr>
                    <td>Notes</td>
                    <td>{{ $payment->notes }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>For any questions, please contact support@example.com</p>
            <p class="no-print">This document will automatically print. If it doesn't, use your browser's print function.</p>
        </div>
    </div>
</body>
</html>