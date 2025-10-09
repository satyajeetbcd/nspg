<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    /**
     * Handle role-based redirects for authenticated users.
     */
    public function handle(Request $request)
    {
        $locale = $request->route('locale') ?? session('locale', config('locale.default', 'en-SA'));

        // Check customer authentication first
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard', ['locale' => $locale]);
        }

        // Check staff authentication
        if (Auth::guard('staff')->check()) {
            $user = Auth::guard('staff')->user();

            // Super admin gets staff dashboard
            if ($this->isSuperAdmin($user)) {
                return redirect()->route('staff.dashboard', ['locale' => $locale]);
            }

            // Regular staff gets staff dashboard
            if ($this->isStaff($user)) {
                return redirect()->route('staff.dashboard', ['locale' => $locale]);
            }
        }

        // Default fallback to public login
        return redirect()->route('public.login', ['locale' => $locale])
            ->with('info', 'Please log in to access your dashboard.');
    }

    /**
     * Check if user is a super admin.
     */
    private function isSuperAdmin($user): bool
    {
        return (
            (isset($user->type) && $user->type === 'super admin') ||
            (isset($user->role) && $user->role === 'super_admin') ||
            (isset($user->is_super_admin) && $user->is_super_admin) ||
            (method_exists($user, 'hasRole') && $user->hasRole('super_admin'))
        );
    }

    /**
     * Check if user is staff.
     */
    private function isStaff($user): bool
    {
        return (
            $this->isSuperAdmin($user) ||
            (isset($user->type) && in_array($user->type, ['staff', 'admin'])) ||
            (isset($user->role) && in_array($user->role, ['staff', 'admin'])) ||
            (method_exists($user, 'hasRole') && ($user->hasRole('staff') || $user->hasRole('admin')))
        );
    }

    /**
     * Redirect after login based on guard.
     */
    public function afterLogin(Request $request, $guard = null)
    {
        $locale = $request->route('locale') ?? app()->getLocale();

        switch ($guard) {
            case 'customer':
                return redirect()->route('customer.dashboard', ['locale' => $locale]);

            case 'staff':
                return redirect()->route('staff.dashboard', ['locale' => $locale]);

            default:
                return $this->handle($request);
        }
    }

    /**
     * Redirect after logout.
     */
    public function afterLogout(Request $request, $guard = null)
    {
        $locale = $request->route('locale') ?? app()->getLocale();

        switch ($guard) {
            case 'customer':
                return redirect()->route('public.home', ['locale' => $locale])
                    ->with('success', 'You have been logged out successfully.');

            case 'staff':
                return redirect()->route('staff.login', ['locale' => $locale])
                    ->with('success', 'You have been logged out successfully.');

            default:
                return redirect()->route('public.home', ['locale' => $locale])
                    ->with('success', 'You have been logged out successfully.');
        }
    }
}


