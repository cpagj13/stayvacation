<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showVerify()
    {
        $pending = session('pending_registration');
        if (!$pending) {
            return redirect()->route('register');
        }

        // Pass a temporary User-like object so the view can show the email
        $user = new User(['name' => $pending['name'], 'email' => $pending['email']]);

        return view('auth.verify-otp', ['user' => $user]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $pending = session('pending_registration');
        if (!$pending) {
            return redirect()->route('register')
                ->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        // Check OTP match
        if (trim($pending['otp_code']) !== trim($request->otp)) {
            return back()->withErrors(['otp' => 'Invalid verification code. Please check your email and try again.']);
        }

        // Check expiry
        if (Carbon::now()->gt(Carbon::parse($pending['otp_expires_at']))) {
            return back()->withErrors(['otp' => 'This verification code has expired. Please click resend code.']);
        }

        // OTP is valid — now create the user in the database
        $user = User::create([
            'name'              => $pending['name'],
            'email'             => $pending['email'],
            'password'          => $pending['password'], // already hashed
            'otp_code'          => null,
            'otp_expires_at'    => null,
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        event(new Registered($user));

        session()->forget('pending_registration');

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home', absolute: false))
            ->with('success', 'Email verified successfully! Welcome to StayVacation.');
    }

    public function resend(Request $request)
    {
        $pending = session('pending_registration');
        if (!$pending) {
            return redirect()->route('register');
        }

        // Generate a new OTP and update the session
        $newOtp = (string) rand(100000, 999999);
        $pending['otp_code']       = $newOtp;
        $pending['otp_expires_at'] = Carbon::now()->addMinutes(10)->toDateTimeString();
        session(['pending_registration' => $pending]);

        $tempUser = new User(['name' => $pending['name'], 'email' => $pending['email']]);

        Mail::to($pending['email'])->send(new OtpVerificationMail($tempUser, $newOtp));

        return back()->with('status', 'A new 6-digit verification code has been sent to your email.');
    }
}
