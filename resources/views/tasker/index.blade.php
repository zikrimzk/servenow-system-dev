<?php
use Illuminate\Support\Str;
use Carbon\Carbon;
?>
@extends('tasker.layouts.main')

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
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <!-- Total Earnings Section -->
                                <div
                                    class="col-md-4 d-flex flex-column justify-content-between align-items-center mb-5 mb-md-0">
                                    <h4 class="text-center mb-3">Total Earnings</h4>
                                    <div class="text-center">
                                        <h1 class="mb-0 text-primary fs-1">RM {{ $totalearningsAll }}</h1>
                                        <p class="text-muted text-sm">Since start</p>
                                    </div>
                                    <hr class="w-100 border-secondary-subtle" />
                                    <div class="d-flex justify-content-between w-100 px-4 text-center">
                                        <div>
                                            <h5 class="mb-0">RM {{ $totalearningsThisMonth }}</h5>
                                            <small class="text-muted">This Month</small>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">RM {{ $totalearningsThisYear }}</h5>
                                            <small class="text-muted">This Year</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Your Rank Level Section -->
                                <div
                                    class="col-md-4 d-flex flex-column justify-content-between align-items-center mb-5 mb-md-0">
                                    <h4 class="text-center mb-3">Your Rank Level</h4>
                                    <div class="text-center">
                                        @if ($totalBookingCount <= 20)
                                            <img src="{{ asset('assets/images/medal/elite_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Elite Tasker</p>
                                        @elseif($totalBookingCount <= 80)
                                            <img src="{{ asset('assets/images/medal/master_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Master Tasker</p>
                                        @elseif($totalBookingCount <= 120)
                                            <img src="{{ asset('assets/images/medal/grandmaster_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Grand Master Tasker</p>
                                        @elseif($totalBookingCount <= 160)
                                            <img src="{{ asset('assets/images/medal/epic_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Epic Tasker</p>
                                        @elseif($totalBookingCount <= 200)
                                            <img src="{{ asset('assets/images/medal/legend_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Legend Tasker</p>
                                        @else
                                            <img src="{{ asset('assets/images/medal/mythic_badge_on.png') }}"
                                                alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                            <p class="mb-0 fw-semibold">Mythic Tasker</p>
                                        @endif

                                    </div>
                                    <hr class="w-100 border-secondary-subtle" />
                                    <div class="d-flex justify-content-between w-100 px-4 text-center">
                                        <div>
                                            <h5 class="mb-0">
                                                @if ($totalBookingCount <= 20)
                                                    {{ $totalBookingCount }} / 20
                                                @elseif($totalBookingCount <= 80)
                                                    {{ $totalBookingCount }} / 80
                                                @elseif($totalBookingCount <= 120)
                                                    {{ $totalBookingCount }} / 120
                                                @elseif($totalBookingCount <= 160)
                                                    {{ $totalBookingCount }} / 160
                                                @elseif($totalBookingCount <= 200)
                                                    {{ $totalBookingCount }} / 200
                                                @else
                                                    {{ $totalBookingCount }} / 1000
                                                @endif
                                            </h5>
                                            <small class="text-muted">Bookings Completed</small>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-danger">{{ $totalPenaltyCount }}</h5>
                                            <small class="text-muted">Penalty</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer Satisfaction Section -->
                                <div
                                    class="col-md-4 d-flex flex-column justify-content-between align-items-center mb-5 mb-md-0">
                                    <h4 class="text-center mb-3">Customer Satisfaction</h4>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @php
                                                $fullStars = floor($totalAVGrating); // Count of full stars
                                                $halfStar = $totalAVGrating - $fullStars >= 0.5 ? 1 : 0; // Check for half star
                                                $emptyStars = 5 - ($fullStars + $halfStar); // Remaining empty stars
                                            @endphp

                                            {{-- Full Stars --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star text-warning f-36"></i>
                                            @endfor

                                            {{-- Half Star --}}
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt text-warning f-36"></i>
                                            @endif

                                            {{-- Empty Stars --}}
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star text-warning f-36"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <hr class="w-100 border-secondary-subtle" />
                                    <div class="d-flex justify-content-between w-100 px-4 text-center">
                                        <div>
                                            <h5 class="mb-0">{{ $totalAVGrating }}/5.0</h5>
                                            <small class="text-muted">Average Rating</small>
                                        </div>
                                        <div>

                                            @if ($totalAVGrating >= 1 && $totalAVGrating < 2)
                                                <h5 class="mb-0 text-danger">Angry</h5>
                                            @elseif ($totalAVGrating >= 2 && $totalAVGrating < 3)
                                                <h5 class="mb-0 text-warning">Sad</h5>
                                            @elseif ($totalAVGrating >= 3 && $totalAVGrating < 4)
                                                <h5 class="mb-0 text-secondary">Neutral</h5>
                                            @elseif ($totalAVGrating >= 4 && $totalAVGrating < 5)
                                                <h5 class="mb-0 text-success">Happy</h5>
                                            @else
                                                <h5 class="mb-0 text-success">Very Happy</h5>
                                            @endif
                                            <small class="text-muted">Verdict</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="mb-4">Confimed Booking</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#</th>
                                            <th>Booking ID</th>
                                            <th>Services</th>
                                            <th>Booking Date</th>
                                            <th>Booking Time</th>
                                        </tr>
                                        @forelse ($confirmBookingData as $cb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <button class="btn btn-link link-primary" data-bs-toggle="modal"
                                                        data-bs-target="#viewBookingDetails-{{ $cb->booking_order_id }}">
                                                        {{ $cb->booking_order_id }}
                                                    </button>
                                                </td>
                                                <td>{{ $cb->servicetype_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cb->booking_date)->format('d F Y') }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($cb->booking_time_start)->format('g:i A') }} -
                                                    {{ \Carbon\Carbon::parse($cb->booking_time_end)->format('g:i A') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Oops, no booking confirmed
                                                    !
                                                </td>
                                            </tr>
                                        @endforelse

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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

            @foreach ($books as $b)
                <!-- Modal View Booking Details Start Here-->
                <div class="modal fade" id="viewBookingDetails-{{ $b->booking_order_id }}" data-bs-keyboard="false"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Booking Details</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <h5 class="mb-3 mt-2">A. Client Details</h5>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Client Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ Str::headline($b->client_firstname . ' ' . $b->client_lastname) }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Client Phone Number</label>
                                            <input type="text" class="form-control" value="{{ $b->client_phoneno }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Client Email</label>
                                            <input type="text" class="form-control" value="{{ $b->client_email }}"
                                                disabled />
                                        </div>
                                    </div>

                                    <h5 class="mb-3 mt-2">B. Booking Details</h5>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking ID</label>
                                            <input type="text" class="form-control"
                                                value="{{ $b->booking_order_id }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Service</label>
                                            <input type="text" class="form-control"
                                                value="{{ Str::headline($b->servicetype_name) }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Date</label>
                                            <input type="text" class="form-control"
                                                value="{{ Carbon::parse($b->booking_date)->format('d F Y') }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Time</label>
                                            <input type="text" class="form-control"
                                                value="{{ Carbon::parse($b->booking_time_start)->format('g:i A') . ' - ' . Carbon::parse($b->booking_time_end)->format('g:i A') }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Address</label>
                                            <textarea class="form-control" cols="20" rows="4" disabled>{{ $b->booking_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Amount (RM)</label>
                                            <input type="text" class="form-control"
                                                value="{{ number_format($b->booking_rate, 2) }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Booking Status</label>
                                            @if ($b->booking_status == 1)
                                                <span class="badge bg-warning">To Pay</span>
                                            @elseif($b->booking_status == 2)
                                                <span class="badge bg-light-success">Paid</span>
                                            @elseif($b->booking_status == 3)
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($b->booking_status == 4)
                                                <span class="badge bg-warning">Rescheduled</span>
                                            @elseif($b->booking_status == 5)
                                                <span class="badge bg-danger">Cancelled</span>
                                            @elseif($b->booking_status == 6)
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($b->booking_status == 7)
                                                <span class="badge bg-light-warning">Pending Refund</span>
                                            @elseif($b->booking_status == 8)
                                                <span class="badge bg-light-success">Refunded</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal View Booking Details End Here-->
            @endforeach

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
