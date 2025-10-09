<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    /**
     * Handle an incoming request to ensure user is authenticated as customer.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if customer is authenticated
        if (!Auth::guard('customer')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('public.login')->with('error', 'Please log in to access this page.');
        }

        $customer = Auth::guard('customer')->user();

        // Check if customer account is active
        if (!$customer->is_active) {
            Auth::guard('customer')->logout();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account deactivated.'], 403);
            }

            return redirect()->route('public.login')
                ->with('error', 'Your account has been deactivated. Please contact support.');
        }

        // Check if customer email is verified (if verification is required)
        if (!$customer->email_verified_at && config('auth.verification.expire') > 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email verification required.'], 403);
            }

            return redirect()->route('public.verification.notice')
                ->with('warning', 'Please verify your email address to continue.');
        }

        return $next($request);
    }
}
