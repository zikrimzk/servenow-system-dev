<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ServeNow | {{ $title }}</title>

    <!-- [Favicon] icon -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon" />
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

    <nav class="navbar navbar-expand-md navbar-light default shadow shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="../assets/images/logo-test.png" class="img-fluid" width="80" height="50"
                    alt="logo" />
            </a>
        </div>
    </nav>

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

                    <div aria-label="alert-section">
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
                            <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                    <use xlink:href="#check-circle-fill"></use>
                                </svg>
                                <div> {{ session('success') }} </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                    <use xlink:href="#exclamation-triangle-fill"></use>
                                </svg>
                                <div> {{ session('error') }} </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- End Alert -->

                    </div>

                    <div class="card border border-0 shadow shadow-md">
                        <div class="card-body">
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
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Password" name="newPass" required />
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

    <!-- [ footer apps ] start -->
    <footer class="mt-auto py-3 bg-white text-center shadow shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                    <p class="mb-0 text-center">
                        <a class="link-primary" href= "##"> ServeNow</a>
                        Copyright © 2024 All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- [ footer apps ] End -->



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
