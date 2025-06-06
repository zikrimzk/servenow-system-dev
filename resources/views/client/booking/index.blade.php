<?php
use Illuminate\Support\Str;
use App\Models\Tasker;
?>
@extends('client.layouts.main')

<style>
    .no-taskers {
        font-size: 18px;
        color: #909090;
        font-weight: bold;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .info {
        margin-top: 20px;
    }

    .info p {
        margin: 5px 0;
        font-size: 14px;
    }

    .info .btn {
        margin-top: 10px;
    }

    #loadingText {
        font-size: 20px;
        font-family: Arial, sans-serif;
        white-space: nowrap;
        overflow: hidden;
        /* Simulates a cursor */
        animation: blink 0.7s step-end infinite;
    }

    @keyframes blink {
        from {
            border-color: black;
        }

        to {
            border-color: transparent;
        }
    }

    .nav-link.disabled {
        pointer-events: none;
        /* Matikan klik */

        /* Contoh efek kabur sikit - optional */
        cursor: not-allowed;
        /* Tukar cursor - optional */
    }

    .avatar-s {
        width: 70px;
        height: 70px;
        overflow: hidden;
        border-radius: 50%;
    }

    .avatar-s img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .scrollable-reviews {
        height: 300px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
    }


    .user-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        /* Menjadikan gambar bulat */
        border: 2px solid #ccc;
        /* Bingkai (pilihan) */
    }

    /* Container untuk gambar */
    .image-container {
        width: 150px;
        height: 150px;
        overflow: hidden;
    }
</style>





