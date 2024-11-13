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
                                <li class="breadcrumb-item" aria-current="page">Service Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Service Management</h2>
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
                <div class="col-sm-12">
                    <div class="alert alert-primary">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-info-circle h2 f-w-400 mb-0"></i>
                            <div class="flex-grow-1 ms-3">
                                <strong>Note:</strong>
                                The administrator will review the services within 3 business days to approve your request.
                                Please ensure that the service amount reflects the actual workload. Overpricing may result
                                in your request being rejected.
                            </div>
                        </div>
                    </div>
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addServiceModal">Add Service</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="dt-responsive table-responsive m-3">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
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
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Service Type</label>
                                            <select class="form-select" name="service_type_id">
                                                <option value="" selected>Select Service Type</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->servicetype_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rate</label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" class="form-control" placeholder="Service Rate"
                                                    name="service_rate" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rate Type</label>
                                            <select class="form-select" name="service_rate_type">
                                                <option value="" selected>Select Rate Type</option>
                                                <option value="per job">Per Job</option>
                                                <option value="per hour">Per Hour</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Service Description</label>
                                            <textarea name="service_desc" class="form-control" cols="20" rows="4" placeholder="Enter your description ..."></textarea>
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
                    </form>

                </div>
            </div>
            <!-- Modal Service Create End  Here -->

            <!-- Modal Service Edit Start Here -->
            @foreach ($services as $sv)
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Service Type</label>
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
                                                    <label class="form-label">Rate</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">RM</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Service Rate" name="service_rate"
                                                            value="{{ $sv->service_rate }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Rate Type</label>
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
                                                    <label class="form-label">Status</label>
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
                                                    <label class="form-label">Service Description</label>
                                                    <textarea name="service_desc" class="form-control" cols="20" rows="4" placeholder="Enter your description ...">{{ $sv->service_desc }}</textarea>
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
                            </form>
                        </div>
                    </div>
                </form>
            @endforeach
            <!-- Modal Service Edit End  Here -->

        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : SERVICES
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
                    ajax: "{{ route('tasker-service-management') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
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

            });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
