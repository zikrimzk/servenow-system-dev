@extends('administrator.layouts.main')

@section('content')
    <style>
        .alphabet-filter-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
            /* Responsive grid */
            gap: 5px;
            /* Spacing between items */
            /* padding: 5px; */
            /* background-color: #f8f9fa; */
            /* Light background */
            /* border: 1px solid #ddd; */
            /* Subtle border */
            border-radius: 5px;
            /* Rounded corners */
        }

        .alphabet-link {
            display: block;
            text-align: center;
            padding: 6px 9px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #000000;
            /* Bootstrap primary color */
            border: 1px solid #ddd;
            /* Button-like border */
            border-radius: 5px;
            /* Rounded edges */
            transition: all 0.2s ease-in-out;
        }

        .alphabet-link:hover,
        .alphabet-link.active {
            background-color: #091b2d;
            color: #fff;
            /* White text on active/hover */
            border-color: #1e4167;
            /* Darker border */
        }

        .card-all {
            border-left: 4px solid #10100f;
        }

        .card-unactive {
            border-left: 4px solid #ffc107;
        }

        .card-active {
            border-left: 4px solid #28a745;
        }

        .card-deactive {
            border-left: 4px solid #dc3545;
        }

        .card-inactive {
            border-left: 4px solid #838592;
        }
    </style>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Users</li>
                                <li class="breadcrumb-item" aria-current="page">e-KYC Card Verification Log</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">e-KYC Card Verification Log</h2>
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
                <div class="card-header">
                    <div class="card-title">servenow e-KYC Card Log</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead class="table-borderless">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Request ID</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Response</th>
                                    <th scope="col">Data</th>
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
    </div>


    <!-- [ Main Content ] end -->


    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('show-card-logs') }}",
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
                        data: 'data',
                        name: 'data'
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
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                "language": {
                    "emptyTable": "No records found"
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
