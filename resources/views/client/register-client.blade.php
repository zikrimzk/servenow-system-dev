<!-- Client Register Page  -->

<!doctype html>
<html lang="en">


<head>
    <title>ServeNow | {{ $title }}</title>

    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta meta name="viewport" content= "width=device-width, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <!-- [Favicon] icon -->
    <link rel="icon" href="assets/images/logo-test-white.png" type="image/x-icon" />
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

    <style>
        .progress-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .progress-bar.weak {
            background-color: #dc3545;
            /* Red */
        }

        .progress-bar.medium {
            background-color: #ffc107;
            /* Yellow */
        }

        .progress-bar.strong {
            background-color: #28a745;
            /* Green */
        }

        #password-strength-text {
            font-weight: bold;
            color: #6c757d;
        }

        #password-match-text {
            font-weight: bold;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-success {
            color: #28a745 !important;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">

    <div class="page-loader">
        <div class="bar"></div>
    </div>


    <!-- [ Register ] start -->
    <form action="{{ route('client-create') }}" method="POST">
        @csrf
        <div class="auth-main">
            <div class="auth-wrapper v1">
                <div class="auth-form">
                    <div class="card my-5 shadow shadow-lg">
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ route('servenow-home') }}">
                                    <img src="../assets/images/logo-test.png" alt="images" class="img-fluid"
                                        width="150" height="70" />
                                </a>
                            </div>

                            <div class="my-3"></div>
                            <h2 class="f-w-700 mb-1 mt-3 text-center">Sign up</h2>
                            <h5 class="f-w-500 mb-3 text-center">It’s Quick and Easy!</h5>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('client_firstname') is-invalid @enderror"
                                            id="floatingInput" placeholder="First Name" name="client_firstname"
                                            value="{{ old('client_firstname') }}" />
                                        <label for="floatingInput">First Name</label>
                                        @error('client_firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('client_lastname') is-invalid @enderror"
                                            id="floatingInput" placeholder="Last Name" name="client_lastname"
                                            value="{{ old('client_lastname') }}" />
                                        <label for="floatingInput">Last Name</label>
                                        @error('client_lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input type="tel"
                                            class="form-control @error('client_phoneno') is-invalid @enderror"
                                            id="ClientPhoneNo" placeholder="Phone Number" name="client_phoneno"
                                            maxlength="15" required value="{{ old('client_phoneno') }}" />
                                        <label for="ClientPhoneNo">Phone Number</label>
                                        @error('client_phoneno')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="phone-error-message" class="text-danger" style="display: none;">
                                            Phone number must be in a valid format (10 or 11 digits)!
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="floatingInput" placeholder="Email" name="email"
                                            value="{{ old('email') }}" />
                                        <label for="floatingInput">Email</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Field -->
                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" placeholder="Password" name="password" />
                                        <label for="password">Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Show/Hide Button -->
                                        <button type="button" class="btn position-absolute end-0 top-0 me-2"
                                            style="background-color: transparent; margin-top:.60rem;"
                                            id="toggle-password-1">
                                            <i id="toggle-icon-password-1" class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    <!-- Password Strength Indicator -->
                                    <div class="progress mt-2"
                                        style="height: 10px; border-radius: 5px; overflow: hidden;">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar"
                                            style="width: 0%;"></div>
                                    </div>
                                    <small id="password-strength-text" class="form-text"></small>
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                        <input type="password"
                                            class="form-control @error('cpassword') is-invalid @enderror"
                                            id="confirm-password" placeholder="Confirm Password" name="cpassword" />
                                        <label for="confirm-password">Confirm Password</label>
                                        @error('cpassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Show/Hide Button -->
                                        <button type="button" class="btn position-absolute end-0 top-0 me-2"
                                            style="background-color: transparent; margin-top:.60rem;"
                                            id="toggle-password-2">
                                            <i id="toggle-icon-password-2" class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    <small id="password-match-text" class="form-text text-danger"></small>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input input-primary" type="checkbox"
                                                id="confirmbox" />
                                            <label class="form-check-label text-muted" for="confirmbox">
                                                I agree to ServeNow’s Terms of Service and Privacy
                                                Policy.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg create-accbtn">Sign
                                    up</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Already have an Account?</h6>
                                <a href="{{ route('client-login') }}" class="link-primary">Login here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- [ Register ] End -->

    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            let isPasswordStrong = false;
            let isPasswordMatching = false;

            // Password Strength Checker
            $('#password').on('input', function() {
                const password = $(this).val();
                const confirmPassword = $('#confirm-password').val();

                const strength = evaluatePasswordStrength(password);

                // Update progress bar
                const bar = $('#password-strength-bar');
                bar.css('width', strength.percent + '%');
                bar.removeClass('weak medium strong');
                bar.addClass(strength.class);

                // Update strength text
                $('#password-strength-text').text(strength.message);

                // Update strength status
                isPasswordStrong = strength.class === 'strong';


                const matchText = $('#password-match-text');
                if (password === confirmPassword && password !== "") {
                    matchText.text('Passwords match').removeClass('text-danger').addClass('text-success');
                    isPasswordMatching = true;
                } else if (password !== confirmPassword || password === "") {
                    matchText.text('Passwords do not match').removeClass('text-success').addClass(
                        'text-danger');
                    isPasswordMatching = false;
                }
                toggleCreateAccountButton();
            });

            // Confirm Password Match Checker
            $('#confirm-password').on('input', function() {
                const password = $('#password').val().trim();
                const confirmPassword = $(this).val().trim();

                const matchText = $('#password-match-text');

                // Check if either of the fields is empty
                if (password === "" || confirmPassword === "") {
                    matchText.text('Both password fields are required').removeClass(
                        'text-success text-danger');
                    isPasswordMatching = false; // Disable match status if any field is empty
                } else {
                    // Check if the passwords match
                    if (password === confirmPassword) {
                        matchText.text('Passwords match').removeClass('text-danger').addClass(
                            'text-success');
                        isPasswordMatching = true;
                    } else {
                        matchText.text('Passwords do not match').removeClass('text-success').addClass(
                            'text-danger');
                        isPasswordMatching = false;
                    }
                }

                toggleCreateAccountButton();
            });

            // Checkbox Event
            $('#confirmbox').on('change', function() {
                toggleCreateAccountButton();
            });

            // Toggle "Create Account" Button
            function toggleCreateAccountButton() {
                const isCheckboxChecked = $('#confirmbox').prop('checked');

                if (isPasswordStrong && isPasswordMatching && isCheckboxChecked) {
                    $('.create-accbtn').prop('disabled', false);
                } else {
                    $('.create-accbtn').prop('disabled', true);
                }
            }

            // Show/Hide Password Functionality for Password Field
            $('#toggle-password-1').on('click', function() {
                togglePasswordVisibility('#password', '#toggle-icon-password-1');
            });

            // Show/Hide Password Functionality for Confirm Password Field
            $('#toggle-password-2').on('click', function() {
                togglePasswordVisibility('#confirm-password', '#toggle-icon-password-2');
            });

            // Function to Toggle Password Visibility
            function togglePasswordVisibility(inputSelector, iconSelector) {
                const inputField = $(inputSelector);
                const icon = $(iconSelector);

                if (inputField.attr('type') === 'password') {
                    inputField.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    inputField.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            }

            // Function to Evaluate Password Strength
            function evaluatePasswordStrength(password) {
                let score = 0;

                if (password.length >= 8) score += 2; // Strong length
                if (/[A-Z]/.test(password)) score += 1; // At least one uppercase letter
                if (/[a-z]/.test(password)) score += 1; // At least one lowercase letter
                if (/\d/.test(password)) score += 1; // At least one number
                if (/[@$!%*?&]/.test(password)) score += 2; // At least one special character
                if (password.length >= 16) score += 1; // Bonus for extra-long passwords

                if (score <= 3) {
                    return {
                        message: 'Weak',
                        percent: 33,
                        class: 'weak'
                    };
                } else if (score <= 5) {
                    return {
                        message: 'Medium',
                        percent: 66,
                        class: 'medium'
                    };
                } else {
                    return {
                        message: 'Strong',
                        percent: 100,
                        class: 'strong'
                    };
                }
            }
        });

        document.getElementById('ClientPhoneNo').addEventListener('input', function() {
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
    </script>

</body>

</html>
<!--Updated By: Muhammad Zikri B. Kashim (12/01/2025)-->

