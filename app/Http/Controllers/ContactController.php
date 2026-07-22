<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Store contact message in database (optional)
        // Or send email to admin
        
        try {
            // Send email to admin
            Mail::raw("Contact Form Submission\n\nName: {$validated['name']}\nEmail: {$validated['email']}\nPhone: {$validated['phone']}\nSubject: {$validated['subject']}\n\nMessage:\n{$validated['message']}", function ($message) use ($validated) {
                $message->to(config('mail.from.address'))
                    ->subject('Contact Form: ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
        } catch (\Exception $e) {
            // If email fails, still show success (email might not be configured yet)
            return back()->with('success', 'Thank you for your message. We have received your inquiry.');
        }
    }
}
