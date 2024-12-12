<?php
use Illuminate\Support\Str;
use App\Models\Tasker;
?>
@extends('client.layouts.main')

@section('content')
    <!-- [ Main Content ] start -->

    <style>
        .table-primary {
            background-color: #e3f2fd !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f8ff;
        }

        .badge-primary {
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9ecef;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            /* Default text color (Bootstrap secondary) */
            border-color: transparent;
            /* Default border color */
            transition: color 0.3s, background-color 0.3s;
        }

        /* Hover effect */
        .nav-tabs .nav-link:hover {
            color: #0d6efd;
            /* Primary color on hover */
            background-color: #f8f9fa;
            /* Light background on hover */
        }

        /* Active tab styles */
        .nav-tabs .nav-link.active {
            color: #fff;
            /* White text */
            background-color: #0d6efd;
            /* Primary background color */
            border-color: #0d6efd;
            /* Primary border color */
        }

        .table-primary:hover {
            background-color: #dbe9ff;
            /* Light blue background on hover */
        }

        /* Focus effect when clicked */
        .table-primary:focus-within {
            background-color: #a6c8ff;
            /* Slightly darker blue when focused */
            box-shadow: 0 0 10px rgba(66, 133, 244, 0.5);
            /* Add a glow effect to indicate focus */
        }
    </style>

    <div class="container p-5">


        <!-- [ Pre-loader ] start -->
        <div class="page-loader">
            <div class="bar"></div>
        </div>

        <div class="container mt-5">
            <!-- Header -->
            <div class="md-12 sm-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">My Task</h2>
                    <div>
                        <button class="btn btn-primary">+ New Task</button>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active fw-bold border-0 border-bottom border-3" href="#upcoming-tasks"
                        data-bs-toggle="tab">
                        Upcoming Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold border-0 border-bottom border-3" href="#completed-tasks"
                        data-bs-toggle="tab">
                        Completed Tasks
                    </a>
                </li>
            </ul>


            <!-- Filters -->
            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">

                <span class="badge bg-primary rounded-pill px-3 py-2">2 Task</span>
                <select class="form-select w-auto" aria-label="Filter by person">
                    <option selected>--Selected--</option>
                    <option value="1">This Week</option>
                    <option value="2">Today</option>
                </select>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="completedTasks">
                    <label class="form-check-label" for="completedTasks">Completed tasks</label>
                </div>
            </div>

            <!-- Task Table -->
            <div class="tab-content">
                <!-- Upcoming Tasks Tab -->
                <div class="tab-pane fade show active" id="upcoming-tasks">
                    <div class="table-responsive shadow-sm rounded border border-4 overflow-auto">
                        <table class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Person</th>
                                    <th>Estimate</th>
                                    <th>Workload</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>ETA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Tasks for Zikri Bin Kashim -->
                                <tr class="table-primary" data-bs-toggle="collapse" data-bs-target="#details-zikri"
                                    aria-expanded="false" style="cursor: pointer;" tabindex="0">
                                    <td class="fw-bold">
                                        <div class="d-flex align-items-center gap-2">
                                            <span>Zikri Bin Kashim</span>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="collapse" id="details-zikri">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <span>Cleaning</span>
                                        </div>
                                    </td>
                                    <td>2h</td>
                                    <td>13h 30m remain</td>
                                    <td>10 A.M</td>
                                    <td>12 P.M</td>
                                    <td><span class="badge bg-success">On schedule</span></td>
                                </tr>

                                <!-- Tasks for Iskandar Zulkarnain -->
                                <tr class="table-primary" data-bs-toggle="collapse" data-bs-target="#details-iskandar"
                                    aria-expanded="false" style="cursor: pointer;" tabindex="0">
                                    <td class="fw-bold">
                                        <div class="d-flex align-items-center gap-2">
                                            <span>Iskandar Zulkarnain</span>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="collapse" id="details-iskandar">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <span>Mounting</span>
                                        </div>
                                    </td>
                                    <td>1h</td>
                                    <td>6h remain</td>
                                    <td>2 P.M</td>
                                    <td>3 P.M</td>
                                    <td><span class="badge bg-success">On schedule</span></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>

                <!-- Completed Tasks Tab -->
                <div class="tab-pane fade" id="completed-tasks">
                    <div class="table-responsive shadow-sm rounded border border-4 overflow-auto">
                        <table class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Person</th>
                                    <th>Estimate</th>
                                    <th>Workload</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>ETA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Completed Tasks -->
                                <tr class="table-primary">
                                    <td class="fw-bold">
                                        <div class="d-flex align-items-center gap-2">
                                            <span>Completed Person Name</span>
                                        </div>
                                    </td>
                                    <td>1h</td>
                                    <td>Completed</td>
                                    <td>9 A.M</td>
                                    <td>10 A.M</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>




        <!-- [ Form Register ] end -->
        <!-- Required Js -->
        <script>
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach((row) => {
                row.addEventListener('click', () => {
                    const target = document.querySelector(row.getAttribute('data-bs-target'));
                    const isExpanded = row.getAttribute('aria-expanded') === 'true';
                    row.setAttribute('aria-expanded', !isExpanded);
                });
            });
        </script>

     

    
    </div>

    <!-- [ footer apps ] start -->
@section('footer')
    @include('client.layouts.footer')
@endsection
<!-- [ footer apps ] End -->
