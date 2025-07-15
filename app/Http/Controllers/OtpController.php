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

        if (
            !Session::has('otp') || 
            !Session::has('otp_expires_at') || 
            !Session::has('otp_user_id')
        ) {
            return back()->withErrors(['otp' => 'No OTP found or session expired.']);
        }

        if (now()->greaterThan(Session::get('otp_expires_at'))) {
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        if ($request->otp == Session::get('otp')) {
            $user = User::find(Session::get('otp_user_id'));

            if (!$user) {
                return back()->withErrors(['otp' => 'User not found.']);
            }

            // ✅ Clear old OTP session data
            Session::forget(['otp', 'otp_expires_at', 'otp_user_id']);

            // ✅ Mark OTP as verified
            Session::put('otp_verified', true);

            // ✅ Authenticate the user
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'OTP Verified!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }
}
