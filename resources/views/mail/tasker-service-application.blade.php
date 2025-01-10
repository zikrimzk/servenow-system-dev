<!DOCTYPE html>
<html>

<head>
    <title>Service Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
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
            font-size: 22px;
            margin: 0;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.5;
        }

        .content h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #0a1734;
        }

        .content p {
            margin-bottom: 12px;
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
            padding: 10px 20px;
            background-color: #0a1734;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
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
            <h1>Service Application Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $taskerDetails['name'] }}</strong>,</p>
            <p>Thank you for submitting your service application to ServeNow. We are excited to have you join
                our platform!</p>
            <p>Your application is currently under review by our team. This process may take up to 3 business
                days.</p>
            <p>The details of your submitted service are as follows:</p>
            <div class="details">
                <p><strong>Service Name:</strong> {{ $taskerDetails['service_name'] }}</p>
                <p><strong>Rate:</strong> RM {{ $taskerDetails['service_rate'] }} /
                    {{ $taskerDetails['service_rate_type'] }}</p>
                <p><strong>Description:</strong> {{ $taskerDetails['service_desc'] }}</p>
            </div>
            <p>We will notify you as soon as your application has been reviewed. In the meantime, if you have
                any questions or need assistance, feel free to reach out to us.</p>
            <p>Thank you for choosing ServeNow as your trusted platform. We look forward to seeing your services
                thrive with us!</p>

            <div class="action-btn">
                <a href="{{ route('tasker-login') }}">Access Your Dashboard</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ServeNow. All rights reserved.</p>
            <p>For inquiries, please contact us at <a href="mailto:support@servenow.com">support@servenow.com</a>.</p>
        </div>
    </div>
</body>

</html>
