<!DOCTYPE html>
<html>

<head>
    @if ($data['statement_status'] == 0)
        <title>Monthly Statement Notification</title>
    @elseif($data['statement_status'] == 1)
        <title>Monthly Payment Notification</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc !important;
            margin: 0;
            padding: 0;
            color: #333 !important;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff !important;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd !important;
        }

        .header {
            background-color: #0a1734 !important;
            color: #ffffff !important;
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
            color: #0a1734 !important;
        }

        .content p {
            margin-bottom: 15px;
        }


        .action-btn {
            text-align: center;
            margin-top: 20px;
        }

        .action-btn a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0a1734 !important;
            color: #ffffff !important;
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
            color: #6c757d !important;
        }

        .footer a {
            color: #007bff !important;
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
            <img src="https://servenow.com.my/assets/images/logo-test-white.png" alt="Company Logo">
            @if ($data['statement_status'] == 0)
                <h1>Monthly Statement Notification</h1>
            @elseif($data['statement_status'] == 1)
                <h1>Monthly Payment Notification</h1>
            @endif
        </div>
        <!-- Content -->

        <div class="content">
            <p>Dear <strong>{{ $data['name'] }}</strong>,</p>
            @if ($data['statement_status'] == 0)
                <p>We are pleased to inform you that your monthly statement for
                    <strong>{{ $data['month_year'] }}</strong> is now available for your review.
                </p>
                <p>This notification was issued on <strong>{{ $data['date'] }}</strong>.</p>

                <p>Your payment for <strong>{{ $data['month_year'] }}</strong> is currently being processed and will be
                    disbursed soon. Please keep an eye on your dashboard for updates.</p>
            @elseif($data['statement_status'] == 1)
                <p>We are delighted to inform you that your payment for <strong>{{ $data['month_year'] }}</strong> has
                    been successfully processed and released.</p>
                <p>This notification was issued on <strong>{{ $data['date'] }}</strong>.</p>

                <p>Your total earnings for the month amount to <strong>RM {{ $data['total_earnings'] }}</strong>. Kindly
                    verify that the amount has been credited to your bank account. If you encounter any discrepancies,
                    please do not hesitate to contact us.</p>
            @endif
            <p>We sincerely appreciate your dedication and outstanding service. Your efforts play a crucial role in
                delivering exceptional care to our clients.</p>

            <div class="action-btn">
                <a href="{{ route('tasker-login') }}">Access Your Dashboard</a>
            </div>
        </div>


        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ServeNow. All rights reserved.</p>
            <p>For additional information, please <a href="{{ route('tasker-login') }}">visit your dashboard</a>.</p>
        </div>
    </div>
</body>

</html>
