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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // ✅ Regenerate session FIRST
        $request->session()->regenerate();

        // ✅ Double-check user still logged in
        $user = Auth::user();

        // ✅ Generate OTP + Expiry
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        // ✅ Store to session (AFTER regenerate)
        session([
            'otp' => $otp,
            'otp_expires_at' => $expiresAt,
            'otp_user_id' => $user->id,
            'otp_verified' => false, // Force re-verification
        ]);

        // ✅ Send OTP email
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
