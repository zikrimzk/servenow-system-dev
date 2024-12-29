<?php
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
?>
@extends('administrator.layouts.main')

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
                                <li class="breadcrumb-item">Performance</li>
                                <li class="breadcrumb-item" aria-current="page">Tasker Performance</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Tasker Performance</h2>
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
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Overall Performance Score</h6>
                            <h4 class="mb-3 text-primary">{{ number_format($overallPerformance, 2) }}%</h4>
                            <p class="mb-0 text-muted text-sm">score</p>
                        </div>
                    </div>
                </div>
                @foreach ($yearlyAverages as $average)
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-2 f-w-400 text-muted">Performance Score ({{ $average['year'] }})</h6>
                                <h4 class="mb-3 text-dark">{{ $average['average_performance'] }}%</h4>
                                <p class="mb-0 text-muted text-sm">score</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <!-- Charts Section -->
                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-muted">Highest Performance Score</h6>
                            <canvas id="highestPerformersChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-muted">Lowest Performance Score</h6>
                            <canvas id="lowestPerformersChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-muted">Monthly Performance Trends</h6>
                            <canvas id="performanceTrendsChart"></canvas>
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
                                    <label for="score_filter" class="form-label">Date Range</label>
                                    <div class="d-flex align-items-center">

                                        <input type="date" id="startDate" name="startDate" class="form-control">
                                        <span class="mx-2">to</span>

                                        <input type="date" id="endDate" name="endDate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="score_filter" class="form-label">Score Range</label>
                                    <div class="d-flex align-items-center">
                                        <!-- Min Score -->
                                        <input type="text" id="score_filter_min" class="form-control"
                                            placeholder="Min Score">
                                        <span class="mx-2">-</span>
                                        <!-- Max Score -->
                                        <input type="text" id="score_filter_max" class="form-control"
                                            placeholder="Max Score">
                                    </div>
                                </div>

                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-9 mb-3">
                                    <label for="rating_filter" class="form-label">Filter by</label>
                                    <div class="d-block  d-md-flex justify-content-between align-items-center gap-2">
                                        <select id="rating_filter" class="form-select mb-3 mb-md-0">
                                            <option value="">Rating</option>
                                            <option value="1">1 Star</option>
                                            <option value="2">2 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="5">5 Stars</option>
                                        </select>

                                        <select id="reaction_filter" class="form-select mb-3 mb-md-0">
                                            <option value="">Satisfaction</option>
                                            <option value="1">Happy</option>
                                            <option value="2">Neutral</option>
                                            <option value="3">Unhappy</option>
                                        </select>

                                        <select id="penalized_filter" class="form-select mb-3 mb-md-0">
                                            <option value="">Penalized</option>
                                            <option value="1">Lowest to Highest</option>
                                            <option value="2">Highest to Lowest</option>
                                        </select>

                                    </div>
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
                                <div class="d-flex justify-content-end align-items-center">
                                    <button id="sendEmailBtn" class="btn btn-primary mb-3">Send Report</button>
                                </div>
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">#</th>
                                            <th scope="col">Tasker Code</th>
                                            <th scope="col">Average Rating</th>
                                            <th scope="col">Client Reaction</th>
                                            <th scope="col">Penalized</th>
                                            <th scope="col">Completed Services</th>
                                            <th scope="col">Performace Score</th>
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
        const chartData = @json($chartData);
        const monthlyLabels = @json($monthlyLabels);

        const datasets = chartData.map(data => {
            return {
                label: `Year ${data.year}`,
                data: data.scores,
                borderColor: getRandomColor(),
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: false,
            };
        });

        const ctx = document.getElementById('performanceTrendsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Score (%)',
                        },
                        min: 0,
                        max: 100,
                    },
                },
            },
        });

        // Helper function to generate random colors for each year
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Highest Performers Chart
        const highestPerformers = @json($highestPerformers);
        const highestLabels = highestPerformers.map(item => item.name);
        const highestScores = highestPerformers.map(item => item.score);

        new Chart(document.getElementById('highestPerformersChart'), {
            type: 'bar',
            data: {
                labels: highestLabels,
                datasets: [{
                    label: 'Performance Score (%)',
                    data: highestScores,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Lowest Performers Chart
        const lowestPerformers = @json($lowestPerformers);
        const lowestLabels = lowestPerformers.map(item => item.name);
        const lowestScores = lowestPerformers.map(item => item.score);

        new Chart(document.getElementById('lowestPerformersChart'), {
            type: 'bar',
            data: {
                labels: lowestLabels,
                datasets: [{
                    label: 'Performance Score (%)',
                    data: lowestScores,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : TASKER PERFORMANCE
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    stateSave: true,
                    ajax: {
                        url: "{{ route('admin-tasker-performance') }}",
                        data: function(d) {
                            d.startDate = $('#startDate').val();
                            d.endDate = $('#endDate').val();
                            d.rating_filter = $('#rating_filter').val();
                            d.reaction_filter = $('#reaction_filter').val();
                            d.score_filter_min = $('#score_filter_min').val();
                            d.score_filter_max = $('#score_filter_max').val();
                            d.penalized_filter = $('#penalized_filter').val();
                        }
                    },
                    columns: [{
                            data: 'checkbox', // New column for checkboxes
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,

                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tasker_code',
                            name: 'tasker_code'
                        },
                        {
                            data: 'average_rating',
                            name: 'average_rating'
                        },
                        {
                            data: 'satisfaction_reaction',
                            name: 'satisfaction_reaction'
                        },
                        {
                            data: 'total_self_cancel_refunds',
                            name: 'total_self_cancel_refunds'
                        },
                        {
                            data: 'total_completed_bookings',
                            name: 'total_completed_bookings'
                        },
                        {
                            data: 'p_score',
                            name: 'p_score'
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

                let selectedTaskers = {}; // Object to track selected taskers

                // Handle checkbox selection
                $('.data-table').on('change', '.tasker-checkbox', function() {
                    const taskerCode = $(this).val();
                    if (this.checked) {
                        selectedTaskers[taskerCode] = true; // Mark as selected
                    } else {
                        delete selectedTaskers[taskerCode]; // Remove from selection
                    }
                });

                // Handle "Select All" checkbox
                $('#select-all').on('click', function() {
                    const isChecked = this.checked;
                    $('.tasker-checkbox').each(function() {
                        const taskerCode = $(this).val();
                        if (isChecked) {
                            selectedTaskers[taskerCode] = true;
                        } else {
                            delete selectedTaskers[taskerCode];
                        }
                        $(this).prop('checked', isChecked);
                    });
                });

                // On table draw (e.g., after reload)
                $('.data-table').on('draw.dt', function() {
                    // Restore checkbox states from the selectedTaskers object
                    $('.tasker-checkbox').each(function() {
                        const taskerCode = $(this).val();
                        $(this).prop('checked', selectedTaskers[taskerCode] === true);
                    });

                    // Update the "Select All" checkbox state
                    const totalCheckboxes = $('.tasker-checkbox').length;
                    const checkedCheckboxes = $('.tasker-checkbox:checked').length;
                    $('#select-all').prop('checked', totalCheckboxes > 0 && totalCheckboxes ===
                        checkedCheckboxes);
                });

                $('#sendEmailBtn').on('click', function() {
                    let selectedTaskers = [];

                    $('.tasker-checkbox:checked').each(function() {
                        selectedTaskers.push($(this).val());
                    });
            
                    if (selectedTaskers.length > 0) {
                        $.ajax({
                            url: "{{ route('admin-send-performance-report') }}",
                            type: "POST",
                            data: {
                                selected_taskers: selectedTaskers,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.success);
                                $('.tasker-checkbox:checked').prop('checked', false);
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        alert("Please select at least one tasker.");
                    }
                });

                $('#startDate, #endDate').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#rating_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#reaction_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#penalized_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#score_filter_min, #score_filter_max').on('keyup', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#clearAllBtn').on('click', function(e) {
                    e.preventDefault();
                    $('#startDate').val('');
                    $('#endDate').val('');
                    $('#rating_filter').val('');
                    $('#reaction_filter').val('');
                    $('#score_filter_min').val('');
                    $('#score_filter_max').val('');
                    $('#penalized_filter').val('');
                    table.ajax.reload();
                    table.draw();
                });

            });


        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
