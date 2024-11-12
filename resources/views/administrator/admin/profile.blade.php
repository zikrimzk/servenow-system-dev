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
                                <li class="breadcrumb-item" aria-current="page">My Profile</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">My Profile</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body py-0">
                            <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-file-text me-2"></i>Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4"
                                        role="tab" aria-selected="true">
                                        <i class="ti ti-lock me-2"></i>Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <form action="{{ route('tasker-update-profile', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
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
                                            <div class="alert alert-success alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#check-circle-fill"></use>
                                                </svg>
                                                <div> {{ session('success') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible d-flex align-items-center"
                                                role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                    <use xlink:href="#exclamation-triangle-fill"></use>
                                                </svg>
                                                <div> {{ session('error') }} </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <!-- End Alert -->
                                      

                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5>Profile</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 text-center mb-3">
                                                        <div class="user-upload">
                                                            <img src="{{ asset('storage/' . auth()->user()->admin_photo) }}"
                                                                alt="Profile Photo" width="150" height="150"
                                                                id="previewImage">
                                                            <label for="profilephoto" class="img-avtar-upload">
                                                                <i class="ti ti-camera f-24 mb-1"></i>
                                                                <span>Upload</span>
                                                            </label>
                                                            <input type="file" id="profilephoto" name="admin_photo"
                                                                class="d-none" accept="image/*"
                                                                @if (auth()->user()->admin_photo == '') required @endif />
                                                            @error('admin_photo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <input type="hidden" name="isUploadPhoto" id="isUploadPhoto"
                                                            value="false">
                                                    </div>

                                                    <!-- First Name Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">First Name</label>
                                                            <input type="text"
                                                                class="form-control @error('admin_firstname') is-invalid @enderror"
                                                                name="admin_firstname"
                                                                value="{{ Auth::user()->admin_firstname }}"
                                                                id="admin_firstname" />
                                                            @error('admin_firstname')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Last Name Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Last Name</label>
                                                            <input type="text"
                                                                class="form-control @error('admin_lastname') is-invalid @enderror"
                                                                name="admin_lastname"
                                                                value="{{ Auth::user()->admin_lastname }}" />
                                                            @error('admin_lastname')
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
                                                                    class="form-control @error('admin_phoneno') is-invalid @enderror"
                                                                    placeholder="Phone No." name="admin_phoneno"
                                                                    value="{{ Auth::user()->admin_phoneno }}" />
                                                                @error('admin_phoneno')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Email Field -->
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="text"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email" value="{{ Auth::user()->email }}" />
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 text-end btn-page">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Change Password</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Old Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h5>New password must contain:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least
                                                    8
                                                    characters</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least
                                                    1
                                                    lower letter (a-z)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least
                                                    1
                                                    uppercase letter(A-Z)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least
                                                    1
                                                    number (0-9)</li>
                                                <li class="list-group-item"><i
                                                        class="ti ti-circle-check text-success f-16 me-2"></i> At least
                                                    1
                                                    special characters</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end btn-page">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#profilephoto').on('change', function() {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    // When the file is loaded, set the src of the img tag
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result).show();
                    };

                    // Read the file as a data URL
                    reader.readAsDataURL(file);
                }
                $('#isUploadPhoto').val('true');
            });

        });
    </script>
    <!-- [ Main Content ] end -->
@endsection
