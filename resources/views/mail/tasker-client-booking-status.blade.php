<!DOCTYPE html>
<html>

<head>
    <title>Booking Status Notification</title>
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
            <h1>Booking Status Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi <strong>{{ $data['name'] }}</strong>,</p>

            @if ($data['users'] == 1)
                {{-- Client --}}
                <p>We’re reaching out to let you know that your booking status has been updated to
                    <strong>{{ $data['booking_status'] }}</strong>.
                </p>
                <p>This update was made on <strong>{{ $data['change_date'] }}</strong>. Here are the details of your
                    booking:</p>
            @elseif ($data['users'] == 2)
                {{-- Tasker --}}
                <p>Your client’s booking status has been updated to <strong>{{ $data['booking_status'] }}</strong>.</p>
                <p>This update was made on <strong>{{ $data['change_date'] }}</strong>. Below are the details of the
                    service:</p>
            @endif

            <div class="details">
                <p><strong>Booking ID:</strong></p>
                <p>{{ $data['booking_order_id'] }}</p>
                <p><strong>Service:</strong></p>
                <p>{{ $data['service_name'] }}</p>
                <p><strong>Date:</strong></p>
                <p>{{ $data['booking_date'] }}</p>
                <p><strong>Time:</strong></p>
                <p>{{ $data['booking_time_start'] }} - {{ $data['booking_time_end'] }}</p>
                <p><strong>Note:</strong></p>
                <p>{{ $data['booking_note'] }}</p>
                <p><strong>Address:</strong></p>
                <p>{{ $data['booking_address'] }}</p>
                <p><strong>Rate:</strong></p>
                <p>RM {{ $data['booking_rate'] }}</p>
            </div>

            @if ($data['users'] == 1)
                {{-- Client --}}
                <p>Thank you for choosing ServeNow. We value your trust in us and look forward to serving you again.</p>
            @elseif ($data['users'] == 2)
                {{-- Tasker --}}
                <p>Thank you for serving your client. We value your trust in us and look forward to serving you again.</p>
            @endif


            <div class="action-btn">
                @if ($data['users'] == 1)
                    <a href="{{ route('client-login') }}">Access Your Dashboard</a>
                @elseif ($data['users'] == 2)
                    <a href="{{ route('tasker-login') }}">View Your Dashboard</a>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ServeNow. All rights reserved.</p>
            <p>For inquiries or support, contact us at <a href="mailto:support@servenow.com">support@servenow.com</a>.
            </p>
        </div>
    </div>
</body>

</html>
