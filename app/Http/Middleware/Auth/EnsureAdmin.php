<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request to ensure user is authenticated as admin.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated on web guard
        if (!Auth::guard('web')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::guard('web')->user();

        // Check if user account is active
        if (isset($user->is_active) && !$user->is_active) {
            Auth::guard('web')->logout();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account deactivated.'], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Ensure user has admin privileges
        if (!$this->isAdminUser($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient privileges.'], 403);
            }

            abort(403, 'Access denied. Administrator privileges required.');
        }

        return $next($request);
    }

    /**
     * Check if the user has admin privileges.
     *
     * @param mixed $user
     * @return bool
     */
    private function isAdminUser($user): bool
    {
        // Check multiple possible admin indicators
        return (
            (isset($user->type) && in_array($user->type, ['admin', 'super admin'])) ||
            (isset($user->role) && in_array($user->role, ['admin', 'super_admin'])) ||
            (isset($user->is_admin) && $user->is_admin) ||
            (isset($user->is_super_admin) && $user->is_super_admin) ||
            (method_exists($user, 'hasRole') && ($user->hasRole('admin') || $user->hasRole('super_admin')))
        );
    }
}
