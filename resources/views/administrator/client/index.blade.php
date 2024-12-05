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
                                <li class="breadcrumb-item" aria-current="page">Client Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Client Management</h2>
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
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <a href="#" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#addClientModal">
                                        <i class="ti ti-plus f-18"></i> Add Client
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Client Create Start Here -->
            <form action="{{ route('admin-client-create') }}" method="POST">
                @csrf
                <div class="modal fade" id="addClientModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Client</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-primary" role="alert">
                                    <h6 class="link-primary">Please note:</h6>
                                    <ul class="mb-0">
                                        <li>Fields marked with a red asterisk (<span class="text-danger">*</span>) are
                                            mandatory.</li>
                                        <li>Ensure the phone number includes the correct country code (e.g., +60 for
                                            Malaysia).</li>
                                        <li>The default password is pre-set. Please update the password later for security
                                            purposes.</li>
                                        <li>Review all entered data before clicking 'Save.'</li>
                                    </ul>
                                </div>
                                <div class="row">

                                    <!-- First Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                First Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('client_firstname') is-invalid @enderror"
                                                name="client_firstname" placeholder="First Name"
                                                value="{{ old('client_firstname') }}" />
                                            @error('client_firstname')
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
                                                class="form-control @error('client_lastname') is-invalid @enderror"
                                                name="client_lastname" placeholder="Last Name"
                                                value="{{ old('client_lastname') }}" />
                                            @error('client_lastname')
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
                                                    class="form-control @error('client_phoneno') is-invalid @enderror"
                                                    placeholder="Phone No." name="client_phoneno"
                                                    value="{{ old('client_phoneno') }}" />
                                                @error('client_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"placeholder="Email" value="{{ old('email') }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- State Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <select name="client_state"
                                                class="form-control @error('client_state') is-invalid @enderror">
                                                <option value="" selected>Select State</option>
                                                @foreach ($states['states'] as $state)
                                                    <option value="{{ strtolower($state['name']) }}">
                                                        {{ $state['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>

                                    <!-- Account Status Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <select class="form-select @error('client_status') is-invalid @enderror"
                                                name="client_status">
                                                <option value ="1">Admin Referal</option>
                                                <option value ="2" disabled>Active</option>
                                                <option value = "3" disabled>Inactive</option>
                                            </select>
                                            @error('client_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password </label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" name="password" value="servenow@1234" />
                                            <span class="text-muted" style="font-size: 9pt">[Default:
                                                servenow@1234]</span>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                                <div class="flex-grow-1 text-end">
                                    <button type="reset" class="btn btn-link-danger btn-pc-default"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal Client Create End  Here -->


            @foreach ($clients as $client)
                <!-- Modal Client Edit Start Here -->
                <form action="{{ route('admin-client-update', $client->id) }}" method="POST">
                    @csrf
                    <div class="modal fade modal-up" id="updateClientModal-{{ $client->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Client Details</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-primary" role="alert">
                                        <h6 class="link-primary">Please note:</h6>
                                        <ul class="mb-0">
                                            <li>Fields marked with a red asterisk (<span class="text-danger">*</span>) are
                                                mandatory.</li>
                                            <li>Review all entered data before clicking 'Save Changes.'</li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center mb-3">
                                                    <img src="{{ asset('storage/' . $client->client_photo) }}"
                                                        alt="Profile Photo" width="150" height="150"
                                                        class="user-avtar rounded-circle">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            First Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="First Name" name="client_firstname"
                                                            value="{{ $client->client_firstname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Last Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Last Name" name="client_lastname"
                                                            value="{{ $client->client_lastname }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Email
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                            name="email" value="{{ $client->email }}" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Phone Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">+60</span>
                                                            <input type="text" class="form-control"
                                                                placeholder="Phone No." name="client_phoneno"
                                                                value="{{ $client->client_phoneno }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Address Line 1
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Address Line 1" name="client_address_one"
                                                                value="{{ $client->client_address_one }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Address Line 2
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Address Line 2" name="client_address_two"
                                                                value="{{ $client->client_address_two }}" />
                                                        </div>
                                                    </div>
                                                    <!-- Postcode Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Postcode</label>
                                                            <input type="text"
                                                                class="form-control @error('client_postcode') is-invalid @enderror"
                                                                name="client_postcode"
                                                                value="{{ $client->client_postcode }}"
                                                                id="client_postcode" maxlength="5"
                                                                oninput="validatePostcode(this)" placeholder="Postcode" />
                                                            @error('client_postcode')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- State Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">State</label>
                                                            <select name="client_state"
                                                                class="form-control addState @error('client_state') is-invalid @enderror">
                                                                @if ($client->client_state == '')
                                                                    <option value="" selected>Select State</option>
                                                                    @foreach ($states['states'] as $state)
                                                                        <option value="{{ strtolower($state['name']) }}">
                                                                            {{ $state['name'] }}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($states['states'] as $state)
                                                                        @if ($client->client_state == strtolower($state['name']))
                                                                            <option
                                                                                value="{{ strtolower($state['name']) }}"
                                                                                selected>
                                                                                {{ $state['name'] }}</option>
                                                                        @else
                                                                            <option
                                                                                value="{{ strtolower($state['name']) }}">
                                                                                {{ $state['name'] }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error('client_state')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                    <!-- Area Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Area</label>
                                                            <select name="client_area"
                                                                class="form-control addCity @error('client_area') is-invalid @enderror">
                                                                @if ($client->client_state == '')
                                                                    <option value="" selected>Select Area</option>
                                                                @else
                                                                    <option value="{{ $client->client_area }}" selected>
                                                                        {{ $client->client_area }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                            @error('client_area')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <input type="hidden" class="isArea"
                                                                value="{{ $client->client_area }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Account Status</label>
                                                        <select class="form-select" name="client_status">
                                                            @if ($client->client_status == 0)
                                                                <option value ="0">Newly Registered</option>
                                                                <option value = "3">Inactive</option>
                                                            @elseif ($client->client_status == 1)
                                                                <option value ="1">Admin Referal</option>
                                                                <option value ="2" disabled>Active</option>
                                                                <option value = "3" disabled>Inactive</option>
                                                            @elseif($client->client_status == 2)
                                                                <option value ="2" selected>Active</option>
                                                                <option value = "3">Inactive</option>
                                                            @elseif($client->client_status == 3)
                                                                <option value ="2">Active</option>
                                                                <option value = "3" selected>Inactive</option>
                                                            @elseif($client->client_status == 4)
                                                                <option value ="4">Deactivated</option>
                                                                <option value ="2">Active</option>
                                                                <option value = "3">Inactive</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <button type="reset" class="btn btn-link-danger btn-pc-default"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal Client Edit End  Here -->

                <!-- Modal Delete Start Here -->
                <div class="modal fade" id="deleteModal-{{ $client->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <div class="d-flex justify-content-center align-items-center mb-3">
                                            <i class="ti ti-trash text-danger" style="font-size: 100px"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h2>Account Deletion</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">
                                                This action will not permanently delete the user. You can always change the status back to active if needed. Are you sure you want to deactivate {{ $client->client_firstname }} account?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('admin-client-delete', $client->id) }}"
                                                class="btn btn-danger">Deactivate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Delete End Here -->
            @endforeach

        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addClientModal'));
                modal.show();
            @endif
        });

        function validatePostcode(input) {
            // Remove any non-numeric characters
            input.value = input.value.replace(/\D/g, '');
            // Trim to 5 characters if longer
            if (input.value.length > 5) {
                input.value = input.value.slice(0, 5);
            }
        }
        $(document).ready(function() {

            // DATATABLE : ClientS
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin-client-management') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'client_firstname',
                            name: 'client_firstname'
                        },
                        {
                            data: 'client_lastname',
                            name: 'client_lastname'
                        },
                        {
                            data: 'client_phoneno',
                            name: 'client_phoneno'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'client_status',
                            name: 'client_status'
                        },
                        {
                            data: 'client_state',
                            name: 'client_state'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]

                });

                function updateArea(modal) {
                    var state = modal.find('.addState').val(); // Find the state within the current modal
                    var addCityDropdown = modal.find(
                    '.addCity'); // Find the city dropdown in the current modal
                    if (state) {
                        $.ajax({
                            url: '/get-areas/' + state, // Ensure this matches the route
                            type: 'GET',
                            success: function(data) {
                                addCityDropdown.empty().append(
                                    '<option value="">Select Area</option>');
                                $.each(data, function(index, area) {
                                    addCityDropdown.append('<option value="' + area +
                                        '">' + area + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching areas: " +
                                error); // For debugging if request fails
                            }
                        });
                    } else {
                        addCityDropdown.empty().append('<option value="">Select Area</option>');
                    }
                }

                // Modal shown logic
                $(document).on('shown.bs.modal', '.modal-up', function() {
                    var modal = $(this); // Current modal being triggered
                    var isArea = modal.find('.isArea')
                .val(); // Get the area value for the current modal

                    if (isArea && isArea.trim() !== "") {
                        // Area is already selected, no need to update
                        console.log("Area already selected:", isArea);
                    } else {
                        // Area is empty, trigger update
                        console.log("No area selected. Updating areas...");
                        updateArea(modal);
                    }
                });

                // AJAX: State change logic (Specific to the modal context)
                $(document).on('change', '.addState', function() {
                    var modal = $(this).closest(
                    '.modal'); // Get the modal that contains the state dropdown
                    updateArea(modal);
                });
            });
        });

        $('.update-btn').on('click', function() {
            alert('Update Button Clicked');
        });
    </script>
@endsection

<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
