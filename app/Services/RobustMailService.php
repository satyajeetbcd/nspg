<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class RobustMailService
{
    protected $providers;
    protected $fallbackOrder;

    public function __construct()
    {
        $this->providers = config('mail_providers.providers', []);
        $this->fallbackOrder = config('mail_providers.fallback_order', ['primary']);
    }

    /**
     * Send email with automatic fallback
     */
    public function sendWithFallback($mailable, $to, $options = [])
    {
        $lastError = null;
        
        foreach ($this->fallbackOrder as $providerName) {
            if (!isset($this->providers[$providerName])) {
                continue;
            }
            
            try {
                $this->configureMailProvider($providerName);
                
                $provider = $this->providers[$providerName];
                Log::info("Attempting to send email using provider: {$providerName} (Host: {$provider['host']}:{$provider['port']})");
                
                Mail::to($to)->send($mailable);
                
                Log::info("Email sent successfully using provider: {$providerName}");
                return true;
                
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                Log::warning("Email sending failed with provider {$providerName}: {$lastError}");
                
                // If this is the last provider, try log driver as final fallback
                if ($providerName === end($this->fallbackOrder)) {
                    try {
                        Log::info("Trying log driver as final fallback");
                        Config::set('mail.default', 'log');
                        Mail::to($to)->send($mailable);
                        Log::info("Email logged successfully (log driver)");
                        return true;
                    } catch (\Exception $logException) {
                        Log::error("Even log driver failed: " . $logException->getMessage());
                    }
                }
            }
        }
        
        throw new \Exception("All email sending methods failed. Last error: {$lastError}");
    }

    /**
     * Configure mail provider
     */
    protected function configureMailProvider($providerName)
    {
        $provider = $this->providers[$providerName];
        
        // Clear any cached mail configuration
        Config::forget('mail.mailers.smtp');
        
        // Set fresh configuration
        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $provider['host'],
            'mail.mailers.smtp.port' => $provider['port'],
            'mail.mailers.smtp.username' => $provider['username'],
            'mail.mailers.smtp.password' => $provider['password'],
            'mail.mailers.smtp.encryption' => $provider['encryption'],
            'mail.mailers.smtp.timeout' => $provider['timeout'],
        ]);
        
        // Force Laravel to reload the mail configuration
        app('mail.manager')->forgetMailers();
    }

    /**
     * Test SMTP connection
     */
    public function testConnection($providerName = 'primary')
    {
        if (!isset($this->providers[$providerName])) {
            throw new \Exception("Provider {$providerName} not found");
        }

        try {
            $this->configureMailProvider($providerName);
            
            // Create a simple test mailable
            $testMailable = new \App\Mail\ContactFormMail([
                'name' => 'Test',
                'phone' => '1234567890',
                'email' => 'test@example.com',
                'message' => 'Connection test'
            ]);
            
            Mail::to(config('mail.from.address'))->send($testMailable);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Connection test failed for {$providerName}: " . $e->getMessage());
        }
    }
}
