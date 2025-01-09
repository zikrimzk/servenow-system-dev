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
                                <li class="breadcrumb-item">e-KYC</li>
                                <li class="breadcrumb-item" aria-current="page">e-KYC Face Verification Log</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">e-KYC Face Verification Log</h2>
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

            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead class="table-borderless">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Request ID</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Response</th>
                                    <th scope="col">Compare With</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time (s)</th>
                                    <th scope="col">DNS</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>


        <!-- [ Main Content ] end -->

        <script>
            $(document).ready(function() {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('show-face-logs') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'requestId',
                            name: 'requestId'
                        },
                        {
                            data: 'requestedBy',
                            name: 'requestedBy'
                        },
                        {
                            data: 'res',
                            name: 'res'
                        },
                        {
                            data: 'compareWith',
                            name: 'compareWith'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'responseTime',
                            name: 'responseTime'
                        },
                        {
                            data: 'domain',
                            name: 'domain'
                        },
                        {
                            data: 'verifiedAt',
                            name: 'verifiedAt'
                        },
                    ],
                    language: {
                        emptyTable: "No data available in the table.",
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
            });
        </script>

        <style>
            .table td {
                word-wrap: break-word;
                /* Membenarkan teks untuk dibungkus pada baris baru */
                white-space: normal;
                /* Menetapkan teks supaya tidak dipaksa ke satu baris */
            }
        </style>
    @endsection

    <!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
