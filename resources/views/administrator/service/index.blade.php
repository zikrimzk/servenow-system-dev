@extends('administrator.layouts.main')

@section('content')
    <style>
        .card-all {
            border-left: 4px solid #10100f;
        }

        .card-pending {
            border-left: 4px solid #ffc107;
        }

        .card-active {
            border-left: 4px solid #28a745;
        }

        .card-terminated {
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
                                <li class="breadcrumb-item">Services</li>
                                <li class="breadcrumb-item" aria-current="page">Service Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Service Management</h2>
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
                    <div class="card card-all">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-dark">Service Registered</h6>
                            <h4 class="mb-3">{{ $totalService }}</h4>
                            <p class="mb-0 text-muted text-sm">services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-pending">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-warning">Pending Services</h6>
                            <h4 class="mb-3">{{ $totalPendingService }}</h4>
                            <p class="mb-0 text-muted text-sm">services pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-active">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-success">Active Services</h6>
                            <h4 class="mb-3">{{ $totalActiveService }}</h4>
                            <p class="mb-0 text-muted text-sm">services active</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-terminated">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-danger">Terminated Services</h6>
                            <h4 class="mb-3">{{ $totalTerminatedService }}</h4>
                            <p class="mb-0 text-muted text-sm">services terminated</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-dark">Most Popular Service Types</h6>
                            <canvas id="popularServiceChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 f-w-400 text-dark">Top Taskers by Registered Services</h6>
                            <canvas id="taskerServiceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6 col-xl-3">
                                    <label for="status_filter" class="form-label">Filter by</label>
                                    <select id="status_filter" class="form-select mb-3 mb-md-0">
                                        <option value="">Status (All)</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">Rejected</option>
                                        <option value="4">Terminated</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <a href="#" id="approveRejectBtn"
                                        class="btn btn-primary d-inline-flex align-items-center gap-2 disabled"
                                        data-bs-toggle="modal" data-bs-target="#approveMultipleModal">
                                        <i class="ti ti-check f-18"></i> Approve / Reject
                                    </a>
                                    <a href="#" id="terminateModalBtn"
                                        class="btn btn-danger d-inline-flex align-items-center gap-2 disabled"
                                        data-bs-toggle="modal" data-bs-target="#terminateMultipleModal">
                                        <i class="ti ti-x f-18"></i> Terminate
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive my-4 mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">#</th>
                                            <th scope="col">Tasker</th>
                                            <th scope="col">Service Name</th>
                                            <th scope="col">Rate (RM)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Approve Start Here -->
            <div class="modal fade" id="approveMultipleModal" data-bs-keyboard="false" tabindex="-1"
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
                                        <h2>Service Request Approval</h2>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fw-normal f-16 text-center">Are you sure you want to approve/reject the
                                            selected <span id="selectionCount">0</span>
                                            services request ?</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-between gap-3 align-items-center">
                                        <button type="reset" class="btn btn-light btn-pc-default"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <div>
                                            <button type="button" id="rejectBtn"
                                                class="btn btn-light-danger">Reject</button>
                                            <button type="button" id="approveBtn"
                                                class="btn btn-light-success">Approve</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Approve End Here -->

            <!-- Modal Terminate Start Here -->
            <div class="modal fade" id="terminateMultipleModal" data-bs-keyboard="false" tabindex="-1"
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
                                        <h2>Terminate Service</h2>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fw-normal f-18 text-center">Are you sure to terminate the selected <span
                                                id="selectionCountTwo">0</span>
                                            services ?</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-center gap-3 align-items-center">
                                        <button type="reset" class="btn btn-light btn-pc-default"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" id="terminateBtn"
                                            class="btn btn-light-danger">Terminate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Terminate End Here -->


            @foreach ($services as $sv)
                <!-- Modal Service Edit Start Here -->
                <div class="modal fade" id="viewDescModal-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                        <form action="{{ route('tasker-service-create') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Service Details</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Service Type</label>
                                                <select class="form-select" name="service_type_id">
                                                    @foreach ($types as $type)
                                                        @if ($sv->service_type_id == $type->id)
                                                            <option value="{{ $type->id }}" selected>
                                                                {{ $type->servicetype_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $type->id }}" disabled>
                                                                {{ $type->servicetype_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Rate</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" class="form-control" placeholder="Service Rate"
                                                        name="service_rate" value="{{ $sv->service_rate }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Rate Type</label>
                                                <select class="form-select" name="service_rate_type">
                                                    @if ($sv->service_rate_type == 'per hour')
                                                        <option value="per job" disabled>Per Job</option>
                                                        <option value="per hour" selected>Per Hour</option>
                                                    @elseif($sv->service_rate_type == 'per job')
                                                        <option value="per job" selected>Per Job</option>
                                                        <option value="per hour" disabled>Per Hour</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Service Description</label>
                                                <textarea name="service_desc" class="form-control" cols="20" rows="4"
                                                    placeholder="Enter your description ...">{{ $sv->service_desc }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Service Edit End  Here -->

                <!-- Modal Approve Start Here -->
                <div class="modal fade" id="approveModal-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
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
                                            <h2>Service Request Approval</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">Are you sure you want to approve this
                                                request ?</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <div>
                                                <a href="{{ route('admin-reject-service', $sv->id) }}"
                                                    class="btn btn-light-danger">Reject</a>
                                                <a href="{{ route('admin-approve-service', $sv->id) }}"
                                                    class="btn btn-light-success">Approve</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Approve End Here -->

                <!-- Modal Terminate Start Here -->
                <div class="modal fade" id="terminateModal-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
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
                                            <h2>Terminate Service</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">Are you sure to terminate this
                                                services ?</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('admin-terminate-service', $sv->id) }}"
                                                class="btn btn-light-danger">Terminate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Terminate End Here -->
            @endforeach


        </div>

    </div>
    <!-- [ Main Content ] end -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onload = function() {
            const serviceLabels = @json($popularServiceTypes->pluck('servicetype_name'));
            const topserviceCounts = @json($popularServiceTypes->pluck('service_count'));

            // PIE CHART
            const ctx1 = document.getElementById('popularServiceChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar', // Change to horizontal bar
                data: {
                    labels: serviceLabels,
                    datasets: [{
                        label: 'Service Count',
                        data: topserviceCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Makes the bar horizontal
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // You can hide legend if not needed
                        }
                    }
                }
            });


            // BAR CHART
            const taskerLabels = @json($taskerServiceCounts->pluck('tasker_firstname'));
            const serviceCounts = @json($taskerServiceCounts->pluck('service_count'));

            const ctx2 = document.getElementById('taskerServiceChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: taskerLabels,
                    datasets: [{
                        label: 'Number of Registered Services',
                        data: serviceCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : SERVICES
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    saveState: false,
                    ajax: {
                        url: "{{ route('admin-service-management') }}",
                        data: function(d) {
                            d.status_filter = $('#status_filter').val();
                        }
                    },
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,

                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'tasker',
                            name: 'tasker'
                        },
                        {
                            data: 'servicetype_name',
                            name: 'servicetype_name'
                        },
                        {
                            data: 'service_rate',
                            name: 'service_rate'
                        },
                        {
                            data: 'service_status',
                            name: 'service_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
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

                $('#status_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                let selectedService = {}; // Track selected rows

                // Function to update selection count and button states
                function updateSelectionCountAndButtons() {
                    const selectedCount = Object.keys(selectedService).length;

                    // Update selection counts
                    $('#selectionCount').text(selectedCount);
                    $('#selectionCountTwo').text(selectedCount);

                    // Track statuses
                    let hasOnlyPending = true; // Assume all are pending until proven otherwise
                    let hasOnlyActive = true; // Assume all are active until proven otherwise

                    // Check the status of selected rows
                    $('.service-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const status = row.find('td:nth-child(6) .badge')
                            .text(); // Adjust column index for "status"

                        // If any status is not 'Pending', disable Approve/Reject
                        if (status !== 'Pending') hasOnlyPending = false;

                        // If any status is not 'Active', disable Terminate
                        if (status !== 'Active') hasOnlyActive = false;
                    });

                    // Approve/Reject Button: Enable only if all selected are Pending
                    if (hasOnlyPending && selectedCount > 0) {
                        $('#approveRejectBtn').removeClass('disabled');
                    } else {
                        $('#approveRejectBtn').addClass('disabled');
                    }

                    // Terminate Button: Enable only if all selected are Active
                    if (hasOnlyActive && selectedCount > 0) {
                        $('#terminateModalBtn').removeClass('disabled');
                    } else {
                        $('#terminateModalBtn').addClass('disabled');
                    }
                }


                // Handle checkbox selection
                $('.data-table').on('change', '.service-checkbox', function() {
                    const serviceId = $(this).val();
                    if (this.checked) {
                        selectedService[serviceId] = true; // Add to selected
                    } else {
                        delete selectedService[serviceId]; // Remove from selected
                    }
                    updateSelectionCountAndButtons();
                });

                // Handle "Select All" checkbox
                $('#select-all').on('change', function() {
                    const isChecked = this.checked;
                    $('.service-checkbox').each(function() {
                        const serviceId = $(this).val();
                        if (isChecked) {
                            selectedService[serviceId] = true;
                        } else {
                            delete selectedService[serviceId];
                        }
                        $(this).prop('checked', isChecked);
                    });
                    updateSelectionCountAndButtons();
                });

                // On table redraw
                $('.data-table').on('draw.dt', function() {
                    $('.service-checkbox').each(function() {
                        const serviceId = $(this).val();
                        $(this).prop('checked', selectedService[serviceId] === true);
                    });

                    // Update "Select All" state
                    const totalCheckboxes = $('.service-checkbox').length;
                    const checkedCheckboxes = $('.service-checkbox:checked').length;
                    $('#select-all').prop('checked', totalCheckboxes > 0 && totalCheckboxes ===
                        checkedCheckboxes);

                    updateSelectionCountAndButtons();
                });

                // Approve/Reject Action
                $('#approveBtn').on('click', function() {
                    const $buttonOne = $(this);
                    const selectedPending = [];
                    $('.service-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const status = row.find('td:nth-child(6) .badge')
                            .text(); // Adjust column index for "status"

                        if (status === 'Pending') {
                            selectedPending.push($(this).val());
                        }
                    });

                    if (selectedPending.length > 0) {
                        // Disable the button and show loading text
                        $buttonOne.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Approving...'
                        );
                        $.ajax({
                            url: "{{ route('admin-approve-multiple-service') }}",
                            type: "POST",
                            data: {
                                selected_service: selectedPending,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // alert(response.success);
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                alert("Error: " + xhr.responseText);
                            }
                        });
                    } else {
                        alert("No Pending services selected.");
                    }
                });

                // Reject Action
                $('#rejectBtn').on('click', function() {
                    const $buttonTwo = $(this);
                    const selectedPending = [];
                    $('.service-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const status = row.find('td:nth-child(6) .badge')
                            .text(); // Adjust column index for "status"

                        if (status === 'Pending') {
                            selectedPending.push($(this).val());
                        }
                    });

                    if (selectedPending.length > 0) {
                        // Disable the button and show loading text
                        $buttonTwo.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Rejecting...'
                        );
                        $.ajax({
                            url: "{{ route('admin-reject-multiple-service') }}",
                            type: "POST",
                            data: {
                                selected_service: selectedPending,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // alert(response.success);
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        alert("No Pending services selected.");
                    }
                });

                // Terminate Action
                $('#terminateBtn').on('click', function() {
                    const $buttonThree = $(this);
                    const selectedActive = [];
                    $('.service-checkbox:checked').each(function() {
                        const row = $(this).closest('tr');
                        const status = row.find('td:nth-child(6) .badge')
                            .text(); // Adjust column index for "status"

                        if (status === 'Active') {
                            selectedActive.push($(this).val());
                        }
                    });

                    if (selectedActive.length > 0) {
                        // Disable the button and show loading text
                        $buttonThree.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Terminating...'
                        );
                        $.ajax({
                            url: "{{ route('admin-terminate-multiple-service') }}",
                            type: "POST",
                            data: {
                                selected_service: selectedActive,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // alert(response.success);
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        alert("No Active services selected.");
                    }
                });
            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
