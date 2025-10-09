<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request to ensure user is authenticated as admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::guard('web')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the admin area.');
        }

        $user = Auth::guard('web')->user();


        // Check if user account is active (admin users don't need plan expiration)
        $isAdminUser = $this->isAdminUser($user);
        if (!$isAdminUser && !$user->is_active) {
            Auth::guard('web')->logout();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account deactivated.'], 403);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Ensure user is admin type
        if (!$isAdminUser) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient privileges.'], 403);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }

    /**
     * Check if the user is an admin.
     */
    private function isAdminUser($user): bool
    {
        // Check if user has admin privileges
        return (
            (isset($user->type) && in_array($user->type, ['admin', 'super admin', 'staff'])) ||
            (isset($user->role) && in_array($user->role, ['admin', 'super_admin', 'staff'])) ||
            (method_exists($user, 'hasRole') && ($user->hasRole('admin') || $user->hasRole('staff')))
        );
    }
}
