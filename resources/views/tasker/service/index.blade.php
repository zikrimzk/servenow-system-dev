@extends('tasker.layouts.main')

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
                                <li class="breadcrumb-item">Services</li>
                                <li class="breadcrumb-item" aria-current="page">Service Enrollment</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Service Enrollment</h2>
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
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6 col-xl-3">
                                    <label for="status_filter" class="form-label">Filter by</label>
                                    <select id="status_filter" class="form-select mb-3 mb-md-0">
                                        <option value="">Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">Rejected</option>
                                        <option value="4">Terminated</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-header border border-0">
                            <div class="d-sm-flex align-items-center justify-content-end">
                                <div>
                                    <a href="#" class="btn btn-primary d-inline-flex align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                        <i class="ti ti-plus f-18"></i> Add Service
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="dt-responsive table-responsive mx-0 mx-md-4">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Service Name</th>
                                            <th scope="col">Rate (RM)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Service Create Start Here -->
            <div class="modal fade" id="addServiceModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('tasker-service-create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Service</h5>
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
                                        <li> Please ensure that the service amount reflects the actual workload. Overpricing
                                            may result in your request being rejected.</li>
                                        <li>Review all entered data before submiting.</li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Service Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('service_type_id') is-invalid @enderror"
                                                name="service_type_id">
                                                <option value="" selected>Select Service Type</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->servicetype_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('service_type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rate <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="text"
                                                    class="form-control @error('service_rate') is-invalid @enderror service_rate"
                                                    placeholder="Service Rate" name="service_rate" />
                                                @error('service_rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rate Type <span class="text-danger">*</span></label>
                                            <select class="form-select  @error('service_rate_type') is-invalid @enderror"
                                                name="service_rate_type">
                                                <option value="" selected>Select Rate Type</option>
                                                <option value="per job">Per Job</option>
                                                <option value="per hour">Per Hour</option>
                                            </select>
                                            @error('service_rate_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Service Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="service_desc" class="form-control @error('service_desc') is-invalid @enderror" cols="20"
                                                rows="4" placeholder="Enter your description ..."></textarea>
                                            @error('service_desc')
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
                                    <button type="submit" class="btn btn-primary" id="addApplicationBtn">Add
                                        Service</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- Modal Service Create End  Here -->


            @foreach ($services as $sv)
                <!-- Modal Service Edit Start Here -->
                <form action="{{ route('tasker-service-update', $sv->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateServiceModal-{{ $sv->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                            <form action="{{ route('tasker-service-create') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="mb-0">Update Service Details</h5>
                                        <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                            data-bs-dismiss="modal">
                                            <i class="ti ti-x f-20"></i>
                                        </a>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h6 class="link-primary">Please note:</h6>
                                            <ul class="mb-0">
                                                <li>Fields marked with a red asterisk (<span class="text-danger">*</span>)
                                                    are
                                                    mandatory.</li>
                                                <li> Please ensure that the service amount reflects the actual workload.
                                                    Overpricing may result in your request being rejected.</li>
                                                <li>Review all entered data before submiting.</li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Service Type <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" name="service_type_id">
                                                        @foreach ($types as $type)
                                                            @if ($sv->service_type_id == $type->id)
                                                                <option value="{{ $type->id }}" selected>
                                                                    {{ $type->servicetype_name }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $type->id }}" disabled>
                                                                    {{ $type->servicetype_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Rate <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">RM</span>
                                                        <input type="text" class="form-control service_rate"
                                                            placeholder="Service Rate" name="service_rate"
                                                            value="{{ $sv->service_rate }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Rate Type <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" name="service_rate_type">
                                                        @if ($sv->service_rate_type == 'per hour')
                                                            <option value="per job">Per Job</option>
                                                            <option value="per hour" selected>Per Hour</option>
                                                        @elseif($sv->service_rate_type == 'per job')
                                                            <option value="per job" selected>Per Job</option>
                                                            <option value="per hour">Per Hour</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Status <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" name="service_status">
                                                        @if ($sv->service_status == 0)
                                                            <option value="0" selected>Pending</option>
                                                        @elseif($sv->service_status == 1)
                                                            <option value="1" selected>Active</option>
                                                            <option value="2">Inactive</option>
                                                        @elseif($sv->service_status == 2)
                                                            <option value="1">Active</option>
                                                            <option value="2"selected>Inactive</option>
                                                        @elseif($sv->service_status == 3)
                                                            <option value="3"selected>Rejected</option>
                                                        @elseif($sv->service_status == 4)
                                                            <option value="3"selected>Terminated</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Service Description <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="service_desc" class="form-control" cols="20" rows="4"
                                                        placeholder="Enter your description ...">{{ $sv->service_desc }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <div class="flex-grow-1 text-end">
                                            <button type="reset" class="btn btn-link-danger btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary updateApplicationBtn">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
                <!-- Modal Service Edit End  Here -->

                <!-- Modal Delete Start Here -->
                <div class="modal fade" id="deleteService-{{ $sv->id }}" data-bs-keyboard="false" tabindex="-1"
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
                                            <h2>Are you sure ?</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class="fw-normal f-18 text-center">This action cannot be undone.</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-center gap-3 align-items-center">
                                            <button type="reset" class="btn btn-light btn-pc-default"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('tasker-service-delete', $sv->id) }}"
                                                class="btn btn-danger">Delete Anyways</a>
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
                var modal = new bootstrap.Modal(document.getElementById('addServiceModal'));
                modal.show();
            @endif
        });
        $(document).ready(function() {

            $(function() {

                // DATATABLE : SERVICES
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('tasker-service-enrollment') }}",
                        data: function(d) {
                            d.status_filter = $('#status_filter').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'servicetype_name',
                            name: 'servicetype_name'
                        },
                        {
                            data: 'service_rate',
                            name: 'service_rate'
                        },
                        {
                            data: 'service_status',
                            name: 'service_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]

                });

                $('#status_filter').on('change', function() {
                    table.ajax.reload();
                    table.draw();
                });

                $('#addApplicationBtn').on('click', function() {
                    const $buttonOne = $(this);

                    $buttonOne.addClass('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm me-2"></span> Adding...'
                    );
                });

                $('.updateApplicationBtn').on('click', function() {
                    const $buttonThree = $(this);

                    $buttonThree.addClass('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm me-2"></span> Saving...'
                    );
                });


                $('.service_rate').on('input', function() {
                    // Get the current value
                    let value = $(this).val();

                    // Allow only numbers and a single decimal point
                    value = value.replace(/[^0-9.]/g,
                        ''); // Remove non-numeric and non-dot characters
                    value = value.replace(/(\..*?)\..*/g, '$1'); // Allow only one decimal point

                    // Format the value to two decimal places
                    if (value.indexOf('.') >= 0) {
                        const parts = value.split('.');
                        if (parts[1].length > 2) {
                            value = `${parts[0]}.${parts[1].substring(0, 2)}`;
                        }
                    }

                    // Update the field value
                    $(this).val(value);
                });

                // Ensure value is always in the correct format on blur (e.g., "10" becomes "10.00")
                $('.service_rate').on('blur', function() {
                    let value = $(this).val();
                    if (value !== '' && !isNaN(value)) {
                        $(this).val(parseFloat(value).toFixed(2));
                    }
                });

            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
<!--Updated By: Muhammad Zikri B. Kashim (10/01/2025)-->

