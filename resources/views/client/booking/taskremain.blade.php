
@extends('client.layouts.main')

@section('content')
    <!-- [ Main Content ] start -->

    
    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>

    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
            <h2 class="fw-bold">My Task</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs mb-3 fw-bold border-bottom border-3 light-primary" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home"
                        role="tab" aria-controls="home" aria-selected="true">ALL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">On Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                        aria-controls="contact" aria-selected="false">Completed</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Cleaning</h6>
        
                            <span>In Progress</span>
   
                    </div>
                    <hr>
                    <div class="d-flex">
                        <img src="path-to-product-image.jpg" alt="Product Image" class="img-thumbnail"
                            style="width: 100px; height: auto;">
                        <div class="ms-3">
                            <p class="mb-1 fw-bold">ISKANDAR ZULKANAIN BIN ROSMI</p>
                            <p class="mb-1">x1</p>
                            <p class="mb-0">RM60 / per job</p>
                            <p class="mb-0">8.00 A.M - 10.00 A.M</p>

                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        
                        <span class="text-muted">Jalan Kemboja 4cTaman Kemboja, 48300 Rawang, Selangor</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Order Total: <span class="text-danger">RM66.88</span></span>
                        <div>
                            <button class="btn btn-danger btn-sm">Cancel Booking</button>

                            <button class="btn btn-outline-secondary btn-sm">Contact Seller</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Baseus Official Store</h6>
                            <div>
                                <button class="btn btn-outline-primary btn-sm">Chat</button>
                                <button class="btn btn-outline-secondary btn-sm">View Shop</button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="path-to-product-image.jpg" alt="Product Image" class="img-thumbnail"
                                style="width: 100px; height: auto;">
                            <div class="ms-3">
                                <p class="mb-1 fw-bold">Baseus AT Car Vacuum Cleaner 45W 5000Pa Sweep Dust</p>
                                <p class="mb-1">Variation: Black</p>
                                <p class="mb-0">x1</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Confirm receipt after you've checked the received items</span>
                            <div>
                                <span class="text-decoration-line-through text-muted me-2">RM239.00</span>
                                <span class="fw-bold text-danger">RM92.44</span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Order Total: <span class="text-danger">RM66.88</span></span>
                            <div>
                                <button class="btn btn-warning btn-sm">Order Received</button>
                                <button class="btn btn-outline-secondary btn-sm">Request For Return/Refund</button>
                                <button class="btn btn-outline-secondary btn-sm">Contact Seller</button>
                            </div>
                        </div>
                    </div>

                </div>



            </div> --}}
    {{-- <!-- Header -->
            <div class="md-12 sm-12">
                
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
            </div> --}}




    <!-- [ Form Register ] end -->
    <!-- Required Js -->
   






    <!-- [ footer apps ] start -->
@section('footer')
    @include('client.layouts.footer')
@endsection
<!-- [ footer apps ] End -->
