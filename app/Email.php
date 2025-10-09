<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Soundasleep\Html2Text;
use Illuminate\Support\Facades\Log;

trait Email
{
    protected $url = "https://api.mailjet.com/v3.1/send";
    protected $api_key;
    protected $secret_key;

    public function __construct()
    {
        $this->initializeEmailConfig();
    }

    // Load email configuration from environment variables

    protected function initializeEmailConfig()
    {
        $this->api_key = env('MAILJET_API_KEY');
        $this->secret_key = env('MAILJET_SECRET_KEY');
    }

    public function sendEmail($customer, $subject, $body)
    {
        // Ensure credentials are loaded
        if (!$this->api_key || !$this->secret_key) {
            $this->initializeEmailConfig();
        }

        // Validate credentials before attempting to send
        if (!$this->api_key || !$this->secret_key) {
            throw new \Exception('Mailjet API credentials are not configured. Please check MAILJET_API_KEY and MAILJET_SECRET_KEY in your .env file.');
        }

        // Convert HTML to plain text for TextPart
        $plain = Html2Text::convert($body);

        try {
            // Send via Mailjet API
            $response = Http::withBasicAuth($this->api_key, $this->secret_key)
                ->timeout(30)
                ->post($this->url, [
                    'Messages' => [[
                        'From' => [
                            'Email' => env('MAILJET_FROM'),
                            'Name'  => env('MAILJET_FROM_NAME'),
                        ],
                        'To' => [[
                            'Email' => $customer->email,
                            'Name'  => $customer->name,
                        ]],
                        'Subject'  => $subject,
                        'TextPart' => $plain,  // Plain text version
                        'HTMLPart' => $body,   // HTML version
                    ]]
                ]);

            if (!$response->successful()) {
                Log::error('Mailjet email sending failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'email' => $customer->email
                ]);
                throw new \Exception('Email sending failed: ' . $response->body());
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Email sending error: ' . $e->getMessage(), [
                'customer_email' => $customer->email,
                'subject' => $subject
            ]);
            throw $e;
        }
    }


    public function verificationTemplate($customer)
    {
        // Ensure we always use the full locale format (en-SA, ar-SA) for verification URLs
        $currentLocale = app()->getLocale();
        $fullLocale = $currentLocale;

        // Map short locales to full locales
        $localeMap = [
            'en' => 'en-SA',
            'ar' => 'ar-SA',
        ];

        if (isset($localeMap[$currentLocale])) {
            $fullLocale = $localeMap[$currentLocale];
        }

        $verificationUrl = URL::temporarySignedRoute(
            'public.verification.verify',
            Carbon::now()->addHours(24),
            [
                'locale' => $fullLocale,
                'id' => $customer->id,
                'hash' => sha1($customer->getEmailForVerification()),
            ]
        );

        return view('mail.verfication', [
            'user' => $customer,
            'verificationUrl' => $verificationUrl,
            'current_year' => date('Y'),
            'support_email' => 'support@' . str_replace(['https://', 'http://'], '', config('app.url')),
        ])->render();
    }
    public function welcomeEmailTemplate($customer)
    {
        return view('mail.welcome', [
            'user_name' => $customer->name,
            'workspace_name' => $customer->workspace_name ?? 'Your Workspace',
            'dashboard_url' => url('/dashboard'),
            'docs_url' => url('/docs'),
            'billing_url' => url('/billing'),
            'preferences_url' => url('/preferences'),
            'current_year' => date('Y'),
        ])->render();
    }


    public function subscriptionActivatedEmail($customer, $plan, $workspaceName)
    {
        $htmlBody = view('mail.subscription', [
            'user_name' => $customer->name,
            'plan_name' => $plan->name,
            'workspaceName' => $workspaceName,
            'start_date' => now()->format('Y-m-d'),
            'renewal_date' => $customer->plan_expire_date?->format('Y-m-d'),
            'amount' => $plan->user_price,
            'currency' => $plan->currency ?? 'USD',
            'billing_email' => $customer->email,
            'support_email' => 'support@' . str_replace('https://', '', config('app.url')),
            'current_year' => date('Y'),
        ])->render();

        return $this->sendEmail($customer, 'Your subscription is active', $htmlBody);
    }
}
