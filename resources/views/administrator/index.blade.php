@extends('administrator.layouts.main')

@section('content')
    <style>
        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Dashboard</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- User Summary Cards -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h3 class="mb-1">{{ $totalActiveAdmin }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Active Admins</p>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="fas fa-users-cog text-danger fs-3"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card  shadow-md">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h3 class="mb-1">{{ $totalActiveTasker }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Active Taskers</p>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <i class="fas fa-user-ninja fs-3 text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h3 class="mb-1">{{ $totalActiveClient }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Active Clients</p>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <i class="fas fa-users fs-3 text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h3 class="mb-1">{{ $totalNewClient }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">New Clients</p>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <i class="fas fa-user-alt fs-3 text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5 class="fw-semibold mb-3 mt-3 text-danger">Attention Required </h5>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h3 class="mb-1">{{ $totalrefundrequest }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Pending Refund</p>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <a href="{{ route('admin-refund-request') }}"
                                                            class="link link-primary text-sm" id="unreview_filter"><i
                                                                class="fas fa-arrow-right text-warning fs-4"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h3 class="mb-1">{{ $totalunreleasedpayment }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Unreleased Payment</p>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <a href="{{ route('admin-e-statement') }}"
                                                            class="link link-primary text-sm" id="unreview_filter"><i
                                                                class="fas fa-arrow-right text-warning fs-4"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="card shadow-md">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h3 class="mb-1">{{ $totalunreview }}</h3>
                                                        <p class="text-muted fw-semibold mb-0">Unreview Bookings</p>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <a href="{{ route('admin-review-management') }}"
                                                            class="link link-primary text-sm" id="unreview_filter"><i
                                                                class="fas fa-arrow-right text-warning fs-4"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Charts Section -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h5 class="mb-3">Monthly Commission (3% Basis)</h5>
                                                <canvas id="commissionChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h5 class="mb-3">Monthly Revenue by Status</h5>
                                                <canvas id="monthlyRevenueChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Completed
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thismonthcompleted }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this month</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-check-circle fs-3 text-success"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Floating
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thismonthfloating }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this month</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-question-circle  fs-3 text-warning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Cancelled
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thismonthCancelled }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this month</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-times-circle fs-3 text-danger"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card bg-primary available-balance-card">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-2 text-white text-opacity-75">Total Revenue</p>
                                                        <h3 class="mb-2 text-white">RM {{ $totalrevenueAllTime }}</h3>
                                                        <p class="text-white mb-0 text-sm text-opacity-75">Since Start</p>

                                                    </div>
                                                    <div class="avtar">
                                                        <i class="ti ti-currency-dollar f-18"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card bg-warning available-balance-card">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <p class="mb-2 text-white text-opacity-75">Total Commision</p>
                                                        <h3 class="mb-2 text-white">RM {{ $totalCommissionAllTime }}</h3>
                                                        <p class="text-white mb-0 text-sm text-opacity-75">with basis 3%
                                                        </p>

                                                    </div>
                                                    <div class="avtar">
                                                        <i class="ti ti-currency-dollar f-18"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Completed
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thisyearcompleted }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this year</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-check-circle fs-3 text-success"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Floating
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thisyearfloating }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this year</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-question-circle  fs-3 text-warning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card shadow-md">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="text-muted mb-1 fw-semibold text-sm">Cancelled
                                                                    Bookings</p>
                                                                <h3 class="mb-1">{{ $thisyearCancelled }}</h3>
                                                                <p class="text-muted mb-0 text-sm">this year</p>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <i class="fas fa-times-circle fs-3 text-danger"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h5 class="mb-3">Yearly Revenue by Status</h5>
                                                <canvas id="yearlyRevenueChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('commissionChart').getContext('2d');
        const commissionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($commisionchartData['labels']), // Months (e.g., "11-2024")
                datasets: [{
                    label: 'Total Commission (RM)',
                    data: @json($commisionchartData['commission']), // Commission amounts
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4, // Smooth line
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                        text: 'Monthly Total Commission (8% of Completed Bookings)',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Commission (RM)',
                        },
                    },
                },
            },
        });
        // Monthly Revenue Chart - Stacked Bar Chart
        const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar', // Bar chart
            data: {
                labels: @json($monthlyChartData['labels']), // Months
                datasets: [{
                        label: 'Completed (RM)',
                        data: @json($monthlyChartData['completed']),
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    },
                    {
                        label: 'Floating (RM)',
                        data: @json($monthlyChartData['floating']),
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                    },
                    {
                        label: 'Cancelled (RM)',
                        data: @json($monthlyChartData['cancelled']),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                        text: 'Monthly Booking Amounts by Status',
                        font: {
                            size: 16
                        },
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        stacked: true, // Enable stacking for x-axis
                        title: {
                            display: true,
                            text: 'Month',
                        },
                    },
                    y: {
                        stacked: true, // Enable stacking for y-axis
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (RM)',
                        },
                    },
                },
            },
        });

        const yearlyCtx = document.getElementById('yearlyRevenueChart').getContext('2d');
        const yearlyChart = new Chart(yearlyCtx, {
            type: 'line', // Line chart
            data: {
                labels: @json($yearlyChartData['labels']), // Years
                datasets: [{
                        label: 'Completed (RM)',
                        data: @json($yearlyChartData['completed']),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: 'Floating (RM)',
                        data: @json($yearlyChartData['floating']),
                        borderColor: 'rgba(255, 206, 86, 1)',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: 'Cancelled (RM)',
                        data: @json($yearlyChartData['cancelled']),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                        text: 'Yearly Booking Totals by Status',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (RM)',
                        },
                    },
                },
            },
        });
    </script>
@endsection
