<!DOCTYPE html>
<html>

<head>
    <title>Tasker Performance Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
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

        .content {
            padding: 20px;
        }

        .content h2 {
            margin-top: 20px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .rating {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .rating span {
            font-size: 20px;
            margin-right: 4px;
        }

        .progress {
            height: 25px;
            border-radius: 12px;
            overflow: hidden;
            background-color: #e9ecef;
            margin: 20px 0;
        }

        .progress-bar {
            height: 100%;
            text-align: center;
            font-weight: bold;
            line-height: 25px;
            color: #fff;
        }

        .alert {
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
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

        .metrics {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .metric-item {
            flex: 1 1 50%;
            padding-top: 10px;
            padding-right: 20px;
            padding-bottom: 10px;
            box-sizing: border-box;
        }

        .metric-item p{
            display: block;
            color: #333;
            margin-bottom: 5px;
        }

        @media (max-width: 600px) {
            .metric-item {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://servenow.com.my/assets/images/logo-test-white.png" alt="Company Logo">
            <h1>Tasker Performance Report</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear <strong>{{ $taskerDetails['name'] }}</strong>,</p>
            <p>We’re sharing your latest performance report. Please review your metrics below:</p>
            <p>The performance report is generated on {{ $taskerDetails['date'] }}.</p>

            <!-- Average Rating -->
            <h2>Average Rating</h2>
            <div class="rating">
                @for ($i = 0; $i < floor($taskerDetails['average_rating']); $i++)
                    <span style="color: #ffc107;">&#9733;</span>
                @endfor
                @if ($taskerDetails['average_rating'] - floor($taskerDetails['average_rating']) >= 0.5)
                    <span style="color: #ffc107;">&#9734;</span>
                @endif
                @for ($i = 0; $i < 5 - ceil($taskerDetails['average_rating']); $i++)
                    <span style="color: #d3d3d3;">&#9734;</span>
                @endfor
                <span style="font-size: 18px; margin-left: 8px;">{{ $taskerDetails['average_rating'] }}/5</span>
            </div>

            <!-- Reaction -->
            <h2>Satisfaction Reaction</h2>
            <p>
                @if ($taskerDetails['satisfaction_reaction'] === 'Happy')
                    <span style="font-size: 24px; color: #28a745;">&#128512;</span> Happy
                @elseif ($taskerDetails['satisfaction_reaction'] === 'Neutral')
                    <span style="font-size: 24px; color: #ffc107;">&#128528;</span> Neutral
                @else
                    <span style="font-size: 24px; color: #dc3545;">&#128577;</span> Unhappy
                @endif
            </p>

            <!-- Performance Score -->
            <h2>Performance Score</h2>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                    style="width: {{ $taskerDetails['performance_score'] }}%; 
                           background-color: {{ $taskerDetails['performance_score'] < 40 ? '#dc3545' : ($taskerDetails['performance_score'] < 70 ? '#ffc107' : '#28a745') }};">
                    {{ $taskerDetails['performance_score'] }}%
                </div>
            </div>

            @if ($taskerDetails['performance_score'] < 40)
                <p class="text-danger alert">Warning: Your performance is critically low. Consistent poor performance
                    may
                    result in account deactivation. Take immediate steps to improve.</p>
            @elseif ($taskerDetails['performance_score'] < 70)
                <p class="text-warning alert">You're on the right track! Work harder to improve and reach the next
                    level.
                </p>
            @else
                <p class="text-success alert">Excellent performance! Keep up the great work and maintain your high
                    standards.</p>
            @endif

            <!-- Additional Metrics -->
            <h2>Additional Metrics</h2>
            <div class="metrics">
                <div class="metric-item">
                    <p>Total Self-Canceled Refunds</p>
                    <p>{{ $taskerDetails['total_self_cancel_refunds'] }}</p>
                </div>
                <div class="metric-item">
                    <p>Total Completed Bookings</p>
                    <p>{{ $taskerDetails['total_completed_bookings'] }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>ServeNow Copyright &copy; {{ date('Y') }} All rights reserved</p>
            <p><a href="{{ route('tasker-login') }}">Visit your dashboard</a> for detailed insights.</p>
        </div>
    </div>
</body>

</html>
