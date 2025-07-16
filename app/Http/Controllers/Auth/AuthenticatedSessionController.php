<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\OtpMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // 🔒 Check if user exists and is locked
        if ($user) {
            // Lockout due to failed login attempts
            if (
                $user->login_attempts >= 5 &&
                $user->last_failed_login_at &&
                now()->diffInMinutes($user->last_failed_login_at) < 5
            ) {
                return back()->withErrors([
                    'email' => 'Too many failed login attempts. Please wait 5 minutes before trying again.'
                ]);
            }

            // Lockout due to manual lock
            if ($user->is_locked) {
                return back()->withErrors([
                    'email' => 'This account is locked. Please contact the Administrator to unlock it.'
                ]);
            }
        }

        // ❌ Invalid credentials
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            if ($user) {
                $user->increment('login_attempts');
                $user->last_failed_login_at = now();
                $user->save(); // ✅ Make sure both fields persist
            }

            return back()->withErrors([
                'email' => 'Invalid credentials.'
            ]);
        }

        // ✅ Valid login
        if ($user) {
            $user->update([
                'login_attempts' => 0,
                'last_failed_login_at' => null,
            ]);
        }

        $request->session()->regenerate();

        // 🔐 Generate OTP
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5); //5 minutes

        Session::put('otp', $otp);
        Session::put('otp_expires_at', $expiresAt);
        Session::put('otp_user_id', $user->id);
        Session::forget('otp_verified');

        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect()->route('otp.verify.page');
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
