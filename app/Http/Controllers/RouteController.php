<?php

namespace App\Http\Controllers;

use App\Models\Tasker;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
{

    /**** General Route Function - Start ****/

    // Get Area API
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

    /**** General Route Function - End ****/




    /**** Client Route Function - Start ****/

    //All Client Route Here ....

    public function gotoIndex()
    {
        return view('client.index',[
            'title'=>'Welcome !',
            'service'=> ServiceType::all()
        ]);
    }

    public function loginOptionNav()
    {
        return view('client.login-option',[
            'title'=>'Select Your Option'
        ]);
    }

    public function clientRegisterFormNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        return view('client.register-client',[
            'title'=>'Sign Up Now !',
            'states' => $states
        ]);
    }
    public function clientLoginNav()
    {
        
        return view('client.login',[
            'title'=>'Login to your account'
        ]);
    }

    public function clientSearchServicesNav()
    {
        return view('client.search-auth',[
            'title'=>'Search Your Services',
            'service'=> ServiceType::all()

        ]);
    }

    public function clientprofileNav()
    {
        return view('client.account.profile-client',[
            'title' => 'My Profile'
        ]);
    }

    /**** Client Route Function - End ****/




    /**** Tasker Route Function - Start ****/

    // Tasker - Registration Form Navigation
    public function taskerRegisterFormNav()
    {
        return view('tasker.register-tasker', [
            'title' => 'Tasker Registration'
        ]);
    }

    // Tasker - First Time Login Form Navigation
    public function taskerFirstTimeNav($id)
    {
        $tasker = Tasker::where('id', Crypt::decrypt($id))->first();

        return view('tasker.first-time', [
            'title' => 'First Time Login',
            'tasker' => $tasker
        ]);
    }

    // Tasker - Login Form Navigation
    public function taskerLoginNav()
    {
        if (!Auth::guard('tasker')->check()) {
            return view('tasker.login', [
                'title' => 'Tasker Login'
            ]);
        } else {
            return redirect(route('tasker-home'));
        }
    }

    // Tasker - Dashboard Navigation
    public function taskerhomeNav()
    {
        return view('tasker.index', [
            'title' => 'Tasker Dashboard'
        ]);
    }

    // Tasker - Profile Navigation
    public function taskerprofileNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        return view('tasker.account.profile', [
            'title' => 'Tasker Profile',
            'states' => $states
        ]);
    }

    // Tasker - Service Management Navigation
    public function taskerServiceManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', 'b.id')
                ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status','a.tasker_id')
                ->where('a.tasker_id','=',Auth::user()->id)
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
                    $status = '<span class="badge bg-danger">Rejected</span>';
                } else if ($row->service_status == 4) {
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
                } else if ($row->service_status == 4) {
                    $button = 'Remarks : Make new application';
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


    /**** Tasker Route Function - End ****/




    /**** Administrator Route Function - Start ****/

    // Admin - First Time Login Navigation
    public function adminFirstTimeNav($id)
    {
        $admin = Administrator::where('id', Crypt::decrypt($id))->first();

        return view('administrator.first-time', [
            'title' => 'First Time Login',
            'admin' => $admin
        ]);
    }

    // Admin - Login Navigation
    public function adminLoginNav()
    {
        if (!Auth::guard('admin')->check()) {
            return view('administrator.login', [
                'title' => 'Admin Login'
            ]);
        } else {
            return redirect(route('admin-home'));
        }
    }

    // Admin - Dashboard Navigation
    public function adminHomeNav()
    {
        return view('administrator.index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    // Admin - Profile Navigation
    public function adminprofileNav()
    {
        return view('administrator.admin.profile', [
            'title' => 'Administrator Profile',
        ]);
    }

    // Admin - Admin Management Navigation
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

    // Admin - Tasker Management Navigation
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
                          <a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="avtar avtar-xs btn-light-primary"">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                    ';

                return $button;
            });

            $table->rawColumns(['tasker_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.tasker.index', [
            'title' => 'Tasker Management',
            'taskers' => Tasker::get(),
        ]);
    }

    // Admin - Tasker Profile Navigation
    public function taskerUpdateNav($id)
    {
        $data = Tasker::where('tasker_code', Crypt::decrypt($id))->first();
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);


        return view('administrator.tasker.update-tasker', [
            'title' => $data->tasker_firstname . ' profile',
            'tasker' => $data,
            'states' => $states,
            'taskerCount' => Tasker::count(),


        ]);
    }

    // Admin - Service Type Management Navigation
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

    // Admin - Service Management Navigation
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

                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
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
                    $status = '<span class="badge bg-danger">Rejected</span>';
                } else if ($row->service_status == 4) {
                    $status = '<span class="badge bg-light-danger">Terminated</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->service_status == 0) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewDescModal-' . $row->id . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
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
                                confirmButtonText: "Approve",
                                cancelButtonText: "Cancel",
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
                                confirmButtonText: "Reject",
                                cancelButtonText: "Cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("admin-reject-service", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                        </script>
                    ';
                } else if ($row->service_status == 1) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewDescModal-' . $row->id . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
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
                    $button = '';
                } else if ($row->service_status == 3) {
                    $button = 'Remarks : Update Required !';
                } else if ($row->service_status == 4) {
                    $button = '';
                }

                return $button;
            });

            $table->rawColumns(['tasker', 'service_rate', 'service_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.service.index', [
            'title' => 'Service Management',
            'services' => Service::get(),
            'types' => ServiceType::where('servicetype_status', 1)->get()
        ]);
    }

    /**** Administrator Route Function - End ****/






  
}
