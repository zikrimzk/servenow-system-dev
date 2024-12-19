<!-- Client Landing / Search Page  -->
<!-- Client Site Template  -->

<!doctype html>
<html lang="en">

<head>
    <title>ServeNow | {{ $title }} </title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta meta name="viewport" content= "width=device-width, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="assets/images/logo-test-white.png" type="image/x-icon" />
    <!-- [Page specific CSS] start -->
    <link href="assets/css/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="assets/fonts/inter/inter.css" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <script src="assets/js/tech-stack.js"></script>
    <link rel="stylesheet" href="assets/css/landing.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <style>
        .search-bar {
            background-color: #ffffff;
            /* Purple background */
            border-radius: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 5px 20px;
            width: 500px;
            border: 1px solid #16325b;
            /* Border width and color */
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14pt;
            flex: 1;
            padding-left: 15px;
        }

        .search-bar input::placeholder {
            color: black;
            opacity: 0.8;
        }


        .btn-outline-primary {
            --bs-btn-color: #000000;
            --bs-btn-border-color: #16325b;
            --bs-btn-hover-color: #000000;
            --bs-btn-hover-bg: #e2edfe;
            --bs-btn-hover-border-color: #0066ff;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #0d6efd;
            --bs-btn-active-border-color: #0d6efd;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #0d6efd;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #0d6efd;
            --bs-gradient: none
        }
    </style>

</head>



