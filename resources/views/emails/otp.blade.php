<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification Code</title>
</head>
<body style="background-color: #090d16; font-family: 'Segoe UI', Arial, sans-serif; color: #f8fafc; margin: 0; padding: 40px 20px;">
    <div style="max-width: 520px; margin: 0 auto; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 40px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0 0 10px 0;">Verify Your Email</h2>
            <p style="color: #94a3b8; font-size: 14px; margin: 0;">Welcome to StayVacation! Please use the 6-digit code below to complete your account registration.</p>
        </div>

        <div style="background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(168,85,247,0.15)); border: 1px solid rgba(99,102,241,0.3); border-radius: 16px; padding: 25px; text-align: center; margin-bottom: 30px;">
            <p style="color: #cbd5e1; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 10px 0; font-weight: 600;">Verification Code</p>
            <div style="font-size: 38px; font-weight: 800; letter-spacing: 8px; color: #38bdf8; font-family: 'Courier New', monospace;">
                {{ $otp }}
            </div>
            <p style="color: #64748b; font-size: 11px; margin: 12px 0 0 0;">This code will expire in 10 minutes.</p>
        </div>

        <div style="border-t: 1px solid rgba(255,255,255,0.1); pt: 20px; text-align: center;">
            <p style="color: #64748b; font-size: 12px; margin: 0;">If you did not request this registration, please ignore this email.</p>
            <p style="color: #475569; font-size: 11px; margin: 8px 0 0 0;">&copy; {{ date('Y') }} StayVacation. All rights reserved.</p>
        </div>

    </div>
</body>
</html>
