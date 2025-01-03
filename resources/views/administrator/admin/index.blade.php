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

        .card-all {
            border-left: 4px solid #10100f;
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
                                <li class="breadcrumb-item" aria-current="page">Administrator Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Administrator Management</h2>
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
                <div class="col-lg-3 col-md-6">
                    <div class="card card-active">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $activated }}</h3>
                                    <p class="text-muted mb-0">Active Administrators</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-check f-36 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card card-inactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $inactive }}</h3>
                                    <p class="text-muted mb-0">Inactive Administrators</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-times f-36 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card card-unactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $notActivated }}</h3>
                                    <p class="text-muted mb-0">Not Activated Administrators</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-clock f-36 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card card-deactive">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $deactivated }}</h3>
                                    <p class="text-muted mb-0">Deactivated Administrators</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-user-lock f-36 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-3 mb-3">
                                    <label for="date_range" class="form-label">Filter by</label>
                                    <select id="status_filter" class="form-select mb-3 mb-md-0">
                                        <option value="">Status</option>
                                        <option value="0">Not Activated</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">Deactivated</option>
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
                            <div class="d-sm-flex align-items-center justify-content-end gap-4">
                                <div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#changeStatusModal"
                                        class="btn btn-primary my-2 disabled" id="changeStatusModalBtn">Change
                                        Status</button>

                                    <a href="#" class="btn btn-primary my-2 d-inline-flex align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                        <i class="ti ti-plus f-18"></i> Add Administrator
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
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Administrator Create Start Here -->
            <form action="{{ route('admin-create') }}" method="POST">
                @csrf
                <div class="modal fade" id="addAdminModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Administrator</h5>
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
                                            <label class="form-label">Admin Code</label>
                                            <input type="text" class="form-control" name="admin_code"
                                                value="SNA<?php echo rand(1, 1000000); ?>" readonly />
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
                                                class="form-control @error('admin_firstname') is-invalid @enderror"
                                                name="admin_firstname" placeholder="First Name"
                                                value="{{ old('admin_firstname') }}" />
                                            @error('admin_firstname')
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
                                                class="form-control @error('admin_lastname') is-invalid @enderror"
                                                name="admin_lastname" placeholder="Last Name"
                                                value="{{ old('admin_lastname') }}" />
                                            @error('admin_lastname')
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
                                                    class="form-control @error('admin_phoneno') is-invalid @enderror"
                                                    placeholder="Phone No." name="admin_phoneno"
                                                    value="{{ old('admin_phoneno') }}" id="admin_phoneno"
                                                    maxlength="13" />
                                                @error('admin_phoneno')
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
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"placeholder="Email" value="{{ old('email') }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Account Status Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <select class="form-select @error('admin_status') is-invalid @enderror"
                                                name="admin_status">
                                                <option value ="0">Not-Activated (default)</option>
                                                <option value ="1" disabled>Active</option>
                                                <option value = "2" disabled>Inactive</option>
                                            </select>
                                            @error('admin_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password </label>
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
            <!-- Modal Administrator Create End  Here -->

            <!-- Modal Update Status Admin Start Here-->
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
                                        <label class="form-label d-block mb-2">Admin Status</label>
                                        <select class="form-control mb-2" id="admin_status_update">
                                            <option value="" selected>Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
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
            <!-- Modal Update Status Admin  End Here-->


            @foreach ($admins as $admin)
                <!-- Modal Administrator Edit Start Here -->
                <form action="{{ route('admin-update', $admin->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateAdminModal-{{ $admin->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Administrator Details</h5>
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
                                            <li>Review all entered data before clicking 'Save Changes.'</li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center mb-3">
                                                    <img src="{{ asset('storage/' . $admin->admin_photo) }}"
                                                        alt="Profile Photo" width="150" height="150"
                                                        class="user-avtar rounded-circle">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Admin Code</label>
                                                        <input type="text" class="form-control" name="admin_code"
                                                            value="{{ $admin->admin_code }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            First Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="First Name" name="admin_firstname"
                                                            value="{{ $admin->admin_firstname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Last Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Last Name" name="admin_lastname"
                                                            value="{{ $admin->admin_lastname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Email
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                            name="email" value="{{ $admin->email }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Phone Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">+60</span>
                                                            <input type="text" class="form-control"
                                                                placeholder="Phone No." name="admin_phoneno"
                                                                value="{{ $admin->admin_phoneno }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Account Status</label>
                                                        <select class="form-select" name="admin_status">
                                                            @if ($admin->admin_status == 0)
                                                                <option value ="0">Not-Activated (default)</option>
                                                            @elseif($admin->admin_status == 1)
                                                                <option value ="1" selected>Active</option>
                                                                <option value = "2">Inactive</option>
                                                            @elseif($admin->admin_status == 2)
                                                                <option value ="1">Active</option>
                                                                <option value = "2" selected>Inactive</option>
                                                            @elseif($admin->admin_status == 3)
                                                                <option value = "3" selected>Deactivated</option>
                                                                <option value ="1">Active</option>
                                                                <option value = "2">Inactive</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                <!-- Modal Administrator Edit End  Here -->

                <!-- Modal Delete Start Here -->
                <div class="modal fade" id="deleteModal-{{ $admin->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <i class="ti ti-trash text-danger" style="font-size: 100px"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h2>Account Deletion</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">
                                                This action will not permanently delete the user. You can always change the
                                                status back to active if needed. Are you sure you want to deactivate
                                                {{ $admin->admin_firstname }} account?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('admin-delete', $admin->id) }}"
                                                class="btn btn-danger">Deactivate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Delete End Here -->
            @endforeach


        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addAdminModal'));
                modal.show();
            @endif
        });

        document.getElementById('admin_phoneno').addEventListener('input', function() {
            const input = this.value.replace(/\D/g, ''); // Remove non-numeric characters
            const errorMessage = document.getElementById('phone-error-message');

            if (input.length <= 11) {
                if (input.length === 10) {
                    // Format for 10 digits: ### ### ####
                    this.value = input.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3');
                    errorMessage.style.display = 'none';
                } else if (input.length === 11) {
                    // Format for 11 digits: ### #### ####
                    this.value = input.replace(/(\d{3})(\d{4})(\d{4})/, '$1 $2 $3');
                    errorMessage.style.display = 'none';
                } else {
                    this.value = input; // Unformatted during input
                    errorMessage.style.display = 'none';
                }
            } else {
                // Show error if more than 11 digits
                errorMessage.style.display = 'block';
            }
        });

        $(document).ready(function() {

            // DATATABLE : ADMINISTRATORS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin-management') }}",
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
                            data: 'admin_fullname',
                            name: 'admin_fullname'
                        },
                        {
                            data: 'admin_phoneno',
                            name: 'admin_phoneno'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'admin_status',
                            name: 'admin_status'
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
                            url: "{{ route('admin-status-update') }}",
                            type: "POST",
                            data: {
                                selected_admin: selectedUsers,
                                admin_status: status,
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