<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast=""
    data-pc-theme="light" class="landing-page">
    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Header ] start -->
    <header id="home" style="background-image: url(../assets/images/servenowBg1.png);">
        <!-- [ Nav ] start -->
        <nav class="navbar navbar-expand-md navbar-light default">
            <div class="container">
                <a class="navbar-brand" href="{{ route('servenow-home') }}">
                    <img src="../assets/images/logo-test.png" alt="img" class="img-fluid"
                        style="max-width: 110px;" />
                </a>
                <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item px-2">
                            <a class="nav-link" href="{{ route('servenow-login-option') }}">Sign up / Log in</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('tasker-login') }}">Become a Tasker
                                <i class="ti ti-external-link"></i> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- [ Nav ] start -->

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <h1 class="wow fadeInUp" data-wow-delay="0.2s">
                        Easy Solutions for
                    </h1>
                    <h1 class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        Your
                        <span class="hero-text-gradient">Home Needs</span>

                    </h1>
                    <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.3s">
                        <div class="col-md-8">
                            <p class="text-muted f-16 mb-0">
                                Trusted Home Services at Your Fingertips.
                            </p>
                        </div>
                    </div>
                    <!-- [ Text] end -->
                    <!-- [ Search-Text] Start -->
                    <div class="my-4 my-sm-5 wow fadeInUp" data-wow-delay="0.4s">
                        <img src="../assets/images/servenowLogoIsk3.png" alt="img" class="img-fluid"
                            style="max-width: 75px;" />
                    </div>



                    <!-- [ Search-Text] End -->
                    <!-- [ Highlight Option] Start -->
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10 text-center">
                                <!-- Buttons with spacing -->
                                <div class="my-2 my-sm-1 d-flex flex-wrap justify-content-center align-items-start gap-2 wow fadeInUp"
                                    data-wow-delay="0.4s">
                                    @foreach ($service as $sv)
                                        <a href="{{ route('client-booking', $sv->id) }}"
                                            class="btn btn-outline-primary">{{ $sv->servicetype_name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ Highlight Option] End -->
            </div>
        </div>
    </header>

    <!-- [ Header ] End -->

    <body>
        <div class="container title my-5">
            <div class="row align-items-center">
                <!-- Image Section -->
                <div class="col-12 col-md-6 mb-4 mb-md-0"> <!-- Added margin bottom for spacing -->
                    <img src="../assets/images/tasker_bg.jpg" alt="Tasker Background" class="img-fluid rounded"
                        style="border-radius: 15px;">
                </div>

                <!-- Steps Section -->
                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                    <!-- Centering the steps -->
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="me-3 fw-bold" style="font-size: 2rem; width:35px;color:red">1</span>
                            <p class="text-muted f-16 mb-0">
                                Choose a Tasker by price, skills, and reviews.
                            </p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="me-3 fw-bold" style="font-size: 2rem;width:35px;color:darkblue">2</span>
                            <p class="text-muted f-16 mb-0">
                                Schedule a Tasker as early as today.
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3 fw-bold" style="font-size: 2rem;width:35px; color:green">3</span>
                            <p class="text-muted f-16 mb-0">
                                Chat, pay, tip, and review all in one place.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container title my-5">
            <h2 class="mb-5">See what happy customers are saying about Servenow</h2>

            <div class="row">
                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                        user234823
                    </h5>
                    <p class="text-muted f-16 mb-3">
                        Vitalii assembled the IKEA Norli drawer chest for me in less than 30 minutes, and he assembled a
                        metal wire shelving unit as well in about 10 minutes.
                    </p>

                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="stars">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-muted"></i>
                            </div>
                            <h5 class="title mb-0"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                                Plumbing
                            </h5>
                        </div>
                    </div>
                </div>



                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                        Isk Ros
                    </h5>
                    <p class="text-muted f-16 mb-3">
                        Vitalii assembled the IKEA Norli drawer chest for me in less than 30 minutes, and he assembled a
                        metal wire shelving unit as well in about 10 minutes.
                    </p>

                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="stars">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-muted"></i>
                            </div>
                            <h5 class="title mb-0"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                                Mounting
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                        Muhammad Khairul
                    </h5>
                    <p class="text-muted f-16 mb-3">
                        Vitalii assembled the IKEA Norli drawer chest for me in less than 30 minutes, and he assembled a
                        metal wire shelving unit as well in about 10 minutes.
                    </p>

                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="stars">
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-muted"></i>
                                <i class="fa fa-star text-muted"></i>
                            </div>
                            <h5 class="title mb-0"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">
                                Flooring
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="background-color: #ffffff">
            <div class="container title pt-5 pb-5">
                <h1 class="wow fadeInUp mb-5" data-wow-delay="0.2s">
                    Your satisfaction,
                    <span class="hero-text-gradient">guaranteed</span>
                </h1>

                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333; font-size:25px">
                            Happiness Pledge
                        </h5>
                        <p class="text-muted f-16">
                            If you’re not satisfied, we’ll work to make it right.
                        </p>
                    </div>



                    <!-- Card 2 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;font-size:25px">
                            Vetted Taskers
                        </h5>
                        <p class="text-muted f-16">
                            Taskers are always background checked before joining the platform.
                        </p>


                    </div>

                    <!-- Card 3 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <h5 style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;font-size:25px">
                            Dedicated Support
                        </h5>
                        <p class="text-muted f-16">
                            Friendly service when you need us – every day of the week.
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <div class="container title my-5">
            <h2 class="mb-5">Recommended Tasker</h2>
            <div class="row">
                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card" style="width: 100%; border-radius: 15px; overflow: hidden;">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center">
                                <img class="rounded-circle"
                                    style="width: 120px; border: 3px solid #ddd; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);"
                                    src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" alt="Avatar" />
                            </div>

                            <h5 class="card-title"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">Murayama Zikri
                            </h5>
                            <p class="card-text" style="font-size: 14px; color: #555;">Some quick example text to
                                build on the card title and make up the bulk of the card's content.</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="my-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-muted"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                    <p class="card-text fs-6 text-muted mb-0">5.4 Km</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="#" style="font-size: 14px; color: #007bff; text-decoration: none;">View
                                    Tasker</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card" style="width: 100%; border-radius: 15px; overflow: hidden;">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center">
                                <img class="rounded-circle"
                                    style="width: 120px; border: 3px solid #ddd; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);"
                                    src="https://mdbcdn.b-cdn.net/img/new/avatars/8.webp" alt="Avatar" />
                            </div>

                            <h5 class="card-title"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">Koba Qiwa
                                Yashito</h5>
                            <p class="card-text" style="font-size: 14px; color: #555;">Some quick example text to
                                build on the card title and make up the bulk of the card's content.</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="my-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                    <p class="card-text fs-6 text-muted mb-0">8.7 Km</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="#" style="font-size: 14px; color: #007bff; text-decoration: none;">View
                                    Tasker</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card" style="width: 100%; border-radius: 15px; overflow: hidden;">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center">
                                <img class="rounded-circle"
                                    style="width: 120px; border: 3px solid #ddd; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);"
                                    src="https://mdbcdn.b-cdn.net/img/new/avatars/4.webp" alt="Avatar" />
                            </div>

                            <h5 class="card-title"
                                style="font-family: 'Arial', sans-serif; font-weight: 600; color: #333;">Sabrina
                                Yoshito</h5>
                            <p class="card-text" style="font-size: 14px; color: #555;">Some quick example text to
                                build on the card title and make up the bulk of the card's content.</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="my-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-muted"></i>
                                    <i class="fa fa-star text-muted"></i>
                                    <i class="fa fa-star text-muted"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                    <p class="card-text fs-6 text-muted mb-0">1.0 Km</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="#" style="font-size: 14px; color: #007bff; text-decoration: none;">View
                                    Tasker</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container title my-5">
            <div class="row align-items-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-6">
                    <h2 class="mb-3">Stay connected with us</h2>
                    <p class="mb-4 mb-md-0">
                        Simply submit your email, we share you the top news related to ServeNow feature updates,
                        roadmap, and news.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <input type="email" class="form-control" placeholder="Enter your email" />
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>


    <!-- [ footer apps ] start -->
    <footer class="footer" style="padding-top: 0; background-color:#e5e7eb">

        <div class="footer-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="../assets/images/logo-test.png" alt="img" class="img-fluid"
                            style="max-width: 110px;" />
                        <p class="mb-4">
                            ServeNow has gained the trust of over 5.5K customers since 2024, thanks to our
                            commitment to delivering high-quality
                            products. Our experienced team players are responsible for managing ServeNow.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-6 wow fadeInUp" data-wow-delay="0.8s">
                                <h5 class="mb-4">Contact Us</h5>
                                <ul class="list-unstyled footer-link">
                                    <li>
                                        <a href="" target="_blank">servenow@mail.com</a>
                                    </li>
                                    <li>
                                        <a href="" target="_blank">6026429534</a>
                                    </li>

                                </ul>
                            </div>

                            <div class="col-sm-6 wow fadeInUp" data-wow-delay="0.6s">
                                <h5 class="mb-4">Follow Us</h5>
                                <ul class="list-unstyled footer-link">
                                    <li>
                                        <a href="https://www.instagram.com" target="_blank">
                                            <i class="fab fa-instagram"
                                                style="color: #E4405F; font-size: 20px; width: 15px"></i>
                                            <span style="margin-left: 8px;">ofc_servenow</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://x.com" target="_blank">
                                            <i class="fab fa-x"
                                                style="color: #1DA1F2; font-size: 20px; width: 15px"></i>
                                            <span style="margin-left: 8px;">serve_now</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.tiktok.com" target="_blank">
                                            <i class="fab fa-tiktok"
                                                style="color: #010101; font-size: 20px; width: 15px"></i>
                                            <span style="margin-left: 8px;">serve_now_ofc</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.pinterest.com" target="_blank">
                                            <i class="fab fa-pinterest"
                                                style="color: #E60023; font-size: 20px; width: 15px"></i>
                                            <span style="margin-left: 8px;">Serve Now</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-sm-6 wow fadeInUp" data-wow-delay="0.8s">
                                <h5 class="mb-4">Download App</h5>
                                <div class="d-flex flex-column">
                                    <ul class="list-unstyled footer-link">
                                        <li>
                                            <a href="https://play.google.com" target="_blank"
                                                class="d-flex align-items-center mb-3">
                                                <i class="fab fa-google-play"
                                                    style="font-size: 25px; color:#a0a0a0"></i>
                                                <span class="ms-2">Google Play</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://apps.apple.com" target="_blank"
                                                class="d-flex align-items-center mt-3">
                                                <i class="fab fa-app-store"
                                                    style="font-size: 25px; color:#a0a0a0"></i>
                                                <span class="ms-2">App Store</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="container">
            <div class="row align-items-center">
                <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                    <p class="mb-0">
                        ServeNow Copyright © 2024 All rights reserved
                    </p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-sos-link mb-0">
                        <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                            <a href="https://fb.com/phoenixcoded">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-facebook"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto my-1 wow fadeInUp" data-wow-delay="0.4s">
                    <p class="mb-0 text-center">
                        ServeNow Copyright © 2024 All rights reserved
                    </p>
                </div>
            </div>
        </div>

    </footer>

    <!-- [ footer apps ] End -->

    <!-- [ Main Content ] end -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!-- Required Js -->

    <script>
        // Your JavaScript code here
        const options = document.querySelectorAll('.option');

        options.forEach((option) => {
            option.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                options.forEach((opt) => opt.classList.remove('highlight'));
                this.classList.add('highlight');
            });
        });
    </script>
    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/fonts/custom-font.js"></script>
    <script src="assets/js/pcoded.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script>
        layout_change('light');
    </script>
    <script>
        layout_theme_contrast_change('false');
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
    <!-- [Page Specific JS] start -->
    <script src="assets/js/plugins/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.marquee/1.4.0/jquery.marquee.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="assets/js/plugins/Jarallax.js"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();

        // slider start
        $('.screen-slide').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.app_dotsContainer',
            URLhashListener: true,
            items: 1
        });
        $('.workspace-slider').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.workspace-card-block',
            URLhashListener: true,
            items: 1.5
        });
        // slider end
        // marquee start
        $('.marquee').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true
        });
        $('.marquee-1').marquee({
            duration: 500000,
            pauseOnHover: true,
            startVisible: true,
            duplicated: true,
            direction: 'right'
        });
        // marquee end
    </script>
    <!-- [Page Specific JS] end -->

</body>

</html>
