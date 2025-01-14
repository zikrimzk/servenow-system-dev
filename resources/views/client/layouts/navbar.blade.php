<!-- [ Nav ] start -->

<style>
    .user-avtar {
    margin: 0 auto; /* Gambar profil tetap di tengah */
    display: block;
}
</style>
<nav class="navbar navbar-expand-md navbar-light default"style="z-index: 1000;">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/images/logo-test.png" alt="img" class="img-fluid" style="max-width: 110px;" />
        </a>
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
                <li class="nav-item px-1 me-2 mb-2 mb-md-0">
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ asset('storage/' . auth()->user()->client_photo) }}" alt="Profile Photo"
                            width="35" height="35" class="user-avtar wid-35 rounded-circle">
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
                </li>

            </ul>
           
        </div>
    </div>
</nav>
<!-- [ Nav ] start -->
