<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta meta name="viewport" content= 
    "width=device-width, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ServeNow System Admin Layout" />
    <meta name="author" content="WorkshopSqualII" />
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

    <!-- [DataTables Links & File] -->
    <link rel="stylesheet" href="../assets/css/plugins/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins/responsive.bootstrap5.min.css" />
    <link href="../assets/css/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/plugins/dataTables.min.js"></script>
    <script src="../assets/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/plugins/dataTables.responsive.min.js"></script>
    <script src="../assets/js/plugins/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/plugins/sweetalert2.all.min.js"></script>

    <!-- [Flatpicker CSS File] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- [FullCalandarJS File]* -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

    <style>
        body.modal-open {
            padding-right: var(--bs-scrollbar-width) !important;
            overflow: hidden;
        }

        .disabled-a {
            pointer-events: none;
            opacity: 0.6;
            text-decoration: none;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #16325b;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">

    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>

    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- Includes File (Header,Sidebar)-->
    @include('tasker.layouts.header')
    @include('tasker.layouts.sidebar')
    <!-- Includes File (Header,Sidebar) end -->


    <!-- Main Content Start -->
    @yield('content')
    <!-- Main Content End -->


    <!-- Includes File (Footer) start -->
    @include('tasker.layouts.footer')
    <!-- Includes File (Footer) end -->



    <!-- Theme Setting start [To be Deleted] -->
    <div class="pct-c-btn">
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
            <i class="ph-duotone ph-gear-six"></i>
        </a>
    </div>

    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Settings</h5>
            <button type="button" class="btn btn-icon btn-link-danger ms-auto" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="ti ti-x"></i></button>
        </div>

        <div class="pct-body customizer-body">
            <div class="offcanvas-body py-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="pc-dark">
                            <h6 class="mb-1">Theme Mode</h6>
                            <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                            <div class="row theme-color theme-layout">
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn active" data-value="true"
                                            onclick="layout_change('light');" data-bs-toggle="tooltip" title="Light">
                                            <svg class="pc-icon text-warning">
                                                <use xlink:href="#custom-sun-1"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="false"
                                            onclick="layout_change('dark');" data-bs-toggle="tooltip" title="Dark">
                                            <svg class="pc-icon">
                                                <use xlink:href="#custom-moon"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="default"
                                            onclick="layout_change_default();" data-bs-toggle="tooltip"
                                            title="Automatically sets the theme based on user's operating system's color scheme.">
                                            <span class="pc-lay-icon d-flex align-items-center justify-content-center">
                                                <i class="ph-duotone ph-cpu"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Theme Contrast</h6>
                        <p class="text-muted text-sm">Choose theme contrast</p>
                        <div class="row theme-contrast">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="layout_theme_contrast_change('true');" data-bs-toggle="tooltip"
                                        title="True">
                                        <svg class="pc-icon">
                                            <use xlink:href="#custom-mask"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="false"
                                        onclick="layout_theme_contrast_change('false');" data-bs-toggle="tooltip"
                                        title="False">
                                        <svg class="pc-icon">
                                            <use xlink:href="#custom-mask-1-outline"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Custom Theme</h6>
                        <p class="text-muted text-sm">Choose your primary theme color</p>
                        <div class="theme-color preset-color">
                            <a href="#!" data-bs-toggle="tooltip" title="Blue" class="active"
                                data-value="preset-1"><i class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Indigo" data-value="preset-2"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Purple" data-value="preset-3"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Pink" data-value="preset-4"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Red" data-value="preset-5"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Orange" data-value="preset-6"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Yellow" data-value="preset-7"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Green" data-value="preset-8"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Teal" data-value="preset-9"><i
                                    class="ti ti-checks"></i></a>
                            <a href="#!" data-bs-toggle="tooltip" title="Cyan" data-value="preset-10"><i
                                    class="ti ti-checks"></i></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Theme layout</h6>
                        <p class="text-muted text-sm">Choose your layout</p>
                        <div class="theme-main-layout d-flex align-center gap-1 w-100">
                            <a href="#!" data-bs-toggle="tooltip" title="Vertical" class="active"
                                data-value="vertical">
                                <img src="../assets/images/customizer/caption-on.svg" alt="img"
                                    class="img-fluid" />
                            </a>
                            <a href="#!" data-bs-toggle="tooltip" title="Horizontal" data-value="horizontal">
                                <img src="../assets/images/customizer/horizontal.svg" alt="img"
                                    class="img-fluid" />
                            </a>
                            <a href="#!" data-bs-toggle="tooltip" title="Color Header"
                                data-value="color-header">
                                <img src="../assets/images/customizer/color-header.svg" alt="img"
                                    class="img-fluid" />
                            </a>
                            <a href="#!" data-bs-toggle="tooltip" title="Compact" data-value="compact">
                                <img src="../assets/images/customizer/compact.svg" alt="img"
                                    class="img-fluid" />
                            </a>
                            <a href="#!" data-bs-toggle="tooltip" title="Tab" data-value="tab">
                                <img src="../assets/images/customizer/tab.svg" alt="img" class="img-fluid" />
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Sidebar Caption</h6>
                        <p class="text-muted text-sm">Sidebar Caption Hide/Show</p>
                        <div class="row theme-color theme-nav-caption">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn-img btn active" data-value="true"
                                        onclick="layout_caption_change('true');" data-bs-toggle="tooltip"
                                        title="Caption Show">
                                        <img src="../assets/images/customizer/caption-on.svg" alt="img"
                                            class="img-fluid" />
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn-img btn" data-value="false"
                                        onclick="layout_caption_change('false');" data-bs-toggle="tooltip"
                                        title="Caption Hide">
                                        <img src="../assets/images/customizer/caption-off.svg" alt="img"
                                            class="img-fluid" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="pc-rtl">
                            <h6 class="mb-1">Theme Layout</h6>
                            <p class="text-muted text-sm">LTR/RTL</p>
                            <div class="row theme-color theme-direction">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn active" data-value="false"
                                            onclick="layout_rtl_change('false');" data-bs-toggle="tooltip"
                                            title="LTR">
                                            <img src="../assets/images/customizer/ltr.svg" alt="img"
                                                class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn" data-value="true"
                                            onclick="layout_rtl_change('true');" data-bs-toggle="tooltip"
                                            title="RTL">
                                            <img src="../assets/images/customizer/rtl.svg" alt="img"
                                                class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item pc-box-width">
                        <div class="pc-container-width">
                            <h6 class="mb-1">Layout Width</h6>
                            <p class="text-muted text-sm">Choose Full or Container Layout</p>
                            <div class="row theme-color theme-container">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn active" data-value="false"
                                            onclick="change_box_container('false')" data-bs-toggle="tooltip"
                                            title="Full Width">
                                            <img src="../assets/images/customizer/full.svg" alt="img"
                                                class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn-img btn" data-value="true"
                                            onclick="change_box_container('true')" data-bs-toggle="tooltip"
                                            title="Fixed Width">
                                            <img src="../assets/images/customizer/fixed.svg" alt="img"
                                                class="img-fluid" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-grid">
                            <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Theme Setting end [To be Deleted] -->


    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/plugins/dataTables.min.js"></script>
    <script src="../assets/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/plugins/dataTables.responsive.min.js"></script>
    <script src="../assets/js/plugins/responsive.bootstrap5.min.js"></script>
    <script src="../assets/js/plugins/sweetalert2.all.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const preloader = document.getElementById("preloader");
            setTimeout(() => {
                preloader.style.opacity = "0";
                preloader.style.visibility = "hidden";
            }, 1000); // Adjust the duration to match the load time
        });
        localStorage.setItem('layout', 'color-header');
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

</html>
