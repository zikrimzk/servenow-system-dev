<?php
use Illuminate\Support\Str;
use App\Models\Tasker;
?>
@extends('client.layouts.main')

<style>
    /* .calendar-container {
        padding: 16px;
        max-width: 400px;
        margin: auto;
        background-color: #fff;
       
    }

    .calendar-container label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    } */

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
                            <h1 class="my-3 my-md-0">{{ $sv->servicetype_name }}</h1>
                            <div class="alert alert-primary mt-3 mb-4">
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
                                <div class="card">
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
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <!-- Address Fields -->
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">Address 1</label>
                                                                <input type="text" class="form-control" id="address1"
                                                                    placeholder="Enter Address"
                                                                    value="{{ Auth::user()->client_address_one }}"readonly />
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">Address 2</label>
                                                                <input type="text" class="form-control" id="address2"
                                                                    placeholder="Enter Address"
                                                                    value="{{ Auth::user()->client_address_two }}"
                                                                    readonly />
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">Postcode</label>
                                                                <input type="text" class="form-control" id="postcode"
                                                                    placeholder="Postcode"
                                                                    value="{{ Auth::user()->client_postcode }}"readonly />
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">State</label>
                                                                <select class="form-control" id="state">
                                                                    <option value="{{ Auth::user()->client_state }}"
                                                                        selected>
                                                                        {{ Str::headline(Auth::user()->client_state) }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">Area</label>
                                                                <select
                                                                    class="form-control @error('client_area') is-invalid @enderror"
                                                                    id="addCity">
                                                                    <option value="{{ Auth::user()->client_area }}"
                                                                        selected>
                                                                        {{ Str::headline(Auth::user()->client_area) }}
                                                                    </option>
                                                                </select>
                                                                @error('client_area')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
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

                                                <div class="text-center m-5 p-5" id="loadingSpinner">
                                                    <div class="spinner-border spinner-border-lg text-primary"
                                                        role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <div class="link-primary mt-3" role="status">
                                                        <h4 id="loadingText"></h4>
                                                        {{-- <h4>Searching for the perfect tasker to meet your needs...</h4> --}}
                                                    </div>
                                                </div>

                                                <!--Tasker Selection [Start]-->
                                                <div id="taskerList" style="display:none;">
                                                    <div class="text-center mb-4 mt-4">
                                                        <h2 class="mb-1">Select Your Tasker</h2>
                                                    </div>
                                                    @foreach ($tasker as $tk)
                                                        <div class="card m-2 border border-0 mb-5">
                                                            <!--Image Tasker Section [Start]-->
                                                            <div class="row mt-4">

                                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <img src="{{ asset('storage/' . $tk->tasker_photo) }}"
                                                                            alt="Profile Photo" width="150"
                                                                            height="150"
                                                                            class="user-avtar rounded-circle">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                                    <div class="p-3">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h5 class="mb-2 f-24">
                                                                                {{ explode(' ', $tk->tasker_firstname)[0] }}.
                                                                            </h5>
                                                                            <h5 class="mb-2">RM
                                                                                {{ $tk->service_rate }}/{{ $tk->service_rate_type }}
                                                                            </h5>
                                                                        </div>
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <span
                                                                                class="badge bg-success text-white me-2">GREAT
                                                                                VALUE</span>
                                                                            <span class="badge text-bg-primary text-dark">2
                                                                                HOUR
                                                                                MINIMUM</span>
                                                                        </div>
                                                                        <div>
                                                                            <p class="mb-1">
                                                                                <span class="fw-bold">★ 4.9</span> (394
                                                                                reviews)
                                                                            </p>
                                                                            {{-- <p class="mb-1">
                                                                            {{ $tk->road_distance }}km</p> --}}
                                                                            <p class="mb-1">N/A Cleaning tasks</p>
                                                                            <p class="mb-0 text-muted">N/A Cleaning tasks
                                                                                overall
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
                                                                    <div
                                                                        class="d-grid d-md-flex justify-content-md-center align-items-md-center ">
                                                                        <button type="button"
                                                                            class="btn btn-primary select-continue-btn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#selectdatetime-{{ $tk->taskerID }}"
                                                                            data-tasker-id="{{ $tk->taskerID }}"
                                                                            data-service-id="{{ $tk->svID }}">
                                                                            Select & Continue
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-9 col-lg-9">
                                                                    <div class=" bg-light p-3">
                                                                        <h4> How I can help:</h4>
                                                                        <p class="text-muted fw-normal f-16">
                                                                            {{ $tk->service_desc }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div id="selectdatetime-{{ $tk->taskerID }}" class="modal fade"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLiveLabel">
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
                                                                                <input type="text" id="task-date"
                                                                                    class="form-control"
                                                                                    name="booking_date"
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
                                                    @endforeach
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
                                                            <!-- Credit Card Option -->
                                                            <div class="col-md-6 col-xxl-4">
                                                                <div class="address-check border rounded my-3">
                                                                    <div class="form-check">
                                                                        <input type="radio" name="payoptradio1"
                                                                            class="form-check-input input-primary"
                                                                            id="payopn-check-1" checked />
                                                                        <label class="form-check-label d-block"
                                                                            for="payopn-check-1">
                                                                            <span class="card-body p-3 d-block">
                                                                                <span class="h5 mb-3 d-block">Credit
                                                                                    Card</span>
                                                                                <span class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="f-12 badge bg-success me-3">5%
                                                                                        OFF</span>
                                                                                    <img src="../assets/images/application/card.png"
                                                                                        alt="img"
                                                                                        class="img-fluid ms-1" />
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
                                                                            id="payopn-check-2" />
                                                                        <label class="form-check-label d-block"
                                                                            for="payopn-check-2">
                                                                            <span class="card-body p-3 d-block">
                                                                                <span class="h5 mb-3 d-block">Online
                                                                                    Banking</span>
                                                                                <span class="d-flex align-items-center">
                                                                                    <span
                                                                                        class="f-12 badge bg-success me-3">5%
                                                                                        OFF</span>
                                                                                    <img src="../assets/images/application/paypal.png"
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
                                                                    <h5>Credit Card Details</h5>
                                                                    <form>
                                                                        <div class="mb-3">
                                                                            <label for="cardholder-name"
                                                                                class="form-label">Cardholder's
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="cardholder-name"
                                                                                placeholder="Enter your name">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="card-number"
                                                                                class="form-label">Card
                                                                                Number</label>
                                                                            <input type="text" class="form-control"
                                                                                id="card-number"
                                                                                placeholder="1234 5678 9012 3456">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label for="expiration-date"
                                                                                    class="form-label">Expiration
                                                                                    Date</label>
                                                                                <div class="d-flex">
                                                                                    <select class="form-select me-2"
                                                                                        id="expiration-month">
                                                                                        <option>01</option>
                                                                                        <option>02</option>
                                                                                        <option>03</option>
                                                                                    </select>
                                                                                    <select class="form-select"
                                                                                        id="expiration-year">
                                                                                        <option>2023</option>
                                                                                        <option>2024</option>
                                                                                        <option>2025</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="cvv"
                                                                                    class="form-label">CVV
                                                                                    Code</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="cvv" placeholder="123">
                                                                            </div>
                                                                        </div>
                                                                    </form>
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
                                                                <input type="text" name="booking_address"
                                                                    class="booking_address">
                                                                <input type="text" name="booking_time_start"
                                                                    class="inputTimeStart">
                                                                <input type="text" name="booking_time_end"
                                                                    class="inputTimeEnd">
                                                                <input type="text" name="booking_rate"
                                                                    class="bookingRate">
                                                                <input type="text" name="service_id"
                                                                    class="serviceID">
                                                                <input type="text" name="tasker_id"
                                                                    class="taskerID">
                                                            </div>
                                                            <div class="d-grid mt-4 mb-4">
                                                                <button type="submit" class="btn btn-primary">Proceed to
                                                                    Payment</button>
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
        /******************** *************************** ****************/
        /******************** TABPANE: TAB NAVIGATION ********************/
        /******************** *************************** ****************/

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const reverseTabButton = document.querySelector('.ti-edit'); // Target the button by its class

            reverseTabButton.addEventListener('click', function() {
                const activeTab = document.querySelector('.nav-pills .nav-link.active');
                const currentIndex = Array.from(tabs).indexOf(activeTab);

                // Check if there is a previous tab to navigate to
                if (currentIndex > 0) {
                    // Deactivate the current tab
                    activeTab.classList.remove('active');
                    activeTab.setAttribute('aria-selected', 'false');

                    // Activate the previous tab
                    const previousTab = tabs[currentIndex - 1];
                    previousTab.classList.add('active');
                    previousTab.setAttribute('aria-selected', 'true');

                    // Activate the corresponding tab content
                    const tabContents = document.querySelectorAll('.tab-pane');
                    tabContents[currentIndex].classList.remove('active', 'show');
                    tabContents[currentIndex - 1].classList.add('active', 'show');
                }

                updateButtons(); // Update navigation buttons and progress bar
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

            // Calculate new index
            let newIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;

            // Ensure index is within bounds
            if (newIndex < 0 || newIndex >= tabs.length) return;

            if (direction === 'next') {
                // Unlock the next tab
                tabs[newIndex].classList.remove('disabled');
                tabs[newIndex].setAttribute('data-bs-toggle', 'tab'); // Allow tab switching

                // Handle Tasker Selection loading
                if (newIndex === 2) { // Tasker Selection index
                    const text = "Finding...";
                    const speed = 200; // Typing speed in milliseconds
                    let i = 0;

                    function typeEffect() {
                        if (i < text.length) {
                            document.getElementById("loadingText").innerHTML += text.charAt(i);
                            i++;
                            setTimeout(typeEffect, speed);
                        }
                    }

                    typeEffect();


                    document.getElementById('loadingSpinner').style.display = 'block'; // Show spinner
                    document.getElementById('taskerList').style.display = 'none'; // Hide tasker list initially

                    // Simulate loading and show the tasker list after 2.5 seconds
                    setTimeout(function() {
                        document.getElementById('loadingSpinner').style.display = 'none'; // Hide spinner
                        document.getElementById('taskerList').style.display = 'block'; // Show tasker list
                    }, 3000); // Adjust delay as needed
                }

                updateBookingAddress();
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

            // Navigation buttons
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const nextStepButton = document.getElementById('nextStepButton');
            const taskoption = document.getElementById('task-option');

            // Enable/Disable "Previous" button
            prevButton.disabled = currentIndex === 0;

            if (currentIndex === 1) {
                // Validate address fields
                const address1 = document.getElementById('address1').value.trim();
                const address2 = document.getElementById('address2').value.trim();
                const postcode = document.getElementById('postcode').value.trim();
                const state = document.getElementById('state').value.trim();
                const area = document.getElementById('addCity').value.trim();

                const isAddressValid = address1 !== "" && postcode !== "" && state !== "" && area !== "";

                // Enable "Next" button only if address is valid
                nextButton.disabled = !isAddressValid;
            } else {
                nextButton.disabled = currentIndex === tabs.length - 1;
            }

            // Adjust "Next" and "Next Step" button visibility for Tasker Selection
            if(currentIndex === 1)
            {
                nextButton.disabled = true;

            }
            if (currentIndex === 2) {
                nextButton.style.display = 'none'; // Hide "Next"
                nextStepButton.style.display = ''; // Show "Next Step"
            } else {
                if (currentIndex === 3) {
                    nextButton.style.display = 'none'; // Hide "Next"
                    nextStepButton.style.display = 'none'; // Show "Next Step"
                } else {
                    nextButton.style.display = '';
                    nextStepButton.style.display = 'none';
                }

            }



            updateProgressBar(currentIndex + 1, tabs.length);
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Lock all tabs except the first one on page load
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            tabs.forEach((tab, index) => {
                if (index !== 0) {
                    tab.classList.add('disabled');
                    tab.removeAttribute('data-bs-toggle'); // Prevent tab switching
                }
            });

            updateButtons();

            // Ensure tabs can't be clicked if disabled
            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    if (tab.classList.contains('disabled')) {
                        e.preventDefault(); // Prevent navigation to disabled tabs
                    }
                });
            });
        });

        /******************** *************************** ***********************/
        /******************** MODAL: ASSIGN TASKER DYNAMICLY ********************/
        /******************** *************************** ***********************/

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.select-continue-btn');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const taskerId = this.getAttribute('data-tasker-id');
                    const svId = this.getAttribute('data-service-id');
                    $('.task-time').val('');
                    if (taskerId) {
                        const today = new Date();
                        const formattedToday = today.toISOString().split('T')[
                            0]; // Format as YYYY-MM-DD
                        localStorage.setItem('selectedTaskerId', taskerId);
                        localStorage.setItem('selectedServiceId', svId);
                        getTaskerTimeSlots(formattedToday);
                        checkoutTaskerDetails();
                        if ($('.task-time').val() == '') {
                            $('.select-tasker').addClass('disabled');
                        }

                    }
                });
            });
        });

        function updateBookingAddress() {
            // Ambil nilai dari setiap medan
            const address1 = document.getElementById('address1').value.trim();
            const address2 = document.getElementById('address2').value.trim();
            const postcode = document.getElementById('postcode').value.trim();
            const state = document.getElementById('state').value.trim();
            const area = document.getElementById('addCity').value.trim();

            // Gabungkan nilai-nilai tersebut
            const fullAddress = `${address1}, ${address2}, ${postcode}, ${area}, ${state}`.replace(/(, )+/g, ', ').replace(
                /, $/, '');

            $('.booking_address').val(fullAddress.toUpperCase());
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addressFields = ['address1', 'address2', 'postcode', 'state', 'addCity'];

            addressFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', updateBookingAddress); // Update address on input change
                }
            });
        });

        // FLATPICKER : CALANDER
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            // Initialize Flatpickr
            flatpickr("#task-date", {
                enableTime: false,
                minDate: "today",
                maxDate: new Date(new Date().setDate(today.getDate() + 7)),
                defaultDate: formattedToday,
                onChange: function(selectedDates, dateStr, instance) {
                    // Pass the selected date to the AJAX function
                    getTaskerTimeSlots(dateStr);
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
                        // Validate slots based on duration
                        const validSlots = validateTimeSlots(data, duration);

                        if (validSlots.length > 0) {
                            taskTimeSelect.append(`<option value="" selected>-Select Time-</option>`);
                            validSlots.forEach(function(time) {
                                taskTimeSelect.append(`<option value="${time}">${time}</option>`);
                            });
                        } else {
                            taskTimeSelect.append(
                                '<option value="" selected>No valid times available</option>');
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

        function validateTimeSlots(slots, duration) {
            const validSlots = [];
            const timeFormat = "HH:mm:ss"; // Format your time as shown in your dropdown (e.g., "07:30:00")
            const timeSlots = slots.map(slot => moment(slot.time, timeFormat)); // Convert to Moment.js objects

            for (let i = 0; i < timeSlots.length; i++) {
                let isValid = true;

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
    @include('client.layouts.footer')
@endsection
<!-- [ footer apps ] End -->
