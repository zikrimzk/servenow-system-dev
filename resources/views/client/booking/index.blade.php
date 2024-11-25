@extends('client.layouts.main')

<style>

</style>

@section('content')
    {{-- content here --}}

    <!-- [ Main Content ] start -->

    <style>
        .custom-order {
            order: 1;
            /* Susun semula butang dan profil di atas pada skrin kecil */
        }

        /* Gunakan media query untuk skrin lebih besar (md dan ke atas) */
        @media (min-width: 768px) {
            .custom-order {
                order: 2;
                /* Pada skrin besar, butang dan profil akan berada selepas "How I can help" */
            }

            /* Anda boleh menambah lebih banyak gaya khusus untuk elemen lain jika perlu */
        }
    </style>
    <div class="pc-container mb-5">
        <div class="pc-content">
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-8 col-md-12">
                    <div id="basicwizard" class="form-wizard row justify-content-center mx-3 my-1">
                        <div class="col-sm-8 col-md-12">
                            <h1 class="my-4">Booking</h1>

                            <div class="alert alert-primary">
                                <div class="d-flex">
                                    <i class="ti ti-edit h2 f-w-400 mb-0 text-primary"></i>
                                    <div class="flex-grow-1 ms-3">
                                        Describe your task in detail to help us match you with the best service providers in
                                        your area. Be as specific as possible about what you need, including any special
                                        requirements or preferences.
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8 col-md-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item" data-target-form="#contactDetailForm">
                                            <a href="#contactDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link active">
                                                <i class="ph-duotone ph-user-circle"></i>
                                                <span class="d-none d-sm-inline">Location</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#jobDetailForm">
                                            <a href="#jobDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="ph-duotone ph-map-pin"></i>
                                                <span class="d-none d-sm-inline">Tasker Selection</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#educationDetailForm">
                                            <a href="#educationDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="ph-duotone ph-graduation-cap"></i>
                                                <span class="d-none d-sm-inline">Special Request</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item">
                                            <a href="#finish" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="ph-duotone ph-check-circle"></i>
                                                <span class="d-none d-sm-inline">Finish</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- START: Define your progress bar here -->
                                        <div id="bar" class="progress mb-3" style="height: 7px">
                                            <div
                                                class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                            </div>
                                        </div>
                                        <!-- END: Define your progress bar here -->
                                        <!-- START: Define your tab pans here -->
                                        <div class="tab-pane show active" id="contactDetail">
                                            <form id="contactForm" method="get" action="/forms/form2_wizard.html">
                                                <div class="text-start">
                                                    <h3 class="mb-2">Start by providing the basic information about your
                                                        task</h3>
                                                    <small class="text-muted">This helps us connect you with the right
                                                        service providers in your area. Be clear and concise about what you
                                                        need, including any essential details to get started.

                                                    </small>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Date Booking :</label>
                                                                    <input type="date" class="form-control"
                                                                        placeholder="Date" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="mb-3 mt-5">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="defaultCheckbox">
                                                                    <label class="form-check-label" for="defaultCheckbox">
                                                                        Default Address
                                                                    </label>
                                                                    <div class="col-sm-12 mt-3">
                                                                        <label class="form-label">Address:</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Enter Address" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end contact detail tab pane -->
                                        <div class="tab-pane" id="jobDetail">
                                            <form id="jobForm" method="post" action="#">
                                                <div class="text-center mb-4 mt-4">
                                                    <h2 class="mb-1">Select Your Tasker</h2>
                                                </div>

                                                <!--Tasker Selection-->
                                                <div class="card m-2 border border-0 mb-5">
                                                    <!--Image Tasker Section [Start]-->
                                                    <div class="row mt-4">

                                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}"
                                                                    alt="Profile Photo" width="150" height="150"
                                                                    class="user-avtar rounded-circle">

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                                            <div class="p-3">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <h5 class="mb-2 f-24">Qiwamuddin</h5>
                                                                    <h5 class="mb-2">RM 47.49/hr</h5>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <span class="badge bg-success text-white me-2">GREAT
                                                                        VALUE</span>
                                                                    <span class="badge text-bg-primary text-dark">2 HOUR
                                                                        MINIMUM</span>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1">
                                                                        <span class="fw-bold">★ 4.9</span> (394 reviews)
                                                                    </p>
                                                                    <p class="mb-1">695 Cleaning tasks</p>
                                                                    <p class="mb-0 text-muted">677 Cleaning tasks overall
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row flex-sm-row  flex-column-reverse">
                                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                                            <div class="d-none d-md-block text-center mt-2 mb-2">
                                                                <a href="" class=" mb-2  primary p-1">View
                                                                    Profile & Review
                                                                </a>
                                                            </div>
                                                            <div class="d-grid d-md-flex justify-content-md-center align-items-md-center ">
                                                                <button class="btn btn-primary">Select & Continue </button>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-9 col-lg-9">
                                                            <div class=" bg-light p-3">
                                                                <h4> How I can help:</h4>
                                                                <p class="text-muted fw-normal f-16">
                                                                    Hello 🥰 I am cleaner with a 5 years of experience
                                                                    🧼🧹
                                                                    I do apartments, Airbnb, offices, etc. 🙌 I have my
                                                                    basic cleaning supplies with me! I love making the
                                                                    space
                                                                    perfect and spotless! I also do organizing, laundry,
                                                                    ironing, and packing!!!
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card m-2 border border-0 mb-5">
                                                    <!--Image Tasker Section [Start]-->
                                                    <div class="row mt-4">

                                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}"
                                                                    alt="Profile Photo" width="150" height="150"
                                                                    class="user-avtar rounded-circle">

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                                            <div class="p-3">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <h5 class="mb-2 f-24">Qiwamuddin</h5>
                                                                    <h5 class="mb-2">RM 47.49/hr</h5>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <span class="badge bg-success text-white me-2">GREAT
                                                                        VALUE</span>
                                                                    <span class="badge text-bg-primary text-dark">2 HOUR
                                                                        MINIMUM</span>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1">
                                                                        <span class="fw-bold">★ 4.9</span> (394 reviews)
                                                                    </p>
                                                                    <p class="mb-1">695 Cleaning tasks</p>
                                                                    <p class="mb-0 text-muted">677 Cleaning tasks overall
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row flex-sm-row  flex-column-reverse">
                                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                                            <div class="d-none d-md-block text-center mt-2 mb-2">
                                                                <a href="" class=" mb-2  primary p-1">View
                                                                    Profile & Review
                                                                </a>
                                                            </div>
                                                            <div class="d-grid d-md-flex justify-content-md-center align-items-md-center ">
                                                                <button class="btn btn-primary">Select & Continue </button>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-9 col-lg-9">
                                                            <div class=" bg-light p-3">
                                                                <h4> How I can help:</h4>
                                                                <p class="text-muted fw-normal f-16">
                                                                    Hello 🥰 I am cleaner with a 5 years of experience
                                                                    🧼🧹
                                                                    I do apartments, Airbnb, offices, etc. 🙌 I have my
                                                                    basic cleaning supplies with me! I love making the
                                                                    space
                                                                    perfect and spotless! I also do organizing, laundry,
                                                                    ironing, and packing!!!
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Tasker Selection [End] -->
                                            </form>
                                        </div>
                                        <!-- end job detail tab pane -->
                                        <div class="tab-pane" id="educationDetail">
                                            <form id="educationForm" method="post" action="#">
                                                <div class="text-center">
                                                    <h3 class="mb-2">Tell us about your education</h3>
                                                    <small class="text-muted">Let us know your name and email address. Use
                                                        an
                                                        address you don't mind other users contacting you at</small>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="schoolName">School Name</label>
                                                            <input type="text" class="form-control" id="schoolName"
                                                                placeholder="enter your school name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="schoolLocation">School
                                                                Location</label>
                                                            <input type="text" class="form-control"
                                                                id="schoolLocation"
                                                                placeholder="enter your school location" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end education detail tab pane -->
                                        <div class="tab-pane" id="finish">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="text-center">
                                                        <i class="ph-duotone ph-gift f-50 text-danger"></i>
                                                        <h3 class="mt-4 mb-3">Thank you !</h3>
                                                        <div class="mb-3">
                                                            <div class="form-check d-inline-block">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheck1" />
                                                                <label class="form-check-label" for="customCheck1">I agree
                                                                    with
                                                                    the Terms and Conditions</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end col -->
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <!-- END: Define your tab pans here -->
                                        <!-- START: Define your controller buttons here-->
                                        <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                                            <div class="first">
                                                <a href="javascript:void(0);" class="btn btn-secondary"> First </a>
                                            </div>
                                            <div class="d-flex">
                                                <div class="previous me-2">
                                                    <a href="javascript:void(0);" class="btn btn-secondary"> Back To
                                                        Previous </a>
                                                </div>
                                                <div class="next">
                                                    <a href="javascript:void(0);" class="btn btn-secondary"> Next Step
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="last">
                                                <a href="javascript:void(0);" class="btn btn-secondary"> Finish </a>
                                            </div>
                                        </div>
                                        <!-- END: Define your controller buttons here-->
                                    </div>
                                </div>
                            </div>
                            <!-- end tab content-->
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
        </div>
    </div>



    <!-- [ Main Content ] end -->
@endsection








<!-- [ footer apps ] start -->
@section('footer')
    @include('client.layouts.footer')
@endsection
<!-- [ footer apps ] End -->
