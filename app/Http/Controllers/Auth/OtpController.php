<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showVerify()
    {
        $userId = session('pending_otp_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', ['user' => $user]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('pending_otp_user_id');
        if (!$userId) {
            return redirect()->route('register')->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $user = User::findOrFail($userId);

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid verification code. Please check your email and try again.']);
        }

        if ($user->otp_expires_at && Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'This verification code has expired. Please click resend code.']);
        }

        // Mark user as verified
        $user->is_verified = true;
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('pending_otp_user_id');

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home', absolute: false))->with('success', 'Email verified successfully! Welcome to StayVacation.');
    }

    public function resend(Request $request)
    {
        $userId = session('pending_otp_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::findOrFail($userId);

        $newOtp = (string) rand(100000, 999999);
        $user->otp_code = $newOtp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new OtpVerificationMail($user, $newOtp));

        return back()->with('status', 'A new 6-digit verification code has been sent to your email.');
    }
}
