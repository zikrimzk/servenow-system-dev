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
                                <li class="breadcrumb-item" aria-current="page">Service Type Management</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Service Type Management</h2>
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
                    <div class="card table-card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addTypeModal">Add Service Type</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="dt-responsive table-responsive m-3">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
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
            <div class="modal fade" id="addTypeModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('admin-servicetype-create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Service Type</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Type Name</label>
                                            <input type="text" class="form-control" placeholder="Type Name"
                                                name="servicetype_name" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" placeholder="Description" name="servicetype_desc"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Availability</label>
                                            <select class="form-select" name="servicetype_status">
                                                <option value ="1" selected>Show</option>
                                                <option value = "2">Hide</option>
                                            </select>
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
            <!-- Modal Service Type Create End  Here -->

            <!-- Modal Service Type Edit Start Here -->
            @foreach ($stypes as $stype)
                <div class="modal fade" id="updateServiceTypeModal-{{ $stype->id }}" data-bs-keyboard="false"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                        <form action="{{ route('admin-servicetype-update', $stype->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Service Type Details</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Type Name</label>
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
                                                <label class="form-label">Availability</label>
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
                        </form>

                    </div>
                </div>
            @endforeach
            <!-- Modal Service Type Edit End  Here -->

        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : SERVICE_TYPES
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
                    ]

                });

            });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
