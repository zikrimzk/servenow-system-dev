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
                                <li class="breadcrumb-item" aria-current="page">Tasker Management</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tasker Management</h2>
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
                                        data-bs-target="#addTaskerModal">Add Tasker</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="dt-responsive table-responsive m-3">
                                <table class="table data-table table-hover nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tasker Code</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Email</th>
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

            <!-- Modal Tasker Create Start Here -->
            <div class="modal fade" id="addTaskerModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('admin-tasker-create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Tasker</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tasker Code</label>
                                            <input type="text" class="form-control" name="tasker_code"
                                                value="SNT<?php echo rand(1, 1000000); ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <!-- First Name Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text"
                                                class="form-control @error('tasker_firstname') is-invalid @enderror"
                                                placeholder="First Name" name="tasker_firstname"
                                                value="{{ old('tasker_firstname') }}" />
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
                                                placeholder="Last Name" name="tasker_lastname"
                                                value="{{ old('tasker_lastname') }}" />
                                            @error('tasker_lastname')
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
                                                    placeholder="Phone No." name="tasker_phoneno"
                                                    value="{{ old('tasker_phoneno') }}" />
                                                @error('tasker_phoneno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email" name="email" value="{{ old('email') }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Account Status Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Status</label>
                                            <select class="form-select @error('tasker_status') is-invalid @enderror"
                                                name="tasker_status">
                                                <option value="4" selected> Password Need Update</option>
                                            </select>
                                            @error('tasker_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
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
                    </form>

                </div>
            </div>
            <!-- Modal Tasker Create End  Here -->


        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addTaskerModal'));
                modal.show();
            @endif
        });
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
            // $('#state').on('change', function() {
            //     var state = $(this).val();
            //     var areas = $('#area').val();
            //     var number = $('#totalcount').val();
            //     alert(number);
            //     var i;
            //     for (i = 1; i <= number; ++i) {
            //         console.log('area'+i);
            //         if (state) {
            //             $.ajax({
            //                 url: '/get-areas/' + state,
            //                 type: 'GET',
            //                 success: function(data) {
            //                     $('#area' + i).empty();
            //                     $('#area' + i).append('<option value="">Select Area</option>');
            //                     $.each(data, function(index, area) {
            //                         if (areas == area) {
            //                             $('#area' + i).append('<option value="' + area +
            //                                 '" selected>' +
            //                                 area + '</option>');
            //                         } else {
            //                             $('#area' + i).append('<option value="' + area +
            //                                 '">' +
            //                                 area + '</option>');
            //                         }

            //                     });
            //                 }
            //             });
            //         } else {
            //             $('#area'+i).empty();
            //             $('#area'+i).append('<option value="">Select Area</option>');
            //         }
            //     }
            // });

        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
