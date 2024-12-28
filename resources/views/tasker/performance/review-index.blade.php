<?php
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$currentMonth = Carbon::now()->month;
$currentYear = Carbon::now()->year;

?>
@extends('tasker.layouts.main')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Performance</li>
                                <li class="breadcrumb-item" aria-current="page">Review Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Review Management</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Start Alert -->
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <!-- End Alert -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Reviews (All)</h6>
                            <h4 class="mb-3">{{ $data->count() }}</h4>
                            <p class="mb-0 text-muted text-sm">users</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Reviews ({{ Carbon::now()->format('F') }})</h6>
                            <h4 class="mb-3">{{ $totalreviewsbymonth }}</h4>
                            <p class="mb-0 text-muted text-sm">users</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Reviews ({{ Carbon::now()->format('Y') }})</h6>
                            <h4 class="mb-3">
                                {{ $totalreviewsbyyear }}</h4>
                            <p class="mb-0 text-muted text-sm">users</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Unreview Booking</h6>
                            <h4 class="mb-3 text-danger">
                                {{ $totalunreview }}
                            </h4>
                            <p class="mb-0 text-muted text-sm">users</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Average Rating</h6>
                            <h4 class="mb-3">{{ number_format($averageRating, 1) }}</h4>
                            <p class="mb-0 text-muted text-sm">stars</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Positive Reviews</h6>
                            <h4 class="mb-3 text-success">{{ $csat }} %</h4>
                            <p class="mb-0 text-muted text-sm">of total reviews</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Neutral Reviews</h6>
                            <h4 class="mb-3 text-secondary">{{ $neutralrev }} %</h4>
                            <p class="mb-0 text-muted text-sm">of total reviews</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Negative Reviews</h6>
                            <h4 class="mb-3 text-danger">
                                {{ $negrev }} %</h4>
                            <p class="mb-0 text-muted text-sm">of total reviews</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $data->where('review_rating', '=', 5)->count() }}</h3>
                                    <p class="text-muted mb-0">Very Happy</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-laugh text-success f-36"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $data->where('review_rating', '=', 4)->count() }}</h3>
                                    <p class="text-muted mb-0">Happy</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-smile text-primary f-36"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $data->where('review_rating', '=', 3)->count() }}</h3>
                                    <p class="text-muted mb-0">Neutral</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-meh text-secondary f-36"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $data->where('review_rating', '=', 2)->count() }}</h3>
                                    <p class="text-muted mb-0">Sad</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-frown text-warning f-36"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-1">{{ $data->where('review_rating', '=', 1)->count() }}</h3>
                                    <p class="text-muted mb-0">Angry</p>
                                </div>
                                <div class="col-4 text-end">
                                    <i class="fas fa-angry text-danger f-36"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-3">
                                    <label for="score_filter" class="form-label">Date Range</label>
                                    <div class="d-flex align-items-center">
                                        <input type="date" id="startDate" name="startDate" class="form-control">
                                        <span class="mx-2">to</span>
                                        <input type="date" id="endDate" name="endDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-3 mb-3">
                                    <label for="endDate" class="form-label">Filter by</label>
                                    <select id="rating_filter" class="form-control" name="rating_filter">
                                        <option value="">Rating</option>
                                        <option value="1">Highest Rating</option>
                                        <option value="2">Lowest Rating</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label for="endDate" class="form-label text-white">Action</label>
                                    <div class="d-flex justify-content-start align-items-end">
                                        <a href="" class="link-primary" id="clearAllBtn">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive my-4 mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Booking ID</th>
                                            <th scope="col">Rating</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @foreach ($data as $b)
                <!-- Modal View Booking Details Start Here-->
                <div class="modal fade" id="viewBookingDetails-{{ $b->bookingID }}" data-bs-keyboard="false"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Booking Details ({{ $b->booking_order_id }})</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <h5 class="mb-3">A. Client Details</h5>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Client Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ Str::headline($b->client_firstname . ' ' . $b->client_lastname) }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Client Phone Number</label>
                                            <input type="text" class="form-control" value="{{ $b->client_phoneno }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Client Email</label>
                                            <input type="text" class="form-control" value="{{ $b->client_email }}"
                                                disabled />
                                        </div>
                                    </div>

                                    <h5 class="mb-3 mt-2">B. Booking Details</h5>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Date</label>
                                            <input type="text" class="form-control"
                                                value="{{ Carbon::parse($b->booking_date)->format('d F Y') }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Time</label>
                                            <input type="text" class="form-control"
                                                value="{{ Carbon::parse($b->booking_time_start)->format('g:i A') . ' - ' . Carbon::parse($b->booking_time_end)->format('g:i A') }}"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Booking Address</label>
                                            <textarea class="form-control" cols="20" rows="4" disabled>{{ $b->booking_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Booking Status</label>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal View Booking Details End Here-->

                <!-- Modal View Review Details Start Here-->
                <form action="{{ route('tasker-review-update', $b->reviewID) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="viewReviewDetails-{{ $b->reviewID }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Review Details</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Review by</label>
                                                <div class="fw-bold">
                                                    {{ Str::headline($b->client_firstname . ' ' . $b->client_lastname) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Review On</label>
                                                <div class="fw-normal">
                                                    {{ Carbon::parse($b->review_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d F Y g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Ratings</label>
                                                <div class="d-flex align-items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($b->review_rating >= $i)
                                                            <i class="fas fa-star text-warning f-16"></i>
                                                        @else
                                                            <i class="far fa-star text-warning f-16"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Review Description</label>
                                                <textarea class="form-control" cols="20" rows="4" readonly>{{ $b->review_description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label d-block mb-2">Review Status</label>
                                                <select name="review_status" class="form-control">
                                                    <option value="1"
                                                        @if ($b->review_status == 1) selected @endif>Show</option>
                                                    <option value="2"
                                                        @if ($b->review_status == 2) selected @endif>Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="form-label">Review Image</label>
                                        @if (
                                            $b->review_imageOne != null ||
                                                $b->review_imageTwo != null ||
                                                $b->review_imageThree != null ||
                                                $b->review_imageFour != null)
                                            <div class="col-sm-6 col-xs-12">
                                                <a data-lightbox="{{ asset('storage/' . $b->review_imageOne) }}">
                                                    <img src="{{ asset('storage/' . $b->review_imageOne) }}"
                                                        class="img-fluid m-b-10" alt="" /></a>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <a data-lightbox="{{ asset('storage/' . $b->review_imageTwo) }}">
                                                    <img src="{{ asset('storage/' . $b->review_imageTwo) }}"
                                                        class="img-fluid m-b-10" alt="" /></a>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <a data-lightbox="{{ asset('storage/' . $b->review_imageThree) }}">
                                                    <img src="{{ asset('storage/' . $b->review_imageThree) }}"
                                                        class="img-fluid m-b-10" alt="" /></a>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <a data-lightbox="{{ asset('storage/' . $b->review_imageFour) }}">
                                                    <img src="{{ asset('storage/' . $b->review_imageFour) }}"
                                                        class="img-fluid m-b-10" alt="" /></a>
                                            </div>
                                        @else
                                            <div class="col-sm-12 col-xs-12">
                                                <p class="text-muted">No Image</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-1">
                                                <label class="form-label">Replies</label>
                                            </div>
                                        </div>
                                        @if ($reply->where('review_id', $b->reviewID)->count() != 0)
                                            @foreach ($reply->where('review_id', $b->reviewID) as $r)
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="fw-bold">
                                                                    @if ($r->reply_by == 1)
                                                                        Administrator
                                                                    @else
                                                                        You
                                                                    @endif
                                                                </span>
                                                                <span>{{ Carbon::parse($r->reply_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y g:i A') }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <p class="mb-0 fw-normal">{{ $r->reply_message }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <p class="mb-0 fw-normal text-muted">No replies yet.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-light btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal View Review Details End Here-->

                <!-- Modal Reply Review Start Here-->
                <form action="{{ route('tasker-reply-review', $b->reviewID) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="replyReview-{{ $b->reviewID }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Reply Review</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Reply to</label>
                                                <div class="fw-bold">
                                                    {{ Str::headline($b->client_firstname . ' ' . $b->client_lastname) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Booking ID</label>
                                                <div class="fw-bold">
                                                    {{ $b->booking_order_id }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Message</label>
                                                <textarea class="form-control" cols="20" rows="4" name="reply_message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-light btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Reply Review</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal Reply Review End Here-->
            @endforeach

            <div class="modal fade modal-lightbox" id="lightboxModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <img src="../assets/images/light-box/l1.jpg" alt="images" class="modal-image img-fluid" />
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- [ Main Content ] end -->
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



    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : REVIEWS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('tasker-review-management') }}",
                        data: function(d) {
                            d.startDate = $('#startDate').val();
                            d.endDate = $('#endDate').val();
                            d.rating_filter = $('#rating_filter').val();
                        }
                    },
                    // ajax: "{{ route('admin-review-management') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'review_date_time',
                            name: 'review_date_time'
                        },
                        {
                            data: 'booking_order_id',
                            name: 'booking_order_id'
                        },
                        {
                            data: 'review_rating',
                            name: 'review_rating'
                        },

                        {
                            data: 'review_status',
                            name: 'review_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        emptyTable: "No data available in the table.", // Custom message when there's no data
                        loadingRecords: "Loading...",
                        processing: "Processing...",
                        zeroRecords: "No matching records found.",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }

                });

                $('#startDate, #endDate').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#rating_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#clearAllBtn').on('click', function(e) {
                    e.preventDefault();
                    $('#startDate').val('');
                    $('#endDate').val('');
                    $('#rating_filter').val('');
                    table.ajax.reload();
                    table.draw();
                });

            });


        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
