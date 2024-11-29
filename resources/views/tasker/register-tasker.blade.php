<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <!-- [Meta] -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta meta name="viewport" content= 
    "width=device-width, user-scalable=no" />
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

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                    <div class="card my-5 shadow shadow-lg p-3">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="../assets/images/logo-test.png" alt="images" class="img-fluid" width="150"
                                height="70" />
                            </div>


                            <h2 class="f-w-700 mb-3 mt-3 text-center">Create your account</h2>
                            <p class="text-muted mb-3">Get started by creating an account. We'll send you a text with a link to download the Tasker app and complete your registration. Standard call, messaging, or data rates may apply.</p>

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
                            <form action="{{ route('tasker-create') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('tasker_firstname') is-invalid @enderror"
                                                id="floatingInput" placeholder="Email" name="tasker_firstname" />
                                            <label for="floatingInput">First Name</label>
                                            @error('tasker_firstname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('tasker_lastname') is-invalid @enderror"
                                                id="floatingInput" placeholder="Last Name" name="tasker_lastname" />
                                            <label for="floatingInput">Last Name</label>
                                            @error('tasker_lastname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('tasker_phoneno') is-invalid @enderror"
                                                id="floatingInput" placeholder="Phone Number"
                                                name="tasker_phoneno" />
                                            <label for="floatingInput">Phone Number</label>
                                            @error('tasker_phoneno')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-floating mb-3">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="floatingInput" placeholder="Email" name="email" />
                                            <label for="floatingInput">Email</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="floatingInput" placeholder="Password" name="password" />
                                            <label for="floatingInput">Password</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('cpassword') is-invalid @enderror"
                                                id="floatingInput" placeholder="Confirm Password" name="cpassword" />
                                            <label for="floatingInput">Confirm Password</label>
                                            @error('cpassword')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input input-primary" type="checkbox"
                                                    id="confirmbox" />
                                                <label class="form-check-label text-muted" for="confirmbox">I
                                                    acknowledge
                                                    I
                                                    am a
                                                    sole proprietor.</label>
                                            </div>
                                            <div class="text-muted">By clicking above, I agree to
                                                ServeNow’s Terms of Service and Privacy Policy.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary create-accbtn">Create
                                        account</button>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Already have an Account?</h6>
                                <a href="{{ route('tasker-login') }}" class="link-primary">Login here</a>
                            </div>
                            {{-- <div class="saprator my-3">
                            <span>OR</span>
                        </div>
                        <div class="text-center">
                            <div class="d-grid my-3">
                                <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                                    <img src="../assets/images/authentication/google.svg" alt="img" /> <span>
                                        Sign
                                        Up with Google</span>
                                </button>
                            </div>
                        </div> --}}
                        </div>
                    </div>
            </div>
        </div>
    </div>




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
            $('.create-accbtn').prop('disabled', true);
            $('#confirmbox').on('change', function() {
                if ($(this).prop('checked')) {
                    $('.create-accbtn').prop('disabled', false);
                } else {
                    $('.create-accbtn').prop('disabled', true);
                }
            });
        });
    </script>

</body>
<!-- [Body] end -->

</html>
