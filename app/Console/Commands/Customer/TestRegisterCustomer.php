<?php

namespace App\Console\Commands\Customer;

use App\Http\Controllers\Public\Auth\CustomerAuthController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TestRegisterCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:register-function
                            {email}
                            {name}
                            {password}
                            {password_confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the register() function directly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Prepare request data
        $request = new Request([
            'email' => $this->argument('email'),
            'name' => $this->argument('name'),
            'password' => $this->argument('password'),
            'password_confirmation' => $this->argument('password_confirmation'),
            'locale' => "en-SA", // Add a locale parameter

        ]);

        $controller = new CustomerAuthController();

        try {
            // Call the register() method directly
            $response = $controller->register($request);

            // Output response message
            $this->info('Register() executed successfully.');

            // Optionally, check if it's a redirect with a session message
            if (method_exists($response, 'getSession')) {
                $session = $response->getSession();
                $this->line('Session messages: ' . json_encode($session->all()));
            }
        } catch (\Exception $e) {
            $this->error('Error executing register(): ' . $e->getMessage());
            Log::error('TestRegisterFunction failed', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
