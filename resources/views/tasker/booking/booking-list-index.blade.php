<?php
use Illuminate\Support\Str;
use Carbon\Carbon;
?>
@extends('tasker.layouts.main')

@section('content')
    <style>
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
                                <li class="breadcrumb-item">Bookings</li>
                                <li class="breadcrumb-item" aria-current="page">Booking List</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Booking List</h2>
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


            <!-- Analytics Start -->
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="card card-all">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Bookings</h6>
                            <h4 class="mb-3">{{ $totalBooking }}</h4>
                            <p class="mb-0 text-muted text-sm">services</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-6">
                    <div class="card card-completed">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400" style="color: #005013">Completed Bookings</h6>
                            <h4 class="mb-3">{{ $totalCompleted }}</h4>
                            <p class="mb-0 text-muted text-sm">bookings completed</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-4">
                    <div class="card card-unpaid">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-warning">Unpaid Bookings</h6>
                            <h4 class="mb-3">{{ $totalUnpaid }}</h4>
                            <p class="mb-0 text-muted text-sm">bookings unpaid</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-confirmed">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-success">Confirmed Bookings</h6>
                            <h4 class="mb-3">{{ $totalConfirmed }}</h4>
                            <p class="mb-0 text-muted text-sm">bookings confirmed</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-cancelled">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-danger">Cancelled Bookings</h6>
                            <h4 class="mb-3">{{ $totalCancelled }}</h4>
                            <p class="mb-0 text-muted text-sm">bookings cancelled</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-dark">Monthly Revenue</h6>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-dark">Yearly Revenue</h6>
                            <canvas id="yearlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-confirmed">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Completed Amount</h6>
                            <h3 class="mb-3 text-success">(+) RM {{ $totalCompletedAmount }}</h3>
                            <p class="mb-0 text-muted text-sm"></p>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-4">
                    <div class="card card-unpaid">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Floating Amount</h6>
                            <h3 class="mb-3 text-warning">(~) RM {{ $totalFloatingAmount }}</h3>
                            <p class="mb-0 text-muted text-sm"></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card card-cancelled">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Cancelled Amount</h6>
                            <h3 class="mb-3 text-danger">(-) RM {{ $totalCancelledAmount }}</h3>
                            <p class="mb-0 text-muted text-sm"></p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Analytics End -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-3">
                                    <label for="date_range" class="form-label">Date Range</label>
                                    <div class="d-flex flex-column flex-md-row align-items-start">
                                        <input type="date" id="startDate" name="startDate" class="form-control">
                                        <span style="margin: 10px 15px">to</span>
                                        <input type="date" id="endDate" name="endDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-9 mb-3">
                                    <label for="filter" class="form-label">Filter by</label>
                                    <div class="d-block  d-md-flex justify-content-between align-items-center gap-2">
                                        <select id="status_filter" class="form-select mb-3 mb-md-0">
                                            <option value="">Status</option>
                                            <option value="1">To Pay</option>
                                            <option value="2">Paid</option>
                                            <option value="3">Confirmed</option>
                                            <option value="4">Rescheduled</option>
                                            <option value="5">Cancelled</option>
                                            <option value="6">Completed</option>
                                        </select>

                                        <select id="service_filter" class="form-select mb-3 mb-md-0">
                                            <option value="">Service Type</option>
                                            @foreach ($books->unique('typeID') as $b)
                                                <option value="{{ $b->typeID }}">
                                                    {{ Str::headline($b->servicetype_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label class="form-label text-white">Action</label>
                                    <div class="d-flex justify-content-start align-items-end">
                                        <a href="" class="link-primary" id="clearAllBtn">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive my-4 mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Booking ID</th>
                                            <th scope="col">Service</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Booking Date</th>
                                            <th scope="col">Booking Time</th>
                                            <th scope="col">Booking Status</th>
                                            <th scope="col">Amount (RM)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @foreach ($books as $b)
                <!-- Modal View Booking Details Start Here-->
                <div class="modal fade" id="viewBookingDetails-{{ $b->bookingID }}" data-bs-keyboard="false"
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
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar', // Change to bar chart
            data: {
                labels: @json($monthlyChartData['labels']),
                datasets: [{
                        label: 'Completed (RM)',
                        data: @json($monthlyChartData['completed']),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)', // Adjust color for bars
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Floating (RM)',
                        data: @json($monthlyChartData['floating']),
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Cancelled (RM)',
                        data: @json($monthlyChartData['cancelled']),
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Booking Amounts by Status',
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
                            text: 'Amount (RM)',
                        },
                    },
                },
            },
        });


        // Yearly Chart
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        const yearlyChart = new Chart(yearlyCtx, {
            type: 'bar', // Change to bar chart
            data: {
                labels: @json($yearlyChartData['labels']), // Years
                datasets: [{
                        label: 'Completed (RM)',
                        data: @json($yearlyChartData['completed']),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Floating (RM)',
                        data: @json($yearlyChartData['floating']),
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Cancelled (RM)',
                        data: @json($yearlyChartData['cancelled']),
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
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

    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : BOOKINGS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('tasker-booking-list') }}",
                        data: function(d) {
                            d.startDate = $('#startDate').val();
                            d.endDate = $('#endDate').val();
                            d.status_filter = $('#status_filter').val();
                            d.service_filter = $('#service_filter').val();

                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        }, {
                            data: 'booking_order_id',
                            name: 'booking_order_id'
                        },
                        {
                            data: 'servicetype_name',
                            name: 'servicetype_name',
                        },
                        {
                            data: 'client',
                            name: 'client',
                            visible: false
                        },
                        {
                            data: 'booking_date',
                            name: 'booking_date'
                        },
                        {
                            data: 'booking_time',
                            name: 'booking_time'
                        },
                        {
                            data: 'booking_status',
                            name: 'booking_status'
                        },
                        {
                            data: 'booking_amount',
                            name: 'booking_amount'
                        },
                    ],
                    language: {
                        emptyTable: "No data available in the table.", // Custom message when there's no data
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

                $('#startDate, #endDate').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#status_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#service_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });


                $('#clearAllBtn').on('click', function(e) {
                    e.preventDefault();
                    $('#startDate').val('');
                    $('#endDate').val('');
                    $('#status_filter').val('');
                    $('#service_filter').val('');
                    table.ajax.reload();
                    table.draw();
                });

            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
<!--Updated By: Muhammad Zikri B. Kashim (12/01/2025)-->
