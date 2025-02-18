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
            padding: 0;
            font-size: 14px;
        }

        .invoice-container {
            width: 100%;
            min-height: auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        header {
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-info h1 {
            color: #000;
            margin: 0 0 8px 0;
            font-size: 20px;
        }

        .company-info p {
            margin: 4px 0;
            color: #000;
        }

        .tax-invoice {
            color: #7360f2;
            text-align: center;
            padding: 12px 0;
            margin: 15px 0;
            border-top: 1px solid #ccc;
            font-size: 18px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .bill-to h3, .invoice-info h3 {
            color: #000;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .bill-to p, .invoice-info p {
            margin: 6px 0;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 170px;
        }

        th {
            background: #7360f2;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
            color: #000;
        }

        .total-row td {
            font-weight: bold;
            background: #f8f9fa;
        }

        .thank-you {
            width: 60%;
        }

        .thank-you p {
            margin: 8px 0;
            color: #000;
        }

        .amount-details table {
            width: 100%;
            margin-top: 0;
        }

        .amount-details td {
            padding: 8px;
            border: none;
        }

        .amount-details tr.total-row {
            background-color: #7360f2;
            color: white;
        }

        .amount-details tr.total-row td {
            font-weight: bold;
        }

        .pay-to {
            margin-top: 30px;
        }

        .pay-to h3 {
            color: #000;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .pay-to p {
            margin: 6px 0;
            color: #000;
        }

        .signature {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 180px;
            text-align: center;
            margin-left: auto;
            padding-top: 8px;
            color: #333;
            font-size: 14px;
        }

        @media print {
            body {
                background: none;
            }
            .invoice-container {
                width: 100%;
                margin: 0;
                padding: 15px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <header>
            <div class="company-info">
                <h1>{{ $company->business_name ?? '' }}</h1>
                <p>{{ $company->business_address ?? '' }}</p>
                <p>Phone: {{ $company->business_phone ?? '' }}</p>
                <p>Email: {{ $company->business_email ?? '' }}</p>
                <p>GSTIN: {{ $company->gst_number ?? '' }}</p>
            </div>
            <h2 class="tax-invoice">Tax Invoice</h2>
        </header>

        <!-- Invoice Details -->
        <section class="invoice-details">
            <div class="bill-to" style="float: left; width: 50%;">
                <h3>Bill To</h3>
                <p><strong>{{ $sale->customer_name ?? '' }}</strong></p>
                <p>Mobile: {{ $sale->customer_mobile ?? '' }}</p>
                <p>GSTIN: {{ $sale->customer->gst_number ?? '' }}</p>
                <p>Address: {{ $sale->customer->address ?? '' }}</p>

            </div>
            <div class="invoice-info" style="float: right; width: 50%; text-align: right;">
                <h3>Invoice Details</h3>
                <p><strong>Invoice No.:</strong> {{ $sale->invoice_number ?? '' }}</p>
                <p><strong>Date:</strong> {{ date('d-m-Y', strtotime($payment->payment_date ?? $sale->date)) }}</p>
                <p><strong>Supply Place:</strong> {{ $sale->supply_place ?? '' }}</p>
            </div>
        </section>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>HSN/SAC</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Price/Unit</th>
                    <th>GST</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $sale->product->name ?? '' }} ({{ $sale->eway_bill_number ?? '' }})</td>
                    <td>{{ $sale->product->hsn_code ?? '' }}</td>
                    <td>{{ $sale->k_weight ?? '' }}</td>
                    <td>Ton</td>
                    <td> {{ number_format($sale->s_price ?? 0, 0) }} Rs.</td>
                    <td>{{ $sale->tax_rate ?? 0 }}%</td>
                    <td> {{ number_format($sale->s_total ?? 0, 0) }} Rs.</td>
                </tr>
                <tr class="total-row">
                    <td colspan="7">Total</td>
                    <td> {{ number_format($sale->s_total, 0) }} Rs.</td>
                </tr>
            </tbody>
        </table>

        @php
            $subTotal = $sale->k_weight * $sale->s_price;
            $taxAmount = ($subTotal * $sale->tax_rate) / 100;
            $halfTaxAmount = $taxAmount / 2;
            $totalAmount = $subTotal + $taxAmount;
        @endphp

        <!-- Amount Section -->
        <section class="amount-summary" style="margin-top: 20px;">
            <div class="thank-you" style="float: left; width: 50%;">
                <p><strong>Invoice Amount In Words</strong></p>
                <p>{{ ucwords(\NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format(round($totalAmount))) }} Rupees only</p>
                <p><strong>Terms And Conditions</strong></p>
                <p>Thank you for doing business with us.</p>
            </div>
            <div class="amount-details" style="float: right; width: 50%;">
                <table>
                    <tr>
                        <td>Sub Total:</td>
                        <td style="text-align: right;"> {{ number_format($sale->k_weight * $sale->s_price, 0) }}Rs.</td>
                    </tr>
                    <tr>
                        <td>SGST @ {{ number_format($sale->tax_rate/2, 1) }}%:</td>
                        <td style="text-align: right;"> {{ number_format($halfTaxAmount, 0) }} Rs.</td>
                    </tr>
                    <tr>
                        <td>CGST @ {{ number_format($sale->tax_rate/2, 1) }}%:</td>
                        <td style="text-align: right;"> {{ number_format($halfTaxAmount, 0) }} Rs.</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Total:</strong></td>
                        <td style="text-align: right;"><strong> {{ number_format($totalAmount, 0) }} Rs.</strong></td>
                    </tr>
                    <tr>
                        <td>Received:</td>
                        <td style="text-align: right;"> {{ number_format($payment->amount ?? 0, 0) }} Rs.</td>
                    </tr>
                    <tr>
                        <td>Balance:</td>
                        <td style="text-align: right;"> {{ number_format($totalAmount - ($payment->amount ?? 0), 0) }} Rs.</td>
                    </tr>
                </table>
            </div>
        </section>

        <!-- Bank & Payment Details -->
        <section style="margin-top: 50px; clear: both;">
            <div class="pay-to" style="float: left; width: 50%;">
                <h3>Pay To:</h3>
                <p><strong>Bank Name:</strong> {{ $company->bank_name }}</p>
                <p><strong>Account No.:</strong> {{ $company->account_no }}</p>
                <p><strong>IFSC Code:</strong> {{ $company->ifsc_code }}</p>
                <p><strong>Account Holder Name:</strong> {{ $company->account_holder_name }}</p>
            </div>
            <div style="float: right; width: 50%; text-align: right; margin-top: 80px;">
                <p>For: {{ $company->account_holder_name ?? '' }}</p>
                <p class="signature">Authorized Signatory</p>
            </div>
        </section>
    </div>
</body>
</html>
