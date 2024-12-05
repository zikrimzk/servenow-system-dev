<!-- Client Profile Page  -->
@extends('client.layouts.main')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">



            <div class="row mx-3 ">
                <h1 class="my-4">My Profile</h1>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-0">
                            <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-file-text me-2"></i>Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-map-pin me-2"></i>Address
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content mb-5">

                        <!-- Update Profile Tab -->
                        <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <form action="{{ route('client-update-profile', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Start Alert -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                                                </path>
                                            </symbol>

                                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                                                </path>
                                            </symbol>
                                        </svg>
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#check-circle-fill"></use>
                                                </svg>
                                                <div> {{ session('success') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#exclamation-triangle-fill"></use>
                                                </svg>
                                                <div> {{ session('error') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <!-- End Alert -->


                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Profile</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 text-center mb-3">
                                                        <div class="user-upload">
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
                                                            @error('client_photo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <input type="hidden" name="isUploadPhoto" id="isUploadPhoto"
                                                            value="false">
                                                    </div>

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
                                                                <div class="invalid-feedback">{{ $message }}</div>
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
                                                                <div class="invalid-feedback">{{ $message }}</div>
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
                                                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                                                name="email" value="{{ Auth::user()->email }}" />
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 text-end btn-page">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Update Address -->
                        <div class="tab-pane show " id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('client-update-address', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Start Alert -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                                                </path>
                                            </symbol>

                                            <symbol id="exclamation-triangle-fill" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                                                </path>
                                            </symbol>
                                        </svg>
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#check-circle-fill"></use>
                                                </svg>
                                                <div> {{ session('success') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#exclamation-triangle-fill"></use>
                                                </svg>
                                                <div> {{ session('error') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <!-- End Alert -->


                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Address</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <!-- Address Line 1 Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address Line 1</label>
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
                                                            <label class="form-label">Address Line 2</label>
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
                                                            <label class="form-label">Postcode</label>
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
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 text-end btn-page">
                                        <button type="submit" class="btn btn-primary">Update Address</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Update Password Tab -->
                        <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <form action="{{ route('client-update-password', Auth::user()->id) }}" method="POST">
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
                                                        <input type="password" class="form-control" name="oldPass"
                                                            id="oldpassword" />
                                                        <button class="btn btn-light border border-1 border-secondary"
                                                            type="button" id="show-old-password">
                                                            <i id="toggle-icon-old-password" class="ti ti-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">New Password</label>
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
                                                    <label class="form-label">Confirm Password</label>
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
                                        <button type="submit" class="btn btn-primary " id="submit-btn">Update
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
