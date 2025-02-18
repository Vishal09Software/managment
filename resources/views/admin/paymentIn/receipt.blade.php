<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .customer-details, .payment-details {
            flex: 1;
        }

        .payment-details {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
        }

        .text-end {
            text-align: right;
        }

        .remarks {
            margin: 20px 0;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h2>Payment Receipt</h2>
            <button onclick="window.print()" class="print-button">Print</button>
        </div>

        <div class="details-section">
            <div class="customer-details">
                <h4>Customer Details:</h4>
                <p><strong>Name:</strong> {{ $payment->customer->name ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $payment->customer->mobile ?? 'N/A' }}</p>
            </div>
            <div class="payment-details">
                <h4>Payment Details:</h4>
                <p><strong>Receipt No:</strong> #{{ $payment->reference_no }}</p>
                <p><strong>Date:</strong> {{ date('d M Y', strtotime($payment->payment_date)) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSales = App\Models\Sale::where('customer_id', $payment->customer_id)->sum('s_total');
                    $totalPayments = App\Models\PaymentIn::where('customer_id', $payment->customer_id)->sum('amount');
                    $remainingAmount = $totalSales - $totalPayments;
                @endphp
                <tr>
                    <td>Total Amount</td>
                    <td class="text-end">{{ number_format($totalSales, 2) }}</td>
                </tr>
                <tr>
                    <td>Payment Amount</td>
                    <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Remaining Balance</td>
                    <td class="text-end">{{ number_format($remainingAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        @if($payment->remarks)
        <div class="remarks">
            <h5>Remarks:</h5>
            <p>{{ $payment->remarks }}</p>
        </div>
        @endif

        <div class="signatures">
            <div>
                <div class="signature-line">Customer Signature</div>
            </div>
            <div>
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>
    </div>
</body>
</html>
