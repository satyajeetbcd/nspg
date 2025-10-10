<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
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
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }
        .field-label {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 5px;
        }
        .field-value {
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
        <p>NSPG Solar - Contact Form</p>
    </div>
    
    <div class="content">
        <p>You have received a new contact form submission from your website. Here are the details:</p>
        
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $contactData['name'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Phone Number:</div>
            <div class="field-value">{{ $contactData['phone'] }}</div>
        </div>
        
        @if(!empty($contactData['email']))
        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $contactData['email'] }}</div>
        </div>
        @endif
        
        @if(!empty($contactData['system_capacity']))
        <div class="field">
            <div class="field-label">Solar System Capacity:</div>
            <div class="field-value">{{ $contactData['system_capacity'] }}</div>
        </div>
        @endif
        
        @if(!empty($contactData['address']))
        <div class="field">
            <div class="field-label">Address:</div>
            <div class="field-value">{{ $contactData['address'] }}</div>
        </div>
        @endif
        
        @if(!empty($contactData['services']) && count($contactData['services']) > 0)
        <div class="field">
            <div class="field-label">Services Required:</div>
            <div class="field-value">{{ implode(', ', $contactData['services']) }}</div>
        </div>
        @endif
        
        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value">{{ $contactData['message'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Submitted At:</div>
            <div class="field-value">{{ now()->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This email was sent from your NSPG Solar website contact form.</p>
        <p>Please respond to the customer as soon as possible.</p>
    </div>
</body>
</html>
