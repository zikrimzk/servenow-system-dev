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
            <h1>Refund Process Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $data['name'] }}</strong>,</p>

            @if ($data['users'] == 1 || $data['users'] == 3)
                {{-- Client Self Refund --}}
                <p>We are writing to inform you that your refund request has been
                    <strong>{{ $data['cr_status'] }}</strong>.
                </p>
                <p>This action was processed on <strong>{{ $data['change_date'] }}</strong>. Below are the details of
                    your refund:</p>
            @elseif ($data['users'] == 2)
                {{-- Tasker Refund --}}
                <p>Your client’s refund request has been marked as <strong>{{ $data['cr_status'] }}</strong>.</p>
                <p>This action was processed on <strong>{{ $data['change_date'] }}</strong>. Below are the refund
                    details:</p>
            @elseif ($data['users'] == 4)
                {{-- Tasker Refund Penalty --}}
                <p>We regret to inform you that a penalty has been imposed due to your inability to attend the booking.
                    As a result, your client’s refund request has been processed.</p>
                <p>This action was processed on <strong>{{ $data['change_date'] }}</strong>. Below are the refund
                    details:</p>
            @elseif ($data['users'] == 5)
                {{-- Client Refund by Tasker --}}
                <p>Your booking has been submitted for a refund by the tasker. Kindly update your bank account details
                    to expedite the refund process.</p>
                <p>This action was initiated on <strong>{{ $data['change_date'] }}</strong>. Below are the refund
                    details:</p>
            @endif

            <div class="details">
                <p><strong>Refund Details:</strong></p>
                <p><strong>Reason:</strong> {{ $data['cr_reason'] }}</p>
                <p><strong>Date:</strong> {{ $data['cr_date'] }}</p>
                <p><strong>Amount:</strong> <span style="font-weight: bold; color:green">RM
                        {{ $data['cr_amount'] }}</span></p>
                <p><strong>Bank Name:</strong> {{ $data['cr_bank_name'] }}</p>
                <p><strong>Account Number:</strong> {{ $data['cr_account_number'] }}</p>
            </div>

            <div class="details">
                <p><strong>Booking Details:</strong></p>
                <p><strong>Booking ID:</strong> {{ $data['booking_order_id'] }}</p>
                <p><strong>Service:</strong> {{ $data['service_name'] }}</p>
                <p><strong>Date:</strong> {{ $data['booking_date'] }}</p>
                <p><strong>Time:</strong> {{ $data['booking_time_start'] }} - {{ $data['booking_time_end'] }}</p>
            </div>

            @if ($data['users'] == 1 || $data['users'] == 3 || $data['users'] == 5)
                {{-- Client --}}
                <p>Thank you for your continued trust in ServeNow. We are committed to ensure your satisfaction and
                    look forward to serving you again in the future.</p>
            @elseif ($data['users'] == 2)
                {{-- Tasker --}}
                <p>Thank you for your dedication and service. Continue to provide exceptional care to your clients. Move
                    on to the next booking !</p>
            @elseif ($data['users'] == 4)
                {{-- Tasker Penalty --}}
                <p>Please ensure such issues do not recur as this may impact your performance and client trust.
                    Consistent
                    service is vital for maintaining our standards.</p>
            @endif

            <div class="action-btn">
                @if ($data['users'] == 1 || $data['users'] == 3)
                    <a href="{{ route('client-login') }}">Book Your Service at ServeNow !</a>
                @elseif ($data['users'] == 2 || $data['users'] == 4)
                    <a href="{{ route('tasker-login') }}">Access Your Dashboard</a>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ServeNow. All rights reserved.</p>
            <p>For inquiries or assistance, please contact us at <a
                    href="mailto:support@servenow.com">support@servenow.com</a>.</p>
        </div>
    </div>
</body>

</html>
