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
                                <li class="breadcrumb-item" aria-current="page">My Profile</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">My Profile</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-0">
                            <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-file-text me-2"></i>Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if (Auth::user()->tasker_status == 0)
                                        <div class="alert alert-primary">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                <div class="flex-grow-1 ms-3"> Step 1 : Fill in the required fields to
                                                    proceed with the verification process! </div>
                                            </div>
                                        </div>
                                    @elseif(Auth::user()->tasker_status == 1)
                                        <div class="alert alert-primary">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div> Step 2 : Complete your account verification
                                                            to start earning! </div>
                                                        <a href="" class="btn btn-link">Verify now</a>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5>Profile</h5>
                                            @if (Auth::user()->tasker_status == 0)
                                                <span class="badge bg-warning">Incomplete Profile</span>
                                            @elseif(Auth::user()->tasker_status == 1)
                                                <span class="badge bg-light-danger">Not Verified</span>
                                            @elseif(Auth::user()->tasker_status == 2)
                                                <span class="badge bg-success">Verified & Active</span>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <h5 class="mb-2 mt-2">A. Personal Information</h5>

                                                <div class="col-sm-12 text-center mb-3">
                                                    <div class="user-upload wid-100">
                                                        <img src="../assets/images/user/avatar-4.jpg" alt="img"
                                                            class="img-fluid" />
                                                        <label for="uplfile" class="img-avtar-upload">
                                                            <i class="ti ti-camera f-24 mb-1"></i>
                                                            <span>Upload</span>
                                                        </label>
                                                        <input type="file" id="uplfile" class="d-none" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_firstname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_lastname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">IC Number <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_icno }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Date of Birth <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            value="{{ Auth::user()->tasker_icno }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control"
                                                            value="(+60) {{ Auth::user()->tasker_phoneno }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->email }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Bio</label>
                                                        <textarea class="form-control" rows="6" cols="50"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5 class="mb-2 mt-2">B. Tasker Address</h5>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Address Line 1 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_address_no }}"
                                                            placeholder="Building Number" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Address Line 2 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_address_road }}"
                                                            placeholder="Road name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Postcode <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_address_state }}"
                                                            placeholder="Road name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">State <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_address_state }}"
                                                            placeholder="Road name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">City <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_address_state }}"
                                                            placeholder="Road name" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <h5 class="mb-2 mt-2">C. Working Area</h5>

                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">State <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_workingloc_state }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Area <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ Auth::user()->tasker_workingloc_area }}" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-end btn-page">
                                    <div class="btn btn-primary">Update Profile</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Change Password</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Old Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h5>New password must contain:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least 8
                                                    characters</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                    lower letter (a-z)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                    uppercase letter(A-Z)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                    number (0-9)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                    special characters</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end btn-page">
                                    <div class="btn btn-outline-secondary">Cancel</div>
                                    <div class="btn btn-primary">Update Profile</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
