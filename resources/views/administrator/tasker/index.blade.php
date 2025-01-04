@extends('administrator.layouts.main')

@section('content')
    <style>
        .alphabet-filter-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
            /* Responsive grid */
            gap: 5px;
            /* Spacing between items */
            /* padding: 5px; */
            /* background-color: #f8f9fa; */
            /* Light background */
            /* border: 1px solid #ddd; */
            /* Subtle border */
            border-radius: 5px;
            /* Rounded corners */
        }

        .alphabet-link {
            display: block;
            text-align: center;
            padding: 6px 9px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #000000;
            /* Bootstrap primary color */
            border: 1px solid #ddd;
            /* Button-like border */
            border-radius: 5px;
            /* Rounded edges */
            transition: all 0.2s ease-in-out;
        }

        .alphabet-link:hover,
        .alphabet-link.active {
            background-color: #091b2d;
            color: #fff;
            /* White text on active/hover */
            border-color: #1e4167;
            /* Darker border */
        }

        .card-new {
            border-left: 4px solid #3037c3;
        }

        .card-unactive {
            border-left: 4px solid #ffc107;
        }

        .card-active {
            border-left: 4px solid #28a745;
        }

        .card-deactive {
            border-left: 4px solid #dc3545;
        }

        .card-inactive {
            border-left: 4px solid #838592;
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
                                <li class="breadcrumb-item">Users</li>
                                <li class="breadcrumb-item" aria-current="page">Tasker Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Tasker Management</h2>
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
                <div class="col-lg-4 col-md-6">
                    <div class="card card-active">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $activeTaskers }}</h3>
                                    <p class="text-muted mb-0">Active Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-check f-36 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-unactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $unverifiedTaskers }}</h3>
                                    <p class="text-muted mb-0">Unverify Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-clock f-36 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-inactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $inactiveTaskers }}</h3>
                                    <p class="text-muted mb-0">Inactive Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-times f-36 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-new">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $incompleteTaskers }}</h3>
                                    <p class="text-muted mb-0">Incomplete Profile Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-edit f-36 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-unactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $resetTaskers }}</h3>
                                    <p class="text-muted mb-0">Action Required Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-exclamation-triangle f-36 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-deactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $bannedTaskers }}</h3>
                                    <p class="text-muted mb-0">Banned Taskers</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-slash f-36 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Analytics End -->


            <!-- Datatable Start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-3 mb-3">
                                    <label for="date_range" class="form-label">Filter by</label>
                                    <select id="status_filter" class="form-select mb-3 mb-md-0">
                                        <option value="">Status</option>
                                        <option value="0">Incomplete Profile</option>
                                        <option value="1">Not Verified</option>
                                        <option value="2">Active</option>
                                        <option value="3">Inactive</option>
                                        <option value="4">Password Reset Needed</option>
                                        <option value="5">Banned</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <div id="alphabet-filter" class="alphabet-filter-container">
                                        <a href="#" class="alphabet-link active" data-letter="">All</a>
                                        @foreach ($alphabet as $a)
                                            <a href="#" class="alphabet-link"
                                                data-letter="{{ $a }}">{{ $a }}</a>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#changeStatusModal"
                                        class="btn btn-primary my-2 disabled" id="changeStatusModalBtn">Change
                                        Status</button>

                                    <a href="#" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#addTaskerModal">
                                        <i class="ti ti-plus f-18"></i> Add Tasker
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive mx-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">Tasker Code</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Email</th>
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
            <!-- Datatable End -->


            <!-- Modal Tasker Create Start Here -->
            <form action="{{ route('admin-tasker-create') }}" method="POST">
                @csrf
                <div class="modal fade" id="addTaskerModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Tasker</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-primary" role="alert">
                                    <h6 class="link-primary">Please note:</h6>
                                    <ul class="mb-0">
                                        <li>Fields marked with a red asterisk (<span class="text-danger">*</span>) are
                                            mandatory.</li>
                                        <li>Ensure the phone number includes the correct country code (e.g., +60 for
                                            Malaysia).</li>
                                        <li>The default password is pre-set. Please update the password later for security
                                            purposes.</li>
                                        <li>Review all entered data before clicking 'Save.'</li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tasker Code</label>
                                            <input type="text" class="form-control" name="tasker_code"
                                                value="SNT<?php echo rand(1, 1000000); ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <!-- First Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                First Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('tasker_firstname') is-invalid @enderror"
                                                placeholder="First Name" name="tasker_firstname"
                                                value="{{ old('tasker_firstname') }}" />
                                            @error('tasker_firstname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Last Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Last Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('tasker_lastname') is-invalid @enderror"
                                                placeholder="Last Name" name="tasker_lastname"
                                                value="{{ old('tasker_lastname') }}" />
                                            @error('tasker_lastname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Number Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Phone Number
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">+60</span>
                                                <input type="text"
                                                    class="form-control @error('tasker_phoneno') is-invalid @enderror tasker-phoneno"
                                                    placeholder="Phone No." name="tasker_phoneno"
                                                    value="{{ old('tasker_phoneno') }}" maxlength="13" />
                                                @error('tasker_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div id="phone-error-message" class="text-danger text-sm"
                                                    style="display: none;">
                                                    Phone number must be in a valid format (10 or 11 digits)!
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email" name="email" value="{{ old('email') }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Account Status Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <select class="form-select @error('tasker_status') is-invalid @enderror"
                                                name="tasker_status">
                                                <option value="4" selected> Password Need Update</option>
                                            </select>
                                            @error('tasker_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" name="password" value="servenow@1234" />
                                            <span class="text-muted" style="font-size: 9pt">[Default:
                                                servenow@1234]</span>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                                <div class="flex-grow-1 text-end">
                                    <button type="reset" class="btn btn-link-danger btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Modal Tasker Create End  Here -->

            <!-- Modal Update Status Client Start Here-->
            <div class="modal fade" id="changeStatusModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0">Change Status</h5>
                            <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                data-bs-dismiss="modal">
                                <i class="ti ti-x f-20"></i>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label d-block mb-2">Tasker Status</label>
                                        <select class="form-control mb-2" id="admin_status_update">
                                            <option value="" selected>Select Status</option>
                                            <option value="0">Incomplete Profile</option>
                                            <option value="1">Not Verified</option>
                                            <option value="2">Active</option>
                                            <option value="3">Inactive</option>
                                            <option value="4">Password Reset Needed</option>
                                            <option value="5">Banned</option>
                                        </select>
                                        <span id="selectionCount" class="text-primary">0</span> bookings selected.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light btn-pc-default"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="updateStatusBtn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Update Status client End Here-->

            @foreach ($taskers as $tk)
                <!-- Modal Tasker Update Start Here -->
                <form action="{{ route('admin-tasker-update', $tk->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateTaskerModal-{{ $tk->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Tasker Update ({{ $tk->tasker_code }})</h5>
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
                                                    <img src="{{ asset('storage/' . $tk->tasker_photo) }}"
                                                        alt="Profile Photo" width="150" height="150"
                                                        class="user-avtar rounded-circle">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="alert alert-primary" role="alert">
                                                <h6 class="link-primary">Please note:</h6>
                                                <ul class="mb-0">
                                                    <li>Fields marked with a red asterisk (<span
                                                            class="text-danger">*</span>) are
                                                        mandatory.</li>
                                                    <li>Ensure the phone number includes the correct country code (e.g., +60
                                                        for
                                                        Malaysia).</li>
                                                    <li>Review all entered data before clicking 'Save Changes.'</li>
                                                </ul>
                                            </div>
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
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_firstname') is-invalid @enderror"
                                                            placeholder="First Name" name="tasker_firstname"
                                                            value="{{ $tk->tasker_firstname }}" />
                                                        @error('tasker_firstname')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Last Name Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Last Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_lastname') is-invalid @enderror"
                                                            placeholder="Last Name" name="tasker_lastname"
                                                            value="{{ $tk->tasker_lastname }}" />
                                                        @error('tasker_lastname')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- IC Number Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            IC Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_icno') is-invalid @enderror"
                                                            placeholder="Enter IC number" name="tasker_icno"
                                                            value="{{ $tk->tasker_icno }}" id="tasker_icno" maxlength="12" pattern="^\d{12}$" />
                                                        @error('tasker_icno')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div id="ic-error-message" class="text-danger"
                                                            style="display: none;">IC Number must be exactly 12 digits!
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Date of Birth Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Date of Birth
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="date"
                                                            class="form-control @error('tasker_dob') is-invalid @enderror"
                                                            name="tasker_dob" value="{{ $tk->tasker_dob }}"
                                                            id="tasker_dob" />
                                                        @error('tasker_dob')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <div id="dob-error-message" class="text-danger"
                                                            style="display: none;">You must be 18 years and above!
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Phone Number Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Phone Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">+60</span>
                                                            <input type="text"
                                                                class="form-control @error('tasker_phoneno') is-invalid @enderror tasker-phoneno"
                                                                placeholder="Phone No." name="tasker_phoneno"
                                                                value="{{ $tk->tasker_phoneno }}" maxlength="13" />
                                                            @error('tasker_phoneno')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <div id="phone-error-message" class="text-danger text-sm"
                                                                style="display: none;">
                                                                Phone number must be in a valid format (10 or 11 digits)!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Email Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Email
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            placeholder="Email" name="email"
                                                            value="{{ $tk->email }}" />
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <h5 class="mb-2 mt-2 mt-2">B. Tasker Address</h5>

                                                <!-- Address Line 1 Field -->
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Address Line 1 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_address_one') is-invalid @enderror"
                                                            name="tasker_address_one"
                                                            value="{{ $tk->tasker_address_one }}"
                                                            placeholder="Address Line 1" />
                                                        @error('tasker_address_one')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Address Line 2 Field -->
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Address Line 2 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_address_two') is-invalid @enderror"
                                                            name="tasker_address_two"
                                                            value="{{ $tk->tasker_address_two }}"
                                                            placeholder="Address Line 2" />
                                                        @error('tasker_address_two')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Postal Code Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Postal Code <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_address_poscode') is-invalid @enderror"
                                                            name="tasker_address_poscode"
                                                            value="{{ $tk->tasker_address_poscode }}"
                                                            placeholder="Postal Code" />
                                                        @error('tasker_address_poscode')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- State Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">State <span
                                                                class="text-danger">*</span></label>
                                                        <select name="tasker_address_state"
                                                            class="form-control @error('tasker_address_state') is-invalid @enderror addStateT">
                                                            @if ($tk->tasker_address_state == '')
                                                                <option value="" selected>Select State</option>
                                                                @foreach ($states['states'] as $state)
                                                                    <option value="{{ strtolower($state['name']) }}">
                                                                        {{ $state['name'] }}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach ($states['states'] as $state)
                                                                    @if ($tk->tasker_address_state == strtolower($state['name']))
                                                                        <option value="{{ strtolower($state['name']) }}"
                                                                            selected>
                                                                            {{ $state['name'] }}</option>
                                                                    @else
                                                                        <option value="{{ strtolower($state['name']) }}">
                                                                            {{ $state['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                        @error('tasker_address_state')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Area Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Area <span
                                                                class="text-danger">*</span></label>
                                                        <select name="tasker_address_area"
                                                            class="form-control @error('tasker_address_area') is-invalid @enderror addCityT">
                                                            @if ($tk->tasker_address_area == '')
                                                                <option value="" selected>Select Area</option>
                                                            @else
                                                                <option value="{{ $tk->tasker_address_area }}" selected>
                                                                    {{ $tk->tasker_address_area }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                        @error('tasker_address_area')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <h5 class="mb-2 mt-2">C. Working Area</h5>

                                                <!-- Working Area State Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">State <span
                                                                class="text-danger">*</span></label>
                                                        <select name="tasker_workingloc_state"
                                                            class="form-control @error('tasker_workingloc_state') is-invalid @enderror addState"
                                                            id="workState">
                                                            @if ($tk->tasker_workingloc_state == '')
                                                                <option value="" selected>Select State</option>
                                                                @foreach ($states['states'] as $state)
                                                                    <option value="{{ strtolower($state['name']) }}">
                                                                        {{ $state['name'] }}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach ($states['states'] as $state)
                                                                    @if ($tk->tasker_workingloc_state == strtolower($state['name']))
                                                                        <option value="{{ strtolower($state['name']) }}"
                                                                            selected>
                                                                            {{ $state['name'] }}</option>
                                                                    @else
                                                                        <option value="{{ strtolower($state['name']) }}">
                                                                            {{ $state['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('tasker_workingloc_state')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Working Area Area Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Area <span
                                                                class="text-danger">*</span></label>
                                                        <select name="tasker_workingloc_area"
                                                            class="form-control @error('tasker_workingloc_area') is-invalid @enderror addCity"
                                                            id="workCity">
                                                            @if ($tk->tasker_workingloc_area == '')
                                                                <option value="" selected>Select Area</option>
                                                            @else
                                                                <option value="{{ $tk->tasker_workingloc_area }}"
                                                                    selected>
                                                                    {{ $tk->tasker_workingloc_area }}</option>
                                                            @endif
                                                        </select>
                                                        @error('tasker_workingloc_area')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Working Radius Field -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Working Radius (KM)
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" min="1" max="200"
                                                            class="form-control @error('working_radius') is-invalid @enderror"
                                                            placeholder="Working Radius" name="working_radius"
                                                            value="{{ $tk->working_radius }}" />
                                                        @error('working_radius')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <h5 class="mb-2 mt-2">D. Account Details</h5>
                                                <!-- Bio Field -->
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Bio</label>
                                                        <textarea class="form-control @error('tasker_bio') is-invalid @enderror" rows="4" name="tasker_bio"
                                                            placeholder="Enter your bio here...">{{ $tk->tasker_bio }}</textarea>
                                                        @error('tasker_bio')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Account Status Field -->
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Account Status</label>
                                                        <select
                                                            class="form-select @error('tasker_status') is-invalid @enderror"
                                                            name="tasker_status">
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
                                                        @error('tasker_status')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
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
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="tasker_account_bank" id="tasker_account_bank"
                                                            class="form-select @error('tasker_account_bank') is-invalid @enderror">
                                                            @if ($tk->tasker_account_bank == '')
                                                                <option value="">Select Bank</option>
                                                            @else
                                                                <option value="{{ $tk->tasker_account_bank }}">
                                                                    {{ $tk->tasker_account_bank }}</option>
                                                            @endif
                                                            @foreach ($bank as $banks)
                                                                @if ($banks['bank'] != $tk->tasker_account_bank)
                                                                    <option value="{{ $banks['bank'] }}">
                                                                        {{ $banks['bank'] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('tasker_account_bank')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <!-- Account Number Field -->
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="tasker_account_number" class="form-label">Account
                                                            Number</label>
                                                        <input type="text"
                                                            class="form-control @error('tasker_account_number') is-invalid @enderror"
                                                            name="tasker_account_number"
                                                            value="{{ $tk->tasker_account_number }}"
                                                            placeholder="Account Number" />
                                                        @error('tasker_account_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror



                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">



                                    </div>
                                </div>
                                <div class="modal-footer justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <button type="reset" class="btn btn-link-danger btn-pc-default"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal Tasker Update End  Here -->
            @endforeach


        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addTaskerModal'));
                modal.show();
            @endif
        });

        const icNoField = document.getElementById('tasker_icno');
        const dobField = document.getElementById('tasker_dob');
        const icErrorMessage = document.getElementById('ic-error-message');
        const dobErrorMessage = document.getElementById('dob-error-message');

        icNoField.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');

            const icNo = this.value.trim();
            const currentYear = new Date().getFullYear();

            // Validate IC Number (exactly 12 digits)
            if (icNo.length === 12) {
                const yearPrefix = parseInt(icNo.substring(0, 2), 10);
                const month = icNo.substring(2, 4);
                const day = icNo.substring(4, 6);

                // Determine full year
                let birthYear = yearPrefix <= (currentYear % 100) ? 2000 + yearPrefix : 1900 + yearPrefix;

                // Validate date components and age
                const birthDate = new Date(`${birthYear}-${month}-${day}`);
                const age = currentYear - birthYear - (new Date().setFullYear(currentYear) < birthDate ? 1 : 0);

                if (!isNaN(birthDate) && age >= 18) {
                    dobField.value = birthDate.toISOString().split('T')[0];
                    dobField.classList.remove('is-invalid');
                    dobErrorMessage.style.display = 'none';
                } else {
                    dobField.value = '';
                    dobField.classList.add('is-invalid');
                    dobErrorMessage.style.display = 'block';
                }

                icErrorMessage.style.display = 'none'; // Hide IC Number error message
            } else {
                dobField.value = '';
                dobField.classList.add('is-invalid');
                dobErrorMessage.style.display = 'block';
                icErrorMessage.style.display = 'block'; // Show IC Number error message
            }
        });

        $(document).ready(function() {

            // DATATABLE : TASKERS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin-tasker-management') }}",
                        data: function(d) {
                            d.status_filter = $('#status_filter').val();
                            d.name_filter = $('#alphabet-filter .active').data('letter');
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
                            data: 'tasker_fullname',
                            name: 'tasker_fullname'
                        },
                        {
                            data: 'tasker_phoneno',
                            name: 'tasker_phoneno',
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'tasker_status',
                            name: 'tasker_status'
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

                $('#alphabet-filter').on('click', '.alphabet-link', function(e) {
                    e.preventDefault();

                    // Highlight the active letter
                    $('#alphabet-filter .alphabet-link').removeClass('active');
                    $(this).addClass('active');

                    // Reload table data
                    table.ajax.reload();
                });

                $(document).on('input', '.tasker-phoneno', function() {
                    const $inputField = $(this);
                    const input = $inputField.val().replace(/\D/g,
                        ''); // Remove non-numeric characters
                    const $modal = $inputField.closest(
                        '.modal'); // Get the modal containing this input field
                    const $errorMessage = $modal.find(
                        '.phone-error-message'); // Find the error message within the same modal

                    if (input.length <= 11) {
                        if (input.length === 10) {
                            // Format for 10 digits: ### ### ####
                            $inputField.val(input.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3'));
                            $errorMessage.hide();
                        } else if (input.length === 11) {
                            // Format for 11 digits: ### #### ####
                            $inputField.val(input.replace(/(\d{3})(\d{4})(\d{4})/, '$1 $2 $3'));
                            $errorMessage.hide();
                        } else {
                            $inputField.val(input); // Unformatted during input
                            $errorMessage.hide();
                        }
                    } else {
                        // Show error if more than 11 digits
                        $errorMessage.show();
                    }
                });

                function updateArea(modal, stateSelector, citySelector, urlSuffix = '') {
                    const state = modal.find(stateSelector)
                        .val(); // Find the state within the current modal
                    const cityDropdown = modal.find(
                        citySelector); // Find the city dropdown in the current modal

                    if (state) {
                        $.ajax({
                            url: '/get-areas/' + state + urlSuffix, // Ensure this matches the route
                            type: 'GET',
                            success: function(data) {
                                cityDropdown.empty().append(
                                    '<option value="">Select Area</option>');
                                $.each(data, function(index, area) {
                                    cityDropdown.append('<option value="' + area +
                                        '">' + area + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching areas: " +
                                    error); // Debugging output
                            }
                        });
                    } else {
                        cityDropdown.empty().append('<option value="">Select Area</option>');
                    }
                }

                // Modal shown logic
                $(document).on('shown.bs.modal', '.modal-up', function() {
                    const modal = $(this); // Current modal being triggered
                    const stateT = modal.find('.addStateT').val();
                    const state = modal.find('.addState').val();

                    // Check and update if necessary
                    if (!stateT) updateArea(modal, '.addStateT', '.addCityT');
                    if (!state) updateArea(modal, '.addState', '.addCity');
                });

                // State change logic
                $(document).on('change', '.addState', function() {
                    const modal = $(this).closest('.modal');
                    updateArea(modal, '.addState', '.addCity');
                });

                $(document).on('change', '.addStateT', function() {
                    const modal = $(this).closest('.modal');
                    updateArea(modal, '.addStateT', '.addCityT');
                });

                let selectedUsers = {}; // Track selected rows

                // Function to update selection count and button states
                function updateSelectionCountAndButtons() {
                    const selectedCount = Object.keys(selectedUsers).length;

                    // Update selection counts
                    $('#selectionCount').text(selectedCount);

                    if (selectedCount > 0) {
                        $('#changeStatusModalBtn').removeClass('disabled'); // Enable button
                    } else {
                        $('#changeStatusModalBtn').addClass('disabled'); // Disable button
                    }
                }

                // Handle checkbox selection
                $('.data-table').on('change', '.user-checkbox', function() {
                    const userID = $(this).val();
                    if (this.checked) {
                        selectedUsers[userID] = true; // Add to selected
                    } else {
                        delete selectedUsers[userID]; // Remove from selected
                    }
                    updateSelectionCountAndButtons();
                });

                // Handle "Select All" checkbox
                $('#select-all').on('change', function() {
                    const isChecked = this.checked;
                    $('.user-checkbox').each(function() {
                        const userID = $(this).val();
                        if (isChecked) {
                            selectedUsers[userID] = true;
                        } else {
                            delete selectedUsers[userID];
                        }
                        $(this).prop('checked', isChecked);
                    });
                    updateSelectionCountAndButtons();
                });

                // On table redraw
                $('.data-table').on('draw.dt', function() {
                    $('.user-checkbox').each(function() {
                        const userID = $(this).val();
                        $(this).prop('checked', selectedUsers[userID] === true);
                    });

                    // Update "Select All" state
                    const totalCheckboxes = $('.user-checkbox').length;
                    const checkedCheckboxes = $('.user-checkbox:checked').length;
                    $('#select-all').prop('checked', totalCheckboxes > 0 && totalCheckboxes ===
                        checkedCheckboxes);

                    updateSelectionCountAndButtons();
                });

                // Change status button click event
                $('#updateStatusBtn').on('click', function() {
                    const $button = $(this);
                    const selectedUsers = [];
                    const status = $('#admin_status_update').val();

                    $('.user-checkbox:checked').each(function() {
                        selectedUsers.push($(this).val());
                    });


                    console.log(selectedUsers, status);

                    if (selectedUsers.length > 0) {

                        // Disable the button and show loading text
                        $button.prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm me-2"></span>Saving...'
                        );

                        $.ajax({
                            url: "{{ route('admin-tasker-status-update') }}",
                            type: "POST",
                            data: {
                                selected_tasker: selectedUsers,
                                tasker_status: status,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.message);
                                window.location.reload();
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                alert("Error: " + xhr.responseText);
                            }
                        });
                    } else {
                        alert(
                            "No valid data selected for status change."
                        );
                    }
                });

            });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
