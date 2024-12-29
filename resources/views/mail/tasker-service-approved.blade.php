<!DOCTYPE html>
<html>

<head>
    <title>Tasker Service Notification</title>
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
            <h1>Service Status Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $taskerDetails['name'] }}</strong>,</p>
            @if ($taskerDetails['service_status'] == 1)
                <p>Congratulations! Your service has been successfully <strong>approved</strong>. We are thrilled to
                    have
                    you join the ServeNow platform.</p>
                <p>This approval was completed on <strong>{{ $taskerDetails['approval_date'] }}</strong>. Below are the
                    details of your approved service:</p>
                <div class="details">
                    <p><strong>Service Name:</strong> {{ $taskerDetails['service_name'] }}</p>
                    <p><strong>Rate:</strong> {{ $taskerDetails['service_rate'] }} /
                        {{ $taskerDetails['service_rate_type'] }}</p>
                    <p><strong>Description:</strong> {{ $taskerDetails['service_desc'] }}</p>
                </div>

                <p>To maximize your success on the platform, please ensure that your profile visibility is enabled in
                    your dashboard and manage your availability effectively. We wish you great success in providing
                    outstanding services to our clients.</p>
            @elseif($taskerDetails['service_status'] == 3)
                <p>We regret to inform you that your service submission has been <strong>rejected</strong>.</p>
                <p>This decision was finalized on <strong>{{ $taskerDetails['approval_date'] }}</strong>. Below are the
                    details of your rejected service:</p>
                <div class="details">
                    <p><strong>Service Name:</strong> {{ $taskerDetails['service_name'] }}</p>
                    <p><strong>Rate:</strong> {{ $taskerDetails['service_rate'] }} /
                        {{ $taskerDetails['service_rate_type'] }}</p>
                    <p><strong>Description:</strong> {{ $taskerDetails['service_desc'] }}</p>
                    <p><strong>Reason:</strong> The rejection may be due to incomplete profile information or a proposed
                        rate that does not meet platform standards.</p>
                </div>

                <p>We encourage you to review the requirements and submit your service again. If you need further
                    clarification, please reach out to our ServeNow team for assistance.</p>
            @elseif($taskerDetails['service_status'] == 4)
                <p>We regret to inform you that your service has been <strong>terminated</strong>.</p>
                <p>The termination was finalized on <strong>{{ $taskerDetails['approval_date'] }}</strong>. Below are
                    the details of the terminated service:</p>
                <div class="details">
                    <p><strong>Service Name:</strong> {{ $taskerDetails['service_name'] }}</p>
                    <p><strong>Rate:</strong> {{ $taskerDetails['service_rate'] }} /
                        {{ $taskerDetails['service_rate_type'] }}</p>
                    <p><strong>Description:</strong> {{ $taskerDetails['service_desc'] }}</p>
                    <p><strong>Reason:</strong> Please contact our administration team for additional details.</p>
                </div>

                <p>We appreciate your effort and contributions. For any further inquiries, feel free to contact the
                    ServeNow team.</p>
            @endif

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
