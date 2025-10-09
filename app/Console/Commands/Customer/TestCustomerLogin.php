<?php

namespace App\Console\Commands\Customer;

use App\Http\Controllers\Public\Auth\CustomerAuthController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

class TestCustomerLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:customer-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the login() function for customers via CLI.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Customer Login Test ===');

        // Step 1: Ask for inputs
        $email = $this->ask('Enter customer email');
        $password = $this->secret('Enter password'); // hides input
        $locale = $this->ask('Enter locale (default: en)', 'en');

        // Step 2: Create a LoginRequest instance
        $loginRequest = LoginRequest::create('/', 'POST', [
            'email' => $email,
            'password' => $password,
            'locale' => $locale,
        ]);

        // Step 3: Attach session to request so redirect()->with() works in CLI
        $loginRequest->setLaravelSession(app(SessionManager::class)->driver());

        // Step 4: Instantiate the controller
        $controller = new CustomerAuthController();

        try {
            // Step 5: Call login() method directly
            $response = $controller->login($loginRequest);

            $this->info("login() executed successfully.");

            // Step 6: Display session flash messages creatively
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

            // Step 7: Show redirect URL if available
            if (method_exists($response, 'getTargetUrl')) {
                $this->line("Redirecting to: " . $response->getTargetUrl());
            }
        } catch (\Exception $e) {
            // Step 8: Catch and show errors
            $this->error("Error executing login(): " . $e->getMessage());
        }
    }
}
