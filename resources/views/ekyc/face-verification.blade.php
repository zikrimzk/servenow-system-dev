<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>e-KYC | Face Verification </title>
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
    <link rel="stylesheet" href="../assets/css/landing.css" />


    <link rel="stylesheet" href="../assets/css/plugins/uppy.min.css" />

    <style>
        .custom-title {
            font-size: 14px;

        }

        .custom-content {
            font-size: 12px;

        }

        #video-container {
            position: relative;
            width: 320px;
            height: 320px;
            margin: 10px auto 20px auto;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }
    </style>

</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light" data-pc-direction="ltr"
    style="background-color: rgba(255,253,255,255)" class="landing-page">

    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <nav class="navbar navbar-expand-md navbar-light default shadow shadow-sm">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="index.html">
                <img src="../assets/images/logo-test.png" class="img-fluid" width="80" height="60" alt="logo" />
            </a>
        </div>
    </nav>


    <!-- Page 1 Start -->
    <div class="pc-container overflow-hidden page-1 mt-5">
        <div class="container">
            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-center">
                        <img src="../assets/images/ekyc/face-id.png" alt="home-image" class="img-fluid" width="150"
                            height="150">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                            <span class="hero-text-gradient">Face Verification</span>
                        </h1>
                    </div>
                </div>
                <div class="col-sm-3 p-3">
                    <div class="d-flex justify-content-center">
                        <p class="text-center">Please submit the following documents to verify your profile.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6">
                    <div class="alert alert-primary m-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1 ms-3">
                                <strong>Face Verification Requirements:</strong>
                                <ul>
                                    <li>Ensure your face is clearly visible in the camera frame.</li>
                                    <li>Remove any masks, glasses, or hats that might obstruct your face.</li>
                                    <li>Use a well-lit environment to avoid shadows or glare.</li>
                                    <li>Keep your expression neutral and look straight at the camera.</li>
                                    <li>Avoid using filters or effects on your device's camera.</li>
                                    <li>Ensure the background is clean and free from distractions.</li>
                                </ul>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 p-4">
                    <div class="d-grid mt-3">
                        <button id="btn-upd" class="btn btn-primary p-3">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

            <!-- [ footer apps ] start -->
            <footer class="mt-auto py-3 text-center shadow shadow-md">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                            <p class="mb-0 text-center">
                                <a class="link-primary" href="##"> ServeNow</a>
                                Copyright © 2024 All rights reserved
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- [ footer apps ] End -->
        </div>
    </div>
    <!-- Page 1 End -->

    <!-- Page 2 Start -->
    <div class="pc-container overflow-hidden page-2 mt-5">
        <div class="container">
            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-12" id="video-containers">
                    <div class="d-flex justify-content-center" id="video-container">
                        <video id="video" width="320" height="320" autoplay playsinline> </video>
                    </div>
                </div>
                <center>
                    <div class="loading " id="loading" style="display: none; margin-bottom: 12rem ;">
                        <img src="../assets/images/ekyc/loading-4.gif" width="300" height="200" alt="Loading" />
                        <p class="fw-bold text-center">Verifying Face...</p>
                    </div>
                </center>

                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-6 p-4">
                        <div class="d-grid mt-4 mb-3">
                            <button id="snap" class="start btn btn-primary p-3">Verify Face</button>
                            <canvas id="canvas" width="320" height="320" style="display: none"></canvas>
                        </div>
                    </div>
                </div>


            </div>




            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- Page 2 End -->


    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        $('.page-2').hide();

        $('#btn-upd').on('click', function () {
            $('.page-1').hide();
            $('.page-2').show();

        });

        const video = document.getElementById("video");
        const snap = document.getElementById("snap");
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        const loadingElement = document.getElementById("loading");
        const container = document.getElementById("video-containers");



        async function startVideo() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                    video.play();
                } catch (error) {
                    console.error("Error accessing camera:", error);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error accessing camera. Please check your camera settings.',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content' // Optional: to adjust content size as well
                        }
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'getUserMedia not supported on your browser. Please try a different browser.',
                    customClass: {
                        title: 'custom-title',
                        content: 'custom-content' // Optional: to adjust content size as well
                    }
                });
            }
        }

        document.addEventListener("DOMContentLoaded", startVideo);

        snap.addEventListener("click", function () {
            loadingElement.style.display = "block";
            snap.style.display = "none";
            video.style.display = "none";
            container.style.display = "none";

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL("image/png");
            const base64Image = dataUrl.split(",")[1];

            const urlParams = new URLSearchParams(window.location.search);
            const filename = urlParams.get("id");

            fetch("https://ekyc-api.xbug.online/process-face", {
                method: "POST",
                body: JSON.stringify({ image: base64Image, filename }),
                headers: { "Content-Type": "application/json" },
            })
                .then((response) => response.json())
                .then((data) => {
                    loadingElement.style.display = "none";
                    video.style.display = "block";
                    container.style.display = "block";
                    snap.style.display = "block";

                    alert(data.message);
                    if (data.status) {
                        // Redirect or handle success case
                        Swal.fire({
                            icon: 'success',
                            title: 'Your verification is completed successfully',
                            confirmButtonText: 'Finish',
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('tasker-ver-success') }}";
                            }
                        });
                    } else {
                        // Handle failure case
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    loadingElement.style.display = "none";
                    video.style.display = "block";
                    snap.style.display = "block";
                    container.style.display = "block";
                    Swal.fire({
                        icon: 'error',
                        title: 'Error sending image to server.',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content'
                        }
                    });
                });
        });
    </script>

    <!-- [Page Specific JS] start -->


</body>
<!-- [Body] end -->

</html>