<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .invoice-details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-paid { background-color: #28a745; color: #fff; }
        .status-overdue { background-color: #dc3545; color: #fff; }
        .status-cancelled { background-color: #6c757d; color: #fff; }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice Notification</h1>
        <p>Invoice #{{ $invoice->code }}</p>
    </div>

    <div class="content">
        <h2>Hello {{ $customer->name }},</h2>
        
        <p>This is to inform you that a new invoice has been generated for your account.</p>

        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Invoice Number:</strong> #{{ $invoice->code }}</p>
            <p><strong>Plan:</strong> {{ $plan->name ?? 'No Plan' }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</p>
            <p><strong>Status:</strong> 
                <span class="status-badge status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
        </div>

        <div class="amount">
            {{ number_format($invoice->amount, 2) }}
            {{ $currency->currencyLanguages->first()?->symbol ?? $currency->getSymbol() ?? '$' }}
        </div>

        <p>Please review the invoice details and ensure payment is made by the due date to avoid any service interruptions.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('customer.invoices.show', ['locale' => app()->getLocale(), 'invoice' => $invoice]) }}" class="button">
                View Invoice
            </a>
            <a href="{{ route('customer.payment.create', ['locale' => app()->getLocale(), 'invoice' => $invoice]) }}" class="button">
                Pay Now
            </a>
            
            @if(isset($token))
                <br><br>
                <a href="{{ route('email.validate', ['token' => $token]) }}" 
                   style="display: inline-block; background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 500; margin-top: 10px;">
                    {{ __('Confirm Invoice Notification') }}
                </a>
            @endif
        </div>

        @if(isset($token) && isset($expires_at))
            <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 6px; border-left: 4px solid #2196f3;">
                <h4 style="margin: 0 0 10px 0; color: #1976d2; font-size: 14px;">{{ __('Secure Link Information') }}</h4>
                <p style="margin: 0; font-size: 13px; color: #424242;">
                    {{ __('This email contains a secure link that will expire on') }} 
                    <strong>{{ $expires_at->format('M d, Y \a\t H:i') }}</strong>.
                    {{ __('This is attempt') }} <strong>{{ $attempt_count }}</strong> {{ __('of 2 allowed attempts.') }}
                </p>
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">
                    {{ __('Link Token') }}: <code style="background: #f5f5f5; padding: 2px 4px; border-radius: 3px;">{{ substr($token, 0, 16) }}...</code>
                </p>
            </div>
        @endif

        <p>If you have any questions about this invoice, please don't hesitate to contact our support team.</p>

        <p>Thank you for your business!</p>

        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>

