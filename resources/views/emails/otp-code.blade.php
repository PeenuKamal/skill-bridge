<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0; padding:0; background:#f4f5f7; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f5f7; padding:32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background:#0d3b66; padding:24px; text-align:center;">
                            <span style="color:#ffffff; font-size:20px; font-weight:bold;">Skill Bridge NB</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px; color:#222222;">
                            <p style="margin:0 0 16px; font-size:16px;">Here is your one-time verification code:</p>
                            <p style="margin:0 0 16px; font-size:32px; font-weight:bold; letter-spacing:6px; text-align:center; color:#0d3b66;">
                                {{ $code }}
                            </p>
                            <p style="margin:0 0 8px; font-size:14px; color:#555555;">
                                This code expires in {{ $expiryMinutes }} minutes.
                            </p>
                            <p style="margin:0; font-size:14px; color:#555555;">
                                If you didn't request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px; background:#f0f0f0; text-align:center; font-size:12px; color:#888888;">
                            Design, developed and managed by
                            <a href="https://thedigisparrow.com/services/" style="color:#0d3b66; text-decoration:none;">The DigiSparrow Inc</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
