@extends('tasker.layouts.main')

@section('content')
    <style>
        .avatar-s {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
        }

        .avatar-s img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .nav-tabs.profile-tabs .nav-item {
                flex: 1 1 auto;
                text-align: center;
            }

            .nav-tabs.profile-tabs .nav-link {
                display: block;
                width: 100%;
            }
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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-0">
                            <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab', 'profile-1') == 'profile-1' ? 'active' : '' }}"
                                        id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab">
                                        <i class="ti ti-file-text me-2"></i>Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab') == 'profile-2' ? 'active' : '' }}"
                                        id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab">
                                        <i class="ti ti-map-pin me-2"></i>Tasker Address
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab') == 'profile-3' ? 'active' : '' }}"
                                        id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab">
                                        <i class="ti ti-building-bank me-2"></i>Bank Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab') == 'profile-4' ? 'active' : '' }}"
                                        id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Start Alert -->
                    <div>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="alert-heading">
                                        <i class="fas fa-check-circle"></i>
                                        Success
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <p class="mb-0">{{ session('error') }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- End Alert -->

                    <div class="tab-content">
                        <!-- Personal Details Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab', 'profile-1') == 'profile-1' ? 'show active' : '' }} "
                            id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <form action="{{ route('tasker-update-profile-personal') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if (Auth::user()->tasker_status == 0)
                                            <div class="alert alert-primary">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                    <div class="flex-grow-1 ms-3">
                                                        <strong>Step 1 :</strong> Please fill in all required fields to
                                                        continue with the
                                                        verification process. <strong>Important:</strong> Ensure you upload
                                                        a clear photo.
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif(Auth::user()->tasker_status == 1)
                                            <div class="alert alert-primary">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                    <div class="flex-grow-1 ms-3">
                                                        <strong>Step 2 :</strong> Please make sure to complete your account
                                                        verification
                                                        to start earning!
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Personal Details</h5>
                                                @if (Auth::user()->tasker_status == 0)
                                                    <span class="badge bg-warning">Incomplete Profile</span>
                                                @elseif(Auth::user()->tasker_status == 1)
                                                    <div class="">
                                                        <span class="badge bg-light-danger">Not Verified</span>

                                                        <a href="" class="btn btn-link" data-bs-toggle="modal"
                                                            data-bs-target="#verifyQrModal">Verify now</a>

                                                    </div>
                                                @elseif(Auth::user()->tasker_status == 2)
                                                    <span class="badge bg-success">Verified & Active</span>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-4">

                                                    <!-- Profile Picture Section Start -->
                                                    <div class="col-md-4 text-center">
                                                        <div class="user-upload avatar-s">
                                                            <img src="{{ asset('storage/' . auth()->user()->tasker_photo) }}"
                                                                alt="Profile Photo" width="150" height="150"
                                                                id="previewImage">
                                                            <label for="profilephoto" class="img-avtar-upload">
                                                                <i class="ti ti-camera f-24 mb-1"></i>
                                                                <span>Upload</span>
                                                            </label>
                                                            <input type="file" id="profilephoto" name="tasker_photo"
                                                                class="d-none" accept="image/*"
                                                                @if (auth()->user()->tasker_photo == '') required @endif />
                                                            @error('tasker_photo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <input type="hidden" name="isUploadPhoto" id="isUploadPhoto"
                                                            value="false">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="profilephoto" class="fw-semibold"
                                                                style="cursor:pointer; color:#16325b">Edit Profile
                                                                Photo</label>
                                                        </div>
                                                    </div>
                                                    <!-- Profile Picture Section End -->

                                                    <!-- Personal Information Section Start -->
                                                    <div class="col-md-8">
                                                        <div class="row">

                                                            <!-- Tasker Code Field -->
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            Tasker Code
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ Auth::user()->tasker_code }}"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- First Name -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text"
                                                                    class="form-control @error('tasker_firstname') is-invalid @enderror"
                                                                    name="tasker_firstname"
                                                                    value="{{ Auth::user()->tasker_firstname }}"
                                                                    id="tasker_firstname" />
                                                                @error('tasker_firstname')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Last Name -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text"
                                                                    class="form-control @error('tasker_lastname') is-invalid @enderror"
                                                                    name="tasker_lastname"
                                                                    value="{{ Auth::user()->tasker_lastname }}" />
                                                                @error('tasker_lastname')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- IC Number -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">IC Number <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class="form-control @error('tasker_icno') is-invalid @enderror"
                                                                    name="tasker_icno" id="tasker_icno"
                                                                    placeholder="IC Number" maxlength="12"
                                                                    pattern="^\d{12}$"
                                                                    value="{{ Auth::user()->tasker_icno }}"
                                                                    @if (Auth::user()->tasker_status == 2) readonly @endif />
                                                                <div id="ic-error-message" class="text-danger"
                                                                    style="display: none;">IC Number must be exactly 12
                                                                    digits!
                                                                </div>
                                                                @error('tasker_icno')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Date of Birth -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Date of Birth <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="date"
                                                                    class="form-control @error('tasker_dob') is-invalid @enderror"
                                                                    name="tasker_dob" id="tasker_dob"
                                                                    value="{{ Auth::user()->tasker_dob }}" readonly />
                                                                <div id="dob-error-message" class="text-danger"
                                                                    style="display: none;">You must be 18 years and above!
                                                                </div>
                                                                @error('tasker_dob')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Phone Number -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Phone Number</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">+60</span>
                                                                    <input type="text"
                                                                        class="form-control @error('tasker_phoneno') is-invalid @enderror"
                                                                        placeholder="Phone No." name="tasker_phoneno"
                                                                        id="tasker_phoneno" maxlength="13"
                                                                        value="{{ Auth::user()->tasker_phoneno }}" />
                                                                    @error('tasker_phoneno')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="text"
                                                                    class="form-control @error('email') is-invalid @enderror"
                                                                    name="email" value="{{ Auth::user()->email }}"
                                                                    readonly />
                                                                @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Bio -->
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label">Bio</label>
                                                                <textarea class="form-control @error('tasker_bio') is-invalid @enderror" rows="4" name="tasker_bio"
                                                                    placeholder="Enter your bio here ...">{{ Auth::user()->tasker_bio }}</textarea>
                                                                @error('tasker_bio')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Personal Information Section End -->
                                                </div>
                                            </div>
                                            <div class="card-footer text-end btn-page">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- Personal Details Tab End -->

                        <!-- Tasker Address Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-2' ? 'show active' : '' }}"
                            id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('tasker-update-profile-address') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Tasker Address</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Address Section -->
                                        <div class="row">
                                            <!-- Address Line 1 -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Address Line 1 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('tasker_address_one') is-invalid @enderror"
                                                    name="tasker_address_one"
                                                    value="{{ Auth::user()->tasker_address_one }}"
                                                    placeholder="Building number and street name" />
                                                @error('tasker_address_one')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Address Line 2 -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Address Line 2 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('tasker_address_two') is-invalid @enderror"
                                                    name="tasker_address_two"
                                                    value="{{ Auth::user()->tasker_address_two }}"
                                                    placeholder="Building name" />
                                                @error('tasker_address_two')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Postal Code -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Postal Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('tasker_address_poscode') is-invalid @enderror"
                                                    id="tasker_address_poscode" name="tasker_address_poscode"
                                                    value="{{ Auth::user()->tasker_address_poscode }}"
                                                    placeholder="Postal Code" maxlength="5" />
                                                @error('tasker_address_poscode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- State -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">State <span class="text-danger">*</span></label>
                                                <select name="tasker_address_state"
                                                    class="form-control @error('tasker_address_state') is-invalid @enderror"
                                                    id="addState">
                                                    @if (Auth::user()->tasker_address_state == '')
                                                        <option value="" selected>Select State</option>
                                                        @foreach ($states['states'] as $state)
                                                            <option value="{{ strtolower($state['name']) }}">
                                                                {{ $state['name'] }}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($states['states'] as $state)
                                                            @if (Auth::user()->tasker_address_state == strtolower($state['name']))
                                                                <option value="{{ strtolower($state['name']) }}" selected>
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

                                            <!-- Area -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Area <span class="text-danger">*</span></label>
                                                <select name="tasker_address_area"
                                                    class="form-control @error('tasker_address_area') is-invalid @enderror"
                                                    id="addCity">
                                                    @if (Auth::user()->tasker_address_area == '')
                                                        <option value="" selected>Select Area</option>
                                                    @else
                                                        <option value="{{ Auth::user()->tasker_address_area }}" selected>
                                                            {{ Auth::user()->tasker_address_area }}
                                                        </option>
                                                    @endif
                                                </select>
                                                @error('tasker_address_area')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- Tasker Address Tab End -->

                        <!-- Bank Details Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-3' ? 'show active' : '' }}"
                            id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <form action="{{ route('tasker-update-profile-bank') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Bank Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Bank Name <span
                                                            class="text-danger">*</span></label>
                                                    <select name="tasker_account_bank"
                                                        class="form-control @error('tasker_account_bank') is-invalid @enderror"
                                                        id="cr_bank_name">
                                                        <option value="">Select Bank</option>
                                                        @foreach ($bank as $banks)
                                                            @if ($banks['bank'] == Auth::user()->tasker_account_bank)
                                                                <option value="{{ $banks['bank'] }}" selected>
                                                                    {{ $banks['bank'] }}
                                                                </option>
                                                            @else
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

                                                <div class="mb-3">
                                                    <label class="form-label">Account Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('tasker_account_number') is-invalid @enderror"
                                                        id="tasker_account_number" name="tasker_account_number"
                                                        placeholder="Account Number"
                                                        value="{{ Auth::user()->tasker_account_number }}" />
                                                    @error('tasker_account_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- Bank Details Tab End -->

                        <!-- Update Password Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-4' ? 'show active' : '' }}"
                            id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                            <form action="{{ route('tasker-update-password', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Old Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('oldPass') is-invalid @enderror"
                                                            name="oldPass" id="oldpassword" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-old-password">
                                                            <i id="toggle-icon-old-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('oldPass')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">New Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('newPass') is-invalid @enderror"
                                                            id="passwords" name="newPass" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password">
                                                            <i id="toggle-icon-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('newPass')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password"
                                                            class="form-control @error('cpassword') is-invalid @enderror"
                                                            name="renewPass" id="cpassword" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password-confirm">
                                                            <i id="toggle-icon-confirm-password" class="ti ti-eye"></i>
                                                        </button>
                                                        @error('cpassword')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h5>New password must contain:</h5>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item" id="min-char"><i></i> At least
                                                        8
                                                        characters</li>
                                                    <li class="list-group-item" id="lower-char"><i></i> At least
                                                        1
                                                        lower letter (a-z)</li>
                                                    <li class="list-group-item" id="upper-char"><i></i> At least
                                                        1
                                                        uppercase letter(A-Z)</li>
                                                    <li class="list-group-item" id="number-char"><i></i> At least
                                                        1
                                                        number (0-9)</li>
                                                    <li class="list-group-item" id="special-char"><i></i> At least
                                                        1
                                                        special characters</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <button type="submit" class="btn btn-primary disabled" id="submit-btn">Update
                                            Password</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <!-- Update Password Tab End -->

                    </div>

                    <div id="verifyQrModal" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="d-flex justify-content-end align-items-center m-2">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="d-none d-md-block">
                                        <div class="alert alert-primary">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                <div class="flex-grow-1 ms-3">
                                                    <strong>Important:</strong>
                                                    Please scan the QR code below using your smartphone to verify your
                                                    account. This
                                                    step is essential to complete your account verification.
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $data = Auth::check() ? Auth::user()->tasker_icno ?? '' : '';
                                        @endphp
                                        <div class="d-flex justify-content-center align-items-center my-3">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ route('tasker-card-ver', $data) }}"
                                                class="img-fluid" alt="qrcode">
                                        </div>

                                    </div>

                                    <div class="d-sm-block d-md-none">
                                        <div class="alert alert-primary">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                                <div class="flex-grow-1 ms-3">
                                                    <strong>Tips:</strong> Please have your MyKad ready and ensure your
                                                    camera lens is clean for a smooth verification process.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid my-3">
                                            <a href="{{ route('tasker-card-ver', $data) }}"
                                                class="btn btn-primary">Verify Account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('tasker_phoneno').addEventListener('input', function() {
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

        document.getElementById('passwords').addEventListener('input', function() {
            const password = this.value;
            const submitbtn = document.getElementById('submit-btn');
            const confirmPasswordInput = document.getElementById('cpassword');


            // Regular expressions for each requirement
            const minChar = /.{8,}/;
            const lowerChar = /[a-z]/;
            const upperChar = /[A-Z]/;
            const numberChar = /[0-9]/;
            const specialChar = /[!@#$%^&*(),.?":{}|<>]/;


            // Function to update each requirement's status
            function validateRequirement(regex, elementId) {
                const element = document.getElementById(elementId);
                if (regex.test(password)) {
                    element.classList.remove('ti', 'ti-circle-x', 'text-danger', 'f-16', 'me-2');
                    element.classList.add('ti', 'ti-circle-check', 'text-success', 'f-16', 'me-2');
                } else {
                    element.classList.remove('ti', 'ti-circle-check', 'text-success', 'f-16', 'me-2');
                    element.classList.add('ti', 'ti-circle-x', 'text-danger', 'f-16', 'me-2');
                }
            }

            // Validate each requirement
            validateRequirement(minChar, 'min-char');
            validateRequirement(lowerChar, 'lower-char');
            validateRequirement(upperChar, 'upper-char');
            validateRequirement(numberChar, 'number-char');
            validateRequirement(specialChar, 'special-char');

            // Check if all requirements are met
            const allRequirementsMet = (
                minChar.test(password) &&
                lowerChar.test(password) &&
                upperChar.test(password) &&
                numberChar.test(password) &&
                specialChar.test(password)
            );

            // Only check the confirm password if all new password requirements are met
            if (allRequirementsMet) {
                confirmPasswordInput.disabled = false;
                checkPasswordsMatch();
            } else {
                submitbtn.classList.add('disabled');
                confirmPasswordInput.disabled =
                    true;
            }

            // Function to check if passwords match
            function checkPasswordsMatch() {
                const confirmPassword = confirmPasswordInput.value;
                if (password === confirmPassword) {
                    submitbtn.classList.remove(
                        'disabled');
                } else {
                    submitbtn.classList.add(
                        'disabled');
                }
            }
        });

        // Confirm Password Match Check
        document.getElementById('cpassword').addEventListener('input', function() {
            const newPassword = document.getElementById('passwords').value;
            const confirmPassword = this.value;
            const submitbtn = document.getElementById('submit-btn');

            function checkPasswordsMatch() {
                if (newPassword === confirmPassword) {
                    submitbtn.classList.remove('disabled');
                } else {
                    submitbtn.classList.add('disabled');
                }
            }

            checkPasswordsMatch();
        });

        function showpassword(buttonName, txtName, iconName) {
            document.getElementById(buttonName).addEventListener('click', function() {
                const passwordInput = document.getElementById(txtName);
                const icon = document.getElementById(iconName);

                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text'; // Change to text to show password
                    icon.classList.remove('ti-eye'); // Remove eye icon
                    icon.classList.add('ti-eye-off'); // Add eye-slash icon
                } else {
                    passwordInput.type = 'password'; // Change to password to hide it
                    icon.classList.remove('ti-eye-off'); // Remove eye-slash icon
                    icon.classList.add('ti-eye'); // Add eye icon
                }
            });
        }

        showpassword('show-old-password', 'oldpassword', 'toggle-icon-old-password');
        showpassword('show-password', 'passwords', 'toggle-icon-password');
        showpassword('show-password-confirm', 'cpassword', 'toggle-icon-confirm-password');

        $(document).ready(function() {

            var activeTab = "{{ session('active_tab', 'profile-1') }}";
            $('.nav-link[href="#' + activeTab + '"]').tab('show');

            $('#profilephoto').on('change', function() {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    // When the file is loaded, set the src of the img tag
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result).show();
                    };

                    // Read the file as a data URL
                    reader.readAsDataURL(file);
                }
                $('#isUploadPhoto').val('true');
            });

            $('#addState').on('change', function() {
                var state = $(this).val();
                if (state) {
                    $.ajax({
                        url: '/get-areas/' + state, // Ensure this matches the route
                        type: 'GET',
                        success: function(data) {
                            $('#addCity').empty().append(
                                '<option value="">Select Area</option>');
                            $.each(data, function(index, area) {
                                $('#addCity').append('<option value="' + area + '">' +
                                    area + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching areas: " +
                                error); // For debugging if request fails
                        }
                    });
                } else {
                    $('#addCity').empty().append('<option value="">Select Area</option>');
                }
            });

            // Allow only numbers in Account Number input
            $('#tasker_account_number').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            });

            // Allow only numbers and restrict Postal Code to max 5 digits
            $('#tasker_address_poscode').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                if (this.value.length > 5) {
                    this.value = this.value.slice(0, 5); // Restrict to 5 characters
                }
            });

        });
    </script>
    <!-- [ Main Content ] end -->
@endsection
<!--Updated By: Muhammad Zikri B. Kashim (14/01/2025)-->
