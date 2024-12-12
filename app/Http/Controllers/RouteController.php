<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Client;
use App\Models\Tasker;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\ServiceType;
use Illuminate\Support\Str;
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

    //Client -Landing Page
    public function gotoIndex()
    {
        if (!Auth::guard('client')->check()) {
            return view('client.index', [
                'title' => 'Welcome !',
                'service' => ServiceType::all()
            ]);
        } else {
            return redirect(route('client-home'));
        }
    }
    
    //Client -LoginOrSignUp Option
    public function loginOptionNav()
    {
        return view('client.login-option', [
            'title' => 'Select Your Option'
        ]);
    }

    //Client- Sign Up Form
    public function clientRegisterFormNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        return view('client.register-client', [
            'title' => 'Sign Up Now !',
            'states' => $states
        ]);
    }

    // Client - First Time Login Form Navigation
    public function clientFirstTimeNav($id)
    {
        $client = Client::where('id', Crypt::decrypt($id))->first();

        return view('client.first-time', [
            'title' => 'First Time Login',
            'client' => $client
        ]);
    }

    //Client - Login Form
    public function clientLoginNav()
    {
        if (!Auth::guard('client')->check()) {

            return view('client.login', [
                'title' => 'Login to your account'
            ]);
        } else {
            return redirect(route('client-home'));
        }
    }
    //Client -- Homepage Login
    public function clientSearchServicesNav()
    {
        return view('client.search-auth', [
            'title' => 'Search Your Services',
            'service' => ServiceType::all()

        ]);
    }
    //Client -- Profile Homepage
    public function clientprofileNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('client.account.profile-client', [
            'title' => 'My Profile',
            'states' => $states
        ]);
    }

    public function clientBooking($id)
    {
        try {
            $client = Client::where('id', auth()->id())->first();
            $clientLat = $client->latitude;
            $clientLng = $client->longitude;

            // API Key for Google Directions API
            $apiKey = env('GOOGLE_MAPS_GEOCODING_API_KEY', '');

            // Fetch taskers and calculate road distances
            $svtasker = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', '=', 'b.id')
                ->join('taskers as c', 'a.tasker_id', '=', 'c.id')
                ->where('b.id', '=', $id)
                ->where('a.service_status', '=', 1)
                ->select(
                    'a.id as svID',
                    'b.id as typeID',
                    'c.id as taskerID',
                    'a.service_rate_type',
                    'a.service_rate',
                    'a.service_status',
                    'a.service_desc',
                    'b.servicetype_name',
                    'b.servicetype_status',
                    'c.tasker_firstname',
                    'c.tasker_rating',
                    'c.tasker_photo',
                    'c.latitude as tasker_lat',
                    'c.longitude as tasker_lng'
                )
                ->get();

            // Filter taskers within a specified distance
            // $svtasker = $svtasker->map(function ($tasker) use ($clientLat, $clientLng, $apiKey) {
            //     $taskerLat = $tasker->tasker_lat;
            //     $taskerLng = $tasker->tasker_lng;

            //     // Call Google Directions API
            //     $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$clientLat,$clientLng&destination=$taskerLat,$taskerLng&key=$apiKey";
            //     $response = file_get_contents($url);
            //     $data = json_decode($response, true);

            //     // Get road distance
            //     if (!empty($data['routes']) && isset($data['routes'][0]['legs'][0]['distance']['value'])) {
            //         $distanceInMeters = $data['routes'][0]['legs'][0]['distance']['value'];
            //         $tasker->road_distance = $distanceInMeters / 1000; // Convert to kilometers
            //     } else {
            //         $tasker->road_distance = null; // If failed
            //     }

            //     return $tasker;
            // })
            //     ->filter(function ($tasker) {
            //         // Filter only taskers within 40 km
            //         return $tasker->road_distance !== null && $tasker->road_distance <= 40;
            //     })
            //     ->sortBy('road_distance'); // Optional: Sort by nearest distance

            $sv = ServiceType::whereId($id)->first();

            $timeSlot = DB::table('time_slots as a')
                ->join('tasker_time_slots as b', 'a.id', '=', 'b.slot_id')
                ->where('b.slot_status', '=', 1)
                ->select('b.slot_id', 'a.time', 'b.tasker_id')
                ->get();

            $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

            return view('client.booking.index', [
                'title' => 'Describe your task',
                'tasker' => $svtasker,
                'sv' => $sv,
                'client' => $client,
                'states' => $states,
                'time' => $timeSlot
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function clientUpcoming()
    {
        return view('client.booking.taskremain', [
            'title' => 'My UpcomingTask',
            
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
                ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status', 'a.tasker_id')
                ->where('a.tasker_id', '=', Auth::user()->id)
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

    // Admin - Time Slot Setting
    public function taskerTimeSlotNav(Request $request)
    {
        $data = DB::table('tasker_time_slots as a')
            ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
            ->select('a.id', 'a.slot_status', 'a.slot_date', 'a.slot_id', 'b.time', 'b.slot_category')
            ->get();

        return view('tasker.task-preference.time-slot-index', [
            'title' => 'Manage Time Slot',
            'slots' => TimeSlot::all(),
            'data' => $data
        ]);
    }

    public function taskerVisibleLocNav(Request $request)
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('tasker.task-preference.visibility-location', [
            'title' => 'Manage Visibility & Location',
            'states' => $states
        ]);
    }

    public function taskerBookingManagementNav(Request $request) 
    {
        return view('tasker.booking.index', [
            'title'=> 'My Booking',
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
    //Updated by: Zikri (5/12/2024)
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
                } else if ($row->admin_status == 2) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                } else if ($row->admin_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Deactivated</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                if ($row->admin_status == 3) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

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
    //Updated by: Zikri (5/12/2024)
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
    //Updated by: Zikri (5/12/2024)
    public function taskerUpdateNav($id)
    {
        $data = Tasker::where('tasker_code', Crypt::decrypt($id))->first();
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('administrator.tasker.update-tasker', [
            'title' => $data->tasker_firstname . ' profile',
            'tasker' => $data,
            'states' => $states,
        ]);
    }

    // Admin - Service Type Management Navigation
    //Updated by: Zikri (5/12/2024)
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
                $isReferenced = DB::table('services')->where('service_type_id', $row->id)->exists();
                $buttonEdit =
                    '
                    <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateServiceTypeModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                    </a>
                ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                    <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal-' . $row->id . '">
                        <i class="ti ti-trash f-20"></i>
                    </a>
                    ';
                } else {
                    $buttonRemove = '';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['servicetype_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.service.servicetype-index', [
            'title' => 'Service Type Management',
            'stypes' => ServiceType::get(),
        ]);
    }

    // Admin - Service Approval Navigation
    //Updated by: Zikri (5/12/2024)
    public function adminServiceManagementNav(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', 'b.id')
                ->join('taskers as c', 'a.tasker_id', 'c.id')
                ->where('a.service_status', '!=', 3)
                ->where('a.service_status', '!=', 4)
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
                        <a href="#" class="avtar avtar-xs btn-light-success" data-bs-toggle="modal" 
                            data-bs-target="#approveModal-' . $row->id . '">
                            <i class="ti ti-check f-20"></i>
                        </a>
                    ';
                } else if ($row->service_status == 1) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewDescModal-' . $row->id . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-danger " data-bs-toggle="modal" 
                            data-bs-target="#terminateModal-' . $row->id . '">
                            <i class="ti ti-x f-20"></i>
                        </a>
                ';
                } else if ($row->service_status == 2 || $row->service_status == 4) {
                    $button = '';
                }

                return $button;
            });

            $table->rawColumns(['tasker', 'service_rate', 'service_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.service.index', [
            'title' => 'Service Approval',
            'services' => Service::get(),
            'types' => ServiceType::where('servicetype_status', 1)->get()
        ]);
    }

    // Admin - Time Slot Setting
    //Updated by: Zikri (5/12/2024)
    public function adminTimeSlotNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('time_slots')
                ->select('id', 'time', 'slot_category')
                ->orderBy('time', 'asc')
                ->orderBy('slot_category','asc')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();


            $table->addColumn('slot_category', function ($row) {
                $cat = null;
                if ($row->slot_category == 1) {
                    $cat = '<span class="badge badge text-bg-primary">Full Time</span>';
                } else if ($row->slot_category == 2) {
                    $cat = '<span class="badge badge bg-light-primary">Part Time</span>';
                }

                return $cat;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('tasker_time_slots')->where('slot_id', $row->id)->exists();
                $editButton = '
                    <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateSlotModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                    </a>';

                if (!$isReferenced) {
                    $deleteButton = '
                        <a href="#" class="avtar avtar-xs btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>';
                } else {
                    $deleteButton = '';
                }
                return $editButton . $deleteButton;
            });
            $table->rawColumns(['slot_category', 'action']);

            return $table->make(true);
        }
        return view('administrator.setting.time-slot-index', [
            'title' => 'Time Slot Setting',
            'slots' => TimeSlot::all()
        ]);
    }

    // Admin - Tasker Management Navigation
    //Updated by: Zikri (5/12/2024)
    public function ClientManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('clients')
                ->select('id', 'client_firstname', 'client_lastname', 'client_phoneno', 'email', 'client_status', 'client_state')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('client_status', function ($row) {
                if ($row->client_status == 0) {
                    $status = '<span class="badge bg-light-success">Newly Registered</span>';
                } else if ($row->client_status == 1) {
                    $status = '<span class="badge bg-light-danger">Admin Referal</span>';
                } else if ($row->client_status == 2) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</span>';
                } else if ($row->client_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                } else if ($row->client_status == 4) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Deactivated</span>';
                }

                return $status;
            });

            $table->addColumn('client_state', function ($row) {
                $state = Str::ucfirst($row->client_state);
                return $state;
            });

            $table->addColumn('action', function ($row) {
                if ($row->client_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateClientModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateClientModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['client_status', 'client_state', 'action']);
            return $table->make(true);
        }

        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('administrator.client.index', [
            'title' => 'Client Management',
            'clients' => Client::get(),
            'states' => $states,
        ]);
    }

    /**** Administrator Route Function - End ****/
}
