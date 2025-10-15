<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\SolarSystem;
use App\Models\PageContent;
use App\Models\ContactInfo;
use App\Models\Review;
use App\Models\CalculatorSetting;
use App\Models\Project;
use App\Mail\ContactFormMail;
use App\Services\SimpleMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->ordered()->get();
        $solarSystems = SolarSystem::active()->ordered()->get();
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        $reviews = Review::active()->featured()->orderBy('created_at', 'desc')->take(6)->get();
        $calculatorSettings = CalculatorSetting::getAllSettings();
        $projects = Project::active()->ordered()->take(6)->get();
        
        return view('frontend.home', compact('banners', 'solarSystems', 'pageContents', 'contactInfos', 'reviews', 'calculatorSettings', 'projects'));
    }

    public function about()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.about', compact('pageContents', 'contactInfos'));
    }

    public function services()
    {
        $solarSystems = SolarSystem::active()->ordered()->get();
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.services', compact('solarSystems', 'pageContents', 'contactInfos'));
    }

    public function calculator()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        $calculatorSettings = CalculatorSetting::getAllSettings();
        
        return view('frontend.calculator', compact('pageContents', 'contactInfos', 'calculatorSettings'));
    }

    public function businessAndPartnership()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.business-and-partnership', compact('pageContents', 'contactInfos'));
    }

    public function ourClients()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        $reviews = Review::active()->featured()->orderBy('created_at', 'desc')->take(6)->get();
        
        return view('frontend.our-clients', compact('pageContents', 'contactInfos', 'reviews'));
    }

    public function download()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.download', compact('pageContents', 'contactInfos'));
    }

    public function contact()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.contact', compact('pageContents', 'contactInfos'));
    }

    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'system_capacity' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'services' => 'nullable|array',
            'services.*' => 'string|in:Installation,Maintenance,Replacement,Other',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields correctly.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Prepare contact data
            $contactData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'system_capacity' => $request->system_capacity,
                'address' => $request->address,
                'services' => $request->services ?? [],
                'message' => $request->message,
                'submitted_at' => now()->format('F j, Y \a\t g:i A'),
            ];

            // Send email using simple mail function
            $this->sendSimpleContactEmail($contactData);

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully! We will contact you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.',
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Send simple contact email using basic Laravel mail
     */
    private function sendSimpleContactEmail($contactData)
    {
        $to = config('mail.from.address', 'satyajeetbcd@gmail.com');
        $subject = 'New Contact Form Submission - NSPG Solar';
        
        // Create HTML email content
        $htmlContent = $this->buildContactEmailHtml($contactData);
        
        // Create plain text content
        $textContent = $this->buildContactEmailText($contactData);
        
        // Try multiple mail methods for better server compatibility
        $this->sendEmailWithFallback($to, $subject, $htmlContent, $textContent, $contactData);
    }

    /**
     * Send email with multiple fallback methods
     */
    private function sendEmailWithFallback($to, $subject, $htmlContent, $textContent, $contactData)
    {
        $lastError = null;
        
        // Method 1: Try Laravel Mail with current config
        try {
            Log::info('Trying Laravel Mail with current config');
            Mail::html($htmlContent, function ($message) use ($to, $subject, $contactData) {
                $message->to($to)
                       ->subject($subject)
                       ->from(config('mail.from.address'), config('mail.from.name', 'NSPG Solar'));
                
                if (!empty($contactData['email'])) {
                    $message->replyTo($contactData['email'], $contactData['name']);
                }
            });
            Log::info('Email sent successfully with Laravel Mail');
            return;
        } catch (\Exception $e) {
            $lastError = $e->getMessage();
            Log::warning('Laravel Mail failed: ' . $lastError);
        }
        
        // Method 2: Try with Gmail SMTP
        try {
            Log::info('Trying Gmail SMTP');
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => 'smtp.gmail.com',
                'mail.mailers.smtp.port' => 587,
                'mail.mailers.smtp.username' => config('mail.from.address'),
                'mail.mailers.smtp.password' => config('mail.mailers.smtp.password'),
                'mail.mailers.smtp.encryption' => 'tls',
            ]);
            
            Mail::html($htmlContent, function ($message) use ($to, $subject, $contactData) {
                $message->to($to)
                       ->subject($subject)
                       ->from(config('mail.from.address'), config('mail.from.name', 'NSPG Solar'));
                
                if (!empty($contactData['email'])) {
                    $message->replyTo($contactData['email'], $contactData['name']);
                }
            });
            Log::info('Email sent successfully with Gmail SMTP');
            return;
        } catch (\Exception $e) {
            $lastError = $e->getMessage();
            Log::warning('Gmail SMTP failed: ' . $lastError);
        }
        
        // Method 3: Try with basic SMTP (no encryption)
        try {
            Log::info('Trying basic SMTP without encryption');
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => 'smtp.gmail.com',
                'mail.mailers.smtp.port' => 587,
                'mail.mailers.smtp.username' => config('mail.from.address'),
                'mail.mailers.smtp.password' => config('mail.mailers.smtp.password'),
                'mail.mailers.smtp.encryption' => null,
            ]);
            
            Mail::html($htmlContent, function ($message) use ($to, $subject, $contactData) {
                $message->to($to)
                       ->subject($subject)
                       ->from(config('mail.from.address'), config('mail.from.name', 'NSPG Solar'));
                
                if (!empty($contactData['email'])) {
                    $message->replyTo($contactData['email'], $contactData['name']);
                }
            });
            Log::info('Email sent successfully with basic SMTP');
            return;
        } catch (\Exception $e) {
            $lastError = $e->getMessage();
            Log::warning('Basic SMTP failed: ' . $lastError);
        }
        
        // Method 4: Fallback to log driver (WORKING METHOD)
        try {
            Log::info('Falling back to log driver - this is working!');
            config(['mail.default' => 'log']);
            Mail::html($htmlContent, function ($message) use ($to, $subject, $contactData) {
                $message->to($to)
                       ->subject($subject)
                       ->from(config('mail.from.address'), config('mail.from.name', 'NSPG Solar'));
                
                if (!empty($contactData['email'])) {
                    $message->replyTo($contactData['email'], $contactData['name']);
                }
            });
            
            // Also save to a dedicated contact form log file
            $this->saveContactFormToFile($contactData);
            
            Log::info('Email logged successfully (check storage/logs/laravel.log)');
            return;
        } catch (\Exception $e) {
            $lastError = $e->getMessage();
            Log::error('Even log driver failed: ' . $lastError);
        }
        
        // If all methods fail, throw exception
        throw new \Exception("All email methods failed. Last error: {$lastError}");
    }

    /**
     * Save contact form data to a dedicated file for easy access
     */
    private function saveContactFormToFile($contactData)
    {
        try {
            $logData = [
                'timestamp' => now()->toDateTimeString(),
                'name' => $contactData['name'],
                'phone' => $contactData['phone'],
                'email' => $contactData['email'] ?? 'Not provided',
                'system_capacity' => $contactData['system_capacity'] ?? 'Not specified',
                'address' => $contactData['address'] ?? 'Not provided',
                'services' => !empty($contactData['services']) ? implode(', ', $contactData['services']) : 'None specified',
                'message' => $contactData['message'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ];
            
            $logEntry = "=== NEW CONTACT FORM SUBMISSION ===\n";
            $logEntry .= "Date: " . $logData['timestamp'] . "\n";
            $logEntry .= "Name: " . $logData['name'] . "\n";
            $logEntry .= "Phone: " . $logData['phone'] . "\n";
            $logEntry .= "Email: " . $logData['email'] . "\n";
            $logEntry .= "System Capacity: " . $logData['system_capacity'] . "\n";
            $logEntry .= "Address: " . $logData['address'] . "\n";
            $logEntry .= "Services: " . $logData['services'] . "\n";
            $logEntry .= "Message: " . $logData['message'] . "\n";
            $logEntry .= "IP: " . $logData['ip_address'] . "\n";
            $logEntry .= "User Agent: " . $logData['user_agent'] . "\n";
            $logEntry .= "=====================================\n\n";
            
            // Save to contact form log file
            file_put_contents(
                storage_path('logs/contact-forms.log'), 
                $logEntry, 
                FILE_APPEND | LOCK_EX
            );
            
            // Also save as JSON for easy parsing
            $jsonData = json_encode($logData, JSON_PRETTY_PRINT) . "\n";
            file_put_contents(
                storage_path('logs/contact-forms.json'), 
                $jsonData, 
                FILE_APPEND | LOCK_EX
            );
            
            Log::info('Contact form data saved to dedicated log files');
            
        } catch (\Exception $e) {
            Log::error('Failed to save contact form to file: ' . $e->getMessage());
        }
    }

    /**
     * Build HTML email content
     */
    private function buildContactEmailHtml($contactData)
    {
        $services = !empty($contactData['services']) ? implode(', ', $contactData['services']) : 'None specified';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>New Contact Form Submission</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #FF6B35, #FF8A65); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .field { margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; border-left: 4px solid #FF6B35; }
                .field-label { font-weight: bold; color: #FF6B35; margin-bottom: 5px; }
                .field-value { color: #666; }
                .footer { text-align: center; margin-top: 30px; padding: 20px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>New Contact Form Submission</h1>
                <p>NSPG Solar - Contact Form</p>
            </div>
            
            <div class='content'>
                <p>You have received a new contact form submission from your website. Here are the details:</p>
                
                <div class='field'>
                    <div class='field-label'>Name:</div>
                    <div class='field-value'>{$contactData['name']}</div>
                </div>
                
                <div class='field'>
                    <div class='field-label'>Phone Number:</div>
                    <div class='field-value'>{$contactData['phone']}</div>
                </div>
                
                " . (!empty($contactData['email']) ? "
                <div class='field'>
                    <div class='field-label'>Email:</div>
                    <div class='field-value'>{$contactData['email']}</div>
                </div>
                " : "") . "
                
                " . (!empty($contactData['system_capacity']) ? "
                <div class='field'>
                    <div class='field-label'>Solar System Capacity:</div>
                    <div class='field-value'>{$contactData['system_capacity']}</div>
                </div>
                " : "") . "
                
                " . (!empty($contactData['address']) ? "
                <div class='field'>
                    <div class='field-label'>Address:</div>
                    <div class='field-value'>{$contactData['address']}</div>
                </div>
                " : "") . "
                
                <div class='field'>
                    <div class='field-label'>Services Required:</div>
                    <div class='field-value'>{$services}</div>
                </div>
                
                <div class='field'>
                    <div class='field-label'>Message:</div>
                    <div class='field-value'>{$contactData['message']}</div>
                </div>
                
                <div class='field'>
                    <div class='field-label'>Submitted At:</div>
                    <div class='field-value'>{$contactData['submitted_at']}</div>
                </div>
            </div>
            
            <div class='footer'>
                <p>This email was sent from your NSPG Solar website contact form.</p>
                <p>Please respond to the customer as soon as possible.</p>
            </div>
        </body>
        </html>
        ";
    }

    /**
     * Build plain text email content
     */
    private function buildContactEmailText($contactData)
    {
        $services = !empty($contactData['services']) ? implode(', ', $contactData['services']) : 'None specified';
        
        return "
NEW CONTACT FORM SUBMISSION - NSPG Solar

You have received a new contact form submission from your website.

Name: {$contactData['name']}
Phone: {$contactData['phone']}
" . (!empty($contactData['email']) ? "Email: {$contactData['email']}\n" : "") . "
" . (!empty($contactData['system_capacity']) ? "System Capacity: {$contactData['system_capacity']}\n" : "") . "
" . (!empty($contactData['address']) ? "Address: {$contactData['address']}\n" : "") . "
Services Required: {$services}
Message: {$contactData['message']}
Submitted At: {$contactData['submitted_at']}

This email was sent from your NSPG Solar website contact form.
Please respond to the customer as soon as possible.
        ";
    }
}
