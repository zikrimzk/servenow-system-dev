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
                                <li class="breadcrumb-item">Setting</li>
                                <li class="breadcrumb-item" aria-current="page">System Setting</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">System Setting</h2>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="mb-2 mt-2">A. System Information</h5>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">System Name</label>
                                        <input type="text" class="form-control" id="system_name" name="system_name"
                                            value="ServeNow" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">System Version</label>
                                        <input type="text" class="form-control" id="system_version" name="system_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">System Serial Number</label>
                                        <input type="text" class="form-control" id="system_version" name="system_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">System Last Update Date</label>
                                        <input type="date" class="form-control" id="system_version" name="system_name">
                                    </div>
                                </div>
                                <h5 class="mb-2 mt-2">B. Company Information</h5>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Registration Number</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Company Phone No</label>
                                        <input type="text" class="form-control" id="company_phoneno"
                                            name="company_phoneno">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Company Email</label>
                                        <input type="text" class="form-control" id="company_email"
                                            name="company_email">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="company_status"
                                            name="company_status">
                                    </div>
                                </div>
                                <h5 class="mb-2 mt-2">C. Account Information</h5>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" id="company_email"
                                            name="company_email">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="company_email"
                                            name="company_email">
                                    </div>
                                </div>
                               
                                <h5 class="mb-2 mt-2">D. Domain Information</h5>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Domain Name</label>
                                        <input type="text" class="form-control" id="system_version"
                                            name="system_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Domain Provider</label>
                                        <input type="text" class="form-control" id="system_version"
                                            name="system_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Domain Start Date</label>
                                        <input type="date" class="form-control" id="system_version"
                                            name="system_name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="system_name" class="form-label">Domain End Date</label>
                                        <input type="date" class="form-control" id="system_version"
                                            name="system_name">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript"></script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
