<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta meta name="viewport" content= "width=device-width, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ServeNow | {{ $title }}</title>

    <!-- [Favicon] icon -->
    <link rel="icon" href="../assets/images/logo-test-white.png" type="image/x-icon" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="../assets/fonts/inter/inter.css" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="../assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <link rel="stylesheet" href="../assets/css/landing.css" />

</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast=""
    data-pc-theme="light" class="landing-page">

    <div class="container">
        <form action="{{ route('tasker-first-time-update', Crypt::encrypt($tasker->id)) }}" method="POST">
            @csrf
            <div class="row justify-content-center align-items-center" style="height: 135vh;">

                <div class="col-md-6 d-sm-block d-none">
                    <h5><span class="link-primary">Hi </span> {{ $tasker->tasker_firstname }} !</h5>
                    <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                        First Time Login
                    </h1>
                    <p class="card-subtitle text-muted">Please change your password for account activation.</p>
                </div>

                <div class="col-sm-12 col-md-4">

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


                    

                    <div class="card border border-0 shadow shadow-md">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <a href="{{ route('servenow-home') }}"><img src="../assets/images/logo-test.png" alt="img"
                                        class="img-fluid" width="150" height="100" /></a>
                            </div>
                            <h4 class="mt-3 mb-3 text-center">Change Password</h4>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="oldpassword" placeholder="Password"
                                        name="oldPass" required />
                                    <label for="password">Old Password</label>

                                    <!-- Show/Hide Button -->
                                    <button type="button" class="btn position-absolute end-0 top-0 me-2"
                                        style="background-color: transparent; margin-top:.60rem;"
                                        id="show-old-password">
                                        <i id="toggle-icon-old-password" class="ti ti-eye"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="newPass" required />
                                    <label for="password">New Password</label>

                                    <!-- Show/Hide Button -->
                                    <button type="button" class="btn position-absolute end-0 top-0 me-2"
                                        style="background-color: transparent; margin-top:.60rem;" id="show-password">
                                        <i id="toggle-icon-password" class="ti ti-eye"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="cpassword"
                                        placeholder="Password" name="renewPass" required />
                                    <label for="password">Confirm Password</label>

                                    <!-- Show/Hide Button -->
                                    <button type="button" class="btn position-absolute end-0 top-0 me-2"
                                        style="background-color: transparent; margin-top:.60rem;"
                                        id="show-password-confirm">
                                        <i id="toggle-icon-confirm-password" class="ti ti-eye"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="mb-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item f-12" id="min-char"><i></i> At least
                                        8
                                        characters</li>
                                    <li class="list-group-item f-12" id="lower-char"><i></i> At least
                                        1
                                        lower letter (a-z)</li>
                                    <li class="list-group-item f-12" id="upper-char"><i></i> At least
                                        1
                                        uppercase letter(A-Z)</li>
                                    <li class="list-group-item f-12" id="number-char"><i></i> At least
                                        1
                                        number (0-9)</li>
                                    <li class="list-group-item f-12" id="special-char"><i></i> At least
                                        1
                                        special characters</li>
                                </ul>
                            </div>

                            <div class="d-grid mt-4 mb-3">
                                <button type="submit" class="btn btn-lg btn-primary" id="submit-btn">Change
                                    Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Required Js -->
    <script>
        document.getElementById('password').addEventListener('input', function() {
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
                    element.classList.remove('ti', 'ti-circle-x', 'text-danger', 'me-2');
                    element.classList.add('ti', 'ti-circle-check', 'text-success', 'me-2');
                } else {
                    element.classList.remove('ti', 'ti-circle-check', 'text-success', 'me-2');
                    element.classList.add('ti', 'ti-circle-x', 'text-danger', 'me-2');
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
            const newPassword = document.getElementById('password').value;
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
        showpassword('show-password', 'password', 'toggle-icon-password');
        showpassword('show-password-confirm', 'cpassword', 'toggle-icon-confirm-password');
    </script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>

</body>

</html>
