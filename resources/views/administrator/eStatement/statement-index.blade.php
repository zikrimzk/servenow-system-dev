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
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <a href="{{ route('admin-refresh-statement') }}"
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
                                            <th scope="col">#</th>
                                            <th scope="col">Tasker</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
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

    @foreach ($data as $d)
        <!-- Modal Approve Start Here -->
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
                                            class="btn btn-light-success">Release</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Approve End Here -->
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

    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : MONTHLY_STATEMENTS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin-e-statement') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'tasker_code',
                            name: 'tasker_code'
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

            });
        });
    </script>
@endsection
