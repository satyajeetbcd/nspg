<?php

namespace App\Http\Controllers\Staff\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the staff login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('staff')->check()) {
            return redirect('/admin');
        }

        return view('staff.auth.login');
    }

    /**
     * Handle staff login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('staff')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin')
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle staff logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}


