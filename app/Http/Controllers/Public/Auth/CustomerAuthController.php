<?php

namespace App\Http\Controllers\Public\Auth;

use App\Email;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\CustomerEmail;
use App\Mail\PasswordResetSuccess;
use App\Models\Customer;
use App\Notifications\CustomResetPassword;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;

class CustomerAuthController extends Controller
{
    use Email;

    public function __construct()
    {
        $this->initializeEmailConfig();
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()]);
        }
        return view('public.auth.register-form');
    }

    /**
     * Handle customer registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|string|email|max:255|unique:customers',
            'name'     => 'required|string|max:255|unique:customers',
            'password' => ['required', 'confirmed'],
        ]);

        $customer = Customer::create([
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
            'is_active' => null,
        ]);

        try {
            $body = $this->verificationTemplate($customer);
            $this->sendEmail($customer, 'Email Verification', $body);

            return redirect()->route('public.login')
                ->with('success', 'Account created successfully! Please check your email and click the verification link to activate your account.');
        } catch (\Exception $e) {
            Log::error('Failed to send registration verification email', [
                'customer_id' => $customer->id,
                'email' => $customer->email,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('public.login','en-SA')
                ->with('warning', 'Account created successfully, but we could not send the verification email. Please use the "Resend Activation Email" option below or contact support.');
        }
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()]);
        }
        return view('public.auth.login-form');
    }

    /**
     * Handle customer login.
     */
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $user = Customer::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('public.login',['locale' => 'en-SA'])->with('failed', 'Account not found');
        }

        if (is_null($user->is_active) || !$user->email_verified_at) {
            session(['unactivated_email' => $email]);
            return redirect()->route('public.login',['locale' => 'en-SA'])->with('failed',
                'Your account is not activated yet. Please check your email for the activation link or click "Resend Activation Email" below.');
        }

        if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return redirect()->route('public.login',['locale' => 'en-SA'])->with('failed', 'Invalid credentials');
        }

        $request->session()->regenerate();
        return redirect()->route('customer.dashboard', ['locale' => 'en-SA'])
            ->with('success', 'Login successful! Welcome back.');
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show email verification notice.
     */
    public function verificationNotice()
    {
        // Check if already authenticated and verified
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            if ($customer->email_verified_at) {
                return redirect()->route('customer.dashboard', ['locale' => app()->getLocale()]);
            }
            return view('public.auth.email-verification-notice', ['customer' => $customer]);
        }

        // If not authenticated, redirect to login
        return redirect()->route('public.login')->with('info', 'Please log in to access verification options.');
    }

    /**
     * Handle email verification.
     */
    public function verify(Request $request, $locale, $id, $hash)
    {
        abort_unless($request->hasValidSignature(), 403);

        $customer = Customer::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($customer->getEmailForVerification()))) {
            abort(403);
        }

        if (!$customer->email_verified_at) {
            $customer->email_verified_at = now();
            $customer->save();
            event(new Verified($customer));
        }

        // Always activate the account when verification link is clicked
        if ($customer->is_active !== 1) {
            $customer->is_active = 1;
            $customer->save();
        }

        try {
            $body = $this->welcomeEmailTemplate($customer);
            $this->sendEmail($customer, 'Welcome!', $body);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('public.login')
            ->with('success', 'Email verified successfully! Your account is now activated. You can login.');
    }

    /**
     * Resend verification email.
     */
    public function resend(Request $request)
    {
        $email = $request->email ?? session('unactivated_email') ?? Auth::guard('customer')->user()?->email;

        if (!$email) {
            return redirect()->route('public.login')->with('failed', 'No email address found for verification.');
        }

        $user = Customer::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('public.login')->with('failed', 'Account not found.');
        }

        $key = 'email.verification.' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 2)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('failed', 'Too many verification emails sent. Please wait ' . $seconds . ' seconds before requesting another.');
        }

        RateLimiter::hit($key, 300);

        try {
            $body = $this->verificationTemplate($user);
            $this->sendEmail($user, 'Email Verification', $body);

            $isUnactivatedRequest = session('unactivated_email');
            session()->forget('unactivated_email');

            if (Auth::guard('customer')->check()) {
                return back()->with('status', 'Verification link sent to your email!');
            } elseif ($isUnactivatedRequest) {
                return redirect()->route('public.login')->with('success', 'Activation email sent to ' . $user->email . '! Please check your inbox and click the verification link.');
            } else {
                return back()->with('status', 'Verification link sent to your email!');
            }
        } catch (\Exception $e) {
            Log::error('Failed to send verification email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);

            $isUnactivatedRequest = session('unactivated_email');

            if ($isUnactivatedRequest) {
                return redirect()->route('public.login')->with('failed', 'Unable to send activation email. Please try again later or contact support.');
            } else {
                return back()->with('failed', 'Unable to send verification email. Please try again later.');
            }
        }
    }

    /**
     * Show forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('public.auth.forgot-password-form');
    }

    /**
     * Send password reset link.
     */
    public function forgotPasswordMail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show password reset form.
     */
    public function resetPasswordForm(Request $request, $token)
    {
        return view('public.auth.reset-password-form', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Customer $customer, string $password) {
                $customer->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $customer->save();

                event(new PasswordReset($customer));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('public.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    /**
     * Generate welcome email template.
     */
    private function welcomeEmailTemplate($customer)
    {
        return view('mail.welcome', [
            'user_name' => $customer->name,
            'workspace_name' => $customer->name . "'s Workspace",
            'dashboard_url' => route('customer.dashboard', ['locale' => app()->getLocale()]),
            'docs_url' => url('/help'),
            'billing_url' => route('customer.subscription.index', ['locale' => app()->getLocale()]),
            'preferences_url' => route('customer.profile.edit', ['locale' => app()->getLocale()]),
            'current_year' => date('Y'),
        ])->render();
    }
}
