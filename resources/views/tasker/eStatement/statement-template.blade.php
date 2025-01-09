<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServeNow - {{ $tasker->tasker_code }}_{{ $statement_dateMY }} </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .credit {
            color: green;
        }

        .uncredited {
            color: red;
        }

        .pending {
            color: orange;
        }

        .table-summary {
            font-weight: bold;
        }

        .footer {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        /* Print styles */
        @media print {
            body {
                font-size: 12px;
            }

            .container {
                margin: 0;
                padding: 0;
            }

            /* .table {
                page-break-inside: avoid;
            } */

            .footer {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid my-5">
        <!-- Company Header -->
        <div class="row align-items-center justify-content-between">
            <div class="col-6 text-start">
                <img src="https://www.servenow.com.my/assets/images/logo-test.png" class="img-fluid" style="max-height: 100px;" alt="logo" />
                {{-- <h5 class="fw-bold">ServeNow Sdn Bhd</h5>
                <p>Jalan Hang Tuah Jaya, 76100 Durian Tunggal, Melaka</p> --}}
            </div>
            <div class="col-6 text-end">
                <h2 class="fw-bold">e-Statement</h2>
            </div>
        </div>
        <hr>

        <!-- Statement Details -->
        <div class="row mb-5">
            <div class="col-6">
                <p class="fw-bold mb-0">{{ Str::upper($tasker->tasker_firstname . ' ' . $tasker->tasker_lastname) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_one) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_two) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_poscode . ' ' . $tasker->tasker_address_area) }}
                </p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_state) }}</p>
            </div>
            <div class="col-6 text-end">
                <p><strong>Statement Date:</strong> {{ $todayDate }}</p>
            </div>
        </div>

        <!-- Booking Summary Table -->
        <h6 class="fw-bold">Transaction Details</h6>
        <hr>
        <div class="row mb-3 mt-3">
            <div class="col-6">
                <p class="fw-bold mb-0">Bank Name</p>
                <p class="mb-0">{{ $tasker->tasker_account_bank != '' ? $tasker->tasker_account_bank : '-' }}</p>
            </div>
            <div class="col-6 text-end">
                <p class="fw-bold mb-0">Account No</p>
                <p class="mb-0">{{ $tasker->tasker_account_number != '' ? $tasker->tasker_account_number : '-' }}</p>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Booking Date</th>
                    <th>Description</th>
                    <th> - </th>
                    <th> +</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataBooking as $b)
                    <tr>
                        <td>{{ $b->booking_date }}</td>
                        <td>
                            <p class="mb-1 mt-0 fw-bold">{{ $b->booking_order_id }}</p>
                            <p class="mb-0 mt-0">{{ $b->booking_address }}</p>
                            @if ($b->booking_status == 6)
                                <p class="text-muted mb-0 mt-0">Completed</p>
                            @elseif($b->booking_status == 5)
                                <p class="text-muted mb-0 mt-0">Cancelled</p>
                            @elseif($b->booking_status == 8)
                                <p class="text-muted mb-0 mt-0">Refunded</p>
                            @endif
                        </td>

                        <td>
                            @if ($b->booking_status == 5)
                                {{ $b->booking_rate }}
                            @elseif($b->booking_status == 8)
                               {{ $b->booking_rate }}
                            @endif
                        </td>
                        <td>
                            @if ($b->booking_status == 6)
                                {{ $b->booking_rate }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="table-summary">
                    <td colspan="2" class="text-end">Total Uncredited Amount (RM)</td>
                    <td class="text-danger">{{ $totalUnCredit }}</td>
                    <td class="credit"></td>

                </tr>
                <tr class="table-summary">
                    <td colspan="2" class="text-end">Total Amount to Be Credited for {{ $statement_dateMY }} (RM)</td>
                    <td class="credit"></td>

                    <td class="text-success">{{ $totalCredit }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>This document is autogenerated by the system. No signature is required.</p>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
</body>

</html>
