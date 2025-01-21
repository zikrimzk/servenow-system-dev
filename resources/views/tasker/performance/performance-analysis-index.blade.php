@extends('tasker.layouts.main')

@section('content')
    <style>
        .card {
            border-radius: 15px;
            background-color: #f9f9f9;
        }

        .circular-chart {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .circle-bg {
            fill: none;
            stroke: #eee;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke-width: 3.8;
            stroke-linecap: round;
            stroke: #4caf50;
            /* Success color */
            transition: stroke-dasharray 0.6s ease-out;
        }

        .circle-text {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem;
            line-height: 1.2;
        }

        /* Past scores section */
        .text-muted {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .fw-bold {
            font-size: 1.2rem;
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
                                <li class="breadcrumb-item">Performance</li>
                                <li class="breadcrumb-item" aria-current="page">Performance Analysis</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Performance Analysis</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Level Section Start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card text-center p-4">
                        <div class="card-header border-0">
                            <h4 class="card-title">Your Performance Level</h4>
                        </div>
                        <div class="card-body">
                            <!-- Rank Icons -->
                            <div class="row text-center">
                                <!-- Icons Section -->
                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 0 && $completedBookings <= 20 || $completedBookings >= 20
                                        ? asset('assets/images/medal/elite_badge_on.png')
                                        : asset('assets/images/medal/elite_badge_off.png') }}"
                                        alt="Elite Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p
                                        class="mt-3 mb-0 {{ $completedBookings > 0 && $completedBookings <= 20 ? 'fw-semibold' : '' }}">
                                        Elite Tasker
                                    </p>
                                    <small>0 - 20</small>
                                </div>

                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 20 && $completedBookings <= 80 || $completedBookings >= 80
                                        ? asset('assets/images/medal/master_badge_on.png')
                                        : asset('assets/images/medal/master_badge_off.png') }}"
                                        alt="Master Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p
                                        class="mt-3 mb-0 {{ $completedBookings > 20 && $completedBookings <= 80 ? 'fw-semibold' : '' }}">
                                        Master Tasker
                                    </p>
                                    <small>20 - 80</small>
                                </div>

                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 80 && $completedBookings <= 120 || $completedBookings >= 120
                                        ? asset('assets/images/medal/grandmaster_badge_on.png')
                                        : asset('assets/images/medal/grandmaster_badge_off.png') }}"
                                        alt="Grand Master Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p
                                        class="mt-3 mb-0 {{ $completedBookings > 80 && $completedBookings <= 120 ? 'fw-semibold' : '' }}">
                                        Grand Master Tasker
                                    </p>
                                    <small>80 - 120</small>
                                </div>

                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 120 && $completedBookings <= 160 || $completedBookings >= 160
                                        ? asset('assets/images/medal/epic_badge_on.png')
                                        : asset('assets/images/medal/epic_badge_off.png') }}"
                                        alt="Epic Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p
                                        class="mt-3 mb-0 {{ $completedBookings > 120 && $completedBookings <= 160 ? 'fw-semibold' : '' }}">
                                        Epic Tasker
                                    </p>
                                    <small>120 - 160</small>
                                </div>

                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 160 && $completedBookings <= 200 || $completedBookings >= 200
                                        ? asset('assets/images/medal/legend_badge_on.png')
                                        : asset('assets/images/medal/legend_badge_off.png') }}"
                                        alt="Legend Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p
                                        class="mt-3 mb-0 {{ $completedBookings > 160 && $completedBookings <= 200 ? 'fw-semibold' : '' }}">
                                        Legend Tasker
                                    </p>
                                    <small>160 - 200</small>
                                </div>

                                <div class="col-6 col-md-2 mb-4">
                                    <img src="{{ $completedBookings > 200
                                        ? asset('assets/images/medal/mythic_badge_on.png')
                                        : asset('assets/images/medal/mythic_badge_off.png') }}"
                                        alt="Mythic Tasker Icon" class="img-fluid" style="max-width: 8rem;">
                                    <p class="mt-3 mb-0 {{ $completedBookings > 200 ? 'fw-semibold' : '' }}">
                                        Mythic Tasker
                                    </p>
                                    <small>200+</small>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div>
                                <p>Progress to Next Level</p>
                                <div class="progress border border-2" style="height: 25px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ min(($completedBookings / 200) * 100, 100) }}%;background-color: #16325b;"
                                        aria-valuenow="{{ $completedBookings }}" aria-valuemin="0" aria-valuemax="200">
                                        {{ $completedBookings }}
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    Completed Bookings: {{ $completedBookings }}
                                    @if ($completedBookings <= 20)
                                        / 20 (Elite Tasker)
                                    @elseif($completedBookings <= 80)
                                        / 80 (Master Tasker)
                                    @elseif($completedBookings <= 120)
                                        / 120 (Grand Master Tasker)
                                    @elseif($completedBookings <= 160)
                                        / 160 (Epic Tasker)
                                    @elseif($completedBookings <= 200)
                                        / 200 (Legend Tasker)
                                    @else
                                        (Congratulations! You are a Mythic Tasker. Wait for another rank to be unlocked.)
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Level Section End -->

            <!-- Performance & Recation Section Start -->
            <div class="row">
                <!-- Performance Score Section -->
                <div class="col-lg-6">
                    <div class="card p-4">
                        <div class="card-body text-center">
                            <!-- Title -->
                            <h4 class="card-title mb-4">Performance Score</h4>
                            <!-- Circular Progress Bar -->
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="position-relative d-flex justify-content-center align-items-center"
                                    style="height: 200px; width: 200px;">
                                    <svg viewBox="0 0 36 36" class="circular-chart">
                                        <path class="circle-bg"
                                            d="M18 2.0845
                                                                                                                           a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                           a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="circle"
                                            stroke-dasharray="{{ $taskers->performance_score_percentage }}, 100"
                                            d="M18 2.0845
                                                                                                                           a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                           a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <div class="circle-text position-absolute">
                                        <h2 class="fw-bold text-primary mb-0">{{ $taskers->performance_score_percentage }}%
                                        </h2>
                                        <small class="text-muted">Overall</small>
                                    </div>
                                </div>
                            </div>


                            <!-- Past Two Months Scores -->
                            <div class="mt-4">
                                <h5 class="mb-3 text-secondary">Past 2 Months Performance</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="text-center">

                                        <h6 class="text-muted">{{ $date['lastMonth'] }}</h6>

                                        <span class="text-dark fw-bold">
                                            @if (!empty($pastPerformance[0]->performance_score_percentage))
                                                {{ $pastPerformance[0]->performance_score_percentage }}%
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="text-muted">{{ $date['twoMonthsAgo'] }}</h6>
                                        <span class="text-dark fw-bold">
                                            @if (!empty($pastPerformance[1]->performance_score_percentage))
                                                {{ $pastPerformance[1]->performance_score_percentage }}%
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Performance Score Section End -->

                <!-- Reaction Section -->
                <div class="col-lg-6">
                    <div class="card p-4">
                        <div class="card-body text-center">
                            <!-- Title -->
                            <h4 class="card-title mb-4">Client's Reaction</h4>
                            <div class="d-flex justify-content-center align-items-center">
                                @if ($taskers->satisfaction_reaction == 1)
                                    <i class="fas fa-smile text-success" style="font-size: 150px;" title="Happy"></i>
                                @elseif ($taskers->satisfaction_reaction == 2)
                                    <i class="fas fa-meh text-warning" style="font-size: 150px;" title="Neutral"></i>
                                @elseif ($taskers->satisfaction_reaction == 3)
                                    <i class="fas fa-frown text-danger" style="font-size: 150px;" title="Unhappy"></i>
                                @else
                                    <i class="fas fa-question-circle text-muted f-80" title="No Reaction"></i>
                                @endif
                            </div>
                            <!-- Past Two Months Reaction -->
                            <div class="mt-4">
                                <h5 class="mb-3 text-secondary">Past 2 Months Performance</h5>
                                <div class="d-flex justify-content-around">
                                    <div class="text-center">
                                        <h6 class="text-muted">{{ $date['lastMonth'] }}</h6>
                                        <span class="text-dark fw-bold">
                                            @if (!empty($pastPerformance[0]->average_rating) >= 4)
                                                <i class="fas fa-smile text-success f-80" title="Happy"></i>
                                            @elseif (!empty($pastPerformance[0]->average_rating) == 3)
                                                <i class="fas fa-meh text-warning f-80" title="Neutral"></i>
                                            @elseif (!empty($pastPerformance[0]->average_rating) == 1 || !empty($pastPerformance[0]->average_rating) == 2)
                                                <i class="fas fa-frown text-danger f-80" title="Unhappy"></i>
                                            @else
                                                <i class="fas fa-question-circle text-muted" style="font-size: 80px;"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="text-muted">{{ $date['twoMonthsAgo'] }}</h6>
                                        <span class="text-dark fw-bold">
                                            @if (!empty($pastPerformance[1]->average_rating) >= 4)
                                                <i class="fas fa-smile text-success f-80" title="Happy"></i>
                                            @elseif (!empty($pastPerformance[1]->average_rating) == 3)
                                                <i class="fas fa-meh text-warning f-80" title="Neutral"></i>
                                            @elseif (!empty($pastPerformance[1]->average_rating) == 1 || !empty($pastPerformance[1]->average_rating) == 2)
                                                <i class="fas fa-frown text-danger f-80" title="Unhappy"></i>
                                            @else
                                                <i class="fas fa-question-circle text-muted" style="font-size: 80px;"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Reaction Section End -->

            </div>
            <!-- Performance & Recation Section End -->


            <!-- Monthly Self-Refund Metrics -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-header text-center text-white" style= "background-color:#16325b; color:white">
                            <h4 class="text-white">Self-Refund Monthly Analysis</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h5 class="text-danger fw-bold">Avoid Frequent Self-Refunds!</h5>
                                <p class="text-muted">
                                    Self-refunds can lower your performance score and frustrate clients. Review your
                                    performance below:
                                </p>
                            </div>

                            <!-- Monthly Analysis Table -->
                            @if ($taskerMonthlyRefunds->isNotEmpty())
                                <table class="table table-bordered text-center" style="table-layout: fixed;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="white-space: normal; word-wrap: break-word;">Month</th>
                                            <th style="white-space: normal; word-wrap: break-word;">Total Refunds</th>
                                            <th style="white-space: normal; word-wrap: break-word;">Penalized Refunds</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($taskerMonthlyRefunds as $refund)
                                            <tr>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {{ Carbon\Carbon::parse($refund->month)->format('F Y') }}</td>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {{ $refund->total_refunds }}</td>
                                                <td style="white-space: normal; word-wrap: break-word;">
                                                    {{ $refund->penalized_refunds }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center text-muted">No refunds recorded for the past months.</p>
                            @endif

                            <!-- Warning Section -->
                            <div class="alert alert-primary mt-4">
                                <h6 class="fw-bold text-danger">Important:</h6>
                                <ul class="mb-0">
                                    <li>Avoid self-refunds to maintain your performance score.</li>
                                    <li>Respond promptly to clients and honor commitments.</li>
                                    <li>Penalized refunds impact your score significantly. Please take necessary actions.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Monthly Self-Refund Metrics End -->

        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
