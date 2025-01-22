@extends('administrator.layouts.main')

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
                                        id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab"
                                        aria-selected="true">
                                        <i class="ti ti-file-text me-2"></i>Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ session('active_tab') == 'profile-2' ? 'active' : '' }}"
                                        id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
                                        aria-selected="false">
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

                        <!-- Update Profile Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab', 'profile-1') == 'profile-1' ? 'show active' : '' }}"
                            id="profile-1" role="tabpanel" aria-labelledby="profile-tab-21">
                            <form action="{{ route('admin-update-profile', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Profile</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Profile Picture Section Start -->
                                                    <div class="col-md-4 text-center">
                                                        <div class="user-upload avatar-s">
                                                            <img src="{{ asset('storage/' . auth()->user()->admin_photo) }}"
                                                                alt="Profile Photo" width="150" height="150"
                                                                id="previewImage" class="img-avtar">
                                                            <label for="profilephoto" class="img-avtar-upload">
                                                                <i class="ti ti-camera f-24 mb-1"></i>
                                                                <span>Upload</span>
                                                            </label>
                                                            <input type="file" id="profilephoto" name="admin_photo"
                                                                class="d-none" accept="image/*"
                                                                @if (auth()->user()->admin_photo == '') required @endif />
                                                            @error('admin_photo')
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

                                                    <div class="col-md-8">
                                                        <div class="row">

                                                            <!-- Admin Code Field -->
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            Admin Code
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ Auth::user()->admin_code }}"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- First Name Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        First Name
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('admin_firstname') is-invalid @enderror"
                                                                        name="admin_firstname"
                                                                        value="{{ Auth::user()->admin_firstname }}"
                                                                        id="admin_firstname" />
                                                                    @error('admin_firstname')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Last Name Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Last Name
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('admin_lastname') is-invalid @enderror"
                                                                        name="admin_lastname"
                                                                        value="{{ Auth::user()->admin_lastname }}" />
                                                                    @error('admin_lastname')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
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
                                                                        <input type="text"
                                                                            class="form-control @error('admin_phoneno') is-invalid @enderror"
                                                                            placeholder="Phone No." name="admin_phoneno"
                                                                            value="{{ Auth::user()->admin_phoneno }}" />
                                                                        @error('admin_phoneno')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Email Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Email
                                                                    </label>
                                                                    <input type="text"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        name="email" value="{{ Auth::user()->email }}"
                                                                        readonly />
                                                                    @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end btn-page">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Update Profile Tab End -->


                        <!-- Update Password Tab Start -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-2' ? 'show active' : '' }}"
                            id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('admin-update-password', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Old Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" class="form-control" name="oldPass"
                                                            id="oldpassword" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-old-password">
                                                            <i id="toggle-icon-old-password" class="ti ti-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        New Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" class="form-control" id="passwords"
                                                            name="newPass" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password">
                                                            <i id="toggle-icon-password" class="ti ti-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Confirm Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" class="form-control" name="renewPass"
                                                            id="cpassword" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-password-confirm">
                                                            <i id="toggle-icon-confirm-password" class="ti ti-eye"></i>
                                                        </button>
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
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
        });
    </script>
    <!-- [ Main Content ] end -->
@endsection
<!--Updated By: Muhammad Zikri B. Kashim (14/01/2025)-->
