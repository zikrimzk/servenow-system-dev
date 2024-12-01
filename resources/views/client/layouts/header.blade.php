<!-- Navbar Include  -->
<header id="home" style="background-image: url(../assets/images/landing/img-headerbg.jpg)">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <h1 class="wow fadeInUp" data-wow-delay="0.2s">
                    Welcome {{ explode(' ', Auth::user()->client_firstname)[0] }} !

                </h1>
                <h1 class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    Search Your 
                    <span class="hero-text-gradient">Home Needs</span>

                </h1>
                <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.3s">
                    <div class="col-md-8">
                        <p class="text-muted f-16 mb-0">
                            Trusted Home Services at Your Fingertips.
                        </p>
                    </div>
                </div>
                <!-- [ Text] end -->
                <!-- [ Search-Text] Start -->
                <div class="my-4 my-sm-5 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="container ">
                        <div class="row justify-content-center">
                            <div
                                class="search-bar d-flex align-items-center col-12 col-sm-8 col-md-6 col-lg-3 border border-1 border-dark">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                <input type="text" class="form-control bg-transparent text-grey w-100"
                                    placeholder="What do you need help with?">
                            </div>
                        </div>
                    </div>
                </div>



                <!-- [ Search-Text] End -->
                <!-- [ Highlight Option] Start -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10 text-center">
                            <!-- Buttons with spacing -->
                            <div class="my-2 my-sm-1 d-flex flex-wrap justify-content-center align-items-start gap-2 wow fadeInUp"
                                data-wow-delay="0.4s">
                                @foreach ($service as $sv)
                                    <a href="{{ route('client-booking',$sv->id) }}"
                                        class="btn btn-outline-primary">{{ $sv->servicetype_name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- [ Highlight Option] End -->
        </div>
    </div>

</header>
