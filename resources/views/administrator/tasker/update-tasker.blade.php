@extends('administrator.layouts.main')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Users</li>
                                <li class="breadcrumb-item" aria-current="page">Update Tasker Details</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Update Tasker Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Start Alert -->
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                    </path>
                </symbol>

                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                    </path>
                </symbol>
            </svg>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#check-circle-fill"></use>
                    </svg>
                    <div> {{ session('success') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#exclamation-triangle-fill"></use>
                    </svg>
                    <div> {{ session('error') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End Alert -->


            <div class="row mt-2">
                <form action="{{ route('admin-tasker-update', $tasker->id) }}" method="POST">
                    @csrf

                    <div class="row mt-3">
                        <div class="col-sm-3 text-center">
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $tasker->tasker_photo) }}" alt="Profile Photo"
                                    width="150" height="150" class="user-avtar rounded-circle">

                            </div>
                        </div>
                        <div class="col-sm-9">

                            <!-- Personal Details Section -->
                            <h5 class="mb-2">A. Personal Details:</h5>
                            <div class="row">
                                <!-- Tasker Code Field -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tasker Code</label>
                                        <input type="text" class="form-control" name="tasker_code"
                                            value="{{ $tasker->tasker_code }}" readonly />
                                    </div>
                                </div>

                                <!-- First Name Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text"
                                            class="form-control @error('tasker_firstname') is-invalid @enderror"
                                            placeholder="Enter first name" name="tasker_firstname"
                                            value="{{ $tasker->tasker_firstname }}" />
                                        @error('tasker_firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Last Name Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text"
                                            class="form-control @error('tasker_lastname') is-invalid @enderror"
                                            placeholder="Enter last name" name="tasker_lastname"
                                            value="{{ $tasker->tasker_lastname }}" />
                                        @error('tasker_lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- IC Number Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">IC Number</label>
                                        <input type="text"
                                            class="form-control @error('tasker_icno') is-invalid @enderror"
                                            placeholder="Enter IC number" name="tasker_icno"
                                            value="{{ $tasker->tasker_icno }}" />
                                        @error('tasker_icno')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Date of Birth Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control @error('tasker_dob') is-invalid @enderror"
                                            name="tasker_dob" value="{{ $tasker->tasker_dob }}" />
                                        @error('tasker_dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone Number Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+60</span>
                                            <input type="text"
                                                class="form-control @error('tasker_phoneno') is-invalid @enderror"
                                                placeholder="Enter phone number" name="tasker_phoneno"
                                                value="{{ $tasker->tasker_phoneno }}" />
                                        </div>
                                        @error('tasker_phoneno')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter email address" name="email"
                                            value="{{ $tasker->email }}" />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bio Field -->
                                <div class="col-sm-12">
                                    <div class="mb-5">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control @error('tasker_bio') is-invalid @enderror" rows="4" name="tasker_bio"
                                            placeholder="Enter your bio here...">{{ $tasker->tasker_bio }}</textarea>
                                        @error('tasker_bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <!-- Tasker Address Section -->
                            <h5 class="mb-2">B. Tasker Address:</h5>
                            <div class="row">
                                <!-- Address Line 1 Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address Line 1 <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('tasker_address_no') is-invalid @enderror"
                                            name="tasker_address_no" placeholder="Building number and street name"
                                            value="{{ $tasker->tasker_address_no }}" />
                                        @error('tasker_address_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address Line 2 Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address Line 2 <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('tasker_address_road') is-invalid @enderror"
                                            name="tasker_address_road" placeholder="Building name"
                                            value="{{ $tasker->tasker_address_road }}" />
                                        @error('tasker_address_road')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Postal Code Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('tasker_address_poscode') is-invalid @enderror"
                                            name="tasker_address_poscode" placeholder="Enter postal code"
                                            value="{{ $tasker->tasker_address_poscode }}" />
                                        @error('tasker_address_poscode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- State Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <select name="tasker_address_state"
                                            class="form-control @error('tasker_address_state') is-invalid @enderror"
                                            id="addState">
                                            <option value="" selected>Select State</option>
                                            @foreach ($states['states'] as $state)
                                                <option value="{{ strtolower($state['name']) }}"
                                                    {{ strtolower($state['name']) == $tasker->tasker_address_state ? 'selected' : '' }}>
                                                    {{ $state['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('tasker_address_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Area Field -->
                                <div class="col-sm-6">
                                    <div class="mb-5">
                                        <label class="form-label">Area <span class="text-danger">*</span></label>
                                        <select name="tasker_address_city"
                                            class="form-control @error('tasker_address_city') is-invalid @enderror"
                                            id="addCity">
                                            <option value="" selected>Select Area</option>
                                            <option value="{{ $tasker->tasker_address_city }}" selected>
                                                {{ $tasker->tasker_address_city }}</option>
                                        </select>
                                        @error('tasker_address_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <!-- Working Area Section -->
                            <h5 class="mb-2">C. Working Area</h5>
                            <div class="row">

                                <!-- Working Area State Field -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <select name="tasker_workingloc_state"
                                            class="form-control @error('tasker_workingloc_state') is-invalid @enderror"
                                            id="workState">
                                            @if ($tasker->tasker_workingloc_state == '')
                                                <option value="" selected>Select State</option>
                                                @foreach ($states['states'] as $state)
                                                    <option value="{{ strtolower($state['name']) }}">
                                                        {{ $state['name'] }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($states['states'] as $state)
                                                    @if ($tasker->tasker_workingloc_state == strtolower($state['name']))
                                                        <option value="{{ strtolower($state['name']) }}" selected>
                                                            {{ $state['name'] }}</option>
                                                    @else
                                                        <option value="{{ strtolower($state['name']) }}">
                                                            {{ $state['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('tasker_workingloc_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Working Area Area Field -->
                                <div class="col-sm-6">
                                    <div class="mb-5">
                                        <label class="form-label">Area <span class="text-danger">*</span></label>
                                        <select name="tasker_workingloc_area"
                                            class="form-control @error('tasker_workingloc_area') is-invalid @enderror"
                                            id="workCity">
                                            @if ($tasker->tasker_workingloc_area == '')
                                                <option value="" selected>Select Area</option>
                                            @else
                                                <option value="{{ $tasker->tasker_workingloc_area }}" selected>
                                                    {{ $tasker->tasker_workingloc_area }}</option>
                                            @endif
                                        </select>
                                        @error('tasker_workingloc_area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Account & Performance Section -->
                            <h5 class="mb-2">D. Account & Performance</h5>
                            <div class="row">

                                <!-- Account Status Field -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Account Status</label>
                                        <select class="form-select" name="tasker_status">
                                            @if ($tasker->tasker_status == 0)
                                                <option value ="0">Incomplete Profile</option>
                                            @elseif($tasker->tasker_status == 1)
                                                <option value ="1" selected>Not Verified</option>
                                                <option value ="2">Active</option>
                                                <option value ="3">Inactive</option>
                                            @elseif($tasker->tasker_status == 2)
                                                <option value ="2"selected>Active</option>
                                                <option value ="3">Inactive</option>
                                                <option value ="5">Banned</option>
                                            @elseif($tasker->tasker_status == 3)
                                                <option value ="2">Active</option>
                                                <option value ="3"selected>Inactive</option>
                                                <option value ="5">Banned</option>
                                            @elseif($tasker->tasker_status == 4)
                                                <option value ="4">Password Need Update</option>
                                            @elseif($tasker->tasker_status == 5)
                                                <option value ="2">Active</option>
                                                <option value ="3">Inactive</option>
                                                <option value ="5"selected>Banned</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Account Rating Field -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Current Rating</label>
                                        <input type="text" class="form-control" name="tasker_rating"
                                            value="{{ $tasker->tasker_rating }}" readonly />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flex-grow-1 text-end">
                        <button type="reset" class="btn btn-link-danger btn-pc-default"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        $(document).ready(function() {

            //SELECT STATE AND AREA FUNCTION
            $('#addState').on('change', function() {
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

            $('#workState').on('change', function() {
                var state = $(this).val();
                if (state) {
                    $.ajax({
                        url: '/get-areas/' + state, // Ensure this matches the route
                        type: 'GET',
                        success: function(data) {
                            $('#workCity').empty().append(
                                '<option value="">Select Area</option>');
                            $.each(data, function(index, area) {
                                $('#workCity').append('<option value="' + area + '">' +
                                    area + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching areas: " +
                                error); // For debugging if request fails
                        }
                    });
                } else {
                    $('#workCity').empty().append('<option value="">Select Area</option>');
                }
            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
