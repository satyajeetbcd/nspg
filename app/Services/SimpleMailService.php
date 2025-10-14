<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SimpleMailService
{
    /**
     * Send email with simple fallback
     */
    public function sendWithFallback($mailable, $to)
    {
        $lastError = null;
        
        // Try different SMTP configurations
        $smtpConfigs = [
            'primary' => [
                'host' => 'smtpout.secureserver.net',
                'port' => 587,
                'encryption' => 'tls',
                'timeout' => 10,
            ],
            'gmail' => [
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'encryption' => 'tls',
                'timeout' => 15,
            ],
            'outlook' => [
                'host' => 'smtp-mail.outlook.com',
                'port' => 587,
                'encryption' => 'tls',
                'timeout' => 15,
            ],
            'yahoo' => [
                'host' => 'smtp.mail.yahoo.com',
                'port' => 587,
                'encryption' => 'tls',
                'timeout' => 15,
            ],
        ];
        
        foreach ($smtpConfigs as $name => $config) {
            try {
                Log::info("Trying SMTP provider: {$name} ({$config['host']}:{$config['port']})");
                
                // Reset mail configuration completely
                Config::set([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $config['host'],
                    'mail.mailers.smtp.port' => $config['port'],
                    'mail.mailers.smtp.username' => config('mail.from.address'),
                    'mail.mailers.smtp.password' => config('mail.mailers.smtp.password'),
                    'mail.mailers.smtp.encryption' => $config['encryption'],
                    'mail.mailers.smtp.timeout' => $config['timeout'],
                ]);
                
                // Clear mail manager cache
                if (app()->bound('mail.manager')) {
                    app('mail.manager')->forgetMailers();
                }
                
                Mail::to($to)->send($mailable);
                
                Log::info("Email sent successfully using: {$name}");
                return true;
                
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                Log::warning("SMTP {$name} failed: {$lastError}");
            }
        }
        
        // Final fallback: Use log driver
        try {
            Log::info("All SMTP failed, using log driver as fallback");
            Config::set(['mail.default' => 'log']);
            Mail::to($to)->send($mailable);
            Log::info("Email logged successfully (log driver)");
            return true;
        } catch (\Exception $e) {
            Log::error("Even log driver failed: " . $e->getMessage());
            throw new \Exception("All email methods failed. Last error: {$lastError}");
        }
    }
}
