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
                                <li class="breadcrumb-item" aria-current="page">Visibility & Location</li>
                            </ul>
                        </div>
                        <div class="col-md-12"> 
                            <div class="page-header-title">
                                <h2 class="mb-4">Visibility & Location</h2>
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

            @if (Auth::user()->tasker_status == 0 || Auth::user()->tasker_status == 1)
                <div class="alert alert-primary">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle h2 f-w-400 mb-0 text-primary"></i>
                        <div class="flex-grow-1 ms-3">
                            <strong>Note :</strong> To enable the profile visibility features, you need to verify first your account !
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->tasker_status == 2)
                <div class="alert alert-primary">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle h2 f-w-400 mb-0 text-primary"></i>
                        <div class="flex-grow-1 ms-3">
                            <strong>Tips : </strong> Please turn on tasker visibility in order to make your profile visible to client. Make sure to choose accessible location for you to make your task.
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">

                <div class="col-md-12">
                    <div class="card">
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

                <div class="col-md-12">
                    <form action="{{ route('tasker-visible-toggle') }}" method="GET" id="formtoggle">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-dark mt-2">
                                        Profile Visibility
                                    </h6>
                                    <div class="form-check form-switch mb-2">
                                        <input type="checkbox" class="form-check-input input-primary f-18"
                                            id="showhideswitch" @if(Auth::user()->tasker_status != 2) disabled  @endif  />
                                        <input type="hidden" name="isChecked" id="isChecked"
                                            value="{{ Auth::user()->tasker_working_status }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <form action="{{ route('tasker-update-location', Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Working Area Section -->
                                    <h6 class="text-dark mb-4 mt-2">
                                        Working Prefered Location
                                    </h6>

                                    <!-- Working Area State Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
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

                                    <!-- Working Area Area Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Area <span class="text-danger">*</span></label>
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
                                    <div class="d-flex justify-content-end align-items-center mt-3 mb-2">
                                        <button type="submit" class="btn btn-outline-primary">Save Location</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

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
                                <div class="d-flex justify-content-center align-items-center my-3">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ route('tasker-card-ver') }}"
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





        </div>
    </div>
    <!-- [ Main Content ] end -->


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
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (26/11/2024)-->
