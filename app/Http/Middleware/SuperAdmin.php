<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request and verify super admin access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::guard('web')->check()) {
            return redirect()->route('dashboard.login')->with('error', 'You must be logged in.');
        }

        $user = Auth::guard('web')->user();

        // Check if user exists and has super admin privileges
        if (!$user) {
            return redirect()->route('dashboard.login')->with('error', 'Authentication required.');
        }

        // Verify user has super admin role/type
        if (!$this->isSuperAdmin($user)) {
            abort(403, 'Access denied. Super admin privileges required.');
        }

        // Check if user account is active
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            return redirect()->route('dashboard.login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }

    /**
     * Check if the user has super admin privileges.
     *
     * @param mixed $user
     * @return bool
     */
    private function isSuperAdmin($user): bool
    {
        // Check multiple possible super admin indicators
        return (
            (isset($user->type) && $user->type === 'super admin') ||
            (isset($user->role) && $user->role === 'super_admin') ||
            (isset($user->is_super_admin) && $user->is_super_admin) ||
            (method_exists($user, 'hasRole') && $user->hasRole('super_admin'))
        );
    }
}
