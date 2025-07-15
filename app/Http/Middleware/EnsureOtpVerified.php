<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ✅ Allow guests to proceed (not yet authenticated)
        if (!Auth::check()) {
            return $next($request);
        }

        // ✅ Allow if OTP has been verified
        if (Session::get('otp_verified')) {
            return $next($request);
        }

        // ✅ Redirect to OTP verification if logged in but not verified
        return redirect()->route('otp.verify.page')->withErrors([
            'otp' => 'Please verify your OTP to continue.'
        ]);
    }
}
    