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
    @include('administrator.layouts.header')
    @include('administrator.layouts.sidebar')
    <!-- Includes File (Header,Sidebar) end -->


    <!-- Main Content Start -->
    @yield('content')
    <!-- Main Content End -->


    <!-- Includes File (Footer) start -->
    @include('administrator.layouts.footer')
    <!-- Includes File (Footer) end -->


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
