<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#0f172a; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0f172a; padding:40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px; width:100%;">

                    <tr>
                        <td style="padding-bottom:24px;" align="center">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color:#6366f1; width:32px; height:32px; border-radius:8px; text-align:center; vertical-align:middle;">
                                        <span style="color:#ffffff; font-size:16px; font-weight:bold;">S</span>
                                    </td>
                                    <td style="padding-left:10px; color:#ffffff; font-size:16px; font-weight:700;">
                                        StayVacation
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#1e293b; border-radius:16px; overflow:hidden; border:1px solid #334155;">

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:36px 32px 24px 32px;" align="center">
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="background-color:#10b98120; width:56px; height:56px; border-radius:50%; text-align:center; vertical-align:middle;">
                                                    <span style="color:#34d399; font-size:26px; line-height:56px;">&#10003;</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <h1 style="color:#ffffff; font-size:22px; font-weight:700; margin:20px 0 6px 0;">
                                            Thank you for booking in StayVacation
                                        </h1>
                                        <p style="color:#94a3b8; font-size:14px; margin:0;">
                                            Hi {{ $booking->guest_name }}, here's a summary of your reservation.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:0 32px;">
                                <tr><td style="border-top:1px solid #334155; padding-top:20px;"></td></tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:4px 32px 8px 32px;">
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; width:40%;">Room</td>
                                    <td style="padding:10px 0; color:#ffffff; font-size:14px; font-weight:600; text-align:right;">{{ $booking->room->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; border-top:1px solid #293548;">Guests</td>
                                    <td style="padding:10px 0; color:#ffffff; font-size:14px; font-weight:600; text-align:right; border-top:1px solid #293548;">{{ $booking->guests }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; border-top:1px solid #293548;">Rooms</td>
                                    <td style="padding:10px 0; color:#ffffff; font-size:14px; font-weight:600; text-align:right; border-top:1px solid #293548;">{{ $booking->rooms_count }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; border-top:1px solid #293548;">Check-in</td>
                                    <td style="padding:10px 0; color:#ffffff; font-size:14px; font-weight:600; text-align:right; border-top:1px solid #293548;">{{ $booking->check_in->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; border-top:1px solid #293548;">Check-out</td>
                                    <td style="padding:10px 0; color:#ffffff; font-size:14px; font-weight:600; text-align:right; border-top:1px solid #293548;">{{ $booking->check_out->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#94a3b8; font-size:13px; border-top:1px solid #293548;">Status</td>
                                    <td style="padding:10px 0; text-align:right; border-top:1px solid #293548;">
                                        <span style="background-color:#f59e0b20; color:#fbbf24; font-size:12px; font-weight:600; padding:4px 10px; border-radius:999px;">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:16px 32px 32px 32px;">
                                <tr>
                                    <td style="background-color:#0f172a; border-radius:12px; padding:16px 20px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color:#94a3b8; font-size:13px;">Total price</td>
                                                <td style="color:#ffffff; font-size:20px; font-weight:700; text-align:right;">₱{{ number_format($booking->total_price, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:0 32px 32px 32px;">
                                <tr>
                                    <td style="color:#64748b; font-size:13px; line-height:1.6; text-align:center;">
                                        We'll review your payment proof and confirm your reservation shortly.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:24px;" align="center">
                            <p style="color:#475569; font-size:12px; margin:0;">
                                Booking reference #{{ $booking->id }} &middot; {{ date('Y') }} StayVacation
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>