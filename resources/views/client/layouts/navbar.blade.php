<!-- [ Nav ] start -->

<style>
    .user-avtar {
        margin: 0 auto;
        /* Gambar profil tetap di tengah */
        display: block;
    }
</style>
{{-- <nav class="navbar navbar-expand-md navbar-light default"style="z-index: 1000;">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
        </a>

        <div>
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <div class=" position-relative">
                        <a href="{{ route('client-profile') }}" class="dropdown-item">
                            <span>
                                <svg class="pc-icon text-muted me-2">
                                    <use xlink:href="#custom-setting-outline"></use>
                                </svg>
                                <span>My Profile</span>
                            </span>
                        </a>
                        <a href="{{ route('client-logout') }}" class="dropdown-item">
                            <span>
                                <svg class="pc-icon text-muted me-2">
                                    <use xlink:href="#custom-share-bold"></use>
                                </svg>
                                <span>Logout</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

            <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item px-1">
                        <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                    </li>
                </ul>
            </div>

        






    </div>
</nav> --}}

{{-- <nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
        </a>

        <!-- User Profile -->
        <div class="d-flex align-items-center ms-auto">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <div class="position-relative">
                        <a href="{{ route('client-profile') }}" class="dropdown-item">
                            <span>
                                <svg class="pc-icon text-muted me-2">
                                    <use xlink:href="#custom-setting-outline"></use>
                                </svg>
                                <span>My Profile</span>
                            </span>
                        </a>
                        <a href="{{ route('client-logout') }}" class="dropdown-item">
                            <span>
                                <svg class="pc-icon text-muted me-2">
                                    <use xlink:href="#custom-share-bold"></use>
                                </svg>
                                <span>Logout</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toggle Button for Mobile View -->
        <button class="navbar-toggler rounded ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>
        
    </div>
</nav> --}}

{{-- <nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container d-flex align-items-center">
        <!-- Menu Collapse Icon and Logo -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="../index.html">
                <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
            </a>
        </div>

        <!-- User Profile -->
        <div class="ms-auto d-flex align-items-center">
            <a class="pc-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <a href="{{ route('client-profile') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-setting-outline"></use>
                            </svg>
                            <span>My Profile</span>
                        </span>
                    </a>
                    <a href="{{ route('client-logout') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-share-bold"></use>
                            </svg>
                            <span>Logout</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}

{{-- <nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container d-flex align-items-center">
        <!-- Mobile: Menu Icon and Logo -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2 d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="../index.html">
                <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
            </a>
        </div>

        <!-- Desktop: Navbar Links (Center) -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-md-flex">
                <li class="nav-item px-3">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>

        <!-- User Profile (Always on the Right) -->
        <div class="ms-auto d-flex align-items-center">
            <a class="pc-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <a href="{{ route('client-profile') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-setting-outline"></use>
                            </svg>
                            <span>My Profile</span>
                        </span>
                    </a>
                    <a href="{{ route('client-logout') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-share-bold"></use>
                            </svg>
                            <span>Logout</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</nav> --}}



{{-- <nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container">
        <!-- Header Section: Logo and Profile Image -->
        <div class="d-flex justify-content-between align-items-center w-100">
            <!-- Collapse Logo -->
            <div class="d-flex align-items-center">
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-flex align-items-center" href="../index.html">
                    <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
                </a>
            </div>

            <!-- Profile Image (Always Visible) -->
            <a class="pc-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
        </div>

        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarMenu">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}

{{-- <nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Left Section: Menu Icon and Logo -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="../index.html">
                <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
            </a>
        </div>

        <!-- Center Section: Navbar Links for Mobile (Hidden on Desktop) -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>

        <!-- Right Section: User Profile (Always on the Right) -->
        <div class="d-flex align-items-center ms-auto">
            <a class="pc-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35"
                    height="35" class="user-avtar wid-35 rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <a href="{{ route('client-profile') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-setting-outline"></use>
                            </svg>
                            <span>My Profile</span>
                        </span>
                    </a>
                    <a href="{{ route('client-logout') }}" class="dropdown-item">
                        <span>
                            <svg class="pc-icon text-muted me-2">
                                <use xlink:href="#custom-share-bold"></use>
                            </svg>
                            <span>Logout</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav> --}}

<nav class="navbar navbar-expand-md navbar-light default" style="z-index: 1000;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Left Section: Menu Icon and Logo -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="../index.html">
                <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
            </a>
        </div>

        <!-- Center Section: Navbar Links (Collapse for Mobile) -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client-home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientBookHistory') }}">My Booking</a>
                </li>
            </ul>
        </div>

    </div>

    <!-- Right Section: User Profile (Fixed Position on the Right) -->
    <div class="position-absolute end-0 top-50 translate-middle-y me-3">
        <a class="pc-head-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
            <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo" width="35" height="35"
                class="user-avtar wid-35 rounded-circle me-3">
        </a>
        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-body">
                <a href="{{ route('client-profile') }}" class="dropdown-item">
                    <span>
                        <svg class="pc-icon text-muted me-2">
                            <use xlink:href="#custom-setting-outline"></use>
                        </svg>
                        <span>My Profile</span>
                    </span>
                </a>
                <a href="{{ route('client-logout') }}" class="dropdown-item">
                    <span>
                        <svg class="pc-icon text-muted me-2">
                            <use xlink:href="#custom-share-bold"></use>
                        </svg>
                        <span>Logout</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>
















































<!-- [ Nav ] start -->
