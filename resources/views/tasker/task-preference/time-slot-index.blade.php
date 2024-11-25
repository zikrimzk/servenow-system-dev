@extends('tasker.layouts.main')
<link rel="stylesheet" href="../assets/css/plugins/dragula.min.css" />

@section('content')
    <!-- [ Main Content ] start -->
    {{-- <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Task Preference</li>
                                <li class="breadcrumb-item" aria-current="page">Time Slot</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Time Slot</h2>
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
                    <div class="card shadow shadow-sm">
                        <div class="card-body">
                           <h3>Monday</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Time Slot Create Start Here -->
            <div class="modal fade" id="addSlotModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <form action="{{ route('admin-timeslot-create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Time Slot</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Slot Start</label>
                                            <input type="time"
                                                class="form-control @error('start_time') is-invalid @enderror"
                                                placeholder="Start Time" name="start_time" />
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Slot End</label>
                                            <input type="time"
                                                class="form-control @error('end_time') is-invalid @enderror"
                                                placeholder="End Time" name="end_time" />
                                            @error('end_time')
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
            <!-- Modal Time Slot Create End  Here -->

            <!-- Modal Time Slot Edit Start Here -->
            @foreach ($slots as $slot)
                <div class="modal fade" id="updateSlotModal-{{ $slot->id }}" data-bs-keyboard="false" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <form action="{{ route('admin-timeslot-update', $slot->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Time Slot</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slot Start</label>
                                                <input type="time"
                                                    class="form-control"
                                                    placeholder="Start Time" name="start_time"
                                                    value="{{ $slot->start_time }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slot End</label>
                                                <input type="time"
                                                    class="form-control"
                                                    placeholder="End Time" name="end_time"
                                                    value="{{ $slot->end_time }}" />
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
            <!-- Modal Time Slot Edit End  Here -->

        </div>

    </div> --}}

    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Task Preference</li>
                                <li class="breadcrumb-item" aria-current="page">Time Slot</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Time Slot</h2>
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
                    <div class="mail-wrapper">
                        <div class="offcanvas-xxl offcanvas-start mail-offcanvas" tabindex="-1" id="offcanvas_mail">
                            <div class="offcanvas-header">
                                <button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_mail"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body p-0">
                                <div id="mail-menulist" class="show collapse collapse-horizontal">
                                    <div class="mail-menulist">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="text-primary ps-3 mb-3 fw-semibold"><i
                                                        class="ti ti-calendar-time me-2"></i>Days</h5>

                                                <div class="list-group list-group-flush" id="list-tab" role="tablist">

                                                    <a class="list-group-item list-group-item-action active btn-isnin"
                                                        id="list-1" data-bs-toggle="list" href="#list-mail-1"
                                                        role="tab">
                                                        <span>
                                                            Monday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-selasa"
                                                        id="list-2" data-bs-toggle="list" href="#list-mail-2"
                                                        role="tab">
                                                        <span>
                                                            Tuesday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-rabu"
                                                        id="list-3" data-bs-toggle="list" href="#list-mail-3"
                                                        role="tab">
                                                        <span>
                                                            Wednesday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-khamis"
                                                        id="list-4" data-bs-toggle="list" href="#list-mail-4"
                                                        role="tab">
                                                        <span>
                                                            Thursday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-jumaat"
                                                        id="list-5" data-bs-toggle="list" href="#list-mail-5"
                                                        role="tab">
                                                        <span>
                                                            Friday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-sabtu"
                                                        id="list-6" data-bs-toggle="list" href="#list-mail-6"
                                                        role="tab">
                                                        <span>
                                                            Saturday
                                                        </span>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action btn-ahad"
                                                        id="list-7" data-bs-toggle="list" href="#list-mail-7"
                                                        role="tab">
                                                        <span>
                                                            Sunday
                                                        </span>
                                                    </a>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mail-content">
                            <div class="d-sm-flex align-items-center">
                                <ul class="list-inline me-auto mb-3">
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvas_mail">
                                            <i class="ti ti-menu-2 f-24"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show  active" id="list-mail-1" role="tabpanel"
                                            aria-labelledby="list-mail-1">
                                            <div class="card table-card">
                                                <div class="card-body">

                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>
                                                    @if ($data->where('slot_day', 'monday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'monday')
                                                            <div class="card p-4 border border-1 mt-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="list-mail-2" role="tabpanel"
                                            aria-labelledby="list-mail-2">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>
                                                    @if ($data->where('slot_day', 'tuesday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'tuesday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="list-mail-3" role="tabpanel"
                                            aria-labelledby="list-mail-3">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>

                                                    @if ($data->where('slot_day', 'wednesday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'wednesday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="list-mail-4" role="tabpanel"
                                            aria-labelledby="list-mail-4">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>

                                                    @if ($data->where('slot_day', 'thursday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'thursday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="list-mail-5" role="tabpanel"
                                            aria-labelledby="list-mail-5">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>
                                                    @if ($data->where('slot_day', 'friday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif
                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'friday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="list-mail-6" role="tabpanel"
                                            aria-labelledby="list-mail-6">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>
                                                    @if ($data->where('slot_day', 'saturday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif
                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'saturday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="list-mail-7" role="tabpanel"
                                            aria-labelledby="list-mail-7">
                                            <div class="card table-card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-end align-items-center my-2 mb-3">
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#addSlotModal">Add Slot</button>
                                                    </div>
                                                    @if ($data->where('slot_day', 'sunday')->count() == 0)
                                                        <div class="text-muted fst-italic text-center">No slots added ...
                                                        </div>
                                                    @endif
                                                    @foreach ($data as $d)
                                                        @if ($d->slot_day == 'sunday')
                                                            <div class="card p-4 border border-1 mb-3">
                                                                <div class="card-body">
                                                                    @if ($d->slot_status == 1)
                                                                        <span
                                                                            class="badge text-bg-success">Available</span>
                                                                    @else
                                                                        <span
                                                                            class="badge text-bg-danger">Unavailable</span>
                                                                    @endif

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span
                                                                                class="text-truncate fw-semibold">{{ $d->start_time }}
                                                                                - {{ $d->end_time }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"
                                                                                class="avtar avtar-s btn-link-secondary"><i
                                                                                    class="ti ti-edit f-18"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#updateSlotModal-{{ $d->id }}"></i>
                                                                            </a>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Time Slot Create Start Here -->
            <div class="modal fade" id="addSlotModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <form action="{{ route('tasker-timeslot-create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mb-0">Add Slot</h5>
                                <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                    data-bs-dismiss="modal">
                                    <i class="ti ti-x f-20"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Slot</label>
                                            <select name="slot_id"
                                                class="form-control @error('slot_id') is-invalid @enderror">
                                                <option value="" selected>Select Slot</option>
                                                @foreach ($slots as $slot)
                                                    <option value="{{ $slot->id }}"> {{ $slot->start_time }} -
                                                        {{ $slot->end_time }}</option>
                                                @endforeach
                                            </select>
                                            @error('slot_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="slot_status"
                                                class="form-control @error('slot_status') is-invalid @enderror">
                                                <option value="1" selected>Available</option>
                                                <option value="0">Unavailable</option>
                                            </select>
                                            @error('slot_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control day" value="monday" name="slot_day">
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
            <!-- Modal Time Slot Create End  Here -->

            <!-- Modal Time Slot Update Start Here -->
            @foreach ($data as $d)
                <div class="modal fade" id="updateSlotModal-{{ $d->id }}" data-bs-keyboard="false"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <form action="{{ route('tasker-timeslot-update', $d->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Slot</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slot</label>
                                                <select name="slot_id" class="form-control">
                                                    <option value="{{ $d->slot_id }}" selected>
                                                        {{ $d->start_time }} - {{ $d->end_time }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="slot_status"
                                                    class="form-control @error('slot_status') is-invalid @enderror">
                                                    @if ($d->slot_status == 1)
                                                        <option value="1" selected>Available</option>
                                                        <option value="0">Unavailable</option>
                                                    @else
                                                        <option value="1">Available</option>
                                                        <option value="0"selected>Unavailable</option>
                                                    @endif
                                                </select>
                                                @error('slot_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control" value="{{ $d->slot_day }}" name="slot_day">
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

            <!-- Modal Time Slot Update End  Here -->


        </div>
    </div>
    <!-- [ Main Content ] end -->


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addSlotModal'));
                modal.show();
            @endif
        });

        document.addEventListener("DOMContentLoaded", function() {
            const dayInput = document.querySelector('.day'); // Hidden input for day
            const tabLinks = document.querySelectorAll('[data-bs-toggle="list"]');

            // Add click event listener to each day button
            tabLinks.forEach(tab => {
                tab.addEventListener("click", function() {
                    const selectedDay = this.querySelector('span').textContent
                        .toLowerCase(); // Get the day from span
                    dayInput.value = selectedDay; // Update the hidden input value
                    localStorage.setItem("activeTab", this.id); // Store the active tab ID
                    localStorage.setItem("selectedDay", selectedDay); // Store the selected day
                });
            });

            // Restore the active tab and hidden input value after reload
            const activeTab = localStorage.getItem("activeTab");
            const savedDay = localStorage.getItem("selectedDay");

            if (activeTab) {
                const activeTabElement = document.getElementById(activeTab);
                if (activeTabElement) {
                    new bootstrap.Tab(activeTabElement).show(); // Reactivate the tab
                }
            }

            if (savedDay && dayInput) {
                dayInput.value = savedDay; // Restore the hidden input value
            }
        });



        $('.btn-isnin').on('click', function() {
            $('.day').val('monday');
        });
        $('.btn-selasa').on('click', function() {
            $('.day').val('tuesday');
        });
        $('.btn-rabu').on('click', function() {
            $('.day').val('wednesday');
        });
        $('.btn-khamis').on('click', function() {
            $('.day').val('thursday');
        });
        $('.btn-jumaat').on('click', function() {
            $('.day').val('friday');
        });
        $('.btn-sabtu').on('click', function() {
            $('.day').val('saturday');
        });
        $('.btn-ahad').on('click', function() {
            $('.day').val('sunday');
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
