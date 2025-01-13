<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                {{-- <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ asset('storage/' . auth()->user()->tasker_photo) }}" alt="Profile Photo"
                            class="user-avatar rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . auth()->user()->tasker_photo) }}"
                                            alt="Profile Photo" class="user-avatar rounded-circle"
                                            style="width: 45px; height: 45px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ Auth::user()->tasker_firstname }}</h6>
                                        <span>{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <hr class="border-secondary border-opacity-50" />
                                <p class="text-span">Manage</p>
                                <a href="{{ route('tasker-profile') }}" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-setting-outline"></use>
                                        </svg>
                                        <span>My Profile</span>
                                    </span>
                                </a>
                                <hr class="border-secondary border-opacity-50" />
                                <div class="d-grid mb-3">
                                    <a href="{{ route('tasker-logout') }}" class="btn btn-primary">
                                        <svg class="pc-icon me-2">
                                            <use xlink:href="#custom-logout-1-outline"></use>
                                        </svg>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</header>
