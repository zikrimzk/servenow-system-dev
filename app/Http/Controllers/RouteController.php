<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Review;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\ReviewReply;
use App\Models\ServiceType;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\DB;
use App\Models\CancelRefundBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;


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

    // Get Bank API
    public function getBank()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBank');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        return response()->json($result);
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
    //Client - Homepage Login
    public function clientSearchServicesNav()
    {
        return view('client.search-auth', [
            'title' => 'Search Your Services',
            'service' => ServiceType::all()

        ]);
    }
    //Client - Profile Homepage
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
                'states' => $states,
                'time' => $timeSlot
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function clientPaymentStatusNav(Request $request)
    {
        $data = [
            'status_id' => $request->query('status_id'),
            'billcode' => $request->query('billcode'),
            'order_id' => $request->query('order_id'),
            'msg' => $request->query('msg'),
            'transaction_id' => $request->query('transaction_id'),
            'current_date' => Carbon::now()->format('Y-m-d'),
            'current_time' => Carbon::now()->format('H:i:s'),
        ];

        return view('client.booking.payment-return', [
            'title' => 'Payment',
            'datas' => $data
        ]);
    }

    public function clientPaymentNav(Request $request)
    {
        return redirect('https://dev.toyyibpay.com/' . $request->billcode);
    }

    public function clientPaymentCallbackNav(Request $request)
    {

        Transaction::where('booking_order_id', $request->order_id)
            ->update([
                'trans_refno' => $request->refno,
                'trans_status' => $request->status,
                'trans_reason' => $request->reason,
                'trans_billcode' => $request->billcode,
                'trans_amount' => $request->amount,
                'trans_transaction_time' => $request->transaction_time,
            ]);

        if ($request->status == '1') {
            $status_payment = 2;
        } else {
            $status_payment = 1;
        }

        Booking::where('booking_order_id', $request->order_id)
            ->update([
                'booking_status' => $status_payment
            ]);
    }


    public function clientBookingHistoryNav()
    {
        $booking = DB::table('bookings as a')
            ->join('services as c', 'a.service_id', '=', 'c.id')
            ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
            ->join('taskers as e', 'c.tasker_id', '=', 'e.id')
            ->select(
                'a.id as bookingID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_latitude',
                'a.booking_longitude',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'a.client_id',
                'a.service_id',
                'a.created_at',
                'a.updated_at',
                'c.service_rate',
                'c.service_rate_type',
                'c.service_desc',
                'c.service_status',
                'c.service_type_id',
                'd.servicetype_name',
                'd.servicetype_desc',
                'd.servicetype_status',
                'e.id as taskerID',
                'e.tasker_code',
                'e.tasker_photo',
                'e.tasker_firstname',
                'e.tasker_lastname',
                'e.tasker_phoneno',
                'e.email'
            )
            ->where('a.client_id', Auth::user()->id)
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_status', 'asc')
            ->get();

        // Grouping berdasarkan booking_date
        $groupedBookings = $booking->groupBy('booking_date');
        $toServeBookings = collect($booking)
            ->whereIn('booking_status', [1, 2, 3, 4])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $completed = collect($booking)
            ->whereIn('booking_status', [6])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $cancelled = collect($booking)
            ->whereIn('booking_status', [5])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $refund = collect($booking)
            ->whereIn('booking_status', [7, 8, 9, 10])
            ->groupBy('booking_date');

        $review = Review::all();
        $refunds = DB::table('cancel_refund_bookings')->get();
        // dd($refunds->booking_id);

        $bank = json_decode(file_get_contents(public_path('assets/json/bank.json')), true);

        return view('client.booking.booking-history', [
            'title' => 'My Booking History',
            'book' => $groupedBookings,
            'toServeBooking' => $toServeBookings,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'refund' => $refund,
            'review' => $review,
            'bank' => $bank,
            'refunds' => $refunds
        ]);
    }

    public function clientViewReview()
    {
        return view('client.booking.view-review', [
            'title' => 'My Review',
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
            'title' => 'My Booking',
        ]);
    }

    // Admin - Booking List

    public function taskerBookingListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',

            )
            ->whereNotIn('a.booking_status', [7, 8, 9, 10])
            ->where('b.tasker_id', Auth::user()->id)
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 1) {
                    $status = '<span class="badge bg-warning">To Pay</span>';
                } else if ($row->booking_status == 2) {
                    $status = '<span class="badge bg-light-success">Paid</span>';
                } else if ($row->booking_status == 3) {
                    $status = '<span class="badge bg-success">Confirmed</span>';
                } else if ($row->booking_status == 4) {
                    $status = '<span class="badge bg-warning">Rescheduled</span>';
                } else if ($row->booking_status == 5) {
                    $status = '<span class="badge bg-danger">Cancelled</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                }
                return $status;
            });

            $table->addColumn('booking_amount', function ($row) {

                if ($row->booking_status == 1) {
                    $amount = '<span class="text-warning"> ' . $row->booking_rate . '</span>';
                } else if ($row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4 || $row->booking_status == 6) {
                    $amount = '<span class="text-success"> ' . $row->booking_rate . '</span>';
                } else if ($row->booking_status == 5) {
                    $amount = '<span class="text-danger"> ' . $row->booking_rate . '</span>';
                }
                return $amount;
            });

            $table->addColumn('action', function ($row) {

                if ($row->booking_status == 1 || $row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                       
                    ';
                    // ' <a href="#" class="avtar avtar-xs btn-light-secondary" data-bs-toggle="modal" 
                    //         data-bs-target="#updatebooking-' . $row->bookingID . '">
                    //         <i class="ti ti-edit f-20"></i>
                    //     </a>'
                } else if ($row->booking_status == 5 || $row->booking_status == 6) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['client', 'booking_date', 'booking_time', 'booking_status', 'booking_amount', 'action']);

            return $table->make(true);
        }
        return view('tasker.booking.booking-list-index', [
            'title' => 'All Booking List',
            'books' => $data,
        ]);
    }

    public function taskerRefundBookingListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [7, 8])
            ->where('b.tasker_id', Auth::user()->id)
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('refund_amount', function ($row) {

                if ($row->booking_status == 7) {
                    $amount = '<span class="text-warning text-center"> ' . $row->cr_amount . '</span>';
                } else if ($row->booking_status == 8) {
                    $amount = '<span class="text-danger text-center"> ' . $row->cr_amount . '</span>';
                }
                return $amount;
            });


            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 7) {
                    $status = '<span class="badge bg-light-warning">Pending Refund</span>';
                } else if ($row->booking_status == 8) {
                    $status = '<span class="badge bg-light-success">Refunded</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['client', 'booking_date', 'booking_time', 'refund_amount', 'booking_status', 'action']);

            return $table->make(true);
        }
        return view('tasker.booking.refund-list-index', [
            'title' => 'Refund Booking List',
            'books' => $data,
        ]);
    }
    public function taskerReviewManagementNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as reviewID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.review_status',
                'f.review_rating',
                'f.review_description',
                'f.review_date_time',
                'f.review_imageOne',
                'f.review_imageTwo',
                'f.review_imageThree',
                'f.review_imageFour',
                'f.review_type',
            )
            ->where('d.id', Auth::user()->id);

        // Apply date range filter before calling get()
        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween(DB::raw("DATE(f.review_date_time)"), [$startDate, $endDate]);
            }
        }

        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $ratingFilter = $request->input('rating_filter');
            if ($ratingFilter == '1') {
                $data->orderByDesc('f.review_rating'); // Highest rating first
            } elseif ($ratingFilter == '2') {
                $data->orderBy('f.review_rating'); // Lowest rating first
            }
        } else {
            $data->orderByDesc('f.review_date_time');
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('review_rating', function ($row) {

                $rating = '';
                for ($i = 1; $i <= $row->review_rating; $i++) {
                    $rating .= '<i class="fas fa-star text-warning"></i>';
                }
                return $rating;
            });


            $table->addColumn('review_date_time', function ($row) {

                $datetime = Carbon::parse($row->review_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d F Y g:i A');
                return $datetime;
            });

            $table->addColumn('review_status', function ($row) {

                if ($row->review_status == 1) {
                    $status = '<span class="badge bg-success">Show</span>';
                } else if ($row->review_status == 2) {
                    $status = '<span class="badge bg-danger">Hide</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {
                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewReviewDetails-' . $row->reviewID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-warning" data-bs-toggle="modal"
                            data-bs-target="#replyReview-' . $row->reviewID . '">
                            <i class="ti ti-repeat f-20"></i>
                        </a>
                    ';
                return $button;
            });

            $table->rawColumns(['booking_order_id', 'client', 'review_rating', 'review_date_time', 'review_status', 'action']);

            return $table->make(true);
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalreview = $data->count();


        // Count total reviews by month
        $totalreviewsbymonth = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereMonth('f.review_date_time', $currentMonth)
            ->whereYear('f.review_date_time', $currentYear)
            ->where('d.id', auth()->user()->id)
            ->count();

        // Count total reviews by year

        $totalreviewsbyyear = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereYear('f.review_date_time', $currentYear)
            ->where('d.id', auth()->user()->id)
            ->count();

        // Count total unreviewed bookings
        $totalcompletedBooking = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->where('a.booking_status', 6)
            ->where('d.id', auth()->user()->id)
            ->count();

        $totalunreview = $totalcompletedBooking - $totalreview;

        // Count total average rating
        $averageRating = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->where('d.id', auth()->user()->id)
            ->avg('f.review_rating');

        // Count Percentage of Positive and Negative Reviews and Nuetral Reviews
        $csat =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '>=', 4)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $neutralrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '=', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $negrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '<', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;

        $reply = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', 'b.id')
            ->join('services as c', 'b.service_id', 'c.id')
            ->join('taskers as d', 'c.tasker_id', 'd.id')
            ->join('review_replies as e', 'a.id', 'e.review_id')
            ->whereNotNull('e.reply_message')
            ->get();

        // dd($reply);

        return view('tasker.performance.review-index', [
            'title' => 'Review Management',
            'data' => $data,
            'totalreviewsbymonth' => $totalreviewsbymonth,
            'totalreviewsbyyear' => $totalreviewsbyyear,
            'totalunreview' => $totalunreview,
            'averageRating' => $averageRating,
            'csat' => $csat,
            'negrev' => $negrev,
            'neutralrev' => $neutralrev,
            'reply' => $reply
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
                ->orderBy('slot_category', 'asc')
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

    // Admin - System Setting
    // Uncompleted
    public function adminSystemSettingNav()
    {
        return view('administrator.setting.system-index', [
            'title' => 'System Settings',

        ]);
    }

    // Admin - Booking List

    public function adminBookingListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',

            )
            ->whereNotIn('a.booking_status', [7, 8, 9, 10])
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 1) {
                    $status = '<span class="badge bg-warning">To Pay</span>';
                } else if ($row->booking_status == 2) {
                    $status = '<span class="badge bg-light-success">Paid</span>';
                } else if ($row->booking_status == 3) {
                    $status = '<span class="badge bg-success">Confirmed</span>';
                } else if ($row->booking_status == 4) {
                    $status = '<span class="badge bg-warning">Rescheduled</span>';
                } else if ($row->booking_status == 5) {
                    $status = '<span class="badge bg-danger">Cancelled</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->booking_status == 1 || $row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-secondary" data-bs-toggle="modal" 
                            data-bs-target="#updatebooking-' . $row->bookingID . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else if ($row->booking_status == 5 || $row->booking_status == 6) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['tasker', 'client', 'booking_date', 'booking_time', 'booking_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.booking.index', [
            'title' => 'Booking List',
            'books' => $data,
        ]);
    }

    public function adminBookingRefundListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [8, 10])
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('refund_amount', function ($row) {

                if ($row->booking_status == 8) {
                    $amount = '<span class="text-danger text-center"> ' . $row->cr_amount . '</span>';
                } else if ($row->booking_status == 10) {
                    $amount = '<span class="text-success text-center"> ' . $row->cr_amount . '</span>';
                }
                return $amount;
            });


            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 8) {
                    $status = '<span class="badge bg-light-success">Refunded</span>';
                } else if ($row->booking_status == 10) {
                    $status = '<span class="badge bg-light-danger">Rejected</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['tasker', 'client', 'booking_date', 'booking_time', 'refund_amount', 'booking_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.booking.refunded-list-index', [
            'title' => 'Refund Booking List',
            'books' => $data,
        ]);
    }

    public function adminBookingRefundReqNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [7, 9])
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 7) {
                    $status = '<span class="badge bg-light-warning">Pending Refund</span>';
                } else if ($row->booking_status == 9) {
                    $status = '<span class="badge bg-light-danger">Require Update</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['tasker', 'client', 'booking_date', 'booking_time', 'booking_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.booking.refund-req-index', [
            'title' => 'Refund Request',
            'books' => $data
        ]);
    }

    public function adminReviewManagementNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as reviewID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.review_status',
                'f.review_rating',
                'f.review_description',
                'f.review_date_time',
                'f.review_imageOne',
                'f.review_imageTwo',
                'f.review_imageThree',
                'f.review_imageFour',
                'f.review_type',
            );

        // Apply date range filter before calling get()
        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween(DB::raw("DATE(f.review_date_time)"), [$startDate, $endDate]);
            }
        }

        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $ratingFilter = $request->input('rating_filter');
            if ($ratingFilter == '1') {
                $data->orderByDesc('f.review_rating'); // Highest rating first
            } elseif ($ratingFilter == '2') {
                $data->orderBy('f.review_rating'); // Lowest rating first
            }
        } else {
            $data->orderByDesc('f.review_date_time');
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('review_rating', function ($row) {

                $rating = '';
                for ($i = 1; $i <= $row->review_rating; $i++) {
                    $rating .= '<i class="fas fa-star text-warning"></i>';
                }
                return $rating;
            });


            $table->addColumn('review_date_time', function ($row) {

                $datetime = Carbon::parse($row->review_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d F Y g:i A');
                return $datetime;
            });

            $table->addColumn('review_status', function ($row) {

                if ($row->review_status == 1) {
                    $status = '<span class="badge bg-success">Show</span>';
                } else if ($row->review_status == 2) {
                    $status = '<span class="badge bg-danger">Hide</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {
                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewReviewDetails-' . $row->reviewID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                         <a href="#" class="avtar avtar-xs btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#replyReview-' . $row->reviewID . '">
                            <i class="ti ti-repeat f-20"></i>
                        </a>
                    ';
                return $button;
            });

            $table->rawColumns(['booking_order_id', 'client', 'review_rating', 'review_date_time', 'review_status', 'action']);

            return $table->make(true);
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalreview = $data->count();


        // Count total reviews by month
        $totalreviewsbymonth = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereMonth('f.review_date_time', $currentMonth)
            ->whereYear('f.review_date_time', $currentYear)
            ->count();

        // Count total reviews by year

        $totalreviewsbyyear = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereYear('f.review_date_time', $currentYear)
            ->count();

        // Count total unreviewed bookings
        $totalcompletedBooking = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->where('a.booking_status', 6)
            ->count();

        $totalunreview = $totalcompletedBooking - $totalreview;

        // Count total average rating
        $averageRating = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->avg('f.review_rating');

        // Count Percentage of Positive and Negative Reviews and Nuetral Reviews
        $csat =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '>=', 4)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $neutralrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '=', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $negrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '<', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        // Count Growth Rate by last month
        $currentMonthReviews = DB::table('reviews')
            ->whereMonth('review_date_time', Carbon::now()->month)
            ->count();
        $lastMonthReviews = DB::table('reviews')
            ->whereMonth('review_date_time', Carbon::now()->subMonth()->month)
            ->count();
        $growthRate =
            $lastMonthReviews > 0
            ? (($currentMonthReviews - $lastMonthReviews) / $lastMonthReviews) * 100
            : 0;

        // Get top service type with most reviews
        $topService = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', '=', 'b.id')
            ->join('services as c', 'b.service_id', '=', 'c.id')
            ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
            ->select('d.servicetype_name', DB::raw('count(*) as total_reviews'))
            ->groupBy('d.servicetype_name')
            ->orderByDesc('total_reviews')
            ->first();

        // Get reviews with replies
        $reply = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', 'b.id')
            ->join('services as c', 'b.service_id', 'c.id')
            ->join('taskers as d', 'c.tasker_id', 'd.id')
            ->join('review_replies as e', 'a.id', 'e.review_id')
            ->whereNotNull('e.reply_message')
            ->get();

        return view('administrator.performance.review-index', [
            'title' => 'Review Management',
            'data' => $data,
            'totalreviewsbymonth' => $totalreviewsbymonth,
            'totalreviewsbyyear' => $totalreviewsbyyear,
            'totalunreview' => $totalunreview,
            'averageRating' => $averageRating,
            'csat' => $csat,
            'negrev' => $negrev,
            'neutralrev' => $neutralrev,
            'growthRate' => $growthRate,
            'topService' => $topService,
            'reply' => $reply,
        ]);
    }

    public function adminTaskerPerformanceNav(Request $request)
    {
        $taskers = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                'taskers.tasker_code',
                'taskers.id',
                DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS tasker_name"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("
                CASE 
                    WHEN AVG(reviews.review_rating) >= 4 THEN '1'
                    WHEN AVG(reviews.review_rating) >= 3 THEN '2'
                    ELSE '3'
                END AS satisfaction_reaction
            "),
                // 'taskers.tasker_selfrefund_count AS total_self_cancel_refunds',
                DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                DB::raw("
                    ROUND(
                        (
                            (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                            + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                            - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
                        ), 2
                    ) AS performance_score_percentage
                "),
            )
            ->groupBy('taskers.id');

        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $taskers->whereBetween('bookings.booking_date', [$request->startDate, $request->endDate]);
            }
        }
        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $taskers->havingRaw('ROUND(AVG(reviews.review_rating)) = ?', [$request->rating_filter]);
        }

        if ($request->has('reaction_filter') && $request->input('reaction_filter') != '') {
            $taskers->having('satisfaction_reaction', '=', $request->reaction_filter);
        }

        if ($request->has('penalized_filter') && $request->input('penalized_filter') != '') {
            if ($request->input('penalized_filter') == 1) {
                $taskers->orderBy('total_self_cancel_refunds', 'asc');
            } else  if ($request->input('penalized_filter') == 2) {
                $taskers->orderBy('total_self_cancel_refunds', 'desc');
            }
        }

        if ($request->has('score_filter_min') && $request->input('score_filter_min') != '' && $request->has('score_filter_max') && $request->input('score_filter_max') != '') {
            $scoreMin = $request->input('score_filter_min');
            $scoreMax = $request->input('score_filter_max');

            if (!empty($scoreMin) && !empty($scoreMax)) {
                $taskers->havingRaw(
                    'performance_score_percentage BETWEEN ? AND ?',
                    [$scoreMin, $scoreMax]
                );
            }
        }
        $data = $taskers->get();

        // Overall performance
        $overallPerformance = $data->avg('performance_score_percentage');

        //calculate highest penalized tasker
        $highestPerformers = $data
            ->filter(function ($tasker) {
                return $tasker->performance_score_percentage >= 60;
            })
            ->sortByDesc('performance_score_percentage')
            ->values()
            ->map(function ($tasker, $index) {
                return [
                    'name' => $tasker->tasker_name,
                    'score' => $tasker->performance_score_percentage,
                ];
            });

        $lowestPerformers = $data
            ->filter(function ($tasker) {
                return $tasker->performance_score_percentage < 40;
            })
            ->sortBy('performance_score_percentage')
            ->values()
            ->map(function ($tasker, $index) {
                return [
                    'name' => $tasker->tasker_name,
                    'score' => $tasker->performance_score_percentage,
                ];
            });

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="tasker-checkbox form-check-input" value="' . $row->id . '">';
            });

            $table->addColumn('tasker_code', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link link-primary">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('average_rating', function ($row) {
                $averageRating = round($row->average_rating * 2) / 2; // Round to nearest 0.5
                $fullStars = floor($averageRating); // Number of full stars
                $halfStar = $averageRating - $fullStars > 0 ? 1 : 0; // Check if there's a half star
                $emptyStars = 5 - $fullStars - $halfStar; // Remaining empty stars

                $stars = '';
                for ($i = 0; $i < $fullStars; $i++) {
                    $stars .= '<i class="fas fa-star text-warning"></i>'; // Full star icon
                }
                if ($halfStar) {
                    $stars .= '<i class="fas fa-star-half-alt text-warning"></i>'; // Half star icon
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    $stars .= '<i class="far fa-star text-muted"></i>'; // Empty star icon
                }

                return $stars;
            });

            $table->addColumn('satisfaction_reaction', function ($row) {
                if ($row->satisfaction_reaction == 1) {
                    // Happy
                    return '<i class="fas fa-smile text-success f-22" title="Happy"></i>';
                } elseif ($row->satisfaction_reaction == 2) {
                    // Neutral 
                    return '<i class="fas fa-meh text-warning f-22" title="Neutral"></i>';
                } elseif ($row->satisfaction_reaction == 3) {
                    // Unhappy 
                    return '<i class="fas fa-frown text-danger f-22" title="Unhappy"></i>';
                } else {
                    // Default for no reaction
                    return '<i class="fas fa-question-circle text-muted f-22" title="No Reaction"></i>';
                }
            });

            $table->addColumn('total_self_cancel_refunds', function ($row) {

                $cancelRefunds = '<span class="badge bg-danger">' . $row->total_self_cancel_refunds . '</span>';
                return $cancelRefunds;
            });


            $table->addColumn('total_completed_bookings', function ($row) {

                $completedBookings = '<span class="badge bg-success">' . $row->total_completed_bookings . '</span>';
                return $completedBookings;
            });

            $table->addColumn('p_score', function ($row) {
                $scorePercentage = $row->performance_score_percentage;
                $progressColor = 'bg-success';

                if ($scorePercentage >= 70) {
                    $progressColor = 'bg-success';
                } elseif ($scorePercentage >= 40) {
                    $progressColor = 'bg-warning';
                } else {
                    $progressColor = 'bg-danger';
                }

                return '
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar ' . $progressColor . '" role="progressbar" style="width: ' . $scorePercentage . '%;" aria-valuenow="' . $scorePercentage . '" aria-valuemin="0" aria-valuemax="100">
                            ' . $scorePercentage . '%
                        </div>
                    </div>
                ';
            });

            $table->rawColumns(['checkbox', 'tasker_code', 'average_rating', 'satisfaction_reaction', 'total_self_cancel_refunds', 'total_completed_bookings', 'p_score']);

            return $table->make(true);
        }
        $taskers = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                'taskers.tasker_code',
                'taskers.id',
                DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS tasker_name"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("CASE 
            WHEN AVG(reviews.review_rating) >= 4 THEN '1'
            WHEN AVG(reviews.review_rating) >= 3 THEN '2'
            ELSE '3'
         END AS satisfaction_reaction"),
                DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                DB::raw("ROUND(
            (
                (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
            ), 2
        ) AS performance_score_percentage"),
                DB::raw("LAST_DAY(bookings.booking_date) AS last_booking_date") // Last day of the month
            )
            ->whereNotNull('bookings.booking_date') // Only consider valid dates
            ->groupBy('taskers.id', 'last_booking_date');

        $data = $taskers->get();

        // Calculate monthly labels
        $monthlyLabels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });

        // Calculate monthly scores
        $monthlyScores = collect(range(1, 12))->map(function ($month) use ($data) {
            return $data->filter(function ($item) use ($month) {
                return Carbon::parse($item->last_booking_date)->month === $month;
            })->avg('performance_score_percentage');
        });

        // Group data by year and month
        $groupedData = $data->groupBy(function ($item) {
            return Carbon::parse($item->last_booking_date)->year; // Group by year
        });

        // Prepare data for the chart
        $chartData = $groupedData->map(function ($items, $year) {
            $monthlyScores = collect(range(1, 12))->map(function ($month) use ($items) {
                return $items->filter(function ($item) use ($month) {
                    return Carbon::parse($item->last_booking_date)->month === $month;
                })->avg('performance_score_percentage') ?? 0;
            });

            return [
                'year' => $year,
                'scores' => $monthlyScores,
            ];
        })->values();


        $yearlyAverages = $chartData
            ->sortByDesc('year') 
            ->take(3) 
            ->map(function ($data) {
                $validScores = collect($data['scores'])->filter(function ($score) {
                    return $score > 0;
                });
                $average = $validScores->avg();

                return [
                    'year' => $data['year'],
                    'average_performance' => round($average, 2),
                ];
            })
            ->sortBy('year') 
            ->values();
        return view('administrator.performance.tasker-performance-index', [
            'title' => 'Tasker Performance',
            'data' => $data,
            'overallPerformance' => $overallPerformance,
            'monthlyLabels' => $monthlyLabels,
            'chartData' => $chartData,
            'monthlyScores' => $monthlyScores,
            'highestPerformers' => $highestPerformers,
            'lowestPerformers' => $lowestPerformers,
            'yearlyAverages' => $yearlyAverages

        ]);
    }






    /**** Administrator Route Function - End ****/
}
