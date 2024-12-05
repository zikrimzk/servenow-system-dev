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
                                <li class="breadcrumb-item">Tasker Management</li>
                                <li class="breadcrumb-item">Tasker Profile</li>
                                <li class="breadcrumb-item" aria-current="page">{{ $tasker->tasker_firstname.' '.$tasker->tasker_lastname }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Tasker Profile</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Start Alert -->
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle"></i>
                                Error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            <!-- End Alert -->

            <div class="row">
                <div class="d-flex flex-wrap justify-content-start align-items-center">
                    <a href="{{ url()->previous() }}" class="btn btn-light-primary btn-sm d-inline-flex">
                        <i class="ti ti-arrow-back-up me-1"></i>
                        Back
                    </a>
                </div>
            </div>
            <div class="card my-4">
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('admin-tasker-update', $tasker->id) }}" method="POST">
                            @csrf
                            <div class="row">
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
                                                <label class="form-label">
                                                    First Name
                                                    <span class="text-danger">*</span>
                                                </label>
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
                                                <label class="form-label">
                                                    Last Name
                                                    <span class="text-danger">*</span>
                                                </label>
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
                                                <label class="form-label">
                                                    IC Number
                                                    <span class="text-danger">*</span>
                                                </label>
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
                                                <label class="form-label">
                                                    Date of Birth
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('tasker_dob') is-invalid @enderror"
                                                    name="tasker_dob" value="{{ $tasker->tasker_dob }}" />
                                                @error('tasker_dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone Number Field -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Phone Number
                                                    <span class="text-danger">*</span>
                                                </label>
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
                                                <label class="form-label">
                                                    Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
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
                                                    class="form-control @error('tasker_address_one') is-invalid @enderror"
                                                    name="tasker_address_one" value="{{ $tasker->tasker_address_one }}"
                                                    placeholder="Building number and street name" />
                                                @error('tasker_address_one')
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
                                                    class="form-control @error('tasker_address_two') is-invalid @enderror"
                                                    name="tasker_address_two" value="{{ $tasker->tasker_address_two }}"
                                                    placeholder="Building name" />
                                                @error('tasker_address_two')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Postal Code Field -->
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Postal Code <span
                                                        class="text-danger">*</span></label>
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
                                                <select name="tasker_address_area"
                                                    class="form-control @error('tasker_address_area') is-invalid @enderror"
                                                    id="addCity">
                                                    @if ($tasker->tasker_address_area == '')
                                                        <option value="" selected>Select Area</option>
                                                    @else
                                                        <option value="{{ $tasker->tasker_address_area }}" selected>
                                                            {{ $tasker->tasker_address_area }}</option>
                                                    @endif
                                                </select>
                                                @error('tasker_address_area')
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
                                <button type="submit"
                                    class="btn btn-primary @if ($tasker->tasker_status == 0 || $tasker->tasker_status == 4) disabled @endif">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
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
