@extends('administrator.layouts.main')

@section('content')
    <style>
        .disabled-a {
            pointer-events: none;
            opacity: 0.6;
            text-decoration: none;
        }

        .card-all {
            border-left: 4px solid #10100f;
        }

        .card-unpaid {
            border-left: 4px solid #ffc107;
        }

        .card-confirmed {
            border-left: 4px solid #28a745;

        }

        .card-completed {
            border-left: 4px solid #005013;
        }

        .card-cancelled {
            border-left: 4px solid #dc3545;
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
                                <li class="breadcrumb-item" aria-current="page">e-Statement</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">e-Statement</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Start Alert -->
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle"></i>
                                Error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            <!-- End Alert -->

            <div class="row">
                <!-- Summary Cards -->
                <div class="col-md-3 col-xl-4">
                    <div class="card card-unpaid">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">To Be Released Amount</h6>
                            <h3 class="mb-3 text-warning">(~) RM {{ $tobeReleased }}</h3>
                            <p class="mb-0 text-muted text-sm">Pending payouts to Taskers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-4">
                    <div class="card card-confirmed">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Released Amount</h6>
                            <h3 class="mb-3 text-success">RM {{ $releasedthisyear }}</h3>
                            <p class="mb-0 text-muted text-sm">Amount released this year</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xl-4">
                    <div class="card card-cancelled">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Released Amount</h6>
                            <h3 class="mb-3 text-danger">RM {{ $releasedAll }}</h3>
                            <p class="mb-0 text-muted text-sm">Amount released</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Charts -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Monthly Released Amount</div>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyReleasedChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Yearly Released Amount</div>
                        </div>
                        <div class="card-body">
                            <canvas id="yearlyReleasedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-3">
                                    <label for="month_range" class="form-label">Month Range</label>
                                    <div class="d-flex align-items-center">
                                        <input type="month" id="startMonth" name="startMonth" class="form-control">
                                        <span class="mx-2">to</span>
                                        <input type="month" id="endMonth" name="endMonth" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="tasker_filter" class="form-label">Tasker</label>
                                    <select id="tasker_filter" class="form-control">
                                        <option value="">All Taskers</option>
                                        @foreach ($data->unique('taskerID') as $b)
                                            <option value="{{ $b->taskerID }}">
                                                {{ Str::headline($b->tasker_firstname . ' ' . $b->tasker_lastname) . ' (' . $b->tasker_code . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <label for="tasker_filter" class="form-label">Filter by</label>
                                    <select id="status_filter" class="form-select mb-3 mb-md-0">
                                        <option value="">Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Released</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label for="endDate" class="form-label text-white">Action</label>
                                    <div class="d-flex justify-content-start align-items-end">
                                        <a href="" class="link-primary" id="clearAllBtn">Clear All</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#releaseModal"
                                        class="btn btn-primary my-2 disabled" id="releaseModalBtn">Release Amount</button>

                                    <a href="{{ route('admin-refresh-statement') }}" id="refreshStatementBtn"
                                        class="btn btn-light-primary d-inline-flex align-items-center gap-2">
                                        <i class="fas fa-redo"></i> Refresh
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">Tasker</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount (RM)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Statement</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Modal Approve Start Here -->
    <div class="modal fade" id="releaseModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-4">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <i class="ti ti-info-circle text-warning" style="font-size: 100px"></i>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-center align-items-center">
                                <h2>Release Amount</h2>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="fw-normal f-18 text-center">Are you sure you want to release the amount to <span
                                        id="selectionCount" class="text-primary">0</span> selected tasker?</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                <button type="reset" class="btn btn-light btn-pc-default"
                                    data-bs-dismiss="modal">Cancel</button>
                                <div>
                                    <button type="button" class="btn btn-light-success"
                                        id="releaseMultipleBtn">Release</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Approve End Here -->

    @foreach ($data as $d)
        <!-- Modal Release Start Here -->
        <div class="modal fade" id="releaseModal-{{ $d->statementID }}" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <i class="ti ti-info-circle text-warning" style="font-size: 100px"></i>
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h2>Release Amount</h2>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="fw-normal f-18 text-center">Are you sure you want to release RM
                                        {{ $d->total_earnings }} to
                                        {{ Str::headline($d->tasker_firstname . ' ' . $d->tasker_lastname) }} ?</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between gap-3 align-items-center">
                                    <button type="reset" class="btn btn-light btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <div>
                                        <a href="{{ route('admin-release-amount', $d->statementID) }}"
                                            class="btn btn-light-success btn-release">Release</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Release End Here -->
    @endforeach

    @foreach ($taskers as $tk)
        <!-- Modal Tasker Details Start Here -->
        <div class="modal fade" id="taskerDetailsModal-{{ $tk->tasker_code }}" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="mb-0">Tasker Details ({{ $tk->tasker_code }})</h5>
                        <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                            data-bs-dismiss="modal">
                            <i class="ti ti-x f-20"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <img src="{{ asset('storage/' . $tk->tasker_photo) }}" alt="Profile Photo"
                                            width="150" height="150" class="user-avtar rounded-circle">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="row">

                                    <h5 class="mb-2">A. Personal Information</h5>

                                    <!-- Tasker Code Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tasker Code</label>
                                            <input type="text" class="form-control" name="tasker_code"
                                                value="{{ $tk->tasker_code }}" readonly />
                                        </div>
                                    </div>

                                    <!-- First Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                First Name
                                            </label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="tasker_firstname" value="{{ $tk->tasker_firstname }}" readonly />
                                        </div>
                                    </div>

                                    <!-- Last Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Last Name
                                            </label>
                                            <input type="text" class="form-control" placeholder="Last Name"
                                                name="tasker_lastname" value="{{ $tk->tasker_lastname }}" readonly />
                                        </div>
                                    </div>

                                    <!-- IC Number Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                IC Number
                                            </label>
                                            <input type="text" class="form-control" placeholder="Enter IC number"
                                                name="tasker_icno" value="{{ $tk->tasker_icno }}" readonly />
                                        </div>
                                    </div>

                                    <!-- Date of Birth Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Date of Birth
                                            </label>
                                            <input type="date" class="form-control" name="tasker_dob"
                                                value="{{ $tk->tasker_dob }}" readonly />
                                        </div>
                                    </div>

                                    <!-- Phone Number Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Phone Number
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">+60</span>
                                                <input type="text" class="form-control" placeholder="Phone No."
                                                    name="tasker_phoneno" value="{{ $tk->tasker_phoneno }}" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Email
                                            </label>
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" value="{{ $tk->email }}" readonly />
                                        </div>
                                    </div>

                                    <h5 class="mb-2 mt-2 mt-2">B. Tasker Address</h5>

                                    <!-- Address Line 1 Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control" name="tasker_address_one"
                                                value="{{ $tk->tasker_address_one }}" placeholder="Address Line 1"
                                                readonly />
                                        </div>
                                    </div>

                                    <!-- Address Line 2 Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address Line 2 </label>
                                            <input type="text" class="form-control" name="tasker_address_two"
                                                value="{{ $tk->tasker_address_two }}" placeholder="Address Line 2"
                                                readonly />
                                        </div>
                                    </div>

                                    <!-- Postal Code Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="tasker_address_poscode"
                                                value="{{ $tk->tasker_address_poscode }}" placeholder="Postal Code"
                                                readonly />
                                        </div>
                                    </div>

                                    <!-- State Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">State </label>
                                            <select name="tasker_address_state" class="form-control" disabled>
                                                @if ($tk->tasker_address_state == '')
                                                    <option value="" selected>Select State</option>
                                                @else
                                                    <option value="{{ $tk->tasker_address_state }}" selected>
                                                        {{ Str::headline($tk->tasker_address_state) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Area Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Area </label>
                                            <select name="tasker_address_area" class="form-control" disabled>
                                                @if ($tk->tasker_address_area == '')
                                                    <option value="" selected>Select Area</option>
                                                @else
                                                    <option value="{{ $tk->tasker_address_area }}" selected>
                                                        {{ Str::headline($tk->tasker_address_area) }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <h5 class="mb-2 mt-2">C. Working Area</h5>

                                    <!-- Working Area State Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <select name="tasker_workingloc_state" class="form-control" disabled>
                                                @if ($tk->tasker_workingloc_state == '')
                                                    <option value="" selected>Select State</option>
                                                @else
                                                    <option value="{{ $tk->tasker_workingloc_state }}" selected>
                                                        {{ Str::headline($tk->tasker_workingloc_state) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Working Area Area Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Area</label>
                                            <select name="tasker_workingloc_area" class="form-control" disabled>
                                                @if ($tk->tasker_workingloc_area == '')
                                                    <option value="" selected>Select Area</option>
                                                @else
                                                    <option value="{{ $tk->tasker_workingloc_area }}" selected>
                                                        {{ Str::headline($tk->tasker_workingloc_area) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Working Radius Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Working Radius (KM)
                                            </label>
                                            <input type="number" min="1" max="200" class="form-control"
                                                placeholder="Working Radius" name="working_radius"
                                                value="{{ $tk->working_radius }}" readonly />
                                        </div>
                                    </div>

                                    <h5 class="mb-2 mt-2">D. Account Details</h5>
                                    <!-- Bio Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Bio</label>
                                            <textarea class="form-control" rows="4" name="tasker_bio" placeholder="Enter your bio here..." readonly>{{ $tk->tasker_bio }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Account Status Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <select class="form-select" name="tasker_status" disabled>
                                                @if ($tk->tasker_status == 0)
                                                    <option value ="0">Incomplete Profile</option>
                                                @elseif($tk->tasker_status == 1)
                                                    <option value ="1" selected>Not Verified</option>
                                                    <option value ="2">Active</option>
                                                    <option value ="3">Inactive</option>
                                                @elseif($tk->tasker_status == 2)
                                                    <option value ="2"selected>Active</option>
                                                    <option value ="3">Inactive</option>
                                                    <option value ="5">Banned</option>
                                                @elseif($tk->tasker_status == 3)
                                                    <option value ="2">Active</option>
                                                    <option value ="3"selected>Inactive</option>
                                                    <option value ="5">Banned</option>
                                                @elseif($tk->tasker_status == 4)
                                                    <option value ="4">Password Need Update</option>
                                                @elseif($tk->tasker_status == 5)
                                                    <option value ="2">Active</option>
                                                    <option value ="3">Inactive</option>
                                                    <option value ="5"selected>Banned</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!--  Ratings Data -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="tasker_rating" class="form-label">Rating</label>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($tk->tasker_rating >= $i)
                                                        <i class="fas fa-star text-warning f-16"></i>
                                                    @elseif ($tk->tasker_rating >= $i - 0.5)
                                                        <i class="fas fa-star-half-alt text-warning f-16"></i>
                                                    @else
                                                        <i class="far fa-star text-warning f-16"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>

                                    <!--  Penalty Data -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="tasker_rating" class="form-label">Penalty
                                                Count</label>
                                            <div class="d-flex align-items-center">
                                                <p class="text-danger fw-bold f-24">
                                                    {{ $tk->tasker_selfrefund_count }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="mb-2 mt-2">E. Bank Details</h5>
                                    <!-- Bank Name Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Bank Name
                                            </label>
                                            <select name="tasker_account_bank" id="tasker_account_bank"
                                                class="form-select" disabled>
                                                @if ($tk->tasker_account_bank == '')
                                                    <option value="">Select Bank</option>
                                                @else
                                                    <option value="{{ $tk->tasker_account_bank }}">
                                                        {{ $tk->tasker_account_bank }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Account Number Field -->
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="tasker_account_number" class="form-label">Account
                                                Number</label>
                                            <input type="text" class="form-control" name="tasker_account_number"
                                                value="{{ $tk->tasker_account_number }}" placeholder="Account Number"
                                                readonly />
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tasker Details End  Here -->
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Released Amount
            const monthlyReleasedCtx = document.getElementById('monthlyReleasedChart').getContext('2d');
            new Chart(monthlyReleasedCtx, {
                type: 'bar',
                data: {
                    // labels: @json($monthlyLabels),
                    datasets: [{
                        label: 'Released Amount (RM)',
                        data: @json($monthlyReleasedAmounts),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (RM)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                }
            });

            // Yearly Released Amount
            const yearlyReleasedCtx = document.getElementById('yearlyReleasedChart').getContext('2d');
            new Chart(yearlyReleasedCtx, {
                type: 'line',
                data: {
                    // labels: @json($yearlyLabels),
                    datasets: [{
                        label: 'Released Amount (RM)',
                        data: @json($yearlyReleasedAmounts),
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (RM)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Year'
                            }
                        }
                    }
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : MONTHLY_STATEMENTS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin-e-statement') }}",
                        data: function(d) {
                            d.startMonth = $('#startMonth').val();
                            d.endMonth = $('#endMonth').val();
                            d.tasker_filter = $('#tasker_filter').val();
                            d.status_filter = $('#status_filter').val();
                            // d.state_filter = $('#state_filter').val();
                        }
                    },
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,

                        },
                        {
                            data: 'tasker_code',
                            name: 'tasker_code'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'total_earnings',
                            name: 'total_earnings'
                        },
                        {
                            data: 'statement_status',
                            name: 'statement_status'
                        },
                        {
                            data: 'file_name',
                            name: 'file_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        emptyTable: "No data available in the table.",
                        loadingRecords: "Loading...",
                        processing: "Processing...",
                        zeroRecords: "No matching records found.",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }

                });

                $('#startMonth, #endMonth').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#tasker_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#status_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });


                // Approve/Reject Action
                $('#refreshStatementBtn').on('click', function() {
                    const $buttonOne = $(this);

                    $buttonOne.addClass('disabled-a', true).html(
                        '<span class="spinner-border spinner-border-sm me-2"></span> Refreshing...'
                    );
                });

                $('.btn-release').on('click', function() {
                    const $buttonThree = $(this);

                    $buttonThree.addClass('disabled-a', true).html(
                        '<span class="spinner-border spinner-border-sm me-2"></span> Releasing...'
                    );
                });

                $('#clearAllBtn').on('click', function(e) {
                    e.preventDefault();
                    $('#startMonth').val('');
                    $('#endMonth').val('');
                    $('#tasker_filter').val('');
                    $('#status_filter').val('');
                    table.ajax.reload();
                    table.draw();
                });




                let selectedStatement = {}; // Track selected rows

                // Function to update selection count and button states
                function updateSelectionCountAndButtons() {
                    const selectedCount = Object.keys(selectedStatement).length;

                    // Update selection counts
                    $('#selectionCount').text(selectedCount);

                    // Track if there is any "Completed" status in the selected rows
                    let hasRelased = false;

                    // Check the status of each selected row
                    $('.statement-checkbox:checked').each(function() {
                        const row = $(this).closest('tr'); // Get the row of the selected checkbox
                        const status = row.find('td:nth-child(5)').text()
                            .trim(); // Extract the booking status from the 5th column

                        if (status === 'Released') {
                            hasRelased = true; // If status is "Completed", set flag to true
                        }
                    });

                    // Enable or disable the "Change Status" button based on the presence of "Completed" status
                    if (hasRelased || selectedCount === 0) {
                        $('#releaseModalBtn').addClass('disabled'); // Disable button
                    } else {
                        $('#releaseModalBtn').removeClass('disabled'); // Enable button
                    }
                }

                // Handle checkbox selection
                $('.data-table').on('change', '.statement-checkbox', function() {
                    const statementID = $(this).val();
                    if (this.checked) {
                        selectedStatement[statementID] = true; // Add to selected
                    } else {
                        delete selectedStatement[statementID]; // Remove from selected
                    }
                    updateSelectionCountAndButtons();
                });

                // Handle "Select All" checkbox
                $('#select-all').on('change', function() {
                    const isChecked = this.checked;
                    $('.statement-checkbox').each(function() {
                        const statementID = $(this).val();
                        if (isChecked) {
                            selectedStatement[statementID] = true;
                        } else {
                            delete selectedStatement[statementID];
                        }
                        $(this).prop('checked', isChecked);
                    });
                    updateSelectionCountAndButtons();
                });

                // On table redraw
                $('.data-table').on('draw.dt', function() {
                    $('.statement-checkbox').each(function() {
                        const statementID = $(this).val();
                        $(this).prop('checked', selectedStatement[statementID] === true);
                    });

                    // Update "Select All" state
                    const totalCheckboxes = $('.statement-checkbox').length;
                    const checkedCheckboxes = $('.statement-checkbox:checked').length;
                    $('#select-all').prop('checked', totalCheckboxes > 0 && totalCheckboxes ===
                        checkedCheckboxes);

                    updateSelectionCountAndButtons();
                });

                //Change status button click event
                $('#releaseMultipleBtn').on('click', function() {
                    const $buttonTwo = $(this);
                    const selectedStatements = [];
                    const excludedStatuses = [
                        'Completed'
                    ]; // Define statuses that cannot be updated

                    $('.statement-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const status = row.find('td:nth-child(5)').text()
                            .trim(); // Adjust column index for "status"

                        // Only add bookings that are not in excluded statuses
                        if (!excludedStatuses.includes(status)) {
                            selectedStatements.push($(this).val());
                        }
                    });

                    if (selectedStatements.length > 0) {

                        // Disable the button and show loading text
                        $buttonTwo.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Releasing...'
                        );

                        $.ajax({
                            url: "{{ route('admin-release-multiple-amount') }}",
                            type: "POST",
                            data: {
                                selected_statments: selectedStatements,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                alert("Error: " + xhr.responseText);
                            }
                        });

                    } else {
                        alert(
                            "No valid statements selected. Ensure none of the selected bookings are 'Completed'."
                        );
                    }
                });
            });
        });
    </script>
@endsection
