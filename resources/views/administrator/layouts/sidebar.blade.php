<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="../assets/images/logo-test.png" class="img-fluid" width="140" height="70" alt="logo" />
            </a>
        </div>
        <div class="navbar-content">
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . auth()->user()->admin_photo) }}" alt="Profile Photo"
                                width="45" height="45" class="user-avtar wid-45 rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0">{{ explode(' ', Auth::user()->admin_firstname)[0] }}.</h6>
                            <small>Administrator</small>
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
                            <a href="{{ route('admin-profile') }}">
                                <i class="ti ti-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="{{ route('admin-logout') }}">
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
                    <a href="{{ route('admin-home') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-home pc-icon "></i> 
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Administrator</label>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-users-cog pc-icon "></i> 
                        </span>
                        <span class="pc-mtext">Users</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-management') }}">Administrator Management</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-client-management') }}">Client Management</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-tasker-management') }}">Tasker Management</a></li>
                    </ul>
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
                        <li class="pc-item"><a class="pc-link"
                                href="{{ route('admin-service-type-management') }}">Service Type </a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-service-management') }}">Service
                                Management</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-calendar-alt pc-icon "></i> 
                        </span>
                        <span class="pc-mtext">Bookings</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-booking-list') }}">Booking List</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-refunded-list') }}">Refund Booking List</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-refund-request') }}">Refund Request</a></li>

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
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-review-management') }}">Review Management</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-tasker-performance') }}">Tasker Performance</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-cogs pc-icon "></i> 
                        </span>
                        <span class="pc-mtext">Setting</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-system-setting') }}">System</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('admin-timeslot-setting') }}">Time Slot</a></li>
                    </ul>
                </li>

            </ul>
            <!-- SideBar Menu Item End -->
        </div>
    </div>
</nav>
