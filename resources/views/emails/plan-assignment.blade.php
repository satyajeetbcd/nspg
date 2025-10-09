<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Plan Assignment Notification') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .message {
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.8;
        }
        .plan-details {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .plan-name {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .plan-description {
            color: #6c757d;
            margin-bottom: 15px;
        }
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .plan-features li {
            padding: 5px 0;
            color: #495057;
        }
        .plan-features li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }
        .action-button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-assigned {
            background: #d4edda;
            color: #155724;
        }
        .status-upgraded {
            background: #cce5ff;
            color: #004085;
        }
        .status-downgraded {
            background: #fff3cd;
            color: #856404;
        }
        .status-removed {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                {{ __('Hello') }} {{ $customer->name }},
            </div>
            
            <div class="message">
                @if($action === 'assigned')
                    <p>{{ __('We are pleased to inform you that a new plan has been assigned to your account.') }}</p>
                @elseif($action === 'upgraded')
                    <p>{{ __('Great news! Your plan has been upgraded to provide you with more features and benefits.') }}</p>
                @elseif($action === 'downgraded')
                    <p>{{ __('Your plan has been changed. Please review the new plan details below.') }}</p>
                @elseif($action === 'removed')
                    <p>{{ __('We are writing to inform you that your current plan has been removed from your account.') }}</p>
                @endif
            </div>

            @if($plan && $action !== 'removed')
                <div class="plan-details">
                    <div class="status-badge status-{{ $action }}">
                        @if($action === 'assigned')
                            {{ __('New Plan Assigned') }}
                        @elseif($action === 'upgraded')
                            {{ __('Plan Upgraded') }}
                        @elseif($action === 'downgraded')
                            {{ __('Plan Changed') }}
                        @endif
                    </div>
                    
                    <div class="plan-name">{{ $plan->name ?? 'Plan #' . $plan->id }}</div>
                    
                    @if($plan->description)
                        <div class="plan-description">{{ $plan->description }}</div>
                    @endif
                    
                    @if($plan->duration)
                        <p><strong>{{ __('Duration') }}:</strong> {{ ucfirst($plan->duration) }}</p>
                    @endif
                    
                    @if($plan->max_users)
                        <p><strong>{{ __('Maximum Users') }}:</strong> {{ $plan->max_users }}</p>
                    @endif
                    
                    @if($plan->features && $plan->features->count() > 0)
                        <h4>{{ __('Plan Features') }}:</h4>
                        <ul class="plan-features">
                            @foreach($plan->features as $feature)
                                <li>{{ $feature->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if($action === 'removed')
                <div class="plan-details">
                    <div class="status-badge status-removed">
                        {{ __('Plan Removed') }}
                    </div>
                    <p>{{ __('Your account no longer has an active plan. Please contact our support team if you have any questions or would like to discuss plan options.') }}</p>
                </div>
            @endif

            <div class="message">
                @if($action !== 'removed')
                    <p>{{ __('You can now access all the features included in your new plan. If you have any questions or need assistance, please don\'t hesitate to contact our support team.') }}</p>
                @else
                    <p>{{ __('If you have any questions about this change or would like to discuss plan options, please contact our support team.') }}</p>
                @endif
            </div>

            <div style="text-align: center;">
                <a href="{{ route('customer.dashboard', ['locale' => app()->getLocale()]) }}" class="action-button">
                    {{ __('Access Your Account') }}
                </a>
                
                @if(isset($token))
                    <br><br>
                    <a href="{{ route('email.validate', ['token' => $token]) }}" 
                       style="display: inline-block; background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 500; margin-top: 10px;">
                        {{ __('Confirm This Action') }}
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
        </div>
        
        <div class="footer">
            <p>{{ __('Thank you for choosing') }} {{ config('app.name') }}!</p>
            <p>
                {{ __('If you have any questions, please contact us at') }} 
                <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
            </p>
            <p style="margin-top: 20px; font-size: 12px; color: #adb5bd;">
                {{ __('This email was sent to') }} {{ $customer->email }}. 
                {{ __('If you did not expect this email, please ignore it.') }}
            </p>
        </div>
    </div>
</body>
</html>
