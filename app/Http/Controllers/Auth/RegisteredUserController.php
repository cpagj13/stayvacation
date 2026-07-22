<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $otp = (string) rand(100000, 999999);

        // Store registration data in session — do NOT create the user in the DB yet
        session([
            'pending_registration' => [
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
                'otp_code'       => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10)->toDateTimeString(),
            ],
        ]);

        // Send OTP email using a temporary non-persisted User object for the Mailable
        $tempUser = new User([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        try {
            Mail::to($request->email)->send(new OtpVerificationMail($tempUser, $otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP email: ' . $e->getMessage());
        }

        return redirect()->route('otp.verify');
    }
}
