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

        .table-statement th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #dee2e6;
        }

        .table-statement td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .table-statement .table-summary td {
            background-color: #f8f9fa;
            font-weight: bold;
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
                <img src="https://www.servenow.com.my/assets/images/logo-test.png" class="img-fluid"
                    style="max-height: 100px;" alt="logo" />
                {{-- <h5 class="fw-bold">ServeNow Sdn Bhd</h5>
                <p>Jalan Hang Tuah Jaya, 76100 Durian Tunggal, Melaka</p> --}}
            </div>
            <div class="col-6 text-end">
                <h2 class="fw-bold">e-Statement</h2>
            </div>
        </div>
        <hr>

        <!-- Statement Details -->
        <div class="row mb-5 justify-content-between">
            <div class="col-6">
                <p class="fw-bold mb-0">{{ Str::upper($tasker->tasker_firstname . ' ' . $tasker->tasker_lastname) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_one) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_two) }}</p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_poscode . ' ' . $tasker->tasker_address_area) }}
                </p>
                <p class="mb-0">{{ Str::upper($tasker->tasker_address_state) }}</p>
            </div>
            <div class="col-6 text-end">
                <table style="width:100%">
                    <tr>
                        <td><p class="mb-0">Statement Date</p></td>
                        <td>:</td>
                        <td><p class="mb-0">{{ $todayDate }}</p></td>

                    </tr>
                    <tr>
                        <td><p class="mb-0">Total Credit Amount</p></td>
                        <td>:</td>
                        <td><p class="mb-0">RM {{ number_format($totalCredit,2) }}</p></td>
                    </tr>
                    <tr>
                        <td><p class="mb-0">Total Debit Amount</p></td>
                        <td>:</td>
                        <td><p class="mb-0">RM {{ number_format($totalUnCredit,2) }}</p></td>
                    </tr>
                    <tr>
                        <td><p class="mb-0">Number of Transactions</p></td>
                        <td>:</td>
                        <td><p class="mb-0">{{ $totalTransaction }}</p></td>
                    </tr>
                </table>
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
        <table class="table table-bordered table-statement">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Date</th>
                    <th>Description</th>
                    <th> - </th>
                    <th> + </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataBooking as $b)
                    <tr>
                        <td style="vertical-align: top; text-align: left;">
                            {{ Carbon\Carbon::parse($b->booking_date)->format('d/m/Y') }}
                        </td>
                        <td style="vertical-align: top; text-align: left;">
                            <p class="mb-0 fw-bold">{{ $b->booking_order_id }}</p>
                            <p class="mb-0 fst-italic">
                                {{ Str::headline($b->client_firstname . ' ' . $b->client_lastname) }}</p>
                            @if ($b->booking_status == 6)
                                <p class="mb-0">Completed</p>
                            @elseif ($b->booking_status == 7)
                                <p class="mb-0">Refund in Progress</p>
                            @elseif($b->booking_status == 5)
                                <p class="mb-0">Cancelled</p>
                            @elseif($b->booking_status == 8)
                                <p class="mb-0">Refunded</p>
                            @endif
                        </td>
                        <td style="vertical-align: top; text-align: right;">
                            @if ($b->booking_status == 5 || $b->booking_status == 7 || $b->booking_status == 8)
                                {{ $minusNumber = number_format($b->booking_rate, 2) }}
                            @endif
                        </td>
                        <td style="vertical-align: top; text-align: right;">
                            @if ($b->booking_status == 6)
                                {{ $addnumber = number_format($b->booking_rate, 2) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="table-summary fw-bold">
                    <td colspan="2" class="text-end">Total Amount (RM)</td>
                    <td class="text-danger" style="text-align: right;">{{ number_format($totalUnCredit, 2) }}</td>
                    <td class="text-success" style="text-align: right;">{{ number_format($totalCredit, 2) }}</td>
                </tr>
                <tr class="table-summary fw-bold">
                    <td colspan="2" class="text-end">System Charges ({{ $system_charges_rate }}%)</td>
                    <td></td>
                    <td class="text-danger" style="text-align: right;">(-) {{ number_format($system_charges, 2) }}</td>
                </tr>
                <tr class="table-summary fw-bold">
                    <td colspan="2" class="text-end">Total Amount to be Credited for {{ $statement_dateMY }} (RM)
                    </td>
                    <td></td>
                    <td class="text-dark" style="text-align: right;">{{ number_format($totalToBeCredited, 2) }}</td>
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
