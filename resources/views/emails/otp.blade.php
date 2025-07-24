<!DOCTYPE html>
<html>
<head>
    <title>Your OTP for Login</title>
</head>
<body>
    <h1>Your OTP</h1>
    <p>Hello,</p>
    <p>Your one-time password (OTP) for login is: <strong>{{ $otp }}</strong></p>
    <p>This OTP is valid for 10 minutes.</p>
    <p>If you did not request this OTP, please ignore this email.</p>
    <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>