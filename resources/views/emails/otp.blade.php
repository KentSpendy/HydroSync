<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body>
    <h2>Hello {{ Auth::user()->name }},</h2>
    <p>Your OTP Code is:</p>
    <h1 style="color: #1D4ED8;">{{ $otp }}</h1>
    <p>This code will expire in 5 minutes.</p>

    <p>If you did not request this, please ignore this email.</p>

    <br>
    <p>— HydroSync Security Team</p>
</body>
</html>
