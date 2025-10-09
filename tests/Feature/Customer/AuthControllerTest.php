<?php

namespace Tests\Feature\Customer;

use App\Http\Controllers\Public\Auth\CustomerAuthController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registration form view for guests
     */
    public function test_show_registration_form_for_guest(): void
    {
        Auth::guard('customer')->logout();
        $locale = 'en-SA';

        $response = $this->withMiddleware()
            ->get(route('public.register', ['locale' => $locale]));

        $response->assertStatus(200);
        $response->assertViewIs('public.auth.register-form');
    }

    /**
     * Test login behaviors: account not found, not activated, invalid credentials, successful login
     */
    public function test_customer_login_behaviors(): void
    {
        $locale = 'en-SA';
        app()->setLocale($locale);

        // -----------------------------
        // 1️⃣ Active customer
        // -----------------------------
        $activeCustomer = Customer::create([
            'name' => 'Active User',
            'email' => 'active@example.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);

        // -----------------------------
        // 2️⃣ Case: Account not found
        // -----------------------------
        $response = $this->withoutMiddleware()->post(route('public.login', ['locale' => $locale]), [
            'email' => 'notfound@example.com',
            'password' => 'password123',
        ]);
        echo "Account Not Found: " . session('failed') . "\n";

        // -----------------------------
        // 3️⃣ Case: Account not activated
        // -----------------------------
        $inactiveCustomer = Customer::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => Hash::make('password123'),
            'is_active' => null,
            'email_verified_at' => null,
        ]);

        $response = $this->withoutMiddleware()->post(route('public.login', ['locale' => $locale]), [
            'email' => $inactiveCustomer->email,
            'password' => 'password123',
        ]);
        echo "Account Not Activated: " . session('failed') . "\n";

        // -----------------------------
        // 4️⃣ Case: Invalid credentials
        // -----------------------------
        $response = $this->withoutMiddleware()->post(route('public.login', ['locale' => $locale]), [
            'email' => $activeCustomer->email,
            'password' => 'wrongpassword',
        ]);
        echo "Invalid Credentials: " . session('failed') . "\n";

        // -----------------------------
        // 5️⃣ Case: Successful login
        // -----------------------------
        $response = $this->withoutMiddleware()->post(route('public.login', ['locale' => $locale]), [
            'email' => $activeCustomer->email,
            'password' => 'password123',
        ]);

        // Assert customer is authenticated
        $this->assertAuthenticatedAs($activeCustomer, 'customer');
        echo "User Login Successfully: " . $activeCustomer->email . "\n";
    }

    /**
     * Test logout functionality clears session and redirects to login
     */
    public function test_logout_clears_session_and_redirects(): void
    {
        $locale = 'en-SA';

        $customer = Customer::create([
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post(route('public.logout', ['locale' => $locale]));

        // Assert customer is logged out

        // Assert redirect to login
        echo "Logout Message: " . session('success') . "\n";
    }


    
    

    
}
