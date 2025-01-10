@extends('tasker.layouts.main')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Task Preferences</li>
                                <li class="breadcrumb-item" aria-current="page">Preferences</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Preferences</h2>
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

            <!-- Start Note -->

            @if (Auth::user()->tasker_status == 0 || Auth::user()->tasker_status == 1)
                <div class="alert alert-primary">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle h2 f-w-400 mb-0 text-primary"></i>
                        <div class="flex-grow-1 ms-3">
                            <strong>Note :</strong> You need to verify first account !
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->tasker_status == 2 &&
                    Auth::user()->tasker_workingloc_state == null &&
                    Auth::user()->tasker_workingloc_area == null)
                <div class="alert alert-primary">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle h2 f-w-400 mb-0 text-primary"></i>
                        <div class="flex-grow-1 ms-3">
                            <strong>Tips : </strong> To enable the profile visibility features, you need to update your
                            working location details first !
                        </div>
                    </div>
                </div>
            @endif
            <!-- End Note -->


            <div class="row">

                <!-- Account Status Start -->
                <div class="col-md-6">
                    <div class="card shadow shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-dark mt-2">
                                    Account Status
                                </h6>
                                @if (Auth::user()->tasker_status == 0)
                                    <span class="badge bg-warning">Incomplete Profile</span>
                                @elseif(Auth::user()->tasker_status == 1)
                                    <div class="">
                                        <span class="badge bg-light-danger">Not Verified</span>

                                        <a href="" class="link-primary ms-2" data-bs-toggle="modal"
                                            data-bs-target="#verifyQrModal">Verify now</a>

                                    </div>
                                @elseif(Auth::user()->tasker_status == 2)
                                    <span class="badge bg-success">Verified & Active</span>
                                @elseif(Auth::user()->tasker_status == 3)
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Account Status End -->

                <!-- Profile Visibility Start -->
                <div class="col-md-6">
                    <form action="{{ route('tasker-visible-toggle') }}" method="GET" id="formtoggle">
                        @csrf
                        <div class="card shadow shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-dark mt-2">
                                        Profile Visibility
                                    </h6>
                                    <div class="form-check form-switch mb-2">
                                        <input type="checkbox" class="form-check-input input-primary f-18"
                                            id="showhideswitch" @if (Auth::user()->tasker_status != 2 ||
                                                    (Auth::user()->tasker_workingloc_state == null && Auth::user()->tasker_workingloc_area == null)) disabled @endif />
                                        <input type="hidden" name="isChecked" id="isChecked"
                                            value="{{ Auth::user()->tasker_working_status }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- Profile Visibility End -->

                <!-- Working Type Start -->
                <div class="col-md-12">
                    <form action="{{ route('tasker-type-change') }}" method="POST" id="formtoggle-type">
                        @csrf
                        <div class="card shadow shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-md-6">
                                        <h6 class="text-dark mt-2">
                                            Working Type
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="tasker_worktype" class="form-select" id="workingtype">
                                            @if (Auth::user()->tasker_worktype == null)
                                                <option value="" selected>- Select -</option>
                                                <option value="1">Full Time </option>
                                                <option value="2">Part Time</option>
                                            @elseif(Auth::user()->tasker_worktype == 1)
                                                <option value="" disabled>- Select -</option>
                                                <option value="1" selected>Full Time</option>
                                                <option value="2">Part Time</option>
                                            @elseif(Auth::user()->tasker_worktype == 2)
                                                <option value="" disabled>- Select -</option>
                                                <option value="1">Full Time</option>
                                                <option value="2" selected>Part Time</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Working Type End -->

                <!-- Working Preferred Location Start -->
                <div class="col-md-12">
                    <form action="{{ route('tasker-update-location', Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="card shadow shadow-sm">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Working Area Section -->
                                    <h6 class="text-dark mb-4 mt-2">
                                        Working Prefered Location
                                    </h6>

                                    <!-- Working Area State Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <select name="tasker_workingloc_state"
                                                class="form-control @error('tasker_workingloc_state') is-invalid @enderror"
                                                id="workState">
                                                @if (Auth::user()->tasker_workingloc_state == '')
                                                    <option value="" selected>Select State</option>
                                                    @foreach ($states['states'] as $state)
                                                        <option value="{{ strtolower($state['name']) }}">
                                                            {{ $state['name'] }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($states['states'] as $state)
                                                        @if (Auth::user()->tasker_workingloc_state == strtolower($state['name']))
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

                                    <!-- Working Area Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Area</label>
                                            <select name="tasker_workingloc_area"
                                                class="form-control @error('tasker_workingloc_area') is-invalid @enderror"
                                                id="workCity">
                                                @if (Auth::user()->tasker_workingloc_area == '')
                                                    <option value="" selected>Select Area</option>
                                                @else
                                                    <option value="{{ Auth::user()->tasker_workingloc_area }}" selected>
                                                        {{ Auth::user()->tasker_workingloc_area }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('tasker_workingloc_area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Working Range Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Working Radius (KM)</label>
                                            <div class="d-flex align-items-center">
                                                <input type="range" name="working_radius" id="working_radius"
                                                    min="5" max="100" step="1"
                                                    value="{{ Auth::user()->working_radius }}"
                                                    class="form-range  @error('working_radius') is-invalid @enderror">
                                                <span id="radius_value" class="ms-2">{{ Auth::user()->working_radius }}
                                                    KM</span>
                                            </div>
                                            @error('working_radius')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center mt-3 mb-2">
                                        <button type="submit" class="btn btn-light-primary">Save Location</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- Working Preferred Location Start -->

                <!-- Verify Account Start -->
                <div id="verifyQrModal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-end align-items-center m-2">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="d-none d-md-block">
                                    <div class="alert alert-primary">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                            <div class="flex-grow-1 ms-3">
                                                <strong>Important:</strong>
                                                Please scan the QR code below using your smartphone to verify your
                                                account. This
                                                step is essential to complete your account verification.
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $data = Auth::check() ? Auth::user()->tasker_icno ?? '' : '';
                                    @endphp
                                    <div class="d-flex justify-content-center align-items-center my-3">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ route('tasker-card-ver', $data) }}"
                                            class="img-fluid" alt="qrcode">
                                    </div>

                                </div>

                                <div class="d-sm-block d-md-none">
                                    <div class="alert alert-primary">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                                            <div class="flex-grow-1 ms-3">
                                                <strong>Tips:</strong> Please have your MyKad ready and ensure your
                                                camera lens is clean for a smooth verification process.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid my-3">
                                        <a href="{{ route('tasker-card-ver', Auth::user()->tasker_icno) }}"
                                            class="btn btn-primary">Verify Account</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Verify Account End -->
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <script>
        const rangeInput = document.getElementById('working_radius');
        const radiusValue = document.getElementById('radius_value');

        // Update the displayed radius value when the slider is dragged
        rangeInput.addEventListener('input', function() {
            radiusValue.textContent = `${rangeInput.value} KM`;
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            if ($('#isChecked').val() == '1') {
                $('#showhideswitch').prop('checked', true)
            } else {
                $('#showhideswitch').prop('checked', false)
            }
            // AJAX : TASKER VISIBILITY TOGGLE
            $('#formtoggle').on('submit', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('tasker-visible-toggle') }}",
                    data: jQuery('#formtoggle').serialize(),
                    type: "GET",
                    success: function(result) {
                        var data = result.data;
                    }

                })
            });

            $('#showhideswitch').on('change', function() {
                if ($(this).prop('checked')) {
                    $('#isChecked').val('1');
                    $('#formtoggle').submit();
                } else {
                    $('#isChecked').val('0');
                    $('#formtoggle').submit();
                }
            });

            // AJAX : TASKER WORKING TYPE TOGGLE
            $('#formtoggle-type').on('submit', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('tasker-type-change') }}",
                    data: $('#formtoggle-type').serialize(),
                    type: "POST",
                    success: function(result) {
                        console.log(result); // Log the JSON response
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText); // Log error details
                        alert("Something went wrong: " + xhr
                            .responseText); // Show error to user
                    }
                });
            });

            $('#workingtype').on('change', function() {
                $('#formtoggle-type').submit();
            });

            //AJAX :FETCH WORKING LOCATION
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
<!--Created By: Muhammad Zikri B. Kashim (26/11/2024)-->
<!--Updated By: Muhammad Zikri B. Kashim (10/01/2025)-->
