<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header d-flex  align-items-center justify-content-center">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="../assets/images/logo-test-whites.png" class="img-fluid" width="140" height="70"
                    alt="logo" />
            </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . auth()->user()->tasker_photo) }}" alt="Profile Photo"
                                width="45" height="45" class="user-avtar wid-45 rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0">{{ explode(' ', Auth::user()->tasker_firstname)[0] }}.</h6>
                            <small>Tasker</small>
                        </div>
                        <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse"
                            href="#pc_sidebar_userlink">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sort-outline"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                        <div class="pt-3">
                            <a href="{{ route('tasker-profile') }}">
                                <i class="ti ti-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="{{ route('tasker-logout') }}">
                                <i class="ti ti-power"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SideBar Menu Item Start -->
            <ul class="pc-navbar">

                <li class="pc-item pc-caption">
                    <label>Main</label>
                </li>
                <li class="pc-item">
                    <a href="{{ route('tasker-home') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-home pc-icon "></i>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Manager</label>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-hammer pc-icon "></i>
                        </span>
                        <span class="pc-mtext">Services</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-service-enrollment') }}">Service
                                Enrollment</a></li>
                    </ul>
                </li>


                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-calendar-check pc-icon "></i>
                        </span>
                        <span class="pc-mtext">Bookings</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-booking-management') }}">My
                                Booking</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-booking-list') }}">Booking
                                List</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-refund-booking-list') }}">Refund
                                Booking List</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-tachometer-alt pc-icon "></i>
                        </span>
                        <span class="pc-mtext">Performance</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-review-management') }}">Review
                                Management</a></li>
                        <li class="pc-item"><a class="pc-link"
                                href="{{ route('tasker-performance-analysis') }}">Performance Analysis</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-caption">
                    <label>Finance</label>
                </li>

                <li class="pc-item">
                    <a href="{{ route('tasker-e-statement') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-file-invoice-dollar pc-icon "></i>
                        </span>
                        <span class="pc-mtext">e-Statement</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Tasker Setting</label>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-cogs pc-icon "></i>
                        </span>
                        <span class="pc-mtext">Task Preferences</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link"
                                href="{{ route('tasker-preferences') }}">Preferences</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('tasker-timeslot-setting') }}">Time
                                Slot</a></li>
                    </ul>
                </li>

            </ul>
            <!-- SideBar Menu Item End -->
        </div>
    </div>
</nav>
