<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>e-KYC | {{ $title }} </title>
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
                <img src="../assets/images/logo-test.png" class="img-fluid" width="80" height="60"
                    alt="logo" />
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
                        <img src="../assets/images/ekyc/home.png" alt="home-image" class="img-fluid" width="150"
                            height="150">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                            <span class="hero-text-gradient">Let's verify e-KYC</span>
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
                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar bg-light-primary">
                                        <i class="fas fa-id-card f-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <small class="text-muted">Step 1</small>
                                            <h5 class="mb-1">Upload a picture of your MyKad</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">To check your personal informations are correct</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar bg-light-primary">
                                        <i class="fas fa-camera f-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <small class="text-muted">Step 2</small>
                                            <h5 class="mb-1">Take a selfie of yourself</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">To match your face with MyKad</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 p-4">
                    <div class="d-grid mt-3">
                        <button id="btn-upd" class="btn btn-primary p-3">
                            Start Verification
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
                <div class="col-sm-12">
                    <div class="d-flex justify-content-center">
                        <img src="../assets/images/ekyc/biometric.png" alt="home-image" class="img-fluid"
                            width="150" height="150">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                            <span class="hero-text-gradient">Upload your MyKad</span>
                        </h1>
                    </div>

                </div>
                <div class="col-sm-3 p-3">
                    <div class="d-flex justify-content-center">
                        <p class="text-center">
                            Please make sure that all details on your MyKad are clearly visible in the camera frame, and
                            that your camera is in focus.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 ">

                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="pc-uppy" id="pc-uppy-1"> </div>
                            <div class="d-grid mt-3">
                                <button id="uploadButton" class="btn btn-primary">Upload MyKad</button>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="loading" id="loading">
                                    <img src="../assets/images/ekyc/loading-4.gif" width="300" height="200"
                                        alt="Loading" />
                                    <p class="fw-bold text-center">Verifying MyKad...</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- [ Main Content ] end -->

            <!-- [ footer apps ] start -->
            <footer class="mt-auto py-3 text-center shadow shadow-sm">
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
    <!-- Page 2 End -->


    <!-- Required Js -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/plugins/uppy.min.js"></script>
    <script src="../assets/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        $('.page-2').hide();

        $('#btn-upd').on('click', function() {
            $('.page-1').hide();
            $('.page-2').show();

        });

        alert('{{ Auth::user()->tasker_icno }}')
    </script>

    <!-- [Page Specific JS] start -->



    <script type="module">
        // Function for displaying uploaded files
        const onUploadSuccess = (elForUploadedFiles) => (file, response) => {
            const url = response.uploadURL;
            const fileName = file.name;

            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = url;
            a.target = '_blank';
            a.appendChild(document.createTextNode(fileName));
            li.appendChild(a);

            document.querySelector(elForUploadedFiles).appendChild(li);
        };

        import {
            Uppy,
            Dashboard,
            Webcam,
            XHRUpload
        } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs';

        const loadingElement = document.getElementById('loading');
        const uplElement = document.getElementById('pc-uppy-1');
        const uplBtn = document.getElementById('uploadButton');
        let base64Image = null; // To store the converted base64 image
        // let base64Image = null;

        loadingElement.style.display = 'none';

        // Uppy setup
        const uppy = new Uppy({
                debug: true,
                autoProceed: true,
                restrictions: {
                    maxNumberOfFiles: 1,
                    allowedFileTypes: ['image/*']
                }
            })
            .use(Dashboard, {
                target: '#pc-uppy-1',
                inline: true,
                showProgressDetails: true,
                showRemoveButtonAfterComplete: true,
                proudlyDisplayPoweredByUppy: false,
                hideUploadButton: true,
                height: 350,
            })
            .use(Webcam, {
                target: Dashboard,
                modes: ['picture'],
                facingMode: 'environment'
            });

        // Convert file to Base64 on 'file-added'
        uppy.on('file-added', (file) => {
            const reader = new FileReader();
            reader.onload = () => {
                base64Image = reader.result.split(',')[1];
            };
            reader.readAsDataURL(file.data);
        });

        $('#uploadButton').on('click', function() {

            if (!base64Image) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select an image!',
                    customClass: {
                        title: 'custom-title',
                        content: 'custom-content' // Optional: to adjust content size as well
                    }
                });
                return;
            }
            submitToServer(base64Image);

        });



        // Submit the Base64 image to the server
        function submitToServer(base64Image) {
            loadingElement.style.display = 'block';
            uplElement.style.display = 'none';
            uplBtn.style.display = 'none';


            fetch('https://ekyc-api.xbug.online/process-card', {
                    method: 'POST',
                    body: JSON.stringify({
                        image: base64Image
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    loadingElement.style.display = 'none';
                    uplElement.style.display = 'display';
                    const idno = '{{ Auth::user()->tasker_icno }}';

                    if (data.success) {
                        const idnoserver = data.data.IDENTITY_NO;
                        const result = idnoserver.replace(/-/g, "");
                        if (result != idno) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error: Your IC No does not match with your registered IC NO.',
                                confirmButtonText: 'Okay',
                                customClass: {
                                    title: 'custom-title',
                                    content: 'custom-content'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: `${data.message}\n\nCARD TYPE: ${data.data.CARD_TYPE}\nIDENTITY NO: ${data.data.IDENTITY_NO}`,
                                confirmButtonText: 'Next Step',
                                customClass: {
                                    title: 'custom-title',
                                    content: 'custom-content'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('tasker-face-ver') }}?id=:filename".replace(':filename', encodeURIComponent(data.filename));
                                }
                            });

                        }

                    } else {
                        uplElement.style.display = 'block';
                        uplBtn.style.display = 'block';

                        Swal.fire({
                            icon: 'error',
                            title: 'Verification failed: ' + data.message,
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
                    }
                })
                .catch((error) => {
                    loadingElement.style.display = 'none';
                    uplElement.style.display = 'block';
                    uplBtn.style.display = 'block';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error sending image to server.',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content'
                        }
                    });
                });
        }
    </script>

</body>
<!-- [Body] end -->

</html>
