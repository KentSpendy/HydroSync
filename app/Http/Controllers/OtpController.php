<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function showVerifyPage()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Session check
        if (!Session::has('otp') || !Session::has('otp_expires_at') || !Session::has('otp_user_id')) {
            return back()->withErrors(['otp' => 'No OTP found or session expired.']);
        }

        // Expiration check
        if (now()->greaterThan(Session::get('otp_expires_at'))) {
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        $user = User::find(Session::get('otp_user_id'));

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        // Check if locked
        if ($user->is_locked) {
            return back()->withErrors(['otp' => 'Your account is locked due to multiple failed OTP attempts. Please contact admin.']);
        }

        // If OTP is incorrect
        if ($request->otp != Session::get('otp')) {
            $user->increment('otp_attempts');

            if ($user->otp_attempts >= 3) {
                $user->is_locked = true;
                $user->save(); // 👈 persist both attempts & lock

                return back()->withErrors(['otp' => 'Your account has been locked due to multiple incorrect OTP entries.']);
            }

            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // ✅ OTP success — Reset everything
        Session::forget(['otp', 'otp_expires_at', 'otp_user_id']);
        Session::put('otp_verified', true);

        $user->update([
            'otp_attempts' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'OTP Verified!');
    }
}
