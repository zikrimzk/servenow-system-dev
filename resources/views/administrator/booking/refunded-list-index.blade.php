<?php
use Illuminate\Support\Str;
use Carbon\Carbon;
?>
@extends('administrator.layouts.main')

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
                                <li class="breadcrumb-item">Bookings</li>
                                <li class="breadcrumb-item" aria-current="page">Refunded Booking List</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Refunded Booking List</h2>
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
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="dt-responsive table-responsive my-4 mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tasker</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Booking Date</th>
                                            <th scope="col">Booking Time</th>
                                            <th scope="col">Booking Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @foreach ($books as $b)
                <!-- Modal View Booking Details Start Here-->
                <form action="{{ route('admin-booking-update', $b->bookingID) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="viewBookingDetails-{{ $b->bookingID }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Booking Details</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>

                                <div class="modal-body">
                                    <div class="row">

                                        <h5 class="mb-3">A. Tasker Details</h5>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Tasker Code</label>
                                                <input type="text" class="form-control" value="{{ $b->tasker_code }}"
                                                    disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Tasker Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Str::headline($b->tasker_firstname . ' ' . $b->tasker_lastname) }}"
                                                    disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tasker Phone Number</label>
                                                <input type="text" class="form-control" value="{{ $b->tasker_phoneno }}"
                                                    disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tasker Email</label>
                                                <input type="text" class="form-control" value="{{ $b->tasker_email }}"
                                                    disabled />
                                            </div>
                                        </div>

                                        <h5 class="mb-3 mt-2">B. Client Details</h5>
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
                                                <input type="text" class="form-control"
                                                    value="{{ $b->client_email }}" disabled />
                                            </div>
                                        </div>

                                        <h5 class="mb-3 mt-2">C. Booking Details</h5>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Booking Date</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Carbon::parse($b->booking_date)->format('d F Y') }}"
                                                    disabled />
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
                                                <label class="form-label">Total Amount Paid</label>
                                                <input class="form-control" value="{{ $b->booking_rate }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label d-block mb-2">Booking Status</label>
                                                @if ($b->booking_status == 7)
                                                    <span class="badge bg-light-warning">Pending Refund</span>
                                                @elseif($b->booking_status == 8)
                                                    <span class="badge bg-light-success">Refunded</span>
                                                @endif
                                            </div>
                                        </div>

                                        <h5 class="mb-3 mt-2">D. Refund Details</h5>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label d-block mb-2">Refund Reason</label>
                                                <textarea class="form-control" cols="20" rows="4" disabled>test</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label d-block mb-2">Amount To be Refunded (RM) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="cancelrefund_amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-light btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Approve Refund</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal View Booking Details End Here-->

                <!-- Modal Approve Start Here -->
                {{-- <div class="modal fade" id="approveModal-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <i class="ti ti-info-circle text-warning" style="font-size: 100px"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h2>Service Request Approval</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">Are you sure you want to approve this
                                                request ?</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <div>
                                                <a href="{{ route('admin-reject-service', $sv->id) }}"
                                                    class="btn btn-light-danger">Reject</a>
                                                <a href="{{ route('admin-approve-service', $sv->id) }}"
                                                    class="btn btn-light-success">Approve</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Modal Approve End Here -->

                <!-- Modal Terminate Start Here -->
                {{-- <div class="modal fade" id="terminateModal-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <i class="ti ti-info-circle text-warning" style="font-size: 100px"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h2>Terminate Service</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">Are you sure to terminate this
                                                services ?</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('admin-terminate-service', $sv->id) }}"
                                                class="btn btn-light-danger">Terminate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Modal Terminate End Here -->
            @endforeach


        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : SERVICES
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    responsive: true,
                    ajax: "{{ route('admin-refunded-list') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'tasker',
                            name: 'tasker'
                        },
                        {
                            data: 'client',
                            name: 'client'
                        },
                        {
                            data: 'booking_date',
                            name: 'booking_date'
                        },
                        {
                            data: 'booking_time',
                            name: 'booking_time'
                        },
                        {
                            data: 'booking_status',
                            name: 'booking_status'
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
                        // loadingRecords: "Loading...",
                        // processing: "Processing...",
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

            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
