<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Tasker;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
{

    public function taskerLoginNav()
    {
        return view('tasker.login', [
            'title' => 'Tasker Login'
        ]);
    }

    public function taskerRegisterFormNav()
    {
        return view('tasker.register-tasker', [
            'title' => 'Tasker Registration'
        ]);
    }

    public function adminLoginNav()
    {
        return view('administrator.login', [
            'title' => 'Admin Login'
        ]);
    }

    public function adminHomeNav()
    {
        return view('administrator.index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function taskerhomeNav()
    {
        return view('tasker.index', [
            'title' => 'Tasker Dashboard'
        ]);
    }

    // public function getStates($loc)
    // {
    //     $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
    //     return view($loc, compact('states'));
    // }

    public function getAreas($state)
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        $areas = [];

        foreach ($states['states'] as $item) {
            if (strtolower($item['name']) == strtolower($state)) {
                $areas = $item['areas'];
                break;
            }
        }

        return response()->json($areas);
    }

    public function adminManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('administrators')
                ->select('id', 'admin_firstname', 'admin_lastname', 'admin_phoneno', 'email', 'admin_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('admin_status', function ($row) {

                if ($row->admin_status == 0) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i> Not Activated</span>';
                } else if ($row->admin_status == 1) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</span>';
                } else {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                          <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteAdmin-' . $row->id . '" data-bs-toggle="modal"
                            data-bs-target="#deleteAdmin">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                            <script>
                                document.querySelector(".deleteAdmin-' . $row->id . '").addEventListener("click", function () {
                                const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: "btn btn-success",
                                    cancelButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                                });
                                swalWithBootstrapButtons
                                .fire({
                                    title: "Are you sure?",
                                    text: "Once deleted, the admin will permanently lose access to the system, and all related data will be removed. This action cannot be undone.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        setTimeout(function() {
                                            location.href="' . route("admin-delete", $row->id) . '";
                                        }, 1000);
                                    } 
                                });
                            });
                        </script>
                    ';

                return $button;
            });

            $table->rawColumns(['admin_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.admin.index', [
            'title' => 'Admin Management',
            'admins' => Administrator::get()
        ]);
    }

    public function serviceTypeManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('service_types')
                ->select('id', 'servicetype_name', 'servicetype_desc', 'servicetype_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('servicetype_status', function ($row) {

                if ($row->servicetype_status == 1) {
                    $status = '<span class="badge rounded-pill text-bg-success">Show</span>';
                } else if ($row->servicetype_status == 2) {
                    $status = '<span class="badge rounded-pill text-bg-danger">Hide</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                          <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateServiceTypeModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteServiceType-' . $row->id . '" data-bs-toggle="modal"
                            data-bs-target="#deleteAdmin">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                            <script>
                                document.querySelector(".deleteServiceType-' . $row->id . '").addEventListener("click", function () {
                                const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: "btn btn-success",
                                    cancelButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                                });
                                swalWithBootstrapButtons
                                .fire({
                                    title: "Are you sure?",
                                    text: "This action cannot be undone.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        setTimeout(function() {
                                            location.href="' . route("admin-servicetype-delete", $row->id) . '";
                                        }, 1000);
                                    } 
                                });
                            });
                        </script>
                    ';

                return $button;
            });

            $table->rawColumns(['servicetype_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.service.servicetype-index', [
            'title' => 'Service Type Management',
            'stypes' => ServiceType::get(),
        ]);
    }

    public function taskerManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('taskers')
                ->select('id', 'tasker_code', 'tasker_firstname', 'tasker_lastname', 'email', 'tasker_status', 'tasker_phoneno')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('tasker_status', function ($row) {

                if ($row->tasker_status == 0) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Incomplete Profile</span>';
                } else if ($row->tasker_status == 1) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Not Verified</span>';
                } else if ($row->tasker_status == 2) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i>Active</span>';
                } else if ($row->tasker_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i>Inactive</span>';
                } else if ($row->tasker_status == 4) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Password Reset Needed</span>';
                } else if ($row->tasker_status == 5) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i>Banned</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                          <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateTaskerModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteAdmin-' . $row->id . '" data-bs-toggle="modal"
                            data-bs-target="#deleteAdmin">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                            <script>
                                document.querySelector(".deleteAdmin-' . $row->id . '").addEventListener("click", function () {
                                const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: "btn btn-success",
                                    cancelButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                                });
                                swalWithBootstrapButtons
                                .fire({
                                    title: "Are you sure?",
                                    text: "Once deleted, the admin will permanently lose access to the system, and all related data will be removed. This action cannot be undone.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        setTimeout(function() {
                                            location.href="' . route("admin-delete", $row->id) . '";
                                        }, 1000);
                                    } 
                                });
                            });
                        </script>
                    ';

                return $button;
            });

            $table->rawColumns(['tasker_status', 'action']);

            return $table->make(true);
        }
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('administrator.tasker.index', [
            'title' => 'Tasker Management',
            'taskers' => Tasker::get(),
            'taskerCount' => Tasker::count(),
            'states' => $states
        ]);
    }

    public function taskerServiceManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', 'b.id')
                ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('service_rate', function ($row) {

                $rate = $row->service_rate . ' / ' . $row->service_rate_type;
                return $rate;
            });

            $table->addColumn('service_status', function ($row) {

                if ($row->service_status == 0) {
                    $status = ' <span class="badge text-bg-warning text-white">Pending</span>';
                } else if ($row->service_status == 1) {
                    $status = '<span class="badge text-bg-success text-white">Active</span>';
                } else if ($row->service_status == 2) {
                    $status = '<span class="badge text-bg-danger text-white">Inactive</span>';
                } else if ($row->service_status == 3) {
                    $status = '<span class="badge bg-light-danger">Terminated</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->service_status == 0) {
                    $button =
                        '
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteService-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                        <script>
                        document.querySelector(".deleteService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "This action cannot be undone.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("tasker-service-delete", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                        </script>
                    ';
                } else if ($row->service_status == 1 || $row->service_status == 2 || $row->service_status == 3) {
                    $button =
                        '
                      <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateServiceModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                      </a>
                      <a href="#" class="avtar avtar-xs  btn-light-danger deleteService-' . $row->id . '">
                        <i class="ti ti-trash f-20"></i>
                      </a>

                    <script>
                        document.querySelector(".deleteService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "This action cannot be undone.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("tasker-service-delete", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                    </script>
                ';
                }


                return $button;
            });

            $table->rawColumns(['service_rate', 'service_status', 'action']);

            return $table->make(true);
        }

        return view('tasker.service.index', [
            'title' => 'Service Management',
            'services' => Service::get(),
            'types' => ServiceType::where('servicetype_status', 1)->get()
        ]);
    }

    public function adminServiceManagementNav(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', 'b.id')
                ->join('taskers as c', 'a.tasker_id', 'c.id')
                ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status', 'c.tasker_code', 'c.tasker_firstname')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('tasker', function ($row) {

                $tasker = '<a href="" class="btn btn-link">'.$row->tasker_code.'</a>';
                return $tasker;
            });

            $table->addColumn('service_rate', function ($row) {

                $rate = $row->service_rate . ' / ' . $row->service_rate_type;
                return $rate;
            });

            $table->addColumn('service_status', function ($row) {

                if ($row->service_status == 0) {
                    $status = ' <span class="badge text-bg-warning text-white">Pending</span>';
                } else if ($row->service_status == 1) {
                    $status = '<span class="badge text-bg-success text-white">Active</span>';
                } else if ($row->service_status == 2) {
                    $status = '<span class="badge text-bg-danger text-white">Inactive</span>';
                } else if ($row->service_status == 3) {
                    $status = '<span class="badge bg-light-danger">Terminated</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->service_status == 0) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-success approveService-' . $row->id . '">
                            <i class="ti ti-check f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-danger rejectService-' . $row->id . '">
                            <i class="ti ti-x f-20"></i>
                        </a>

                        <script>
                        document.querySelector(".approveService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "Approve?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("admin-approve-service", $row->id) . '";
                                    }, 500);
                                } 
                            });
                        });

                        document.querySelector(".rejectService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "This action cannot be undone.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("tasker-service-delete", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                        </script>
                    ';
                } else if ($row->service_status == 1) {
                    $button =
                        '
                    <a href="#" class="avtar avtar-xs btn-light-danger terminateService-' . $row->id . '">
                        <i class="ti ti-x f-20"></i>
                    </a>

                    <script>
                    document.querySelector(".terminateService-' . $row->id . '").addEventListener("click", function () {
                        const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        buttonsStyling: false
                        });
                        swalWithBootstrapButtons
                        .fire({
                            title: "Are you sure?",
                            text: "Terminate ' . $row->tasker_firstname . ' ' . $row->servicetype_name . ' services ?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Terminate",
                            cancelButtonText: "Cancel",
                            reverseButtons: true
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    location.href="' . route("admin-terminate-service", $row->id) . '";
                                }, 500);
                            } 
                        });
                    });
                    </script>
                ';
                } else if ($row->service_status == 2) {
                    $button = 'update required !';
                } else if ($row->service_status == 3) {
                    $button = '';
                }

                return $button;
            });

            $table->rawColumns(['tasker','service_rate', 'service_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.service.index', [
            'title' => 'Service Management',
            'services' => Service::get(),
            'types' => ServiceType::where('servicetype_status', 1)->get()
        ]);
    }

    public function taskerprofileNav()
    {
        return view('tasker.account.profile', [
            'title' => 'Tasker Profile'
        ]);
    }
}