@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container mb-5">
        <div class="pc-content">
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-8 col-md-12">
                    <div id="basicwizard" class="form-wizard row justify-content-center mx-3 my-1">
                        <div class="col-sm-8 col-md-12">

                            <!-- Start Alert -->
                            <div>
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-check-circle"></i>
                                                Success
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <p class="mb-0">{{ session('success') }}</p>
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-info-circle"></i>
                                                Error
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <p class="mb-0">{{ session('error') }}</p>
                                    </div>
                                @endif
                            </div>
                            <!-- End Alert -->

                            <h1 class="mb-4 mt-4 mt-md-2">{{ $sv->servicetype_name }}</h1>
                        </div>

                        <div class="col-sm-8 col-md-12">
                            <div class="card shadow">
                                <div class="card-body p-3">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item" data-target-form="#contactDetailForm">
                                            <a href="#contactDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link active ">
                                                <i class="fas fa-location-arrow"></i>
                                                <span class="d-none d-sm-inline">Location</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#optionDetailForm">
                                            <a href="#jobOption" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn disabled">
                                                <i class="fas fa-cog"></i>
                                                <span class="d-none d-sm-inline">Option</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" data-target-form="#jobDetailForm">
                                            <a href="#jobDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn disabled">
                                                <i class="fas fa-user-tag"></i>
                                                <span class="d-none d-sm-inline">Tasker Selection</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#educationDetailForm">
                                            <a href="#educationDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn disabled">
                                                <i class="fas fa-money-check-alt"></i>
                                                <span class="d-none d-sm-inline">Payment</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->

                                    </ul>
                                </div>
                            </div>
                            <form action="{{ route('clientBookService') }}" method="POST" id="bookingForm">
                                @csrf
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <!-- START: Define your progress bar here -->
                                            <div id="bar" class="progress mb-3" style="height: 7px">
                                                <div
                                                    class="bar progress-bar progress-bar-striped progress-bar-animated bg-primary">
                                                </div>
                                            </div>
                                            <!-- END: Define your progress bar here -->

                                            <!-- LOCATION TAB [START] -->
                                            <div class="tab-pane show active" id="contactDetail">
                                                <div class="text-center mb-4 mt-4">
                                                    <h2 class="mb-1">Your Location</h2>
                                                </div>
                                                <div class="row mt-4">
                                                    <p class="text-muted fst-italic mb-3">Choose your options</p>
                                                    @if (Auth::user()->client_address_one == '' ||
                                                            Auth::user()->client_address_two == '' ||
                                                            Auth::user()->client_postcode == '')
                                                        <div class="col-xl-12">
                                                            <div class="mb-4">
                                                                <p class="mb-2">It seems you don't have any address
                                                                    details. Click the button below to add your address
                                                                    details or choose different address to continue.</p>
                                                                <a href="{{ route('client-profile') }}"
                                                                    class="btn btn-light btn-sm">Add Address Details</a>
                                                            </div>

                                                        </div>
                                                    @else
                                                        <div class="col-xl-12">
                                                            <div class="address-check border card rounded p-3">
                                                                <div class="form-check">
                                                                    <input type="radio"
                                                                        class="form-check-input input-primary"
                                                                        id="useProfileAddress" name="addressOption"
                                                                        checked="" />
                                                                    <label class="form-check-label d-block"
                                                                        for="useProfileAddress">
                                                                        <span class="h6 mb-3 d-block">
                                                                            {{ Auth::user()->client_firstname . ' ' . Auth::user()->client_lastname }}
                                                                            <small class="text-muted">(Default)</small>
                                                                        </span>
                                                                        <p class="mb-0">
                                                                            {{ Str::headline(Auth::user()->client_address_one . ', ' . Auth::user()->client_address_two . ', ' . Auth::user()->client_area . ', ' . Auth::user()->client_postcode . ' ' . Auth::user()->client_state) }}
                                                                        </p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-xl-12">
                                                        <div class="address-check border card rounded p-3">
                                                            <div class="form-check">
                                                                <input type="radio"
                                                                    class="form-check-input input-primary"
                                                                    id="useDifferentAddress" name="addressOption" />
                                                                <label class="form-check-label d-block"
                                                                    for="useDifferentAddress">
                                                                    <span class="h6 mb-3 d-block">
                                                                        Different Address
                                                                        <small class="text-muted">(Optional)</small>
                                                                    </span>
                                                                    <p class="mb-0 text-muted">
                                                                        You have to enter your address
                                                                    </p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="differentAddressContent" style="display: none;">
                                                    <p>Please enter your new address below:</p>
                                                    <div class="row mt-4">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <!-- Address Fields -->
                                                                <div class="col-sm-12 mb-3">
                                                                    <label class="form-label">Address</label>
                                                                    <input type="text" class="form-control"
                                                                        id="address" placeholder="Enter Address">
                                                                </div>
                                                                <!-- State Field -->
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">State</label>
                                                                        <select name="client_state" class="form-control"
                                                                            id="addState">
                                                                            <option value="" selected>Select State
                                                                            </option>
                                                                            @foreach ($states['states'] as $state)
                                                                                <option
                                                                                    value="{{ strtolower($state['name']) }}">
                                                                                    {{ $state['name'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Area Field -->
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Area</label>
                                                                        <select name="client_area" class="form-control"
                                                                            id="addCity">
                                                                            <option value="" selected>Select Area
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- LOCATION TAB [END] -->


                                            <!-- OPTION SETTING TAB [START] -->
                                            <div class="tab-pane" id="jobOption">
                                                <div class="text-center mb-4 mt-4">
                                                    <h2 class="mb-1">Service Options</h2>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <div class="alert alert-primary mt-3 mb-4">
                                                            <div class="d-flex">
                                                                <i class="ti ti-edit h2 f-w-400 mb-0 text-primary"></i>
                                                                <div class="flex-grow-1 ms-3">
                                                                    Describe your task in detail to help us match you with
                                                                    the best service providers in
                                                                    your area. Be as specific as possible about what you
                                                                    need, including any special
                                                                    requirements or preferences.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 ">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-3">
                                                                <label class="mb-2"> Service
                                                                    Options</label>
                                                                <select id="task-option" class="form-control"
                                                                    onchange="updateHours()">
                                                                    <option value="" selected>Select
                                                                        Options</option>
                                                                    <option value="s">Small</option>
                                                                    <option value="m">Medium</option>
                                                                    <option value="l">Large</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-12 mb-3">
                                                                <label class="mb-2 d-block">Est. hour(s)</label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="1" id="hour1"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour1">1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="2" id="hour2"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour2">2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="3" id="hour3"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour3">3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="4" id="hour4"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour4">4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="5" id="hour5"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour5">5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="hour" value="6" id="hour6"
                                                                        disabled />
                                                                    <label class="form-check-label"
                                                                        for="hour6">6</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12mb-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="schoolName">Tell us the details
                                                                of
                                                                your task</label>
                                                            <textarea name="booking_note" id="" cols="30" rows="5" class="form-control"
                                                                placeholder="Provide a summary of what you need done for your Tasker. Be sure to include details like the size of your space, any equipment/tools needed, and how to get in."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- OPTION SETTING TAB [END] -->


                                            <!-- TASKER SELECTION TAB [START] -->
                                            <div class="tab-pane" id="jobDetail">
                                                <div class="text-center mb-4 mt-4">
                                                    <h2 class="mb-1">Select Your Tasker</h2>
                                                </div>
                                                <!--Tasker Selection [Start]-->
                                                <div id="taskerList">
                                                    <!--Tasker List Ajax Generated -->
                                                </div>
                                                @foreach ($tasker as $tk)
                                                    <div id="selectdatetime-{{ $tk->taskerID }}" class="modal fade"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLiveLabel">
                                                                        Plan Your Task with
                                                                        {{ explode(' ', $tk->tasker_firstname)[0] }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 mb-3">
                                                                            <label for="task-date"
                                                                                class="mb-2">Availability</label>
                                                                            <input type="text"
                                                                                class="form-control task-date"
                                                                                placeholder="Choose Date">
                                                                        </div>
                                                                        <div class="col-sm-12 mb-3">
                                                                            <label for="task-time"
                                                                                class="mb-2">Time</label>
                                                                            <select class="form-control task-time">
                                                                                <!-- Options akan diisi melalui AJAX -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-grid mt-4 mb-2 ">
                                                                        <button type="button"
                                                                            class="btn btn-primary select-tasker disabled"id="nextStepButton"
                                                                            onclick="navigateTabs('next')"
                                                                            data-bs-dismiss="modal">
                                                                            Select &
                                                                            Continue</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="taskerReviewModal-{{ $tk->taskerID }}"
                                                        tabindex="-1" aria-labelledby="taskerProfileModal"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <!-- Gantikan teks di sini jika mahu -->
                                                                    <h5 class="modal-title" id="jobModalLabel">Profile &
                                                                        Review</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="modal-body">
                                                                    <!-- Bahagian asal card-header -->
                                                                    <div class="d-flex align-items-start mb-3">
                                                                        <div class="flex-shrink-0">
                                                                            <div class="avatar avatar-s">
                                                                                <img src="{{ $tk->tasker_photo ? asset('storage/' . $tk->tasker_photo) : asset('images/default-profile.png') }}"
                                                                                    alt="{{ $tk->tasker_firstname }}"
                                                                                    class="rounded-circle">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 mx-3">
                                                                            <p class="mb-1">
                                                                                {{ Str::headline($tk->tasker_firstname . ' ' . $tk->tasker_lastname) }}
                                                                            </p>
                                                                            @php

                                                                                $taskerReviews = $review->where(
                                                                                    'taskerID',
                                                                                    $tk->taskerID,
                                                                                );

                                                                                $totalRating = $taskerReviews->avg(
                                                                                    'review_rating',
                                                                                );

                                                                                $totalReviews = $taskerReviews->count();
                                                                            @endphp

                                                                            <h6 class="mb-0">
                                                                                <i class="fas fa-star"
                                                                                    style="margin-right: 5px;"></i>
                                                                                {{ number_format($totalRating, 1) }}
                                                                                <span
                                                                                    style="font-size: 0.9em; color: gray;">({{ $totalReviews }}
                                                                                    review)</span>
                                                                            </h6>

                                                                            <p class="mt-3 text-muted">
                                                                                {{ $tk->tasker_bio ? $tk->tasker_bio : 'No bio available.' }}
                                                                            </p>

                                                                        </div>

                                                                    </div>
                                                                    <hr>

                                                                    <!-- Bahagian asal card-body -->
                                                                    <div class="scrollable-reviews"
                                                                        style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                                                                        @foreach ($review->where('taskerID', $tk->taskerID) as $r)
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-center">
                                                                                        @if ($r->review_type == 1)
                                                                                            <h6>{{ Str::headline($r->client_firstname . ' ' . $r->client_lastname) }}
                                                                                            </h6>
                                                                                        @else
                                                                                            <h6>Anonymous</h6>
                                                                                        @endif
                                                                                        <div class="text-end">
                                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                                @if ($r->review_rating >= $i)
                                                                                                    <i
                                                                                                        class="fas fa-star text-warning f-16"></i>
                                                                                                @elseif($r->review_rating >= $i - 0.5)
                                                                                                    <i
                                                                                                        class="fas fa-star-half-alt text-warning f-16"></i>
                                                                                                @else
                                                                                                    <i
                                                                                                        class="far fa-star text-warning f-16"></i>
                                                                                                @endif
                                                                                            @endfor
                                                                                        </div>
                                                                                    </div>
                                                                                    <p>
                                                                                        {{ $r->review_description }}
                                                                                    </p>

                                                                                    <div class="d-flex pt-2">
                                                                                        @php
                                                                                            $images = [
                                                                                                $r->review_imageOne,
                                                                                                $r->review_imageTwo,
                                                                                                $r->review_imageThree,
                                                                                                $r->review_imageFour,
                                                                                            ];
                                                                                            $hasImage = array_filter(
                                                                                                $images,
                                                                                            ); // Check if at least one image exists
                                                                                        @endphp

                                                                                        @if ($hasImage)
                                                                                            @if ($r->review_imageOne)
                                                                                                <div class="me-2"
                                                                                                    style="width: 70px; height: 70px; border: 1px solid #ccc; border-radius: 0; overflow: hidden;">
                                                                                                    <a
                                                                                                        data-lightbox="{{ asset('storage/' . $r->review_imageOne) }}">
                                                                                                        <img src="{{ asset('storage/' . $r->review_imageOne) }}"
                                                                                                            alt="Image1"
                                                                                                            class="img-fluid"
                                                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                    </a>
                                                                                                </div>
                                                                                            @endif
                                                                                            @if ($r->review_imageTwo)
                                                                                                <div class="me-2"
                                                                                                    style="width: 70px; height: 70px; border: 1px solid #ccc; border-radius: 0; overflow: hidden;">
                                                                                                    <a
                                                                                                        data-lightbox="{{ asset('storage/' . $r->review_imageTwo) }}">
                                                                                                        <img src="{{ asset('storage/' . $r->review_imageTwo) }}"
                                                                                                            alt="Image2"
                                                                                                            class="img-fluid"
                                                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                    </a>
                                                                                                </div>
                                                                                            @endif
                                                                                            @if ($r->review_imageThree)
                                                                                                <div class="me-2"
                                                                                                    style="width: 70px; height: 70px; border: 1px solid #ccc; border-radius: 0; overflow: hidden;">
                                                                                                    <a
                                                                                                        data-lightbox="{{ asset('storage/' . $r->review_imageThree) }}">
                                                                                                        <img src="{{ asset('storage/' . $r->review_imageThree) }}"
                                                                                                            alt="Image3"
                                                                                                            class="img-fluid"
                                                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                    </a>
                                                                                                </div>
                                                                                            @endif
                                                                                            @if ($r->review_imageFour)
                                                                                                <div class="me-2"
                                                                                                    style="width: 70px; height: 70px; border: 1px solid #ccc; border-radius: 0; overflow: hidden;">
                                                                                                    <a
                                                                                                        data-lightbox="{{ asset('storage/' . $r->review_imageFour) }}">
                                                                                                        <img src="{{ asset('storage/' . $r->review_imageFour) }}"
                                                                                                            alt="Image4"
                                                                                                            class="img-fluid"
                                                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                    </a>
                                                                                                </div>
                                                                                            @endif
                                                                                        @else
                                                                                            <span
                                                                                                style="font-size: 12px; color: gray;">No
                                                                                                image uploaded</span>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-between mt-4">
                                                                                        <ul class="list-inline mb-0 me-2">
                                                                                            <li class="list-inline-item">
                                                                                                <i
                                                                                                    class="text-muted ti ti-map-pin"></i>
                                                                                                {{ $r->client_area }},
                                                                                                {{ $r->client_state }}
                                                                                            </li>
                                                                                            <li class="list-inline-item">
                                                                                                <i
                                                                                                    class="text-muted ti ti-clock"></i>
                                                                                                {{ \Carbon\Carbon::parse($r->review_date_time)->diffForHumans() }}
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <!-- Butang tutup -->
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="modal fade modal-lightbox" id="lightboxModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                            <div class="modal-body">
                                                                <img src="../assets/images/light-box/l1.jpg"
                                                                    alt="images" class="modal-image img-fluid" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tasker Selection [End] -->
                                            </div>
                                            <!-- TASKER SELECTION TAB [END] -->

                                            <!-- PAYMENT TAB [START] -->
                                            <div class="tab-pane" id="educationDetail">
                                                <div class="text-center mb-4 mt-4">
                                                    <h2 class="mb-1">Payment</h2>
                                                </div>
                                                <div class="container mt-4 pt-4">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="card rounded p-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between mb-2">
                                                                    <h6 class="mb-0">Client Details</h6>
                                                                </div>
                                                                <h5>{{ Auth::user()->client_firstname . ' ' . Auth::user()->client_lastname }}
                                                                </h5>
                                                                <p class="mb-0 address-details"></p>
                                                                <p class="mb-0">+60
                                                                    {{ Auth::user()->client_phoneno }}</p>
                                                                <p class="mb-0">{{ Auth::user()->email }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Payment Option -->
                                                            <div class="col-md-6 col-xxl-4">
                                                                <div class="address-check border rounded my-3">
                                                                    <div class="form-check">
                                                                        <input type="radio" name="payoptradio1"
                                                                            class="form-check-input input-primary"
                                                                            id="payopn-check-1" checked />
                                                                        <label class="form-check-label d-block"
                                                                            for="payopn-check-1">
                                                                            <span class="card-body p-3 d-block">
                                                                                <span class="h5 mb-3 d-block">Online
                                                                                    Banking</span>
                                                                                <span class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="f-12 badge bg-success me-3">Great
                                                                                        Deals</span>
                                                                                    <img src="../assets/images/toyippay-logo.svg"
                                                                                        alt="img"
                                                                                        class="img-fluid ms-1"
                                                                                        width="0px" />
                                                                                </span>
                                                                            </span>

                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-xxl-4">
                                                                <div class="address-check border rounded  my-3">
                                                                    <div class="form-check">
                                                                        <input type="radio" name="payoptradio1"
                                                                            class="form-check-input input-primary"
                                                                            id="payopn-check-2" disabled />
                                                                        <label class="form-check-label d-block"
                                                                            for="payopn-check-2">
                                                                            <span class="card-body p-3 d-block">
                                                                                <span class="h5 mb-3 d-block">Credit
                                                                                    Card</span>
                                                                                <span class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="f-12 badge bg-danger me-3">Unavailable</span>
                                                                                    <img src="../assets/images/application/card.png"
                                                                                        alt="img"
                                                                                        class="img-fluid ms-1" />
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- Payment Section -->
                                                        <div class="col-lg-8 col-md-12">
                                                            <!-- Tambahkan semua elemen form pembayaran di sini -->
                                                            <div class="card p-4">
                                                                <div id="credit-card-form" class="mt-4">
                                                                    <h5>Pay with Online Banking</h5>
                                                                    <p class="text-muted mb-3">Please click button below to
                                                                        continue your payment</p>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="paymentButton" onclick="disableButton()">
                                                                        Proceed to Payment
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="paypal-message" class="mt-4"
                                                                style="display: none;">
                                                                <h5>Pay with PayPal</h5>
                                                                <p>You will be redirected to PayPal to complete your
                                                                    payment.
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Order Summary Section -->
                                                        <div class="col-lg-4 col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5>Booking Summary</h5>
                                                                </div>
                                                                <div class="card-body p-0">
                                                                    <ul class="list-group list-group-flush"
                                                                        id="tasker-details">
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="checkout-details">
                                                                <input type="hidden" name="booking_date"
                                                                    class="bookingDate">
                                                                <input type="hidden" name="booking_address"
                                                                    class="booking_address">
                                                                <input type="hidden" name="booking_latitude"
                                                                    class="booking_latitude">
                                                                <input type="hidden" name="booking_longitude"
                                                                    class="booking_longitude">
                                                                <input type="hidden" name="booking_time_start"
                                                                    class="inputTimeStart">
                                                                <input type="hidden" name="booking_time_end"
                                                                    class="inputTimeEnd">
                                                                <input type="hidden" name="booking_rate"
                                                                    class="bookingRate">
                                                                <input type="hidden" name="service_id"
                                                                    class="serviceID">
                                                                <input type="hidden" name="tasker_id" class="taskerID">

                                                            </div>
                                                            <div class="d-grid mt-4 mb-4">
                                                                {{-- <button type="submit" class="btn btn-primary">Proceed to
                                                                    Payment</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- PAYMENT TAB [END] -->

                                            <!-- START: Define your controller buttons here-->
                                            <div class="d-flex justify-content-between mt-3">
                                                <button type="button" class="btn btn-secondary" id="prevButton"
                                                    onclick="navigateTabs('prev')">Back to Previous</button>
                                                <button type="button" class="btn btn-primary" id="nextButton"
                                                    onclick="navigateTabs('next')">Next Step</button>
                                            </div>
                                            <!-- END: Define your controller buttons here-->
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content-->
                            </form>


                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lightboxModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
            var elements = document.querySelectorAll('[data-lightbox]');

            elements.forEach(function(element) {
                element.addEventListener('click', function(event) {
                    // Prevent default action if the element is a link
                    event.preventDefault();

                    var imagesPath = event.target; // Get the clicked element
                    if (imagesPath.tagName === 'IMG') {
                        imagesPath = imagesPath
                            .parentNode; // Get the parent anchor if an image is clicked
                    }

                    var recipient = imagesPath.getAttribute(
                        'data-lightbox'); // Retrieve the data-lightbox value
                    if (recipient) {
                        var image = document.querySelector(
                            '.modal-image'); // Find the modal image element
                        image.setAttribute('src', recipient); // Set the new image source
                        lightboxModal.show(); // Show the modal
                    }
                });
            });

            function removeClassByPrefix(node, prefix) {
                for (let i = 0; i < node.classList.length; i++) {
                    let value = node.classList[i];
                    if (value.startsWith(prefix)) {
                        node.classList.remove(value);
                    }
                }
            }
        });
    </script>

    <script>
        const paymentButton = document.getElementById('paymentButton');


        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.href = "{{ route('clientBookHistory') }}";
            }
        });

        document.getElementById('bookingForm').addEventListener('submit', function(event) {

            paymentButton.disabled = true;
            paymentButton.textContent = "Processing...";
        });
    </script>




    <script>
        /******************** *************************** ****************/
        /******************** TABPANE: TAB NAVIGATION ********************/
        /******************** *************************** ****************/
        const navPills = document.querySelectorAll('.nav-pills .nav-link');

        navPills.forEach(navPill => {
            navPill.addEventListener('click', function() {

                if (this.href.includes('#contactDetail')) {
                    updateButtons();


                    navPills.forEach(tab => {
                        tab.classList.add('disabled');


                        tab.addEventListener('click', function(e) {
                            e.preventDefault();
                        });
                    });
                } else if (this.href.includes('#jobOption')) {
                    updateButtons();
                } else if (this.href.includes('#jobDetail')) {
                    updateButtons();
                } else if (this.href.includes('#educationDetail')) {
                    updateButtons();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const useDefaultAddress = document.getElementById('useProfileAddress');
            const useDifferentAddress = document.getElementById('useDifferentAddress');
            const addressFields = ['address', 'addState', 'addCity'];
            const differentAddressContent = document.getElementById('differentAddressContent');


            updateNextButtonState();



            useDefaultAddress.addEventListener('change', function() {
                updateNextButtonState();
            });

            useDifferentAddress.addEventListener('change', function() {
                differentAddressContent.style.display = 'block';
                updateNextButtonState();
            });

            addressFields.forEach((fieldId) => {
                document.getElementById(fieldId).addEventListener('input', function() {
                    updateNextButtonState();
                });
            });

            function updateNextButtonState() {
                if (useDefaultAddress.checked) {
                    nextButton.disabled = false;
                } else if (useDifferentAddress.checked) {
                    nextButton.disabled = !validateDifferentAddressFields();
                } else {
                    nextButton.disabled = true;
                }
            }

            function validateDifferentAddressFields() {
                return addressFields.every((fieldId) => {
                    const field = document.getElementById(fieldId);
                    return field.value.trim() !== '';
                });
            }

        });



        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const reverseTabButton = document.querySelector('.ti-edit');

            reverseTabButton.addEventListener('click', function() {
                const activeTab = document.querySelector('.nav-pills .nav-link.active');
                const currentIndex = Array.from(tabs).indexOf(activeTab);

                if (currentIndex > 0) {

                    activeTab.classList.remove('active');
                    activeTab.setAttribute('aria-selected', 'false');


                    const previousTab = tabs[currentIndex - 1];
                    previousTab.classList.add('active');
                    previousTab.setAttribute('aria-selected', 'true');


                    const tabContents = document.querySelectorAll('.tab-pane');
                    tabContents[currentIndex].classList.remove('active', 'show');
                    tabContents[currentIndex - 1].classList.add('active', 'show');
                }

                updateButtons();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const creditCardForm = document.getElementById('credit-card-form');
            const paypalMessage = document.getElementById('paypal-message');
            const creditCardRadio = document.getElementById('payopn-check-1');
            const paypalRadio = document.getElementById('payopn-check-2');

            // Show/Hide forms based on selection
            creditCardRadio.addEventListener('change', function() {
                if (creditCardRadio.checked) {
                    creditCardForm.style.display = 'block';
                    paypalMessage.style.display = 'none';
                }
            });

            paypalRadio.addEventListener('change', function() {
                if (paypalRadio.checked) {
                    creditCardForm.style.display = 'none';
                    paypalMessage.style.display = 'block';
                }
            });
        });

        function updateProgressBar(step, totalSteps) {
            const progressBar = document.querySelector('.bar');
            const progress = (step / totalSteps) * 100; // Kira peratus kemajuan
            progressBar.style.width = progress + '%'; // Set lebar progress bar
        }

        function navigateTabs(direction) {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const activeTab = document.querySelector('.nav-pills .nav-link.active');
            let currentIndex = Array.from(tabs).indexOf(activeTab);


            let newIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;


            if (newIndex < 0 || newIndex >= tabs.length) return;

            if (direction === 'next') {
                // Unlock the next tab
                tabs[newIndex].classList.remove('disabled');
                tabs[newIndex].setAttribute('data-bs-toggle', 'tab'); // Allow tab switching

                if (newIndex === 1) {
                    findNearbyTaskers();
                }

                // updateBookingAddress();
            }

            // Navigate to new tab
            tabs[newIndex].click();
            updateProgressBar(newIndex + 1, tabs.length);
            updateButtons();
        }

        function updateButtons() {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const activeTab = document.querySelector('.nav-pills .nav-link.active');
            const currentIndex = Array.from(tabs).indexOf(activeTab);
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const nextStepButton = document.getElementById('nextStepButton');
            prevButton.disabled = currentIndex === 0;
            const hourRadios = document.querySelectorAll('input[name="hour"]');
            const isHourSelected = Array.from(hourRadios).some(radio => radio.checked);

            tabs.forEach(tab => {
                tab.classList.remove('disabled');
                tab.style.pointerEvents = '';
                tab.style.opacity = '';
            });

            if (currentIndex === 1) {

                nextButton.style.display = 'none';
                nextButton.disabled = true;
                nextStepButton.style.display = 'none';

                if (isHourSelected) {
                    nextButton.style.display = '';
                    nextButton.disabled = false;
                }
            } else if (currentIndex === 2) {

                nextButton.disabled = !isHourSelected;
                nextButton.style.display = 'none';
                nextStepButton.style.display = '';
            } else {

                nextButton.disabled = false;
                if (currentIndex === 3) {

                    nextButton.style.display = 'none';
                    nextStepButton.style.display = 'none';
                } else {
                    nextButton.style.display = '';
                    nextStepButton.style.display = 'none';
                }
            }


            updateProgressBar(currentIndex + 1, tabs.length);
        }


        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            tabs.forEach((tab, index) => {
                if (index !== 0) {
                    tab.classList.add('disabled');
                    tab.removeAttribute('data-bs-toggle');
                }
            });

            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    if (tab.classList.contains('disabled')) {
                        e.preventDefault();
                    }
                });
            });
        });




        /******************** *************************** ***********/
        /******************** AJAX: FETCH TASKER ********************/
        /******************** *************************** ***********/

        let useProfileAddress = true;
        const differentContent = document.getElementById('differentAddressContent');
        $('#useProfileAddress').on('change', function() {
            if (this.checked) {
                useProfileAddress = true;
                differentContent.style.display = 'none';
            } else {
                useProfileAddress = false;
                differentContent.style.display = 'none';
            }
        });

        $('#useDifferentAddress').on('change', function() {
            if (this.checked) {
                useProfileAddress = false;
                differentContent.style.display = 'block';
            } else {
                useProfileAddress = false;
                differentContent.style.display = 'none';
            }
        });

        $('#addState').on('change', function() {
            var state = $(this).val();
            if (state) {
                $.ajax({
                    url: '/get-areas/' + state, // Ensure this matches the route
                    type: 'GET',
                    success: function(data) {
                        $('#addCity').empty().append(
                            '<option value="">Select Area</option>');
                        $.each(data, function(index, area) {
                            $('#addCity').append('<option value="' + area + '">' +
                                area + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching areas: " +
                            error); // For debugging if request fails
                    }
                });
            } else {
                $('#addCity').empty().append('<option value="">Select Area</option>');
            }
        });

        function findNearbyTaskers() {
            var area = document.getElementById('addCity').value;
            var state = document.getElementById('addState').value;
            var address = document.getElementById('address').value;
            var fullAddress = `${address}, ${area}, ${state}`.replace(/(, )+/g, ', ').replace(/, $/, '');
            $.ajax({
                url: '{{ route('booking-generate-coordinates') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    address: fullAddress,
                    useProfileAddress: useProfileAddress,
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let {
                            latitude,
                            longitude,
                            address
                        } = response;
                        console.log(latitude, longitude);
                        fetchTaskers(latitude, longitude);
                        $('.booking_latitude').val(latitude);
                        $('.booking_longitude').val(longitude);
                        $('.booking_address').val(address.replace(/(, )+/g, ', ').replace(/, $/, ''));

                    } else {
                        alert(response.status);
                    }
                },
                error: function(err) {
                    console.error(err);
                },
            });
        }

        function fetchTaskers(latitude, longitude) {
            $.ajax({
                url: '{{ route('booking-fetch-tasker', $sv->id) }}',
                method: 'GET',
                data: {
                    latitude: latitude,
                    longitude: longitude,
                },
                success: function(response) {
                    if (response.status === 'success') {

                        displayTaskers(response.taskers);

                    } else {
                        alert(response.message);
                    }
                },
                error: function(err) {
                    console.error(err);
                },
            });
        }

        function displayTaskers(taskers) {
            let taskerContainer = document.getElementById('taskerList'); // Assume this container exists
            taskerContainer.innerHTML = '';

            if (taskers.length > 0) {
                let taskerArray = Object.values(taskers);
                taskerArray.forEach(tasker => {
                    let badgeText = '';
                    let badgeClass = '';
                    // Logik menentukan teks dan warna berdasarkan overall_book
                    if (tasker.overall_book >= 0 && tasker.overall_book <= 20) {
                        badgeText = 'Elite Tasker';
                        badgeClass = 'badge bg-primary text-white'; // Biru
                    } else if (tasker.overall_book > 20 && tasker.overall_book <= 80) {
                        badgeText = 'Master Tasker';
                        badgeClass = 'badge bg-success text-white'; // Hijau
                    } else if (tasker.overall_book > 80 && tasker.overall_book <= 120) {
                        badgeText = 'Grand Master Tasker';
                        badgeClass = 'badge bg-warning text-white'; // Kuning
                    } else if (tasker.overall_book > 120 && tasker.overall_book <= 160) {
                        badgeText = 'Epic Tasker';
                        badgeClass = 'badge bg-danger text-white'; // Merah
                    } else if (tasker.overall_book > 160 && tasker.overall_book <= 200) {
                        badgeText = 'Legend';
                        badgeClass = 'badge bg-dark text-white'; // Hitam
                    } else if (tasker.overall_book > 200) {
                        badgeText = 'Mythic Tasker';
                        badgeClass = 'badge bg-secondary text-white'; // Kelabu
                    }
                    taskerContainer.innerHTML += `
                        <div class="card m-2 border border-0 mb-5">
                            <!--Image Tasker Section [Start]-->
                            <div class="row mt-4">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="image-container">
                                            <img src="{{ asset('storage') }}/${tasker.tasker_photo}"
                                                alt="Profile Photo" 
                                                class="user-avatar rounded-circle">
                                        </div>
                                        
                                    </div>
                                    <h4 class="mb-3 mt-2 d-lg-none text-center">
                                            RM ${tasker.service_rate}/${tasker.service_rate_type}
                                        </h4>
                                </div>

                                <div class="col-sm-9 col-md-9 col-lg-9">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-2 f-24">
                                                ${tasker.tasker_firstname.split(' ')[0]}.
                                            </h6>
                                            <h5 class="mb-2 d-none d-lg-block">
                                                RM ${tasker.service_rate}/${tasker.service_rate_type}
                                            </h5>
                                        </div>

                                        <div class="d-flex align-items-center mb-2">
                                            <span class="${badgeClass} me-2">${badgeText}</span>
                                        </div>
                                        <div>
                                            <p class="mb-1">
                                                <span class="fw-bold"> ★ ${tasker.rating_count.toFixed(1)} </span> (${tasker.review_count} reviews)
                                            </p>                                       
                                            <p class="mb-1">${tasker.task_count} ${tasker.servicetype_name} tasks</p>
                                            <p class="mb-1"> 
                                                <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                                ${tasker.road_distance.toFixed(2)} KM away
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row flex-sm-row  flex-column-reverse">
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="d-flex justify-content-center mt-2 mb-2">
                                    <a href="#" 
                                        class="btn btn-link text-decoration-none primary p-1 view-profile-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#taskerReviewModal-${tasker.taskerID}">
                                        View Profile & Review
                                    </a>
                                </div>
                                    <div class="d-grid d-md-flex justify-content-md-center align-items-md-center ">
                                        <button type="button"
                                            class="btn btn-primary select-continue-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#selectdatetime-${tasker.taskerID}"
                                            data-tasker-id="${tasker.taskerID}"
                                            data-service-id="${tasker.svID}">
                                            Select & Continue
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-9 col-lg-9">
                                    <div class=" bg-light p-3">
                                        <h4> How I can help:</h4>
                                            <p class="text-muted fw-normal f-16">
                                                ${tasker.service_desc}
                                            </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                let noTaskersMessage = document.createElement('div');
                noTaskersMessage.classList.add('no-taskers');
                noTaskersMessage.textContent = 'Oops, there are no taskers around you. Sorry !';
                taskerContainer.appendChild(noTaskersMessage);
            }

        }

        /******************** *************************** ***********************/
        /******************** MODAL: ASSIGN TASKER DYNAMICLY ********************/
        /******************** *************************** ***********************/

        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Use event delegation on the tasker container
            const taskerContainer = document.getElementById('taskerList');
            taskerContainer.addEventListener('click', function(event) {
                // Check if the clicked element has the 'select-continue-btn' class
                if (event.target.classList.contains('select-continue-btn')) {
                    const taskerId = event.target.getAttribute('data-tasker-id');
                    const svId = event.target.getAttribute('data-service-id');
                    $('.task-time').val('');
                    if (taskerId) {
                        const today = new Date();
                        const formattedToday = formatDateLocal(today); // Format as YYYY-MM-DD
                        localStorage.setItem('selectedTaskerId', taskerId);
                        localStorage.setItem('selectedServiceId', svId);
                        getTaskerTimeSlots(formattedToday);
                        checkoutTaskerDetails();
                        if ($('.task-time').val() == '') {
                            $('.select-tasker').addClass('disabled');
                        }
                    }
                }
            });
        });


        // function updateBookingAddress() {
        //     // Ambil nilai dari setiap medan
        //     const address1 = document.getElementById('address1').value.trim();
        //     const address2 = document.getElementById('address2').value.trim();
        //     const postcode = document.getElementById('postcode').value.trim();
        //     const state = document.getElementById('state').value.trim();
        //     const area = document.getElementById('addCity').value.trim();

        //     // Gabungkan nilai-nilai tersebut
        //     const fullAddress = `${address1}, ${address2}, ${postcode}, ${area}, ${state}`.replace(/(, )+/g, ', ').replace(
        //         /, $/, '');

        //     $('.booking_address').val(fullAddress.toUpperCase());
        // }

        // document.addEventListener('DOMContentLoaded', function() {
        //     const addressFields = ['address1', 'address2', 'postcode', 'state', 'addCity'];

        //     addressFields.forEach(fieldId => {
        //         const field = document.getElementById(fieldId);
        //         if (field) {
        //             field.addEventListener('input', updateBookingAddress); // Update address on input change
        //         }
        //     });
        // });

        // FLATPICKER : CALANDER
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const formattedToday = formatDateLocal(today); // Format as YYYY-MM-DD

            // Initialize Flatpickr
            $('.bookingDate').val(formattedToday);
            flatpickr(".task-date", {
                enableTime: false,
                minDate: "today",
                maxDate: new Date(new Date().setDate(today.getDate() + 7)),
                defaultDate: formattedToday,
                onChange: function(selectedDates, dateStr, instance) {
                    // Pass the selected date to the AJAX function
                    getTaskerTimeSlots(dateStr);
                    $('.bookingDate').val(dateStr);
                }
            });

            // Trigger initial fetch for today's date
            getTaskerTimeSlots(formattedToday);
        });


        /******************** *************************** ********************/
        /******************** SELECT HOURS DURATION START ********************/
        /******************** *************************** ********************/

        function updateHours() {
            const option = document.getElementById('task-option').value;
            const radios = [{
                    id: 'hour1',
                    range: ['s']
                },
                {
                    id: 'hour2',
                    range: ['s']
                },
                {
                    id: 'hour3',
                    range: ['m']
                },
                {
                    id: 'hour4',
                    range: ['m']
                },
                {
                    id: 'hour5',
                    range: ['l']
                },
                {
                    id: 'hour6',
                    range: ['l']
                }
            ];

            radios.forEach(radio => {
                const el = document.getElementById(radio.id);
                if (radio.range.includes(option)) {
                    el.disabled = false;
                } else {
                    el.disabled = true;
                    el.checked = false;
                    nextButton.disabled = true;
                }
            });
        }

        function saveToLocalStorage(event) {
            const selectedValue = event.target.value;
            localStorage.setItem('selectedHour', selectedValue);
            const nextbutton = document.getElementById('nextButton');
            nextButton.disabled = false;
            updateButtons();


        }

        document.querySelectorAll('input[name="hour"]').forEach(radio => {
            radio.addEventListener('change', saveToLocalStorage);
        });

        function loadFromLocalStorage() {
            const savedHour = localStorage.getItem('selectedHour');
            if (savedHour) {
                const savedRadio = document.querySelector(`input[name="hour"][value="${savedHour}"]`);
                if (savedRadio) {
                    savedRadio.checked = true;
                    // Enable the appropriate option
                    const optionMap = {
                        '1': 's',
                        '2': 's',
                        '3': 'm',
                        '4': 'm',
                        '5': 'l',
                        '6': 'l'
                    };
                    document.getElementById('task-option').value = optionMap[savedHour];
                    updateHours();
                }
            }
        }
        //window.onload = loadFromLocalStorage;


        /******************** *************************** ********************/
        /******************** AJAX: TASKER TIME SLOT START ********************/
        /******************** *************************** ********************/

        // function getTaskerTimeSlots(date) {
        //     const taskerid = localStorage.getItem('selectedTaskerId');
        //     const duration = parseInt(localStorage.getItem('selectedHour')); // Duration in hours

        //     if (!taskerid || !duration) {
        //         return;
        //     }

        //     const urlTemplate = "{{ route('client-tasker-get-time', [':date', ':taskerid']) }}";
        //     const url = urlTemplate
        //         .replace(':date', encodeURIComponent(date))
        //         .replace(':taskerid', encodeURIComponent(taskerid));

        //     jQuery.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function(result) {
        //             console.log("AJAX successke:", result); // Debug log
        //             const data = result.data; // Assuming the server returns an array of time slots

        //             // Reset dropdown
        //             const taskTimeSelect = jQuery('.task-time');
        //             taskTimeSelect.empty();

        //             if (data.length > 0) {
        //                 // Validate slots based on duration
        //                 const validSlots = validateTimeSlots(data, duration);

        //                 if (validSlots.length > 0) {
        //                     taskTimeSelect.append(`<option value="" selected>-Select Time-</option>`);
        //                     validSlots.forEach(function(time) {
        //                         console.log("KEPUTUSAN:", time); // Debug log

        //                         taskTimeSelect.append(`<option value="${time}">${time}</option>`);
        //                     });
        //                 } else {
        //                     taskTimeSelect.append(
        //                         '<option value="" selected>No valid times available</option>');
        //                 }
        //             } else {
        //                 taskTimeSelect.append('<option value="" selected>No times available</option>');
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('AJAX Error:', error);
        //             alert('Failed to fetch time slots. Please try again.');
        //         }
        //     });
        // }

        // function validateTimeSlots(slots, duration) {
        //     const validSlots = [];
        //     const timeFormat = "HH:mm:ss"; // Format your time as shown in your dropdown (e.g., "07:30:00")
        //     const timeSlots = slots.map(slot => moment(slot.time, timeFormat)); // Convert to Moment.js objects

        //     for (let i = 0; i < timeSlots.length; i++) {
        //         let isValid = true;

        //         // Check if consecutive slots exist for the required duration
        //         for (let j = 1; j < duration; j++) {
        //             const nextTime = timeSlots[i].clone().add(j, 'hours'); // Add 1 hour per step
        //             if (!timeSlots.some(slot => slot.isSame(nextTime))) {
        //                 isValid = false; // Invalidate if any required slot is missing
        //                 break;
        //             }
        //         }

        //         if (isValid) {
        //             validSlots.push(slots[i].time); // Add valid starting times as string
        //         }
        //     }

        //     return validSlots;
        // }
        function convertTo12HourFormat(time) {
            const [hours, minutes, seconds] = time.split(":");
            let hrs = parseInt(hours, 10);
            const period = hrs >= 12 ? "PM" : "AM";
            hrs = hrs % 12 || 12; // Convert 0 to 12 for midnight
            return `${hrs}:${minutes} ${period}`;
        }

        function getTaskerTimeSlots(date) {
            const taskerid = localStorage.getItem('selectedTaskerId');
            const duration = parseInt(localStorage.getItem('selectedHour')); // Duration in hours

            if (!taskerid || !duration) {
                return;
            }

            const urlTemplate = "{{ route('client-tasker-get-time', [':date', ':taskerid']) }}";
            const url = urlTemplate
                .replace(':date', encodeURIComponent(date))
                .replace(':taskerid', encodeURIComponent(taskerid));

            jQuery.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    console.log("AJAX success:", result); // Debug log
                    const data = result.data; // Assuming the server returns an array of time slots

                    // Reset dropdown
                    const taskTimeSelect = jQuery('.task-time');
                    taskTimeSelect.empty();

                    if (data.length > 0) {
                        // Validate slots based on duration and current time
                        const validSlots = validateTimeSlots(data, duration, date);

                        if (validSlots.length > 0) {
                            taskTimeSelect.append(`<option value="" selected>-Select Time-</option>`);
                            validSlots.forEach(function(time) {
                                console.log("Valid Time:", time); // Debug log
                                var ctime = convertTo12HourFormat(time);

                                taskTimeSelect.append(
                                    `<option value="${time}">${ctime}</option>`);
                            });
                        } else {
                            taskTimeSelect.append(
                                '<option value="" selected>No valid times available</option>'
                            );
                        }
                    } else {
                        taskTimeSelect.append('<option value="" selected>No times available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to fetch time slots. Please try again.');
                }
            });
        }

        function validateTimeSlots(slots, duration, selectedDate) {
            const validSlots = [];
            const timeFormat = "HH:mm:ss"; // Format your time as shown in your dropdown (e.g., "07:30:00")
            const timeSlots = slots.map(slot => moment(slot.time, timeFormat)); // Convert to Moment.js objects
            const now = moment(); // Current time
            const isToday = moment(selectedDate).isSame(now, 'day'); // Check if selected date is today

            for (let i = 0; i < timeSlots.length; i++) {
                let isValid = true;

                // Skip slots before the current time if today
                if (isToday && timeSlots[i].isBefore(now)) {
                    continue;
                }

                // Check if consecutive slots exist for the required duration
                for (let j = 1; j < duration; j++) {
                    const nextTime = timeSlots[i].clone().add(j, 'hours'); // Add 1 hour per step
                    if (!timeSlots.some(slot => slot.isSame(nextTime))) {
                        isValid = false; // Invalidate if any required slot is missing
                        break;
                    }
                }

                if (isValid) {
                    validSlots.push(slots[i].time); // Add valid starting times as string
                }
            }

            return validSlots;
        }

        $('.task-time').on('change', function() {
            if (this.value == '') {
                $('.select-tasker').addClass('disabled');
            } else {
                localStorage.setItem('selectedTime', this.value);
                $('.select-tasker').removeClass('disabled');
                checkoutTaskerDetails();
            }
        })

        /******************** *************************** ******************************/
        /******************** AJAX: FETCH TASKER DETAILS [CHECKOUT] ********************/
        /******************** *************************** ******************************/

        function convertTo24HourFormat(time) {
            const [hours, minutes] = time.match(/\d+/g);
            const isPM = time.includes('PM');
            let hours24 = parseInt(hours);

            if (isPM && hours24 < 12) {
                hours24 += 12; // Convert PM to 24-hour format
            } else if (!isPM && hours24 === 12) {
                hours24 = 0; // Convert 12 AM to 00
            }

            return `${hours24.toString().padStart(2, '0')}:${minutes.padStart(2, '0')}:00`;
        }

        function checkoutTaskerDetails() {
            const taskerId = localStorage.getItem('selectedTaskerId');
            const svId = localStorage.getItem('selectedServiceId');

            $.ajax({
                url: '{{ route('getTaskerDetail') }}',
                type: 'GET',
                data: {
                    id: taskerId,
                    svid: svId,
                },
                success: function(result) {
                    var data = result.taskerservice[0];

                    // TIME RANGE CALCULATION START
                    const durationHour = parseInt(localStorage.getItem('selectedHour'));
                    const time = localStorage.getItem('selectedTime');

                    console.log('Time Dalam Function checkoutTaskerDetails', time);

                    // Split the time string into hours and minutes
                    const [startHour, startMinute] = time.split(':').map(Number); // Convert "7:30" to [7, 30]

                    // Calculate the end time
                    const endHour = startHour + durationHour;
                    const endMinute = startMinute;

                    // Format the time range as 'hh:mm AM/PM - hh:mm AM/PM'
                    const formatTime = (hour, minute) => {
                        const period = hour >= 12 ? 'PM' : 'AM';
                        const formattedHour = hour > 12 ? hour - 12 : hour === 0 ? 12 :
                            hour;
                        const formattedMinute = minute.toString().padStart(2,
                            '0');
                        return `${formattedHour}:${formattedMinute} ${period}`;
                    };

                    const startTimeFormatted = formatTime(startHour, startMinute);
                    const endTimeFormatted = formatTime(endHour, endMinute);
                    // TIME RANGE CALCULATION END

                    // PRICE CALCULATIOM START

                    const svrate = data.service_rate;
                    let price = 0; // Use let since these values will change
                    let servicetax = 0;
                    let totalprice = 0;

                    if (data.service_rate_type === 'per job') {
                        price = svrate * 1; // Assuming a fixed rate for 'per job'
                        servicetax = price * (3 / 100); // 3% service tax
                        totalprice = price + servicetax;
                    } else if (data.service_rate_type === 'per hour') {
                        price = svrate * durationHour; // Multiply rate by hours
                        servicetax = price * (3 / 100); // 3% service tax
                        totalprice = price + servicetax;
                    }

                    // Format results for display with two decimal places
                    price = price.toFixed(2);
                    servicetax = servicetax.toFixed(2);
                    totalprice = totalprice.toFixed(2);

                    // PRICE CALCULATIOM END


                    //INITIALIZE IN INPUT FORM START
                    $('.inputTimeStart').val(convertTo24HourFormat(startTimeFormatted));
                    $('.inputTimeEnd').val(convertTo24HourFormat(endTimeFormatted));
                    $('.bookingRate').val(totalprice)
                    $('.serviceID').val(svId);
                    $('.taskerID').val(taskerId);
                    $('.address-details').html($('.booking_address').val());


                    var dateBooking = $('.bookingDate').val();
                    var date = new Date(dateBooking);

                    // Format to "DD MMMM YYYY" (22 December 2024)
                    var formattedDate = date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                    //INITIALIZE IN INPUT FORM END


                    const taskerDetailsHTML = `
                        <li class="list-group-item">                                        
                            <div class="d-flex align-items-start">
                                <img class="bg-light rounded user-avtar rounded-circle flex-shrink-0"
                                    src="{{ asset('storage') }}/${data.tasker_photo}" 
                                    alt="Tasker photo" width="60" height="60" />
                                <div class="flex-grow-1 mx-2">
                                    <h5 class="mb-1">${data.tasker_firstname.split(' ')[0]}.</h5>
                                    <h5 class="mb-1">
                                        <b>${data.servicetype_name}</b>
                                        <span class="mx-2 text-sm text-decoration-line-through text-muted f-w-400"></span>
                                    </h5>
                                    <p class="text-muted text-sm mb-1">${formattedDate}</p>
                                    <p class="text-muted text-sm mb-2">${startTimeFormatted} - ${endTimeFormatted}</p>

                                </div>
                                <a href="#" class="avtar avtar-s btn-link-primary btn-pc-default flex-shrink-0" id="prevButton" onclick="navigateTabs('prev')">
                                    <i class="ti ti-edit f-20"></i>
                                </a>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="float-end">
                                <h5 class="mb-0">RM ${ price} </h5>
                            </div>
                            <span class="text-muted">Sub Total</span>
                        </li>

                        <li class="list-group-item">
                            <div class="float-end">
                                <h5 class="mb-0">RM ${ servicetax }</h5>
                            </div>
                            <span class="text-muted">Service Charge (3%)</span>
                        </li>

                        <li class="list-group-item">
                            <div class="float-end">
                                <h5 class="mb-0">RM 0.00</h5>
                            </div>
                            <span class="text-muted">Discount</span>
                        </li>

                        <li class="list-group-item">
                            <div class="float-end">
                                <h5 class="mb-0 text-success">RM ${ totalprice }</h5>
                            </div>
                            <span class="text-success">Total Payable Amount</span>
                        </li>
                    `;

                    $('#tasker-details').html(taskerDetailsHTML);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching tasker data:', error);
                }
            });
        }
    </script>
    <!-- [ Main Content ] end -->
@endsection


<!-- [ footer apps ] start -->
@section('footer')
    {{-- @include('client.layouts.footer') --}}
@endsection
<!-- [ footer apps ] End -->
