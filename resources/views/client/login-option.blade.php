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

     <!-- [ Option ] start -->
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5 shadow shadow-lg">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="{{ route('tasker-home') }}"><img src="../assets/images/logo-test.png" alt="img" class="img-fluid" width="150" height="100" /></a>
                            <div class="d-grid mb-3  my-3">
                                <a href="{{ route('client-login') }}" class="btn btn-outline-primary btn-lg">
                                    <span>Log In</span>
                                </a>
                            </div>
                        </div>
                        <div class="saprator my-3">
                            <span>OR</span>
                        </div>
                        <div class="d-grid my-3">
                            <a href="{{ route('client-register-form') }}" class="btn btn-primary btn-lg">
                                <span>Sign Up</span>
                            </a>
                        </div>
                       
                        <div class="text-center mt-4">
                            <div class="d-inline-flex align-items-center">
                                <label for="terms" class="f-w-400 mb-0 text-muted">
                                    By signing up you agree to our <a href="#" class="link-primary f-w-600">Terms of Use</a> and <a href="#" class="link-primary f-w-600">Privacy Policy</a>.
                                </label>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Option ] End -->
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>

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
