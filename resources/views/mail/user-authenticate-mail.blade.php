<!DOCTYPE html>
<html>

<head>
    <title>ServeNow Account Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .header {
            background-color: #0a1734;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }

        .content h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #0a1734;
        }

        .content p {
            margin-bottom: 15px;
        }

        .details {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #0a1734;
            border-radius: 4px;
        }

        .details p {
            margin: 6px 0;
            color: #555;
        }

        .action-btn {
            text-align: center;
            margin-top: 20px;
        }

        .action-btn a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0a1734;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .action-btn a:hover {
            background-color: #09204d;
        }

        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #6c757d;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://servenow.com.my/assets/images/logo-test-white.png" alt="ServeNow Logo">
            @if ($data['option'] == 1)
                <h1>Account Activation</h1>
            @elseif($data['option'] == 2)
                <h1>Reset Your Password</h1>
            @elseif($data['option'] == 3)
                <h1>Reset Password</h1>
            @endif
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $data['name'] }}</strong>,</p>

            @if ($data['option'] == 1)
                <!-- Placeholder for email verification -->
                <p>
                    Thank you for signing up with ServeNow. Please verify your email address by clicking the link below to activate your account.
                </p>
                <div class="action-btn">
                    <a href="{{ $data['link'] }}">Verify Email</a>
                </div>
            @elseif($data['option'] == 2)
                <!-- Reset Password Process -->
                <p>
                    We received a request to reset your ServeNow account password. If you did not make this request, you can safely ignore this email.
                </p>
                <p>
                    Click the button below to reset your password. This link will expire in <strong>1 hour</strong>.
                </p>
                <div class="action-btn">
                    <a href="{{ $data['link'] }}">Reset Password</a>
                </div>
            @elseif($data['option'] == 3)
                <!-- After Reset Password Process -->
                <p>
                    Your password has been successfully reset!
                </p>
                <p>
                    You can now log in to your account using your new password. Click the button below to proceed to the login page.
                </p>
                <div class="action-btn">
                    @if($data['users'] == 1)
                        <a href="{{ route('admin-login') }}">Login Now !</a>
                    @elseif($data['users'] == 2)
                        <a href="{{ route('tasker-login') }}">Login Now !</a>
                    @elseif($data['users'] == 3)
                        <a href="{{ route('client-login') }}">Login Now !</a>
                    @endif
                </div>
            @elseif ($data['option'] == 4)
                <!-- Placeholder for After Email Verification -->
                <p>
                    Your account has been verified. You can continue login using your credential.
                </p>
                <div class="action-btn">
                    @if($data['users'] == 1)
                        <a href="{{ route('admin-login') }}">Login Now !</a>
                    @elseif($data['users'] == 2)
                        <a href="{{ route('tasker-login') }}">Login Now !</a>
                    @elseif($data['users'] == 3)
                        <a href="{{ route('client-login') }}">Login Now !</a>
                    @endif
                </div>
            @endif
            
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>Best regards,</p>
            <p>The ServeNow Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ServeNow. All rights reserved.</p>
            <p>Need help? <a href="mailto:support@servenow.com">Contact Support</a></p>
        </div>
    </div>
</body>

</html>
