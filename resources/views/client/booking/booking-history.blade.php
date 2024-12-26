@extends('client.layouts.main')


@section('content')

    <style>
        .nav-tabs .nav-link.active {
            background-color: #16325b;
            /* Light gray background for active tab */
            border-color: #dee2e6 #dee2e6 #fff;
            /* Adjust border color */
            color: #fcfcfc;
            /* Darker text color */
        }

        :root {
            --gl-star-empty: url('../../images/rating/star-empty.svg');
            --gl-star-full: url('../../images/rating/star-full.svg');
            --gl-star-size: 35px;
        }

        .gl-star-rating--stars {
            flex-wrap: wrap;
        }

        .gl-star-rating [data-value]:not(.gl-active) .gl-emote-bg {
            fill: #dcdce6;
        }

        .gl-active svg.feather {
            fill: var(--bs-danger);
            stroke: var(--bs-danger);
        }

        .photo-slot {
            width: 80px;
            height: 80px;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .photo-preview {
            position: relative;
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-preview button {
            position: absolute;
            top: 2px;
            right: 2px;
            background: white;
            border: none;
            color: red;
            font-weight: bold;
            cursor: pointer;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
        }

        .table-refund {
            width: 100%;
            border-collapse: collapse;
        }

        .table-refund td,
        .table-refund th {
            padding: 8px;
        }

        .table-refund td {
            text-align: right;
        }

        .table-refund th {
            text-align: left;
        }

        .table-refund tr {
            border-bottom: 1px solid #ddd;
        }
    </style>


    <div class="pc-container mb-5">
        <div class="pc-content">
            <div class="row">

                <div class="col-sm-8 col-md-12">

                    <h1 class="my-4 mx-3">My Booking</h1>

                    <!-- Start Alert -->
                    <div class="mx-3">
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

                    <ul class="nav nav-tabs mb-3 fw-bold border-bottom border-3 light-primary mx-3 my-1" id="myTab"
                        role="tablist">
                        {{-- <li class="nav-item">
                            <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#allbooking"
                                role="tab" aria-controls="home" aria-selected="true">All</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link text-uppercase active" id="profile-tab" data-bs-toggle="tab" href="#toserve"
                                role="tab" aria-controls="profile" aria-selected="true">Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#completed"
                                role="tab" aria-controls="contact" aria-selected="false">Completed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#cancelled"
                                role="tab" aria-controls="contact" aria-selected="false">Cancelled</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#refund"
                                role="tab" aria-controls="contact" aria-selected="false">Refund</a>
                        </li>
                    </ul>
                </div>


                <div class="col-sm-8 col-md-12">
                    <div class="tab-content mx-3 my-1" id="myTabContent">

                        {{-- <div class="tab-pane fade show active" id="allbooking" role="tabpanel"
                            aria-labelledby="allbooking-tab">
                            @foreach ($book as $date => $book)
                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                    <h3 class="mb-3 mt-2 fw-bold">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h3>
                                    @foreach ($book as $b)
                                        <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                                                @if ($b->booking_status == 1)
                                                    <span class="badge bg-warning">To Pay</span>
                                                @elseif($b->booking_status == 2)
                                                    <span class="badge bg-light-success">Paid</span>
                                                @elseif($b->booking_status == 3)
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($b->booking_status == 4)
                                                    <span class="badge bg-warning">Rescheduled</span>
                                                @elseif($b->booking_status == 5)
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($b->booking_status == 6)
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($b->booking_status == 7)
                                                    <span class="badge bg-light-warning">Pending Refund</span>
                                                @elseif($b->booking_status == 8)
                                                    <span class="badge bg-light-success">Refunded</span>
                                                @endif
                                            </div>
                                            <hr>
                                            <div class="d-flex">
                                                <img src="{{ asset('storage/' . $b->tasker_photo) }}" alt="Product Image"
                                                    width="100" height="100" class="">
                                                <div class="ms-3">
                                                    <p class="mb-1 fw-bold">{{ $b->tasker_firstname }}</p>
                                                    <p class="mb-1">{{ $b->tasker_code }}</p>
                                                    <p class="mb-0">{{ $b->service_rate }}/{{ $b->service_rate_type }}</p>
                                                    <p class="mb-0">
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_start)->format('g:i A') }}
                                                        -
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_end)->format('g:i A') }}
                                                    </p>

                                                </div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">{{ $b->booking_address }}</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Total: <span
                                                        class="text-danger">RM{{ $b->booking_rate }}</span></span>
                                                @if ($b->booking_status == 1)
                                                    <div>
                                                        <button class="btn btn-danger"
                                                            data-bs-target="#cancelBookingModal-{{ $b->bookingID }}"
                                                            data-bs-toggle="modal">
                                                            Cancel Booking
                                                        </button>

                                                        <button class="btn btn-outline-secondary">Contact Tasker</button>
                                                    </div>
                                                @elseif($b->booking_status == 2 || $b->booking_status == 4)
                                                    <div>
                                                        <button class="btn btn-danger"
                                                            data-bs-target="#refundBookingModal-{{ $b->bookingID }}"
                                                            data-bs-toggle="modal">Request Refund</button>

                                                        <button class="btn btn-outline-secondary">Contact Tasker</button>
                                                    </div>
                                                @elseif($b->booking_status == 3)
                                                    <div>
                                                        <button class="btn btn-primary"
                                                            data-bs-target="#completeBookingModal-{{ $b->bookingID }}"
                                                            data-bs-toggle="modal">Service Completed</button>
                                                        <button class="btn btn-outline-secondary">Contact Tasker</button>
                                                    </div>
                                                @elseif($b->booking_status == 6)
                                                    @if ($review->where('booking_id', $b->bookingID)->count() == 0)
                                                        <div>
                                                            <button class="btn btn-primary"data-bs-toggle="modal"
                                                                data-bs-target="#reviewModal-{{ $b->bookingID }}">Submit
                                                                your review</button>
                                                        </div>
                                                    @else
                                                        <div class="text-muted fst-italic">Review Submitted</div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <div class="modal fade" id="cancelBookingModal-{{ $b->bookingID }}"
                                            data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-4">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center mb-3">
                                                                    <i class="ti ti-info-circle text-warning"
                                                                        style="font-size: 100px"></i>
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <h2>Cancel Booking Request</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mb-3">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <p class="fw-normal f-18 text-center">Are you sure you
                                                                        want to
                                                                        cancel this
                                                                        booking? </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-between gap-3 align-items-center">
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-pc-default"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <div>
                                                                        <a href="{{ route('client-change-booking-status', [$b->bookingID, $b->taskerID, 1]) }}"
                                                                            class="btn btn-light-danger">Cancel Booking</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="refundBookingModal-{{ $b->bookingID }}"
                                            data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-4">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center mb-3">
                                                                    <i class="ti ti-info-circle text-warning"
                                                                        style="font-size: 100px"></i>
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <h2>Refund Booking Request</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mb-3">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <p class="fw-normal f-18 text-center">Are you sure you
                                                                        want to
                                                                        request a
                                                                        refund? This action will cancel your booking, and it
                                                                        may take up
                                                                        to 5
                                                                        working days to process your refund. </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-between gap-3 align-items-center">
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-pc-default"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <div>
                                                                        <a href="{{ route('client-change-booking-status', [$b->bookingID, $b->taskerID, 2]) }}"
                                                                            class="btn btn-light-danger">Refund</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="completeBookingModal-{{ $b->bookingID }}"
                                            data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-4">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center mb-3">
                                                                    <i class="ti ti-info-circle text-warning"
                                                                        style="font-size: 100px"></i>
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <h2>Confirmation</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mb-3">
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">
                                                                    <p class="fw-normal f-18 text-center">Are you sure you
                                                                        want to mark
                                                                        this booking as complete ?</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div
                                                                    class="d-flex justify-content-between gap-3 align-items-center">
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-pc-default"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <div>
                                                                        <a href="{{ route('client-change-booking-status', [$b->bookingID, $b->taskerID, 3]) }}"
                                                                            class="btn btn-success">Completed</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('client-submit-review') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div id="reviewModal-{{ $b->bookingID }}" class="modal fade" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLiveLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLiveLabel">
                                                                Review &
                                                                Rate</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <input type="hidden" value="{{ $b->bookingID }}"
                                                                    name="booking_id">
                                                            </div>
                                                            <h6 class="mb-3">
                                                                {{ $b->tasker_firstname . ' ' . $b->tasker_lastname }}
                                                            </h6>
                                                            <p class="text-muted small mb-4">
                                                                {{ $b->tasker_code }}</p>
                                                            <div class="mb-3">
                                                                <label for="glsr-ltr" class="form-label"><strong>Work
                                                                        Quality</strong></label>
                                                                <select id="glsr-ltr" class="star-rating-old"
                                                                    name="review_rating">
                                                                    <option value="">Select a rating</option>
                                                                    <option value="5">Fantastic</option>
                                                                    <option value="4">Great</option>
                                                                    <option value="3">Good</option>
                                                                    <option value="2">Poor</option>
                                                                    <option value="1">Terrible</option>
                                                                </select>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="qualityInput"
                                                                    class="form-label"><strong>Review</strong></label>
                                                                <textarea class="form-control" id="qualityInput" rows="8" cols="5"
                                                                    placeholder="Share your thoughts on the services to help other buyers." name="review_description"></textarea>
                                                            </div>

                                                            <div class="d-flex gap-2 justify-content-start mb-2">
                                                                <div class="photo-slot text-center" id="addPhotoButton">
                                                                    <label style="cursor: pointer; display: block;">
                                                                        <input type="file" class="photoInput"
                                                                            accept="image/*" multiple
                                                                            style="display: none;" name="photos[]">
                                                                        <img src="../../assets/images/image_upload.jpg"
                                                                            alt="Add Picture"
                                                                            style="width: 50px; height: 50px; opacity: 0.6;">
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            <div class="mt-2 d-flex gap-2 photoPreviewContainer">

                                                            </div>
                                                            <p class="photoCounter" style="font-size: 14px;">0/4</p>
                                                            <p class="errorMessage" style="color: red; display: none;">You
                                                                can only
                                                                upload up
                                                                to 4 photos!</p>

                                                            <div class="photoPreviewContainer" class="mt-2">
                                                                <img class="photoPreview"
                                                                    style="max-width: 200px; display: none;"
                                                                    alt="Photo Preview">
                                                            </div>

                                                            <small class="text-muted">Add 50 characters with 1
                                                                photo and 1
                                                                video to
                                                                earn
                                                            </small>


                                                        </div>
                                                        <div
                                                            class="modal-footer justify-content-between align-items-center">

                                                            <div class="center-form-check mb-3 mt-3">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="anonymousCheck" name="review_type">
                                                                    <label class="form-check-label small"
                                                                        for="anonymousCheck">
                                                                        Leave your review anonymously
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Submit</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                            @endforeach
                        </div> --}}

                        <div class="tab-pane fade show active" id="toserve" role="tabpanel" aria-labelledby="toserve-tab">
                            @if ($toServeBooking->count() >= 1)
                                @foreach ($toServeBooking as $date => $bookings)
                                    <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                        <h3 class="mb-3 mt-2 fw-bold">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                        </h3>
                                        @foreach ($bookings as $b)
                                            <form action="{{ route('client-topay-function') }}" method="POST">
                                                @csrf
                                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                                                        @if ($b->booking_status == 1)
                                                            <span class="badge bg-warning">To Pay</span>
                                                        @elseif ($b->booking_status == 2)
                                                            <span class="badge bg-light-success">Paid</span>
                                                        @elseif($b->booking_status == 3)
                                                            <span class="badge bg-success">Confirmed</span>
                                                        @elseif($b->booking_status == 4)
                                                            <span class="badge bg-warning">Rescheduled</span>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex">
                                                        <img src="{{ asset('storage/' . $b->tasker_photo) }}"
                                                            alt="Tasker Photo" width="100" height="100">
                                                        <div class="ms-3">
                                                            <p class="mb-1 fw-bold">{{ $b->tasker_firstname }}</p>
                                                            <p class="mb-1">{{ $b->tasker_code }}</p>
                                                            <p class="mb-1">#{{ $b->booking_order_id }}</p>
                                                            <p class="mb-0">
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_start)->format('g:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_end)->format('g:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted">{{ $b->booking_address }}</span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Total: <span
                                                                class="text-danger">RM{{ $b->booking_rate }}</span></span>
                                                        @if ($b->booking_status == 1)
                                                            <div>
                                                                <input type="hidden" name="booking_date"
                                                                    value="{{ $b->booking_date }}">
                                                                <input type="hidden" name="booking_order_id"
                                                                    value="{{ $b->booking_order_id }}">
                                                                <button class="btn btn-light-warning">Proceed to
                                                                    Pay</button>
                                                                <button class="btn btn-light-danger" type="button"
                                                                    data-bs-target="#cancelBookingModal-{{ $b->bookingID }}"
                                                                    data-bs-toggle="modal">
                                                                    Cancel Booking
                                                                </button>
                                                            </div>
                                                        @elseif ($b->booking_status == 2 || $b->booking_status == 4)
                                                            <div>
                                                                <button class="btn btn-light-danger" type="button"
                                                                    data-bs-target="#refundBookingModalTwo-{{ $b->bookingID }}"
                                                                    data-bs-toggle="modal"
                                                                    data-booking-id="{{ $b->bookingID }}"
                                                                    onclick="saveBookingIDToLocalStorage(this)">Request
                                                                    Refund</button>

                                                                <button class="btn btn-light-secondary"
                                                                    type="button">Contact
                                                                    Tasker</button>
                                                            </div>
                                                        @elseif($b->booking_status == 3)
                                                            <div>
                                                                <button class="btn btn-light-primary" type="button"
                                                                    data-bs-target="#completeBookingModalTwo-{{ $b->bookingID }}"
                                                                    data-bs-toggle="modal">Service Completed</button>
                                                                <button class="btn btn-light-secondary"
                                                                    type="button">Contact
                                                                    Tasker</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="modal fade" id="cancelBookingModal-{{ $b->bookingID }}"
                                                data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 mb-4">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center mb-3">
                                                                        <i class="ti ti-info-circle text-warning"
                                                                            style="font-size: 100px"></i>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <h2>Cancel Booking Request</h2>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <p class="fw-normal f-18 text-center">Are you sure
                                                                            you
                                                                            want to
                                                                            cancel this
                                                                            booking? </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div
                                                                        class="d-flex justify-content-between gap-3 align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-light btn-pc-default"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <div>
                                                                            <a href="{{ route('client-change-booking-status', [$b->bookingID, $b->taskerID, 1]) }}"
                                                                                class="btn btn-light-danger">Cancel
                                                                                Booking</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{ route('client-refund-request', $b->bookingID) }}"
                                                method="POST"> @csrf
                                                <div class="modal fade refundBookingModalTwo"
                                                    id="refundBookingModalTwo-{{ $b->bookingID }}"
                                                    data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 mb-3">
                                                                        <h4>Refund Booking Request</h4>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="mb-3">
                                                                                    <label for="cr_reason"
                                                                                        class="form-label">Refund
                                                                                        Reason
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <textarea name="cr_reason" id="cr_reason" cols="30" rows="10"
                                                                                        class="form-control @error('cr_reason') is-invalid @enderror" placeholder="Enter your reason ..."></textarea>
                                                                                    @error('cr_reason')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="mb-3">
                                                                                    <label for="cr_bank_name"
                                                                                        class="form-label">Bank
                                                                                        Name<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select name="cr_bank_name"
                                                                                        class="form-control @error('cr_bank_name') is-invalid @enderror"
                                                                                        id="cr_bank_name">
                                                                                        <option value="">Select
                                                                                            Bank
                                                                                        </option>
                                                                                        @foreach ($bank as $banks)
                                                                                            <option
                                                                                                value="{{ $banks['bank'] }}">
                                                                                                {{ $banks['bank'] }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('cr_bank_name')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="mb-3">
                                                                                    <label for="cr_account_name"
                                                                                        class="form-label">Account
                                                                                        Holder Name<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('cr_account_name') is-invalid @enderror"
                                                                                        name="cr_account_name"
                                                                                        placeholder="Enter your account holder name"
                                                                                        id="cr_account_name">
                                                                                    @error('cr_account_name')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="mb-3">
                                                                                    <label for="cr_account_number"
                                                                                        class="form-label">Account
                                                                                        Number<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('cr_account_number') is-invalid @enderror"
                                                                                        name="cr_account_number"
                                                                                        placeholder="Enter your account number"
                                                                                        id="cr_account_number">
                                                                                    @error('cr_account_number')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="mb-3">
                                                                                    <table class="table-refund">
                                                                                        <tr class="mb-3">
                                                                                            <td>Total Paid</td>
                                                                                            <td>{{ $b->booking_rate }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="mb-3">
                                                                                            <td class="text-danger">Service
                                                                                                Charge (3%)</td>
                                                                                            <td class="text-danger">
                                                                                                {{ number_format($b->booking_rate * 0.03, 2) }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="mb-3">
                                                                                            <td>Amount to be refunded
                                                                                            </td>
                                                                                            <td>{{ $b->booking_rate - number_format($b->booking_rate * 0.03, 2) }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <input type="hidden"
                                                                                        class="form-control"
                                                                                        name="cr_amount"
                                                                                        value ="{{ $b->booking_rate - number_format($b->booking_rate * 0.03, 2) }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div
                                                                            class="d-flex justify-content-between gap-3 align-items-center">
                                                                            <button type="button"
                                                                                class="btn btn-light btn-pc-default"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-light-danger"
                                                                                data-bs-dismiss="modal">Confirm
                                                                                Refund</button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="modal fade" id="completeBookingModalTwo-{{ $b->bookingID }}"
                                                data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 mb-4">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center mb-3">
                                                                        <i class="ti ti-info-circle text-warning"
                                                                            style="font-size: 100px"></i>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <h2>Confirmation</h2>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <p class="fw-normal f-18 text-center">Are you sure
                                                                            you
                                                                            want to mark
                                                                            this booking as complete ?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div
                                                                        class="d-flex justify-content-between gap-3 align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-light btn-pc-default"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <div>
                                                                            <a href="{{ route('client-change-booking-status', [$b->bookingID, $b->taskerID, 3]) }}"
                                                                                class="btn btn-success">Completed</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center vh-100">
                                        <div class="row justify-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="text-center">
                                                    <i class="fas fa-calendar-week f-68"></i>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p class="mb-0 text-center f-18">No booking yet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="allbooking-tab">
                            @if ($completed->count() >= 1)
                                @foreach ($completed as $date => $booking)
                                    <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                        <h3 class="mb-3 mt-2 fw-bold">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                        </h3>
                                        @foreach ($booking as $b)
                                            <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                                                    <span class="badge bg-success">Completed</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/' . $b->tasker_photo) }}"
                                                        alt="Product Image" width="100" height="100"
                                                        class="">
                                                    <div class="ms-3">
                                                        <p class="mb-1 fw-bold">{{ $b->tasker_firstname }}</p>
                                                        <p class="mb-1">{{ $b->tasker_code }}</p>
                                                        <p class="mb-1">#{{ $b->booking_order_id }}</p>
                                                        <p class="mb-0">
                                                            {{ $b->service_rate }}/{{ $b->service_rate_type }}
                                                        </p>
                                                        <p class="mb-0">
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_start)->format('g:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_end)->format('g:i A') }}
                                                        </p>

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">{{ $b->booking_address }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Total: <span
                                                            class="text-danger">RM{{ $b->booking_rate }}</span></span>
                                                    @if ($review->where('booking_id', $b->bookingID)->count() == 0)
                                                        <div>
                                                            <button class="btn btn-light-primary"data-bs-toggle="modal"
                                                                data-bs-target="#reviewModalTwo-{{ $b->bookingID }}">Submit
                                                                your
                                                                review</button>
                                                        </div>
                                                    @else
                                                        <div class="text-muted fst-italic"> Review Submitted </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <form method="POST" action="{{ route('client-submit-review') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div id="reviewModalTwo-{{ $b->bookingID }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLiveLabel">
                                                            Review &
                                                            Rate</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <input type="hidden" value="{{ $b->bookingID }}"
                                                                name="booking_id" style="display:none;">
                                                        </div>
                                                        <h6 class="mb-3">
                                                            {{ $b->tasker_firstname . ' ' . $b->tasker_lastname }}
                                                        </h6>
                                                        <p class="text-muted small mb-4">
                                                            {{ $b->tasker_code }}</p>
                                                        <div class="mb-3">
                                                            <label for="glsr-ltr" class="form-label"><strong>Work
                                                                    Quality</strong></label>
                                                            <select id="glsr-ltr" class="star-rating-old"
                                                                name="review_rating">
                                                                <option value="">Select a rating</option>
                                                                <option value="5">Fantastic</option>
                                                                <option value="4">Great</option>
                                                                <option value="3">Good</option>
                                                                <option value="2">Poor</option>
                                                                <option value="1">Terrible</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="qualityInput"
                                                                class="form-label"><strong>Review</strong></label>
                                                            <textarea class="form-control" id="qualityInput" rows="8" cols="5"
                                                                placeholder="Share your thoughts on the services to help other buyers." name="review_description"></textarea>
                                                        </div>

                                                        <div class="d-flex gap-2 justify-content-start mb-2">
                                                            <div class="photo-slot text-center" id="addPhotoButton">
                                                                <label
                                                                    style="cursor: pointer; display: block; width: 100%;">
                                                                    <input type="file" class="photoInput"
                                                                        accept="image/*" multiple style="display: none;"
                                                                        name="photos[]">
                                                                    <img src="../../assets/images/image_upload.jpg"
                                                                        alt="Add Picture"
                                                                        style="width: 70%; display:block; margin: 0 auto; opacity: 0.6;">
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <div class="mt-2 d-flex gap-2 photoPreviewContainer">

                                                        </div>
                                                        <p class="photoCounter" style="font-size: 14px;">0/4</p>
                                                        <p class="errorMessage" style="color: red; display: none;">You
                                                            can only
                                                            upload up
                                                            to 4 photos!</p>

                                                        <div class="photoPreviewContainer" class="mt-2">
                                                            <img class="photoPreview"
                                                                style="max-width: 200px; display: none;"
                                                                alt="Photo Preview">
                                                        </div>

                                                        <small class="text-muted">Add 50 characters with 1
                                                            photo
                                                        </small>


                                                    </div>
                                                    <div class="modal-footer justify-content-between align-items-center">

                                                        <div class="center-form-check mb-3 mt-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="anonymousCheck" name="review_type"
                                                                    value="2">
                                                                <label class="form-check-label small"
                                                                    for="anonymousCheck">
                                                                    Leave your review anonymously
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Submit</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            @else
                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center vh-100">
                                        <div class="row justify-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="text-center">
                                                    <i class="fas fa-calendar-week f-68"></i>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p class="mb-0 text-center f-18">No booking yet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="allbooking-tab">
                            @if ($cancelled->count() >= 1)
                                @foreach ($cancelled as $date => $booking)
                                    <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                        <h3 class="mb-3 mt-2 fw-bold">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                        </h3>
                                        @foreach ($booking as $b)
                                            <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/' . $b->tasker_photo) }}"
                                                        alt="Product Image" width="100" height="100"
                                                        class="">
                                                    <div class="ms-3">
                                                        <p class="mb-1 fw-bold">{{ $b->tasker_firstname }}</p>
                                                        <p class="mb-1">{{ $b->tasker_code }}</p>
                                                        <p class="mb-1">#{{ $b->booking_order_id }}</p>
                                                        <p class="mb-0">
                                                            {{ $b->service_rate }}/{{ $b->service_rate_type }}
                                                        </p>
                                                        <p class="mb-0">
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_start)->format('g:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_end)->format('g:i A') }}
                                                        </p>

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">

                                                    <span class="text-muted">{{ $b->booking_address }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Total: <span
                                                            class="text-danger">RM{{ $b->booking_rate }}</span></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center vh-100">
                                        <div class="row justify-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="text-center">
                                                    <i class="fas fa-calendar-week f-68"></i>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p class="mb-0 text-center f-18">No booking yet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="allbooking-tab">
                            @if ($refund->count() >= 1)
                                @foreach ($refund as $date => $booking)
                                    <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                        <h3 class="mb-3 mt-2 fw-bold">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                        </h3>
                                        @foreach ($booking as $b)
                                            <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                                                    @if ($b->booking_status == 7)
                                                        <span class="badge bg-light-warning">Pending Refund</span>
                                                    @elseif($b->booking_status == 8)
                                                        <span class="badge bg-light-success">Refunded</span>
                                                    @elseif($b->booking_status == 9)
                                                        <span class="badge bg-light-danger">Update Required</span>
                                                    @elseif($b->booking_status == 10)
                                                        <span class="badge bg-danger">Refund Rejected</span>
                                                    @endif
                                                </div>
                                                <hr>
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/' . $b->tasker_photo) }}"
                                                        alt="Product Image" width="100" height="100"
                                                        class="">
                                                    <div class="ms-3">
                                                        <p class="mb-1 fw-bold">{{ $b->tasker_firstname }}</p>
                                                        <p class="mb-1">{{ $b->tasker_code }}</p>
                                                        <p class="mb-1">#{{ $b->booking_order_id }}</p>
                                                        <p class="mb-0">
                                                            {{ $b->service_rate }}/{{ $b->service_rate_type }}
                                                        </p>
                                                        <p class="mb-0">
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_start)->format('g:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $b->booking_time_end)->format('g:i A') }}
                                                        </p>

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">{{ $b->booking_address }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Total: <span
                                                            class="text-danger">RM{{ $b->booking_rate }}</span></span>
                                                    @if ($b->booking_status == 9)
                                                        <button class="btn btn-light-danger" type="button"
                                                            data-bs-target="#refundDetails-{{ $b->bookingID }}"
                                                            data-bs-toggle="modal">Update Details</button>
                                                    @else
                                                        <button class="btn btn-light-secondary" type="button"
                                                            data-bs-target="#refundDetails-{{ $b->bookingID }}"
                                                            data-bs-toggle="modal">View Refund Details</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                @foreach ($refunds as $rf)
                                    <form action="{{ route('client-update-refund-request', $rf->id) }}" method="POST">
                                        @csrf
                                        <div class="modal fade" id="refundDetails-{{ $rf->booking_id }}"
                                            data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="mb-0">Refund Details</h5>
                                                        <a href="#"
                                                            class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                                            data-bs-dismiss="modal">
                                                            <i class="ti ti-x f-20"></i>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-3">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_reason"
                                                                                class="form-label">Refund
                                                                                Reason
                                                                                <span class="text-danger">*</span></label>
                                                                            <textarea cols="25" rows="10" class="form-control" readonly>{{ $rf->cr_reason }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_bank_name"
                                                                                class="form-label">Refund
                                                                                Status</label>
                                                                            @if ($rf->cr_status == 0)
                                                                                <input type="text" class="form-control"
                                                                                    value="Require Update" readonly />
                                                                            @elseif ($rf->cr_status == 1)
                                                                                <input type="text" class="form-control"
                                                                                    value="Pending Request" readonly />
                                                                            @elseif($rf->cr_status == 2)
                                                                                <input type="text" class="form-control"
                                                                                    value="Approved" readonly />
                                                                            @elseif($rf->cr_status == 3)
                                                                                <input type="text" class="form-control"
                                                                                    value="Rejected" readonly />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_bank_name"
                                                                                class="form-label">Bank
                                                                                Name</label>
                                                                            @if ($rf->cr_status == 0)
                                                                                <select name="cr_bank_name"
                                                                                    class="form-control @error('cr_bank_name') is-invalid @enderror"
                                                                                    id="cr_bank_name">
                                                                                    <option value="">Select
                                                                                        Bank
                                                                                    </option>
                                                                                    @foreach ($bank as $banks)
                                                                                        <option
                                                                                            value="{{ $banks['bank'] }}">
                                                                                            {{ $banks['bank'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('cr_bank_name')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            @else
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $rf->cr_bank_name }}"
                                                                                    readonly />
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_account_name"
                                                                                class="form-label">Account
                                                                                Holder Name</label>
                                                                            @if ($rf->cr_status == 0)
                                                                                <input type="text"
                                                                                    class="form-control @error('cr_account_name') is-invalid @enderror"
                                                                                    name="cr_account_name"
                                                                                    placeholder="Enter your account holder name"
                                                                                    id="cr_account_name">
                                                                                @error('cr_account_name')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            @else
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $rf->cr_account_name }}"
                                                                                    readonly />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_account_number"
                                                                                class="form-label">Account
                                                                                Number</label>
                                                                            @if ($rf->cr_status == 0)
                                                                                <input type="text"
                                                                                    class="form-control @error('cr_account_number') is-invalid @enderror"
                                                                                    name="cr_account_number"
                                                                                    placeholder="Enter your account number"
                                                                                    id="cr_account_number">
                                                                                @error('cr_account_number')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            @else
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $rf->cr_account_number }}"
                                                                                    readonly />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div class="mb-3">
                                                                            <label for="cr_account_number"
                                                                                class="form-label">Total Amount to be
                                                                                Refunded</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $rf->cr_amount }}" readonly />
                                                                        </div>
                                                                    </div>
                                                                    @if ($rf->cr_status == 0)
                                                                        <div class="col-sm-12">
                                                                            <div
                                                                                class="d-flex justify-content-between gap-3 align-items-center">
                                                                                <button type="button"
                                                                                    class="btn btn-light btn-pc-default"
                                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-light-danger"
                                                                                    data-bs-dismiss="modal">Save
                                                                                    Changes</button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            @else
                                <div class="card p-3 mb-3 border border-2 shadow shadow-sm">
                                    <div class="d-flex justify-content-center align-items-center vh-100">
                                        <div class="row justify-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="text-center">
                                                    <i class="fas fa-calendar-week f-68"></i>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p class="mb-0 text-center f-18">No booking yet</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../assets/js/plugins/star-rating.min.js"></script>
    <script>
        // let uploadedPhotos = [];
        // const maxPhotos = 4;

        // const photoInputs = document.getElementsByClassName('photoInput');
        // const errorMessages = document.getElementsByClassName('errorMessage');
        // const photoCounters = document.getElementsByClassName('photoCounter');
        // const photoPreviewContainers = document.getElementsByClassName('photoPreviewContainer');

        // // Iterate through all photoInput elements to add event listeners
        // Array.from(photoInputs).forEach((photoInput, index) => {
        //     photoInput.addEventListener('change', function(event) {
        //         const files = Array.from(event.target.files);

        //         // Access corresponding elements for this specific photoInput
        //         const errorMessage = errorMessages[index];
        //         const photoCounter = photoCounters[index];
        //         const photoPreviewContainer = photoPreviewContainers[index];

        //         // Check if the max photo limit is exceeded
        //         if (uploadedPhotos.length + files.length > maxPhotos) {
        //             errorMessage.style.display = 'block';
        //             event.target.value = ''; // Reset the input
        //             return;
        //         }

        //         errorMessage.style.display = 'none';

        //         // Process and display each file
        //         files.forEach(file => {
        //             if (uploadedPhotos.length < maxPhotos) {
        //                 const reader = new FileReader();

        //                 reader.onload = function(e) {
        //                     const div = document.createElement('div');
        //                     div.classList.add('photo-preview');

        //                     const img = document.createElement('img');
        //                     img.src = e.target.result;
        //                     img.style.maxWidth = '100px'; // Optional: Limit the preview size

        //                     const btnRemove = document.createElement('button');
        //                     btnRemove.innerHTML = 'x';
        //                     btnRemove.style.marginLeft = '5px'; // Optional: Add spacing
        //                     btnRemove.addEventListener('click', () => {
        //                         photoPreviewContainer.removeChild(div);
        //                         uploadedPhotos = uploadedPhotos.filter(f => f !== file);
        //                         updateInputFiles(photoInput);
        //                         updateCounter(photoCounter);
        //                     });

        //                     div.appendChild(img);
        //                     div.appendChild(btnRemove);
        //                     photoPreviewContainer.appendChild(div);

        //                     uploadedPhotos.push(file);
        //                     updateInputFiles(photoInput);
        //                     updateCounter(photoCounter);
        //                 };

        //                 reader.readAsDataURL(file);
        //             }
        //         });

        //         event.target.value = ''; // Clear the input after processing files
        //     });
        // });

        // function updateInputFiles(photoInput) {
        //     const dataTransfer = new DataTransfer();

        //     uploadedPhotos.forEach(file => {
        //         dataTransfer.items.add(file);
        //     });

        //     photoInput.files = dataTransfer.files;
        // }

        // function updateCounter(photoCounter) {
        //     photoCounter.innerText = `${uploadedPhotos.length}/${maxPhotos}`;
        // }


        function saveBookingIDToLocalStorage(button) {
            // Get the booking ID from the data attribute
            const bookingID = button.getAttribute('data-booking-id');
            // Save it to localStorage
            localStorage.setItem('selectedBookingID', bookingID);
            console.log('Booking ID saved to localStorage:', bookingID); // Optional: For debugging

        }
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var booking = localStorage.getItem('selectedBookingID');
                var modal = new bootstrap.Modal(document.getElementById('refundBookingModalTwo-' + booking));
                modal.show();
            @endif
        });
        let uploadedPhotos = [];
        const maxPhotos = 4;

        const photoInputs = document.getElementsByClassName('photoInput');
        const errorMessages = document.getElementsByClassName('errorMessage');
        const photoCounters = document.getElementsByClassName('photoCounter');
        const photoPreviewContainers = document.getElementsByClassName('photoPreviewContainer');
        const addPhotoButtons = document.querySelectorAll('#addPhotoButton label'); // Select the button container

        // Iterate through all photoInput elements to add event listeners
        Array.from(photoInputs).forEach((photoInput, index) => {
            photoInput.addEventListener('change', function(event) {
                const files = Array.from(event.target.files);

                // Access corresponding elements for this specific photoInput
                const errorMessage = errorMessages[index];
                const photoCounter = photoCounters[index];
                const photoPreviewContainer = photoPreviewContainers[index];
                const addPhotoButton = addPhotoButtons[index]; // Get the corresponding button

                // Check if the max photo limit is exceeded
                if (uploadedPhotos.length + files.length > maxPhotos) {
                    errorMessage.style.display = 'block';
                    event.target.value = ''; // Reset the input
                    return;
                }

                errorMessage.style.display = 'none';

                // Process and display each file
                files.forEach(file => {
                    if (uploadedPhotos.length < maxPhotos) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.classList.add('photo-preview');

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '100px'; // Optional: Limit the preview size

                            const btnRemove = document.createElement('button');
                            btnRemove.innerHTML = 'x';
                            btnRemove.style.marginLeft = '5px'; // Optional: Add spacing
                            btnRemove.addEventListener('click', () => {
                                photoPreviewContainer.removeChild(div);
                                uploadedPhotos = uploadedPhotos.filter(f => f !== file);
                                updateInputFiles(photoInput);
                                updateCounter(photoCounter);
                                toggleAddPhotoButton(
                                    addPhotoButton
                                ); // Enable the button again if max is not reached
                            });

                            div.appendChild(img);
                            div.appendChild(btnRemove);
                            photoPreviewContainer.appendChild(div);

                            uploadedPhotos.push(file);
                            updateInputFiles(photoInput);
                            updateCounter(photoCounter);
                            toggleAddPhotoButton(
                                addPhotoButton); // Disable the button if max is reached
                        };

                        reader.readAsDataURL(file);
                    }
                });

                event.target.value = ''; // Clear the input after processing files
            });
        });

        function updateInputFiles(photoInput) {
            const dataTransfer = new DataTransfer();

            uploadedPhotos.forEach(file => {
                dataTransfer.items.add(file);
            });

            photoInput.files = dataTransfer.files;
        }

        function updateCounter(photoCounter) {
            photoCounter.innerText = `${uploadedPhotos.length}/${maxPhotos}`;
        }

        function toggleAddPhotoButton(addPhotoButton) {
            if (uploadedPhotos.length >= maxPhotos) {
                addPhotoButton.style.pointerEvents = 'none'; // Disable click
                addPhotoButton.style.opacity = '0.5'; // Optional: Add visual indication
            } else {
                addPhotoButton.style.pointerEvents = 'auto'; // Enable click
                addPhotoButton.style.opacity = '1'; // Reset visual indication
            }
        }
    </script>
    <script>
        var destroyed = false;
        var starratingPrebuilt = new StarRating('.star-rating-prebuilt', {
            prebuilt: true,
            maxStars: 5
        });
        var starrating = new StarRating('.star-rating', {
            stars: function(el, item, index) {
                el.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect class="gl-star-full" width="19" height="19" x="2.5" y="2.5"/><polygon fill="#FFF" points="12 5.375 13.646 10.417 19 10.417 14.665 13.556 16.313 18.625 11.995 15.476 7.688 18.583 9.333 13.542 5 10.417 10.354 10.417"/></svg>';
            }
        });
        var starratingOld = new StarRating('.star-rating-old');
        document.querySelector('.toggle-star-rating').addEventListener('click', function() {
            if (!destroyed) {
                starrating.destroy();
                starratingOld.destroy();
                starratingPrebuilt.destroy();
                heartrating.destroy();
                destroyed = true;
            } else {
                starrating.rebuild();
                starratingOld.rebuild();
                starratingPrebuilt.rebuild();
                heartrating.rebuild();
                destroyed = false;
            }
        });
        var heartrating = new StarRating('.heart-rating', {
            stars: function(el, item, index) {
                el.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" style="width:var(--gl-star-size);height:var(--gl-star-size);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
            }
        });
    </script>

@section('footer')
    @include('client.layouts.footer')
@endsection
@endsection
