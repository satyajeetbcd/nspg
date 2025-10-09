<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    /**
     * Handle an incoming request to ensure user is authenticated as staff.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated on staff guard
        if (!Auth::guard('staff')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login', ['locale' => app()->getLocale()])->with('error', 'Please log in to access this page.');
        }

        $user = Auth::guard('staff')->user();

        // Check if user account is active
        if (isset($user->is_active) && !$user->is_active) {
            Auth::guard('staff')->logout();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account deactivated.'], 403);
            }

            return redirect()->route('login', ['locale' => app()->getLocale()])
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Ensure user is staff type (not customer)
        if (!$this->isStaffUser($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient privileges.'], 403);
            }

            abort(403, 'Access denied. Staff privileges required.');
        }

        return $next($request);
    }

    /**
     * Check if the user is a staff member.
     *
     * @param mixed $user
     * @return bool
     */
    private function isStaffUser($user): bool
    {
        // Check if user has staff or admin privileges
        return (
            (isset($user->type) && in_array($user->type, ['staff', 'admin', 'super admin'])) ||
            (isset($user->role) && in_array($user->role, ['staff', 'admin', 'super_admin'])) ||
            (method_exists($user, 'hasRole') && ($user->hasRole('staff') || $user->hasRole('admin')))
        );
    }
}
