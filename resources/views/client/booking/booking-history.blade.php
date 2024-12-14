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
    </style>
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
            <h2 class="fw-bold">My Task</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs mb-3 fw-bold border-bottom border-3 light-primary" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#allbooking"
                        role="tab" aria-controls="home" aria-selected="true">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#toserve" role="tab"
                        aria-controls="profile" aria-selected="false">Upcoming</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#completed"
                        role="tab" aria-controls="contact" aria-selected="false">Completed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#cancelled"
                        role="tab" aria-controls="contact" aria-selected="false">Cancelled</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="allbooking" role="tabpanel" aria-labelledby="allbooking-tab">
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
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="{{ asset('storage/' . $b->tasker_photo) }}" alt="Product Image" width="100"
                                height="100" class="">
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
                            <span class="fw-bold">Total: <span class="text-danger">RM{{ $b->booking_rate }}</span></span>
                            @if ($b->booking_status == 1)
                                <div>
                                    <button class="btn btn-danger">Cancel Booking</button>

                                    <button class="btn btn-outline-secondary">Contact Seller</button>
                                </div>
                            @elseif($b->booking_status == 2)
                                <div>
                                    <button class="btn btn-danger">Request Refund</button>

                                    <button class="btn btn-outline-secondary">Contact Seller</button>
                                </div>
                            @elseif($b->booking_status == 3 || $b->booking_status == 4)
                                <div>
                                    <button class="btn btn-primary">Service Completed</button>
                                    <button class="btn btn-outline-secondary">Contact Seller</button>
                                </div>
                            @elseif($b->booking_status == 6)
                                <div>
                                    <button class="btn btn-primary"data-bs-toggle="modal"
                                        data-bs-target="#reviewModal">Submit your review</button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="tab-pane fade" id="toserve" role="tabpanel" aria-labelledby="allbooking-tab">
                @foreach ($book->whereIn('booking_status', [2, 3, 4]) as $b)
                    <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                            @if ($b->booking_status == 2)
                                <span class="badge bg-light-success">Paid</span>
                            @elseif($b->booking_status == 3)
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($b->booking_status == 4)
                                <span class="badge bg-warning">Rescheduled</span>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="{{ asset('storage/' . $b->tasker_photo) }}" alt="Product Image" width="100"
                                height="100" class="">
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
                            <span class="fw-bold">Total: <span class="text-danger">RM{{ $b->booking_rate }}</span></span>
                            <div>
                                @if ($b->booking_status == 2)
                                    <button class="btn btn-danger">Request Refund</button>
                                    <button class="btn btn-outline-secondary">Contact Seller</button>
                                @elseif($b->booking_status == 3)
                                    <button class="btn btn-primary"data-bs-toggle="modal"
                                        data-bs-target="#reviewModal">Submit your review</button>
                                @elseif($b->booking_status == 4)
                                    <button class="btn btn-danger">Request Refund</button>
                                    <button class="btn btn-outline-secondary">Contact Seller</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="allbooking-tab">
                @foreach ($book->whereIn('booking_status', [6]) as $b)
                    <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="{{ asset('storage/' . $b->tasker_photo) }}" alt="Product Image" width="100"
                                height="100" class="">
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
                            <span class="fw-bold">Total: <span class="text-danger">RM{{ $b->booking_rate }}</span></span>
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    Open Review Modal
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="allbooking-tab">
                @foreach ($book->whereIn('booking_status', [5]) as $b)
                    <div class="card p-3 mb-3  border border-2 shadow shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $b->servicetype_name }}</h6>
                            <span class="badge bg-danger">Cancelled</span>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="{{ asset('storage/' . $b->tasker_photo) }}" alt="Product Image" width="100"
                                height="100" class="">
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
                            <span class="fw-bold">Total: <span class="text-danger">RM{{ $b->booking_rate }}</span></span>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div id="reviewModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Review & Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">
                        KHAIRUL ADZHAR BIN NORAIDI
                    </h6>
                    <p class="text-muted small mb-4"> SSTS_152</p>
                    <div class="mb-3">
                        <label for="glsr-ltr" class="form-label"><strong>Work Quality</strong></label>
                        <select id="glsr-ltr" class="star-rating-old">
                            <option value="">Select a rating</option>
                            <option value="5">Fantastic</option>
                            <option value="4">Great</option>
                            <option value="3">Good</option>
                            <option value="2">Poor</option>
                            <option value="1">Terrible</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="qualityInput" class="form-label"><strong>Review</strong></label>
                        <textarea class="form-control" id="qualityInput" rows="8" cols="5"
                            placeholder="Share your thoughts on the services to help other buyers."></textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-start mb-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-camera"></i> Add Photo
                        </button>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-camera-video"></i> Add Video
                        </button>
                    </div>

                    <small class="text-muted">Add 50 characters with 1 photo and 1 video to earn </small>


                </div>
                <div class="modal-footer justify-content-between align-items-center">
                    <!-- Checkbox for Anonymous Review -->
                    <div class="center-form-check mb-3 mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="anonymousCheck">
                            <label class="form-check-label small" for="anonymousCheck">
                                Leave your review anonymously
                            </label>
                        </div>
                    </div>
                    <!-- Submit and Cancel Buttons -->
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Submit</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/plugins/star-rating.min.js"></script>
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

