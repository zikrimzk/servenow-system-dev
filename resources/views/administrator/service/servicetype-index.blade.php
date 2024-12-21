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
                                <li class="breadcrumb-item">Services</li>
                                <li class="breadcrumb-item" aria-current="page">Service Type</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Service Type</h2>
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
                                        data-bs-toggle="modal" data-bs-target="#addTypeModal">
                                        <i class="ti ti-plus f-18"></i> Add Service Type
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
                                            <th scope="col">Type Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Availability</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Service Type Create Start Here -->
            <form action="{{ route('admin-servicetype-create') }}" method="POST">
                @csrf
                <div class="modal fade" id="addTypeModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Service Type</h5>
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
                                        <li>Review all entered data before clicking 'Save.'</li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Type Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('servicetype_name') is-invalid @enderror"
                                                placeholder="Type Name" name="servicetype_name"
                                                value="{{ old('servicetype_name') }}" />
                                            @error('servicetype_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @error('servicetype_desc') is-invalid @enderror" rows="3" placeholder="Description"
                                                name="servicetype_desc">{{ old('servicetype_desc') }}</textarea>
                                            @error('servicetype_desc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Availability
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('servicetype_status') is-invalid @enderror"
                                                name="servicetype_status">
                                                <option value="1"
                                                    {{ old('servicetype_status') == '1' ? 'selected' : '' }}>Show</option>
                                                <option value="2"
                                                    {{ old('servicetype_status') == '2' ? 'selected' : '' }}>Hide</option>
                                            </select>
                                            @error('servicetype_status')
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
            <!-- Modal Service Type Create End  Here -->


            @foreach ($stypes as $stype)
                <!-- Modal Service Type Edit Start Here -->
                <form action="{{ route('admin-servicetype-update', $stype->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateServiceTypeModal-{{ $stype->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Service Type Details</h5>
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
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Type Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="servicetype_name"
                                                    value="{{ $stype->servicetype_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" rows="3" placeholder="Description" name="servicetype_desc">{{ $stype->servicetype_desc }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Availability
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" name="servicetype_status">
                                                    @if ($stype->servicetype_status == 1)
                                                        <option value ="1" selected>Show</option>
                                                        <option value = "2">Hide</option>
                                                    @elseif($stype->servicetype_status == 2)
                                                        <option value ="1">Show</option>
                                                        <option value = "2" selected>Hide</option>
                                                    @endif
                                                </select>
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
                <!-- Modal Service Type Edit End  Here -->

                <!-- Modal Delete Start Here -->
                <div class="modal fade" id="deleteModal-{{ $stype->id }}" data-bs-keyboard="false" tabindex="-1"
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
                                            <a href="{{ route('admin-servicetype-delete', $stype->id) }}"
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
                var modal = new bootstrap.Modal(document.getElementById('addTypeModal'));
                modal.show();
            @endif
        });

        $(document).ready(function() {

            // DATATABLE : SERVICE_TYPES
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin-service-type-management') }}",
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
                            data: 'servicetype_desc',
                            name: 'servicetype_desc'
                        },
                        {
                            data: 'servicetype_status',
                            name: 'servicetype_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        emptyTable: "No data available in the table.", // Custom message when there's no data
                        loadingRecords: "Loading...",
                        processing: "Processing...",
                        zeroRecords: "No matching records found.",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }

                });

            });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
