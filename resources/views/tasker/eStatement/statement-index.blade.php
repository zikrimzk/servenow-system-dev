@extends('tasker.layouts.main')

@section('content')
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
                            <p class="mb-0 text-muted text-sm">Pending payouts</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-4">
                    <div class="card card-confirmed">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Earnings</h6>
                            <h3 class="mb-3 text-success">RM {{ $releasedthisyear }}</h3>
                            <p class="mb-0 text-muted text-sm">Amount earned this year</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xl-4">
                    <div class="card card-cancelled">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Total Earnings</h6>
                            <h3 class="mb-3 text-danger">RM {{ $releasedAll }}</h3>
                            <p class="mb-0 text-muted text-sm">Amount earned</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Charts -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Monthly Earnings</div>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyReleasedChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Yearly Earnings</div>
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
                        <div class="card-body">
                            <div class="dt-responsive table-responsive my-4 mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">Amount (RM)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Statement</th>
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
                        url: "{{ route('tasker-e-statement') }}",
                        data: function(d) {
                            d.startMonth = $('#startMonth').val();
                            d.endMonth = $('#endMonth').val();
                            d.status_filter = $('#status_filter').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
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

                $('#status_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#clearAllBtn').on('click', function(e) {
                    e.preventDefault();
                    $('#startMonth').val('');
                    $('#endMonth').val('');
                    $('#status_filter').val('');
                    table.ajax.reload();
                    table.draw();
                });

            });
        });
    </script>
@endsection
