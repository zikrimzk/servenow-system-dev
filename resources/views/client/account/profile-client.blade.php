<!-- Client Profile Page  -->
@extends('client.layouts.main')

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

            <div class="row mx-3">
                <h1 class="mb-4 mt-4 mt-md-2">My Profile</h1>
                <div class="col-sm-12">
                    <div class="card shadow">
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
                                        aria-selected="true">
                                        <i class="ti ti-map-pin me-2"></i>Address
                                    </a>
                                </li>
                                <li class="nav-item {{ session('active_tab') == 'profile-3' ? 'active' : '' }}">
                                    <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3"
                                        role="tab" aria-selected="true">
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

                    <div class="tab-content mb-5">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade {{ session('active_tab', 'profile-1') == 'profile-1' ? 'show active' : '' }}"
                            id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <form action="{{ route('client-update-profile', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Personal Details</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="row mb-4">

                                                    <!-- Profile Picture Section Start -->
                                                    <div class="col-md-4 text-center">
                                                        <div class="user-upload avatar-s">
                                                            <img src="{{ asset('storage/' . auth()->user()->client_photo) }}"
                                                                alt="Profile Photo" width="150" height="150"
                                                                id="previewImage">
                                                            <label for="profilephoto" class="img-avtar-upload">
                                                                <i class="ti ti-camera f-24 mb-1"></i>
                                                                <span>Upload</span>
                                                            </label>
                                                            <input type="file" id="profilephoto" name="client_photo"
                                                                class="d-none" accept="image/*"
                                                                @if (auth()->user()->client_photo == '') required @endif />
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

                                                    <div class="col-md-8">
                                                        <div class="row">

                                                            <!-- First Name Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">First Name</label>
                                                                    <input type="text"
                                                                        class="form-control @error('client_firstname') is-invalid @enderror"
                                                                        name="client_firstname"
                                                                        value="{{ Auth::user()->client_firstname }}"
                                                                        id="client_firstname" />
                                                                    @error('client_firstname')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Last Name Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Last Name</label>
                                                                    <input type="text"
                                                                        class="form-control @error('client_lastname') is-invalid @enderror"
                                                                        name="client_lastname"
                                                                        value="{{ Auth::user()->client_lastname }}" />
                                                                    @error('client_lastname')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Phone Number Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Phone Number</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">+60</span>
                                                                        <input type="text"
                                                                            class="form-control @error('client_phoneno') is-invalid @enderror"
                                                                            placeholder="Phone No." name="client_phoneno"
                                                                            value="{{ Auth::user()->client_phoneno }}" />
                                                                        @error('client_phoneno')
                                                                            <div class="invalid-feedback">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Email Field -->
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="text"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        name="email" value="{{ Auth::user()->email }}"
                                                                        disabled />
                                                                    @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-end btn-page">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>

                        <!-- Update Address -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-2' ? 'show active' : '' }}"
                            id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('client-update-address', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Address</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <!-- Address Line 1 Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Address Line 1
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control @error('client_address_one') is-invalid @enderror"
                                                                name="client_address_one"
                                                                value="{{ Auth::user()->client_address_one }}"
                                                                id="client_address_one" />
                                                            @error('client_address_one')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Address Line 2 Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Address Line 2
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control @error('client_address_two') is-invalid @enderror"
                                                                name="client_address_two"
                                                                value="{{ Auth::user()->client_address_two }}"
                                                                id="client_address_two" />
                                                            @error('client_address_two')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- Postcode Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Postcode
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control @error('client_postcode') is-invalid @enderror"
                                                                name="client_postcode"
                                                                value="{{ Auth::user()->client_postcode }}"
                                                                id="client_postcode" maxlength="5"
                                                                oninput="validatePostcode(this)" />
                                                            @error('client_postcode')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- State Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">State <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="client_state"
                                                                class="form-control @error('client_state') is-invalid @enderror"
                                                                id="addState">
                                                                @if (Auth::user()->client_state == '')
                                                                    <option value="" selected>Select State</option>
                                                                    @foreach ($states['states'] as $state)
                                                                        <option value="{{ strtolower($state['name']) }}">
                                                                            {{ $state['name'] }}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($states['states'] as $state)
                                                                        @if (Auth::user()->client_state == strtolower($state['name']))
                                                                            <option
                                                                                value="{{ strtolower($state['name']) }}"
                                                                                selected>
                                                                                {{ $state['name'] }}</option>
                                                                        @else
                                                                            <option
                                                                                value="{{ strtolower($state['name']) }}">
                                                                                {{ $state['name'] }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                            @error('client_state')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                    <!-- Area Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Area <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="client_area"
                                                                class="form-control @error('client_area') is-invalid @enderror"
                                                                id="addCity">
                                                                @if (Auth::user()->client_state == '')
                                                                    <option value="" selected>Select Area</option>
                                                                @else
                                                                    <option value="{{ Auth::user()->client_area }}"
                                                                        selected>{{ Auth::user()->client_area }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                            @error('client_area')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12 text-end btn-page">
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>

                        <!-- Update Password  -->
                        <div class="tab-pane fade {{ session('active_tab') == 'profile-3' ? 'show active' : '' }}"
                            id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <form action="{{ route('client-update-password', Auth::user()->id) }}" method="POST">
                                @csrf
                                <div class="card shadow">
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
                    </div>


                </div>
            </div>

        </div>
    </div>

    <script>
        function validatePostcode(input) {
            // Remove any non-numeric characters
            input.value = input.value.replace(/\D/g, '');
            // Trim to 5 characters if longer
            if (input.value.length > 5) {
                input.value = input.value.slice(0, 5);
            }
        }


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

            $('#workState').on('change', function() {
                var state = $(this).val();
                if (state) {
                    $.ajax({
                        url: '/get-areas/' + state, // Ensure this matches the route
                        type: 'GET',
                        success: function(data) {
                            $('#workCity').empty().append(
                                '<option value="">Select Area</option>');
                            $.each(data, function(index, area) {
                                $('#workCity').append('<option value="' + area + '">' +
                                    area + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching areas: " +
                                error); // For debugging if request fails
                        }
                    });
                } else {
                    $('#workCity').empty().append('<option value="">Select Area</option>');
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





        });
    </script>




    <!-- [ Main Content ] end -->
@endsection
