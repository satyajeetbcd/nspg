<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Account Status Notification') }}</title>
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
        .status-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }
        .status-activated {
            background: #d4edda;
            color: #155724;
        }
        .status-deactivated {
            background: #f8d7da;
            color: #721c24;
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
        .reason-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }
        .reason-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 14px;
        }
        .reason-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
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
                @if($action === 'activated')
                    <p>{{ __('Great news! Your account has been activated and you now have full access to all features and services.') }}</p>
                @elseif($action === 'deactivated')
                    <p>{{ __('We are writing to inform you that your account has been deactivated.') }}</p>
                @endif
            </div>

            <div class="status-card">
                <div class="status-badge status-{{ $action }}">
                    @if($action === 'activated')
                        {{ __('Account Activated') }}
                    @elseif($action === 'deactivated')
                        {{ __('Account Deactivated') }}
                    @endif
                </div>
                
                @if($action === 'activated')
                    <h3 style="color: #28a745; margin: 0 0 10px 0;">{{ __('Welcome Back!') }}</h3>
                    <p style="margin: 0; color: #6c757d;">{{ __('Your account is now active and ready to use.') }}</p>
                @elseif($action === 'deactivated')
                    <h3 style="color: #dc3545; margin: 0 0 10px 0;">{{ __('Account Deactivated') }}</h3>
                    <p style="margin: 0; color: #6c757d;">{{ __('Your account access has been temporarily suspended.') }}</p>
                @endif
            </div>

            @if($reason)
                <div class="reason-box">
                    <h4>{{ __('Reason') }}:</h4>
                    <p>{{ $reason }}</p>
                </div>
            @endif

            <div class="message">
                @if($action === 'activated')
                    <p>{{ __('You can now log in to your account and enjoy all the features and services available to you. If you have any questions or need assistance, please don\'t hesitate to contact our support team.') }}</p>
                @elseif($action === 'deactivated')
                    <p>{{ __('If you believe this is an error or have any questions about your account status, please contact our support team immediately. We are here to help resolve any issues.') }}</p>
                @endif
            </div>

            @if($action === 'activated')
                <div style="text-align: center;">
                    <a href="{{ route('customer.dashboard', ['locale' => app()->getLocale()]) }}" class="action-button">
                        {{ __('Access Your Account') }}
                    </a>
                    
                    @if(isset($token))
                        <br><br>
                        <a href="{{ route('email.validate', ['token' => $token]) }}" 
                           style="display: inline-block; background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 500; margin-top: 10px;">
                            {{ __('Confirm Account Activation') }}
                        </a>
                    @endif
                </div>
            @else
                <div style="text-align: center;">
                    <a href="mailto:{{ config('mail.from.address') }}" class="action-button">
                        {{ __('Contact Support') }}
                    </a>
                    
                    @if(isset($token))
                        <br><br>
                        <a href="{{ route('email.validate', ['token' => $token]) }}" 
                           style="display: inline-block; background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 500; margin-top: 10px;">
                            {{ __('Confirm Account Deactivation') }}
                        </a>
                    @endif
                </div>
            @endif

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
