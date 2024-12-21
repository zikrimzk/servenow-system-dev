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


            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
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
                                            <th scope="col">No</th>
                                            <th scope="col">Tasker Code</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
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
                                                    class="form-control @error('tasker_phoneno') is-invalid @enderror"
                                                    placeholder="Phone No." name="tasker_phoneno"
                                                    value="{{ old('tasker_phoneno') }}" />
                                                @error('tasker_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
        $(document).ready(function() {

            // DATATABLE : TASKERS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin-tasker-management') }}",
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
                            data: 'tasker_firstname',
                            name: 'tasker_firstname'
                        },
                        {
                            data: 'tasker_lastname',
                            name: 'tasker_lastname'
                        },
                        {
                            data: 'tasker_phoneno',
                            name: 'tasker_phoneno'
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

            });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
