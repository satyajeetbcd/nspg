<?php

namespace App\Http\Middleware\Role;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request to check user type.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $types  Comma-separated list of allowed types
     */
    public function handle(Request $request, Closure $next, string $types): Response
    {
        // Check if user is authenticated
        if (!Auth::guard('web')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::guard('web')->user();
        $allowedTypes = explode(',', $types);

        // Check if user type is allowed
        if (!$this->hasValidUserType($user, $allowedTypes)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient privileges.'], 403);
            }

            abort(403, 'Access denied. Required user type: ' . implode(' or ', $allowedTypes));
        }

        return $next($request);
    }

    /**
     * Check if user has one of the valid types.
     *
     * @param mixed $user
     * @param array $allowedTypes
     * @return bool
     */
    private function hasValidUserType($user, array $allowedTypes): bool
    {
        // Clean and normalize allowed types
        $allowedTypes = array_map('trim', $allowedTypes);

        // Check user type
        if (isset($user->type)) {
            return in_array($user->type, $allowedTypes);
        }

        // Check user role (alternative field)
        if (isset($user->role)) {
            return in_array($user->role, $allowedTypes);
        }

        // Check if using role-based system (like Spatie Permissions)
        if (method_exists($user, 'hasAnyRole')) {
            return $user->hasAnyRole($allowedTypes);
        }

        // Default to false if no valid type found
        return false;
    }
}
