@php
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    $is_mobile =
        preg_match(
            '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',
            $useragent,
        ) ||
        preg_match(
            '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/',
            substr($useragent, 0, 4),
        );

@endphp

<?php if (!$is_mobile): ?>
<?php
// Flash error message ke sesi sebelum redirect
session()->flash('error', 'Please login from a mobile device.');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <script>
        Swal.fire({
            icon: 'info',
            title: '',
            text: 'The e-KYC verification process can only be completed on a mobile device. Please login from a mobile device.',
            customClass: {
                title: 'custom-title',
                content: 'custom-content'
            },
            confirmButtonText: 'OK'
        }).then(() => {
            // Redirect ke login page
            window.location.href = "<?php echo e(route('login')); ?>?error=XxXxXxXxXxXx";
        });
    </script>
</body>

</html>
<?php exit(); ?>
<?php endif; ?>


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
                        <img src="../assets/images/ekyc/loading-4.gif" width="300" height="200"
                            alt="Loading" />
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

        $('#btn-upd').on('click', function() {
            $('.page-1').hide();
            $('.page-2').show();

        });

        const urlParams = new URLSearchParams(window.location.search);
        const filename = urlParams.get("id");

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

        /**
         * Converts a JavaScript object into an HTML formatted list.
         * @param {Object} detail - The detail object to format.
         * @returns {string} - The HTML string representing the detail.
         */
        function convertDetailToList(detail) {
            let list = '<ul style="text-align: left; list-style-type: disc; padding-left: 20px;">';
            for (const [key, value] of Object.entries(detail)) {
                if (typeof value === 'object' && value !== null) {
                    if (Array.isArray(value)) {
                        // Handle arrays
                        list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${value.join(', ')}</li>`;
                    } else {
                        // Handle nested objects
                        list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${convertDetailToList(value)}</li>`;
                    }
                } else {
                    list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${value}</li>`;
                }
            }
            list += '</ul>';
            return list;
        }

        /**
         * Capitalizes the first letter of a string.
         * @param {string} string - The string to capitalize.
         * @returns {string} - The capitalized string.
         */
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        /**
         * Displays the verification details in a new SweetAlert.
         * @param {Object} detail - The detail object containing verification information.
         */
        function displayVerificationDetails(detail) {
            Swal.fire({
                icon: 'info',
                title: 'Verification Details',
                html: `
                <div style="text-align: left;">
                    ${convertDetailToList(detail)}
                </div>
            `,
                confirmButtonText: 'Close',
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false, // Prevent closing by pressing Esc
                customClass: {
                    title: 'custom-title',
                    content: 'custom-content'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reopen the initial verification success modal
                    showVerificationSuccess(currentData);
                }
            });
        }

        /**
         * Displays the initial verification success SweetAlert with "Finish" and "Detail" buttons.
         * @param {Object} data - The data object containing message and detail.
         */
        function showVerificationSuccess(data) {
            Swal.fire({
                icon: 'success',
                title: 'VERIFICATION SUCCESS: ' + data.message,
                showDenyButton: true, // Enables the "Detail" button
                confirmButtonText: 'Finish',
                denyButtonText: 'Detail',
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false, // Prevent closing by pressing Esc
                customClass: {
                    title: 'custom-title',
                    content: 'custom-content'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Corrected redirection with proper string formatting
                    window.location.href = `{{ route('tasker-ver-success') }}?idno=${filename}`;
                    // Alternatively, using template literals:
                } else if (result.isDenied) {
                    // Display the detailed verification information
                    displayVerificationDetails(data.detail);
                }
            });
        }


        /**
         * Menampilkan SweetAlert ralat dengan butang "Again" dan "Detail".
         * @param {string} message - Mesej ralat utama.
         * @param {Object} detail - Butiran ralat.
         */
        function showErrorAlert(message, detail) {
            Swal.fire({
                icon: 'error',
                title: 'VERIFICATION FAILED: ' + message,
                showDenyButton: true, // Menambah butang "Detail"
                confirmButtonText: 'Again',
                denyButtonText: 'Detail',
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false, // Prevent closing by pressing Esc
                customClass: {
                    title: 'custom-title',
                    content: 'custom-content'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reload the page for another attempt
                    location.reload();
                } else if (result.isDenied) {
                    // Paparkan butiran ralat
                    displayErrorDetails(detail);
                }
            });
        }

        /**
         * Menampilkan butiran ralat dalam SweetAlert baru.
         * @param {Object} detail - Butiran ralat yang diterima dari server.
         */
        function displayErrorDetails(detail) {
            // Ubah butiran ralat menjadi senarai HTML atau format yang diinginkan
            let errorDetails = convertDetailToList(detail);

            Swal.fire({
                icon: 'error',
                title: 'Error Details',
                html: `
            <div style="text-align: left;">
                ${errorDetails}
            </div>
        `,
                confirmButtonText: 'Close',
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false, // Prevent closing by pressing Esc
                customClass: {
                    title: 'custom-title',
                    content: 'custom-content'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kembali ke SweetAlert ralat utama
                    showErrorAlert(detail.message, detail);
                }
            });
        }

        /**
         * Fungsi pembantu untuk memaparkan butiran sebagai senarai HTML.
         * @param {Object} detail - Butiran ralat.
         * @returns {string} - Senarai HTML.
         */
        function convertDetailToList(detail) {
            let list = '<ul style="text-align: left; list-style-type: disc; padding-left: 20px;">';
            for (const [key, value] of Object.entries(detail)) {
                if (typeof value === 'object' && value !== null) {
                    if (Array.isArray(value)) {
                        // Menangani array
                        list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${value.join(', ')}</li>`;
                    } else {
                        // Menangani objek bersarang
                        list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${convertDetailToList(value)}</li>`;
                    }
                } else {
                    list += `<li><strong>${capitalizeFirstLetter(key)}:</strong> ${value}</li>`;
                }
            }
            list += '</ul>';
            return list;
        }

        /**
         * Fungsi pembantu untuk menukar huruf pertama menjadi huruf besar.
         * @param {string} string - String asal.
         * @returns {string} - String dengan huruf pertama besar.
         */
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }


        // Variable to store the current data object for modal navigation
        let currentData = {};


        document.addEventListener("DOMContentLoaded", startVideo);

        snap.addEventListener("click", function() {
            loadingElement.style.display = "block";
            snap.style.display = "none";
            video.style.display = "none";
            container.style.display = "none";

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL("image/png");
            const base64Image = dataUrl.split(",")[1];

          

            fetch("{{ env('API_EKYC_URL') }}/process-face", {
                    method: "POST",
                    body: JSON.stringify({
                        image: base64Image,
                        filename
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        'Authorization': '{{ env('EKYC_API_KEY') }}'
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    // Hide loading and show video and buttons again
                    loadingElement.style.display = "none";
                    video.style.display = "block";
                    container.style.display = "block";
                    snap.style.display = "block";

                    // Store the current data object for later use
                    currentData = data;

                    // Handle response based on status
                    if (data.status) {
                        // Success case
                        showVerificationSuccess(data);
                    } else {
                        // Failure case
                        showErrorAlert(data.message, data);

                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    // Hide loading and show video and buttons again
                    loadingElement.style.display = "none";
                    video.style.display = "block";
                    snap.style.display = "block";
                    container.style.display = "block";
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR SENDING IMAGE TO SERVER. CONTACT US BY EMAIL AT [support@servenow.com.my] FOR INFORMATION OR REPORT',
                        allowOutsideClick: false, // Prevent closing by clicking outside
                        allowEscapeKey: false, // Prevent closing by pressing Esc
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


{{-- fetch("{{ env('API_EKYC_URL') }}/process-face", {
    method: "POST",
    body: JSON.stringify({
        image: base64Image,
        filename
    }),
    headers: {
        "Content-Type": "application/json",
        'Authorization': '{{ env('EKYC_API_KEY') }}'
    },
})
.then((response) => response.json())
.then((data) => {
    loadingElement.style.display = "none";
    video.style.display = "block";
    container.style.display = "block";
    snap.style.display = "block";

    // alert(data.message);
    if (data.status) {
        // Redirect or handle success case
        Swal.fire({
            icon: 'success',
            title: 'VERIFICATION SUCCESS: ' + data.message,
            confirmButtonText: 'Finish',
            customClass: {
                title: 'custom-title',
                content: 'custom-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    `{{ route('tasker-ver-success') }}?idno=${filename}`;
            }
        });
    } else {
        // Handle failure case
        Swal.fire({
            icon: 'error',
            title: 'VERIFICATION FAILED: ' + data.message,
            confirmButtonText: 'Again',
            customClass: {
                title: 'custom-title',
                content: 'custom-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
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
        title: 'ERROR SENDING IMAGE TO SERVER. CONTACT US BY EMAIL AT [help-center@servenow.com.my] FOR INFORMATION OR REPORT',
        customClass: {
            title: 'custom-title',
            content: 'custom-content'
        }
    });
}); --}}
