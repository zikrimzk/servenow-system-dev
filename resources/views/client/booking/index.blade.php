@extends('client.layouts.main')

<style>
    /* .calendar-container {
        padding: 16px;
        max-width: 400px;
        margin: auto;
        background-color: #fff;
       
    }

    .calendar-container label {
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    } */

    .info {
        margin-top: 20px;
    }

    .info p {
        margin: 5px 0;
        font-size: 14px;
    }

    .info .btn {
        margin-top: 10px;
    }
</style>





@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container mb-5">
        <div class="pc-content">
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-8 col-md-12">
                    <div id="basicwizard" class="form-wizard row justify-content-center mx-3 my-1">
                        <div class="col-sm-8 col-md-12">
                            <h1 class="my-3 my-md-0">{{ $sv->servicetype_name }}</h1>

                            <div class="alert alert-primary mt-3 mb-4">
                                <div class="d-flex">
                                    <i class="ti ti-edit h2 f-w-400 mb-0 text-primary"></i>
                                    <div class="flex-grow-1 ms-3">
                                        Describe your task in detail to help us match you with the best service providers in
                                        your area. Be as specific as possible about what you need, including any special
                                        requirements or preferences.
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8 col-md-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item" data-target-form="#contactDetailForm">
                                            <a href="#contactDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link active ">
                                                <i class="fas fa-location-arrow"></i>
                                                <span class="d-none d-sm-inline">Location</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#jobDetailForm">
                                            <a href="#jobDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="fas fa-user-tag"></i>
                                                <span class="d-none d-sm-inline">Tasker Selection</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item" data-target-form="#educationDetailForm">
                                            <a href="#educationDetail" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="fas fa-money-check-alt"></i>
                                                <span class="d-none d-sm-inline">Payment</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                        <li class="nav-item">
                                            <a href="#finish" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link icon-btn">
                                                <i class="fas fa-check-circle"></i>
                                                <span class="d-none d-sm-inline">Finish</span>
                                            </a>
                                        </li>
                                        <!-- end nav item -->
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- START: Define your progress bar here -->
                                        <div id="bar" class="progress mb-3" style="height: 7px">
                                            <div
                                                class="bar progress-bar progress-bar-striped progress-bar-animated bg-primary">
                                            </div>
                                        </div>
                                        <!-- END: Define your progress bar here -->

                                        <!-- START: Define your tab pans here -->
                                        <div class="tab-pane show active" id="contactDetail">
                                            <div class="text-center mb-4 mt-4">
                                                <h2 class="mb-1">Please Provide Your Preferred Location</h2>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <!-- Default Address Checkbox -->
                                                        <div class="col-sm-12">
                                                            <div class="mb-3 mt-5">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="defaultCheckbox" value="1"
                                                                    onclick="toggleAddressFields()">
                                                                <label class="form-check-label"
                                                                    for="defaultCheckbox">Default Address</label>
                                                            </div>
                                                        </div>
                                                        <!-- Address Fields -->
                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label">Address 1</label>
                                                            <input type="text" class="form-control" id="address1"
                                                                placeholder="Enter Address" name="address1" />
                                                        </div>

                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label">Address 2</label>
                                                            <input type="text" class="form-control" id="address2"
                                                                placeholder="Enter Address" name="address2" />
                                                        </div>
                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label">Postcode</label>
                                                            <input type="text" class="form-control" id="postcode"
                                                                placeholder="Postcode" name="postcode" />
                                                        </div>
                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label">State:</label>
                                                            <select name="client_state" class="form-control" id="state">
                                                                <option value="" selected>Select State</option>
                                                                @foreach ($states['states'] as $state)
                                                                    <option value="{{ strtolower($state['name']) }}">
                                                                        {{ $state['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label">Area <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="client_area"
                                                                class="form-control @error('client_area') is-invalid @enderror"
                                                                id="addCity">
                                                                <option value="" selected>Select Area
                                                                </option>
                                                            </select>
                                                            @error('client_area')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end contact detail tab pane -->




                                        <!-- START: Define your tab pans here -->
                                        <div class="tab-pane" id="jobDetail">

                                            <div class="text-center mb-4 mt-4">
                                                <h2 class="mb-1">Select Your Tasker</h2>
                                            </div>

                                            <!--Tasker Selection-->
                                            @foreach ($tasker as $tk)
                                                <div class="card m-2 border border-0 mb-5">
                                                    <!--Image Tasker Section [Start]-->
                                                    <div class="row mt-4">

                                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <img src="{{ asset('storage/' . $tk->tasker_photo) }}"
                                                                    alt="Profile Photo" width="150" height="150"
                                                                    class="user-avtar rounded-circle">

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                                            <div class="p-3">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <h5 class="mb-2 f-24">
                                                                        {{ explode(' ', $tk->tasker_firstname)[0] }}.
                                                                    </h5>
                                                                    <h5 class="mb-2">RM
                                                                        {{ $tk->service_rate }}/{{ $tk->service_rate_type }}
                                                                    </h5>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <span class="badge bg-success text-white me-2">GREAT
                                                                        VALUE</span>
                                                                    <span class="badge text-bg-primary text-dark">2
                                                                        HOUR
                                                                        MINIMUM</span>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1">
                                                                        <span class="fw-bold">★ 4.9</span> (394
                                                                        reviews)
                                                                    </p>
                                                                    <p class="mb-1">N/A Cleaning tasks</p>
                                                                    <p class="mb-0 text-muted">N/A Cleaning tasks
                                                                        overall
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row flex-sm-row  flex-column-reverse">
                                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                                            <div class="d-none d-md-block text-center mt-2 mb-2">
                                                                <a href="" class=" mb-2  primary p-1">View
                                                                    Profile & Review
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="d-grid d-md-flex justify-content-md-center align-items-md-center ">
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#selectdatetime-{{ $tk->taskerID }}">Select
                                                                    &
                                                                    Continue</button>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-9 col-lg-9">
                                                            <div class=" bg-light p-3">
                                                                <h4> How I can help:</h4>
                                                                <p class="text-muted fw-normal f-16">
                                                                    {{ $tk->service_desc }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="/TEST" method="POST">
                                                    <div id="selectdatetime-{{ $tk->taskerID }}" class="modal fade"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLiveLabel">
                                                                        Plan Your Task with
                                                                        {{ explode(' ', $tk->tasker_firstname)[0] }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>

                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <input type="hidden" name="booking_address"
                                                                                id="booking_address" class="form-control">
                                                                            <label class="mb-2"> Service
                                                                                Options</label>
                                                                            <select id="task-option" class="form-control"
                                                                                onchange="updateHours()">
                                                                                <option value="" selected>Select
                                                                                    Options</option>
                                                                                <option value="s">Small</option>
                                                                                <option value="m">Medium</option>
                                                                                <option value="l">Large</option>
                                                                            </select>
                                                                        </div>

                                                                        <label class="mb-2">Est. hour(s)</label>
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="row mb-3">
                                                                                <div class="col-sm-12" id="hours-options">
                                                                                    <!-- Radio Buttons -->
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="1" id="hour1"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour1">1</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="2" id="hour2"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour2">2</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="3" id="hour3"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour3">3</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="4" id="hour4"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour4">4</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="5" id="hour5"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour5">5</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check form-check-inline">
                                                                                        <input class="form-check-input"
                                                                                            type="radio" name="group5"
                                                                                            value="6" id="hour6"
                                                                                            disabled />
                                                                                        <label class="form-check-label"
                                                                                            for="hour6">6</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="task-date"
                                                                                class="mb-2">Availability</label>
                                                                            <input type="text" id="task-date"
                                                                                class="form-control"
                                                                                placeholder="Choose Date">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="task-time"
                                                                                class="mb-2">Time</label>
                                                                            <select id="task-time" class="form-control">
                                                                                @foreach ($time->where('tasker_id', $tk->taskerID) as $t)
                                                                                    <option value="{{ $t->time }}">
                                                                                        {{ $t->time }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-grid mt-4 mb-2 ">
                                                                        <button type="submit"
                                                                            class="btn btn-primary ">Select
                                                                            & Continue</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endforeach
                                            <!-- Tasker Selection [End] -->
                                        </div>
                                        <!-- end job detail tab pane -->



                                        <!-- START: Define your tab pans here -->
                                        <div class="tab-pane" id="educationDetail">
                                            <form id="educationForm" method="post" action="#">
                                                <div class="text-center">
                                                    <h3 class="mb-2">Special Request </h3>
                                                    <small class="text-muted">Let Tasker know did you need add some note
                                                        for them.</small>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="schoolName">Special
                                                                Request:</label>
                                                            <input type="text" class="form-control" id="schoolName"
                                                                placeholder="Special Request" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="container mt-5">
                                                    <h3 class="mb-4">Payment</h3>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="list-group" id="payment-options">
                                                                <button
                                                                    class="list-group-item list-group-item-action active"
                                                                    data-bs-toggle="tab" data-bs-target="#credit-card">
                                                                    Credit Card
                                                                </button>
                                                                <button
                                                                    class="list-group-item list-group-item-action"href="#"
                                                                    data-bs-toggle="tab">
                                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/PayPal_logo.svg/2560px-PayPal_logo.svg.png"
                                                                        style="height: 20px;" id="paypal">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade show active" id="credit-card">
                                                                    <h5>Amount being paid now: <strong>RM50.00</strong></h5>
                                                                    <form>
                                                                        <div class="mb-3">
                                                                            <label for="cardholder-name"
                                                                                class="form-label">Cardholder's
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="cardholder-name"
                                                                                placeholder="Enter your name">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="card-number"
                                                                                class="form-label">Card Number</label>
                                                                            <input type="text" class="form-control"
                                                                                id="card-number"
                                                                                placeholder="1234 5678 9012 3456">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label for="expiration-date"
                                                                                    class="form-label">Expiration
                                                                                    Date</label>
                                                                                <div class="d-flex">
                                                                                    <select class="form-select me-2"
                                                                                        id="expiration-month">
                                                                                        <option>01</option>
                                                                                        <option>02</option>
                                                                                        <option>03</option>
                                                                                    </select>
                                                                                    <select class="form-select"
                                                                                        id="expiration-year">
                                                                                        <option>2023</option>
                                                                                        <option>2024</option>
                                                                                        <option>2025</option>

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="cvv"
                                                                                    class="form-label">CVV Code</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="cvv" placeholder="123">
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="tab-pane fade" id="paypal">
                                                                    <h5>PayPal</h5>
                                                                    <p>Redirecting you to PayPal...</p>
                                                                </div>
                                                                <div class="tab-pane fade" id="pay-later">
                                                                    <h5>Pay Later</h5>
                                                                    <p>Select this option to defer payment.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end education detail tab pane -->

                                        <!-- START: Define your tab pans here -->
                                        <div class="tab-pane" id="finish">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="text-center">
                                                        <i class="ph-duotone ph-gift f-50 text-danger"></i>
                                                        <h3 class="mt-4 mb-3">Thank you !</h3>
                                                        <div class="mb-3">
                                                            <div class="form-check d-inline-block">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheck1" />
                                                                <label class="form-check-label" for="customCheck1">I agree
                                                                    with
                                                                    the Terms and Conditions</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end col -->
                                            </div>
                                            <!-- end row -->


                                        </div>
                                        <!-- END: Define your tab pans here -->

                                        <!-- START: Define your controller buttons here-->
                                        <div class="d-flex justify-content-between mt-3">
                                            <button class="btn btn-secondary" id="prevButton"
                                                onclick="navigateTabs('prev')">Back to Previous</button>
                                            <button class="btn btn-primary" id="nextButton"
                                                onclick="navigateTabs('next')">Next Step</button>
                                        </div>
                                        <!-- END: Define your controller buttons here-->
                                    </div>
                                </div>
                            </div>
                            <!-- end tab content-->
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
        </div>
    </div>


    <script>
        function updateBookingAddress() {
            // Ambil nilai dari setiap medan
            const address1 = document.getElementById('address1').value.trim();
            const address2 = document.getElementById('address2').value.trim();
            const postcode = document.getElementById('postcode').value.trim();
            const state = document.getElementById('state').value.trim();
            const area = document.getElementById('addCity').value.trim();

            // Gabungkan nilai-nilai tersebut
            const fullAddress = `${address1}, ${address2}, ${area}, ${state}, ${postcode}`.replace(/(, )+/g, ', ').replace(
                /, $/, '');

            // Masukkan hasil gabungan ke dalam medan `booking_address`
            document.getElementById('booking_address').value = fullAddress;
        }

        // Tambahkan event listener pada medan alamat
        document.addEventListener('DOMContentLoaded', function() {
            const addressFields = ['address1', 'address2', 'postcode', 'state', 'addCity'];

            addressFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', updateBookingAddress); // Update address on input change
                }
            });
        });

        function updateHours() {
            const option = document.getElementById('task-option').value;

            const radios = [{
                    id: 'hour1',
                    range: ['s']
                },
                {
                    id: 'hour2',
                    range: ['s']
                },
                {
                    id: 'hour3',
                    range: ['m']
                },
                {
                    id: 'hour4',
                    range: ['m']
                },
                {
                    id: 'hour5',
                    range: ['l']
                },
                {
                    id: 'hour6',
                    range: ['l']
                }
            ];

            radios.forEach(radio => {
                const el = document.getElementById(radio.id);
                if (radio.range.includes(option)) {
                    el.disabled = false;
                } else {
                    el.disabled = true;
                    el.checked = false;
                }
            });
        }
    </script>

    <script>
        // DEFAULT ADDRESS
        function toggleAddressFields() {
            const checkbox = document.getElementById('defaultCheckbox');

            // Fields
            const address1 = document.getElementById('address1');
            const address2 = document.getElementById('address2');
            const postcode = document.getElementById('postcode');
            const state = document.getElementById('state');
            const city = document.getElementById('addCity'); // Corrected ID

            if (checkbox.checked) {
                // Set default values (ensure these are passed from server-side to JavaScript)
                address1.value = "{{ $client->client_address_one ?? '' }}";
                address2.value = "{{ $client->client_address_two ?? '' }}";
                postcode.value = "{{ $client->client_postcode ?? '' }}";
                state.value = "{{ strtolower($client->client_state ?? '') }}";
                city.innerHTML =
                    `<option value="{{ $client->client_area ?? '' }}" selected>{{ $client->client_area ?? '' }}</option>`;

                // Lock fields
                address1.disabled = true;
                address2.disabled = true;
                postcode.disabled = true;
                state.disabled = true;
                city.disabled = true;

                // Trigger state change
                $('#state').trigger('change');
                $('#booking_address').val(address1.value + ', ' + address2.value + ', ' + city.value + ', ' + state.value +
                    ' ' + postcode.value);
            } else {
                // Clear fields
                address1.value = "";
                address2.value = "";
                postcode.value = "";
                state.value = "";
                city.innerHTML = '<option value="" selected>Select Area</option>';

                // Unlock fields
                address1.disabled = false;
                address2.disabled = false;
                postcode.disabled = false;
                state.disabled = false;
                city.disabled = false;

                $('#booking_address').val('');

            }
        }

        // FLATPICKER : CALANDER
        document.addEventListener('DOMContentLoaded', function() {
            // Get today's date
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD

            // Initialize Flatpickr
            flatpickr("#task-date", {
                enableTime: false, // Disable time selection
                minDate: "today", // Start from today
                maxDate: new Date(new Date().setDate(today.getDate() +
                    7)), // Set max date to one week from today
                inline: false, // Do not display the calendar inline
                defaultDate: formattedToday, // Set default date to today
                onChange: function(selectedDates, dateStr, instance) {
                    // Update the display with the selected date
                    document.getElementById('selected-date').textContent = dateStr;
                }
            });

            // Set the initial display to today's date
            document.getElementById('selected-date').textContent = formattedToday;
        });


        // AJAX : STATE 
        $('#state').on('change', function() {
            var state = $(this).val();
            if (state) {
                $.ajax({
                    url: '/get-areas/' + state, // Ensure this matches the route
                    type: 'GET',
                    success: function(data) {
                        $('#addCity').empty().append(
                            '<option value="">Select Area</option>');
                        $.each(data, function(index, area) {
                            $('#addCity').append('<option value="' + area + '">' +
                                area + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching areas: " +
                            error); // For debugging if request fails
                    }
                });
            } else {
                $('#addCity').empty().append('<option value="">Select Area</option>');
            }
        });

        // PROGRESBAR JS START
        function updateProgressBar(step, totalSteps) {
            const progressBar = document.querySelector('.bar');
            const progress = (step / totalSteps) * 100; // Kira peratus kemajuan
            progressBar.style.width = progress + '%'; // Set lebar progress bar
        }

        function navigateTabs(direction) {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const activeTab = document.querySelector('.nav-pills .nav-link.active');
            let currentIndex = Array.from(tabs).indexOf(activeTab);

            // Tentukan indeks baru
            let newIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;

            // Pastikan indeks baru berada dalam jangkauan
            if (newIndex >= tabs.length) {
                newIndex = 0; // Kembali ke tab pertama
            } else if (newIndex < 0) {
                newIndex = tabs.length - 1; // Pergi ke tab terakhir
            }

            // Klik tab baru
            tabs[newIndex].click();
            updateProgressBar(newIndex + 1, tabs.length);
        }

        function updateButtons() {
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            const activeTab = document.querySelector('.nav-pills .nav-link.active');
            const currentIndex = Array.from(tabs).indexOf(activeTab);

            // Butang navigasi
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');

            // Aktifkan/Nonaktifkan butang "Prev"
            prevButton.disabled = currentIndex === 0;

            if (currentIndex === 1) { // Semak jika pengguna berada pada tab Alamat (indeks 1)
                const address1 = document.getElementById('address1').value.trim();
                const address2 = document.getElementById('address2').value.trim();
                const postcode = document.getElementById('postcode').value.trim();
                const state = document.getElementById('state').value.trim();
                const area = document.getElementById('addCity').value.trim();

                // Semak jika semua medan alamat diisi
                const isAddressValid = address1 !== "" && postcode !== "" && state !== "" && area !== "";

                // Aktifkan butang "Next" hanya jika medan alamat diisi
                nextButton.disabled = !isAddressValid;
            } else {
                nextButton.disabled = currentIndex === tabs.length - 1; // Normal behavior for other tabs
            }

            updateProgressBar(currentIndex + 1, tabs.length);
        }

        // Pastikan fungsi ini dipanggil pada setiap perubahan input di medan borang alamat
        function attachAddressFieldListeners() {
            const addressFields = ['address1', 'postcode', 'state', 'addCity'];

            addressFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', updateButtons); // Panggil `updateButtons` pada perubahan input
                }
            });
        }

        // Tambahkan pendengar acara apabila DOM telah dimuat

        // Tambahkan pendengar acara untuk mengesan perubahan input

        document.addEventListener('DOMContentLoaded', () => {
            // Pastikan butang dan progress bar disesuaikan pada pemuatan halaman
            updateButtons();
            attachAddressFieldListeners();

            // Dengarkan event perubahan tab Bootstrap
            const tabs = document.querySelectorAll('.nav-pills .nav-link');
            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', () => {
                    updateButtons();
                });
            });
        });
        // PROGRESBAR JS END
    </script>








    <!-- [ Main Content ] end -->
@endsection








<!-- [ footer apps ] start -->
@section('footer')
    @include('client.layouts.footer')
@endsection
<!-- [ footer apps ] End -->
