<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 18px;
            color: #666;
        }
        .content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .company-info, .customer-info {
            width: 45%;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .invoice-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th,
        .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-paid { background-color: #28a745; color: #fff; }
        .status-overdue { background-color: #dc3545; color: #fff; }
        .status-cancelled { background-color: #6c757d; color: #fff; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-number">#{{ $invoice->code }}</div>
    </div>

    <div class="content">
        <div class="company-info">
            <div class="section-title">From</div>
            <div class="info-item"><strong>FERP Controller</strong></div>
            <div class="info-item">Billing Department</div>
            <div class="info-item">Email: billing@ferpcontroller.com</div>
            <div class="info-item">Date: {{ $invoice->created_at->format('M d, Y') }}</div>
        </div>

        <div class="customer-info">
            <div class="section-title">Bill To</div>
            <div class="info-item"><strong>{{ $invoice->customer->name ?? 'N/A' }}</strong></div>
            <div class="info-item">{{ $invoice->customer->email ?? 'N/A' }}</div>
            <div class="info-item">Due Date: {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</div>
        </div>
    </div>

    <div class="invoice-details">
        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Subscription Plan</td>
                    <td>{{ $invoice->plan->name ?? 'No Plan' }}</td>
                    <td>
                        {{ number_format($invoice->amount, 2) }}
                        {{ $invoice->currency->currencyLanguages->first()?->symbol ?? $invoice->currency->getSymbol() ?? '$' }}
                    </td>
                    <td>
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-amount">
                Total: {{ number_format($invoice->amount, 2) }}
                {{ $invoice->currency->currencyLanguages->first()?->symbol ?? $invoice->currency->getSymbol() ?? '$' }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice. No signature required.</p>
        <p>Generated on {{ now()->format('M d, Y H:i:s') }}</p>
    </div>
</body>
</html>


