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


            <div class="row">
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
                            <h5 class="mb-2">A. Personal Details:</h5>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tasker Code</label>
                                        <input type="text" class="form-control" name="tasker_code"
                                            value="{{ $tasker->tasker_code }}" readonly />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name"
                                            name="tasker_firstname" value="{{ $tasker->tasker_firstname }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name"
                                            name="tasker_lastname" value="{{ $tasker->tasker_lastname }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">IC Number</label>
                                        <input type="text" class="form-control" placeholder="IC No." name="tasker_icno"
                                            value="{{ $tasker->tasker_icno }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" placeholder="IC No." name="tasker_dob"
                                            value="{{ $tasker->tasker_dob }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+60</span>
                                            <input type="text" class="form-control" placeholder="Phone No."
                                                name="tasker_phoneno" value="{{ $tasker->tasker_phoneno }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            value="{{ $tasker->email }}" />
                                    </div>
                                </div>

                                 <!-- Bio Field -->
                                 <div class="col-sm-12">
                                    <div class="mb-5">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control @error('tasker_bio') is-invalid @enderror" rows="4" cols="20"
                                            name="tasker_bio" placeholder="Enter your bio here ...">{{ $tasker->tasker_bio }}</textarea>
                                        @error('tasker_bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <h5 class="mb-2">B. Tasker Address:</h5>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tasker Code</label>
                                        <input type="text" class="form-control" name="tasker_code"
                                            value="{{ $tasker->tasker_code }}" readonly />
                                    </div>
                                </div>
                               
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
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Working State</label>
                                        <select class="form-select" name="tasker_workingloc_state" id="state">
                                            @if ($tasker->tasker_workingloc_state == '')
                                                <option value="-" selected>Select State</option>
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
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Working Area **</label>
                                        <select class="form-select" name="tasker_workingloc_area">
                                            @if ($tasker->tasker_workingloc_area == '')
                                                <option value="-" selected>Select Area</option>
                                            @else
                                                <option value="-" selected>
                                                    {{ $tasker->tasker_workingloc_area }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Current Rating</label>
                                        <input type="text" class="form-control" name="tasker_rating"
                                            value="{{ $tasker->tasker_rating }}" readonly />
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" value="{{ $taskerCount }}"
                                    id="totalcount" />
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

            // DATATABLE : TASKERS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.childRowImmediate,
                            type: ''
                        }
                    },
                    ajax: "{{ route('admin-tasker-management') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'tasker_code',
                            name: 'tasker_code'
                        },
                        {
                            data: 'tasker_firstname',
                            name: 'tasker_firstname'
                        },
                        {
                            data: 'tasker_lastname',
                            name: 'tasker_lastname'
                        },
                        {
                            data: 'tasker_phoneno',
                            name: 'tasker_phoneno'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'tasker_status',
                            name: 'tasker_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]

                });

            });

            //SELECT STATE AND AREA FUNCTION
            $('#state').on('change', function() {
                    var state = $(this).val();
                    alert(number);
                    if (state) {
                        $.ajax({
                            url: '/get-areas/' + state,
                            type: 'GET',
                            success: function(data) {
                                $('#area').empty();
                                $('#area').append('<option value="">Select Area</option>');
                                $.each(data, function(index, area) {
                                    if (areas == area) {
                                        $('#area').append('<option value="' + area +
                                            '" selected>' +
                                            area + '</option>');
                                    } else {
                                        $('#area').append('<option value="' + area +
                                            '">' +
                                            area + '</option>');
                                    }

                                });
                            }
                        });
                    } else {
                        $('#area').empty();
                        $('#area').append('<option value="">Select Area</option>');
                    }
                }
            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
