<!-- Client Register Page  -->

<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>ServeNow | {{ $title }}</title>

    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


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
    data-pc-theme_contrast="" data-pc-theme="dark">

    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Register ] start -->
    <form action="{{ route('client-create') }}" method="POST">
        @csrf
        <div class="auth-main">
            <div class="auth-wrapper v1">
                <div class="auth-form">
                    <div class="card my-5 shadow shadow-lg">
                        <div class="card-body">
                            <div class="text-center">
                                <a href="{{ route('tasker-home') }}"><img src="../assets/images/logo-test.png"
                                        alt="img" class="img-fluid" width="150" height="100" /></a>

                            </div>
                            <div class="my-3"></div>
                            <h1 class="f-w-500 mb-1 text-start"style="color:#16325b">Sign up</h1>
                            <h5 class="f-w-500 mb-3 text-start">It’s Quick and Easy!</h5>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('client_firstname') is-invalid @enderror"
                                            id="floatingInput" placeholder="First Name" name="client_firstname" />
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
                                            id="floatingInput" placeholder="Last Name" name="client_lastname" />
                                        <label for="floatingInput">Last Name</label>
                                        @error('client_lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control @error('client_phoneno') is-invalid @enderror"
                                    id="floatingInput" placeholder="Phone Number" name="client_phoneno" />
                                <label for="floatingInput">Phone Number</label>
                                @error('client_phoneno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="floatingInput" placeholder="Email" name="email" />
                                <label for="floatingInput">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="floatingInput" placeholder="Password" name="password" />
                                <label for="floatingInput">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control  @error('cpassword') is-invalid @enderror"
                                    id="floatingInput" placeholder="Confirm Password" name="cpassword" />
                                <label for="floatingInput">Confirm Password</label>
                                @error('cpassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <select name="client_state"
                                    class="form-control @error('client_state') is-invalid @enderror" id="addState">
                                    <option value="" selected>Select State</option>
                                    @foreach ($states['states'] as $state)
                                        <option value="{{ strtolower($state['name']) }}">
                                            {{ $state['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('client_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="d-flex mt-1 justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="confirmbox" />
                                    <label class="form-check-label text-muted" for="confirmbox">I agree to all the
                                        Terms & Condition</label>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg create-accbtn">Sign
                                    up</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Already have an Account?</h6>
                                <a href="login-v1.html" class="link-primary">Login here</a>
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

    <script>
        layout_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    <script>
        main_layout_change('vertical');
    </script>

</body>
<!-- [Body] end -->

</html>
