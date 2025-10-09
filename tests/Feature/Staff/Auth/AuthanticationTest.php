<?php

namespace Tests\Feature\Staff\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

use function Laravel\Prompts\password;

class AuthanticationTest extends TestCase
{
    protected $startTime;
    protected $uiLocale = 'en-SA';

    protected function setUp(): void
    {
        parent::setUp();
        $this->startTime = microtime(true);
    }
    protected function tearDown(): void
    {
        $runtime = number_format(microtime(true) - $this->startTime, 4);

        // ✅ نطبع رسالة النجاح + runtime
        echo "\n✅ [PASSED] " . __METHOD__ . " in {$runtime} sec\n";

        parent::tearDown();
    }
    /**
     * A basic feature test example.
     */
    public function test_login_page_loads(): void
    {
        $response = $this->get(route("login", ['locale' => 'en-SA']));

        $response->assertSee('Email')     // check input label
            ->assertSee('Password')  // check another input
            ->assertSee('Login');    // check button text
        $response->assertSee('Login'); // looks for text "Login"
        $runtime = number_format(microtime(true) - $this->startTime, 4);
    }


      public function test_staff_can_login_with_valid_credentials()
    {
    $staff = User::where('email','staff@thefuture.erp')->first();

        $response = $this->post(route('login.submit',['locale',$this->uiLocale]), [
            'email' => 'staff@thefuture.erp',
            'password' => '123123123',
        ]);

        $response->assertRedirect(route('staff.dashboard'));
        $this->assertAuthenticatedAs($staff, 'staff');
    }

    public function test_staff_cannot_login_with_wrong_password()
    {
       $staff = User::where('email','staff@thefuture.erp')->first();

        $response = $this->post(route('login.submit'), [
            
            'email' => 'staff@thefuture.erp',
            'password' => 'wrongpass',
        ]);

        echo $response->content();
        $this->assertGuest('staff');
    }

    public function test_staff_can_logout()
    {
        $staff = User::where('email','staff@thefuture.erp')->first();

        $this->actingAs($staff, 'staff')
             ->post(route('staff.logout'))
             ->assertRedirect(route('login.submit'));

        $this->assertGuest('staff');
    }
}
