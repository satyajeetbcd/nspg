<?php

namespace App\Console\Commands\Customer;

use App\Http\Controllers\Public\Auth\CustomerAuthController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestResendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:resend-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively test the resend() method for activation emails via CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Resend Activation Email Test ===');

        // Step 1: Ask for customer email
        $email = $this->ask('Enter customer email (leave blank to use session/unactivated_email if available)');

        // Step 2: Create a Request instance (no setContainer needed)
        $request = Request::create('/', 'POST', [
            'email' => $email ?: null,
        ]);

        // Step 3: Instantiate the controller
        $controller = new CustomerAuthController();

        try {
            // Step 4: Call the resend() method directly
            $response = $controller->resend($request);

            $this->info("resend() executed successfully.");

            // Step 5: Display session messages creatively
            if (method_exists($response, 'getSession')) {
                $session = $response->getSession();

                $this->info("=== Session Messages ===");

                foreach ($session->all() as $key => $value) {
                    if (in_array($key, ['success', 'failed', 'warning', 'status', 'info'])) {
                        switch ($key) {
                            case 'success':
                                $this->info("✅ Success: $value");
                                break;
                            case 'failed':
                                $this->error("❌ Failed: $value");
                                break;
                            case 'warning':
                                $this->warn("⚠️ Warning: $value");
                                break;
                            case 'info':
                                $this->line("ℹ️ Info: $value");
                                break;
                            case 'status':
                                $this->line("🔔 Status: $value");
                                break;
                            default:
                                $this->line("$key: $value");
                        }
                    }
                }
            }

            // Step 6: Show redirect URL if available
            if (method_exists($response, 'getTargetUrl')) {
                $this->line("Redirecting to: " . $response->getTargetUrl());
            }
        } catch (\Exception $e) {
            $this->error("Error executing resend(): " . $e->getMessage());
            Log::error('TestResendEmail failed', ['error' => $e->getMessage()]);
        }
    }
}
