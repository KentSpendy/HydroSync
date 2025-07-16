<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\ActivityLogger;

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

        if (!Session::has('otp') || !Session::has('otp_expires_at') || !Session::has('otp_user_id')) {
            ActivityLogger::log('OTP Expired', 'User attempted to verify OTP but session/OTP was missing or expired.');
            return back()->withErrors(['otp' => 'No OTP found or session expired.']);
        }

        if (now()->greaterThan(Session::get('otp_expires_at'))) {
            ActivityLogger::log('OTP Expired', 'User attempted to verify OTP but it was expired.');
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        $user = User::find(Session::get('otp_user_id'));

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        if ($user->is_locked) {
            ActivityLogger::log('Account Locked', 'User attempted to verify OTP but account is already locked.');
            return back()->withErrors(['otp' => 'Your account is locked due to multiple failed OTP attempts. Please contact admin.']);
        }

        // ❌ Incorrect OTP
        if ($request->otp != Session::get('otp')) {
            $user->increment('otp_attempts');

            if ($user->otp_attempts >= 3) {
                $user->update(['is_locked' => true]);
                ActivityLogger::log('Account Locked', 'User account locked due to 3 incorrect OTP attempts.');
                return back()->withErrors(['otp' => 'Your account has been locked due to multiple incorrect OTP entries.']);
            }

            ActivityLogger::log('Invalid OTP', 'User entered an incorrect OTP.');
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // ✅ OTP Valid
        Session::forget(['otp', 'otp_expires_at', 'otp_user_id']);
        Session::put('otp_verified', true);
        $user->update(['otp_attempts' => 0]);

        Auth::login($user);

        ActivityLogger::log('OTP Verified', 'User verified OTP and successfully logged in.');

        return redirect()->route('dashboard')->with('success', 'OTP Verified!');
    }
}
