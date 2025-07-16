<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - HydroSync</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 8px 0 0 0;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .description {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .otp-container {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 2px dashed #9ca3af;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            display: inline-block;
        }
        .otp-label {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            color: #1d4ed8;
            letter-spacing: 4px;
            margin: 0;
            font-family: 'Courier New', monospace;
        }
        .expiry-info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .expiry-info p {
            margin: 0;
            color: #92400e;
            font-weight: 500;
        }
        .security-notice {
            background-color: #f0f9ff;
            border: 1px solid #e0f2fe;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }
        .security-notice h3 {
            color: #0369a1;
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }
        .security-notice p {
            margin: 0;
            color: #0c4a6e;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .signature {
            font-weight: 600;
            color: #1f2937;
            margin-top: 10px;
        }
        .brand-accent {
            color: #1d4ed8;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 20px;
            }
            .otp-code {
                font-size: 28px;
                letter-spacing: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Secure Access</h1>
            <p>Your verification code is ready</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ Auth::user()->name }},
            </div>
            
            <p class="description">
                We've generated a secure verification code for your account. Please use the code below to complete your authentication.
            </p>
            
            <div class="otp-container">
                <div class="otp-label">Your OTP Code</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <div class="expiry-info">
                <p>This code will expire in 5 minutes for your security</p>
            </div>
            
            <div class="security-notice">
                <h3>🛡️ Security Reminder</h3>
                <p>If you didn't request this verification code, please ignore this email and ensure your account remains secure. Never share your OTP code with anyone.</p>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated message from <span class="brand-accent">HydroSync</span></p>
            <p class="signature">— HydroSync Security Team</p>
        </div>
    </div>
</body>
</html>